<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

class AttendanceReturn extends DataLayer{

    public function __construct()
    {
        parent::__construct("attendance_returns", ["description"]);
    }

    public static function returnAttendanceId($id): string {
        $attendanceRetorn = (new AttendanceReturn)->findByid($id);
        return $attendanceRetorn->description;
    }
    
}