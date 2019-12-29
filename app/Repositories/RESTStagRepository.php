<?php


namespace App\Repositories;


use App\Http\Resources\SubjectCollection;
use App\Http\Resources\TimeSchedule;
use App\Http\Utilities\Lessons;
use GuzzleHttp\Client;
use GuzzleHttp\TransferStats;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class RESTStagRepository implements StagRepositoryInterface
{
    /**
     * @var Client
     */
    protected $apiClient;

    public function __construct(Client $client)
    {
        $this->apiClient = $client;
    }

    /**
     * Return true if room exists
     *
     * @param string $building
     * @param string $room
     * @return bool
     */
    public function roomExists(string $building, string $room): bool
    {
        $room = $this->getRoom($building, $room);

        return !empty($room['mistnostInfo']);
    }

    /**
     * Return room's subjects
     *
     * @param string $building
     * @param string $room
     * @return array
     */
    public function getRoomsSubjects(string $building, string $room, string $everyLesson = 'true'): array
    {
        $semester = $this->getSemester();
        $response = $this->endpointRequest('rozvrhy/getRozvrhByMistnost', [
            'budova' => $building,
            'mistnost' => $room,
            'semestr' => $semester,
            'vsechnyCasyKonani' => $everyLesson,
            'outputFormat' => 'JSON'
        ]);

        $subjects = collect($response['rozvrhovaAkce']);

        return SubjectCollection::make($subjects)->resolve();
    }

    /**
     * Return room's time schedule
     *
     * @param string $building
     * @param string $room
     * @return array
     */
    public function getRoomsTimeSchedule(string $building, string $room): array
    {
        $subjects = $this->getRoomsSubjects($building, $room, 'false');
        $days = ['pondělí', 'úterý', 'středa', 'čtvrtek', 'pátek', 'sobota', 'neděle'];
        $timeSchedule = [];
        foreach ($days as $day) {
            $timeSchedule[$day] = Arr::where($subjects['data'], function ($value) use ($day) { // set a lesson to the day
                return $value['day'] === $day && $value['repeat'] === 'Každý';
            });
        }
        $subjects = $this->getRoomsSubjects($building, $room);

        $timeSchedule['others'] = Arr::where($subjects['data'], function ($value) use ($day) { // set other lessons
            return $value['repeat'] === 'Jiný';
        });

        return $timeSchedule;
    }

    /**
     * Return all subjects for the room with previous lesson key, current lesson key and next lesson key
     *
     * @param string $building
     * @param string $number
     * @param int $lesson
     * @param Carbon|null $date
     * @return array
     */
    public function getSubjectByLesson(string $building, string $number, int $lesson, Carbon $date = null): array
    {
        $subjects = $this->getRoomsSubjects($building, $number);

        $date = $date ?? Carbon::now()->startOfDay();

        $subjects['page'] = key(Arr::where($subjects['data'], function ($value) use ($lesson, $date) { // getting key of current lesson
            return $lesson >= $value['startsLesson'] && $lesson <= $value['endsLesson'] && Carbon::parse($value['date'])->equalTo($date->startOfDay());
        }));

        $subjects['pageNext'] = array_key_first(Arr::where($subjects['data'], function ($value) use ($lesson, $date) { // getting key of next lesson
            return $lesson < $value['startsLesson'] && Carbon::parse($value['date'])->equalTo($date);
        }));

        $subjects['pagePrevious'] = array_key_last(Arr::where($subjects['data'], function ($value, $key) use ($lesson, $date, $subjects) { //getting key of previous lesson
            return $lesson > $value['startsLesson'] && Carbon::parse($value['date'])->equalTo($date) && $subjects['page'] !== $key;
        }));

        return $subjects;
    }

    /**
     * Return current semester
     *
     * @return mixed
     */
    protected function getSemester(): string
    {
        $response = $this->endpointRequest('kalendar/getAktualniObdobiInfo', [
            'outputFormat' => 'JSON'
        ]);

        return $response['obdobi'];
    }

    /**
     * Get room info
     *
     * @param string $building
     * @param string $room
     * @return array
     */
    protected function getRoom(string $building, string $room): array
    {
        return $this->endpointRequest('mistnost/getMistnostiInfo', ['zkrBudovy' => $building, 'cisloMistnosti' => $room, 'outputFormat' => 'JSON']);
    }

    /**
     * Send get request to URL and convert response to array
     *
     * @param string $url
     * @param array $query
     * @return array
     */
    protected function endpointRequest(string $url, array $query): array
    {
        try {
            $response = $this->apiClient->get($url, ['query' => $query]);

        } catch (\Exception $e) {
            return [];
        }

        return $this->responseHandler($response->getBody()->getContents());
    }

    /**
     * Convert response to JSON
     *
     * @param string $response
     * @return array
     */
    protected function responseHandler(string $response): array
    {
        if ($response) {
            return json_decode($response, true);
        }

        return [];
    }
}
