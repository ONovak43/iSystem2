<?php

namespace Tests\Unit;

use App\Repositories\RESTStagRepository;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RESTStagRepositoryTest extends TestCase
{
    /** @test */
    public function a_room_exists()
    {
        $stag = $this->createStag([], json_encode(['mistnostInfo' => '123']));

        $this->assertTrue($stag->roomExists('KL', '206'));
    }

    /** @test */
    public function a_room_doesnt_exist()
    {
        $stag = $this->createStag([], json_encode(['mistnostInfo' => '']));

        $this->assertFalse($stag->roomExists('KL', '2026'));
    }

    /** @test */
    public function a_room_has_subjects()
    {
        $stag = $this->createStag([
            new Response(200,[], $this->getTestSemesterJSON()),
            new Response(200, [], $this->getTestData()),
        ]);

        $timeSchedule = $stag->getRoomsSubjects('KL', '206', 'ZS');

        $this->assertEquals('Programování 1 pro vzdělávání', $timeSchedule['data'][0]['name']);
    }

    /** @test */
    public function a_room_has_a_timeschedule()
    {
        $stag = $this->createStag([
            new Response(200,[], $this->getTestSemesterJSON()),
            new Response(200, [], $this->getTestDataFalse()),
            new Response(200,[], $this->getTestSemesterJSON()),
            new Response(200, [], $this->getTestData()),
        ]);

        $timeSchedule = $stag->getRoomsTimeSchedule('KL', '206', 'ZS');

        $this->assertEquals('PGM1P', $timeSchedule['pondělí'][0]['shortName']);
    }

    /** @test */
    public function a_room_subject_on_first_lesson_on_monday()
    {
        $stag = $this->createStag([
            new Response(200,[],$this->getTestSemesterJSON()),
            new Response(200,[],$this->getTestData()),
        ]);

        $subject = $stag->getSubjectByLesson('KL', '206', 1, Carbon::createFromDate(2019,9,23));

        $this->assertEquals('Programování 1 pro vzdělávání', $subject['data'][$subject['page']]['name']);
    }

    /** @test */
    public function next_and_previous_lesson_in_free_room()
    {
        $stag = $this->createStag([
            new Response(200,[], $this->getTestSemesterJSON()),
            new Response(200, [], $this->getTestData()),
        ]);

        $subject = $stag->getSubjectByLesson('KL', '206', 13, Carbon::createFromDate(2019,10,30));

        $this->assertEquals('Multimédia pro vzdělávání 1', $subject['data'][$subject['pageNext']]['name']);
        $this->assertEquals('Zpracování dat pro vzdělávání', $subject['data'][$subject['pagePrevious']]['name']);
    }

    protected function getTestSemesterJSON()
    {
        return '{
        "obdobi": "ZS",
        "akademRok": "2019",
        "semestrInteligentne": "ZS",
        "akademRokInteligentne": "2019",
        "posledniVyucovaciDenRoku": {
        "value": "24.5.2020"
        },
        "posledniDenSemestruInteligentne": {
        "value": "20.12.2019"
        },
        "posledniDenZimnihoZkouskoveho": {
        "value": "16.2.2020"
        },
        "posledniDenLetnihoZkouskoveho": {
        "value": "31.8.2020"
        },
        "prvniDenStavajicihoAkademickehoRoku": {
        "value": "1.9.2019"
        },
        "posledniDenStavajicihoAkademickehoRoku": {
        "value": "31.8.2020"
        }
        }';
    }

}
