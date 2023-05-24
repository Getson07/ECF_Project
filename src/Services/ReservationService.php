<?php

namespace App\Services;

use App\Repository\ScheduleRepository;

class ReservationService
{
  private static $DAYS = [
    'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'
  ];
  private ScheduleRepository $scheduleRepository;

  public function __construct(ScheduleRepository $scheduleRepository)
  {
    $this->scheduleRepository = $scheduleRepository;
  }

  public function getHours(int $dayNumber){
    $schedule = $this->scheduleRepository->findOneBy(["day" => ReservationService::$DAYS[$dayNumber]]);
    return $schedule;
  }
}