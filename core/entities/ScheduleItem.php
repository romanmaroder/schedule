<?php


namespace core\entities;


class ScheduleItem

{

    public function days(): array
    {
        return [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            0 => 'Sunday',
        ];
    }

    public function hours(): array
    {
        return [
            0 => '0:00',
            1 => '1:00',
            2 => '2:00',
            3 => '3:00',
            4 => '4:00',
            5 => '5:00',
            6 => '6:00',
            7 => '7:00',
            8 => '8:00',
            9 => '9:00',
            10 => '10:00',
            11 => '11:00',
            12 => '12:00',
            13 => '13:00',
            14 => '14:00',
            15 => '15:00',
            16 => '16:00',
            17 => '17:00',
            18 => '18:00',
            19 => '19:00',
            20 => '20:00',
            21 => '21:00',
            22 => '22:00',
            23 => '23:00'
        ];
    }



}