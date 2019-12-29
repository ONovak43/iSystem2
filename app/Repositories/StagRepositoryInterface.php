<?php


namespace App\Repositories;



interface StagRepositoryInterface
{
    /**
     * Return true if room exists
     *
     * @param string $building
     * @param string $room
     * @return bool
     */
    public function roomExists(string $building, string $room): bool;

    /**
     * Return room's time schedule
     *
     * @param string $building
     * @param string $room
     * @param string $everyLesson
     * @return array
     */
    public function getRoomsSubjects(string $building, string $room, string $everyLesson): array;

    /**
     * Return room's time schedule
     *
     * @param string $building
     * @param string $room
     * @return array
     */
    public function getRoomsTimeSchedule(string $building, string $room): array;

    /**
     * Return all subjects for the room with current lesson
     *
     * @param string $building
     * @param string $number
     * @param int $lesson
     * @return array
     */
    public function getSubjectByLesson(string $building, string $number, int $lesson): array;
}
