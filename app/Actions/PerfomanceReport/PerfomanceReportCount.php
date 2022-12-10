<?php

namespace App\Actions\AdditiveCriterion;

use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PerfomanceReportCount
{

  public function __invoke(array $criterias)
  {

    $maxValues = $this->findMaxValues($criterias);

    [
      'lastMonth' => $lastMonthNormalizeCriteria,
      'currentMonth' => $currentMonthNormalizeCriteria
    ] = $this->normalizeCriterias($criterias, $maxValues);

    

    $importance = [1, 0.7, 0.5, 1, 0.5];
    $signs = [-1, -1, -1, -1, 1];

    $lastMonthAdditiveCritearia = $this->countAdditiveCriteria($lastMonthNormalizeCriteria, $importance, $signs);
    $currentMonthAdditiveCritearia = $this->countAdditiveCriteria($currentMonthNormalizeCriteria, $importance, $signs);

    $response = [
      'lastMonthCritery' => $criterias['lastMonth'],
      'currentMonthCritery' => $criterias['currentMonth'],
      'lastMonthNormalizeCriteria' => $lastMonthNormalizeCriteria,
      'currentMonthNormalizeCriteria' => $currentMonthNormalizeCriteria,
      'lastMonthAdditiveCritearia' => $lastMonthAdditiveCritearia,
      'currentMonthAdditiveCritearia' => $currentMonthAdditiveCritearia
    ];

    $fileData = (new PerfomanceReportExport)->exportPerfomanceReport($response, $importance, $signs, $maxValues);

    return [
      'response' => $response,
      'fileData' => $fileData,
      'maxValues' => $maxValues
    ];
  }


  private function findMaxValues(array $criterias)
  {
    $maxValues = [];

    foreach ($criterias['lastMonth'] as $key => $criteria) {
      $maxValues[$key] = max($criterias['lastMonth'][$key], $criterias['currentMonth'][$key]);
    }

    return $maxValues;
  }


  private function normalizeCriterias(array $criterias, array $maxValues)
  {
    $lastMonthNormalizeCriteria = [];
    $currentMonthNormalizeCriteria = [];

    foreach ($criterias['lastMonth'] as $key => $criteria) {
      $lastMonthNormalizeCriteria[$key] = $criteria / $maxValues[$key];
    }

    foreach ($criterias['currentMonth'] as $key => $criteria) {
      $currentMonthNormalizeCriteria[$key] = $criteria /  $maxValues[$key];
    }

    return [
      'lastMonth' => $lastMonthNormalizeCriteria,
      'currentMonth' => $currentMonthNormalizeCriteria
    ];
  }

  private function countAdditiveCriteria(array $criterias, array $importance, array $signs)
  {
    $result = 0;
    foreach ($criterias as $key => $criteria) {
      $index = array_search($key, array_keys($criterias));
      $result += $importance[$index] * $signs[$index] * $criteria;
    }
    return $result;
  }














  // TODO FIX

  // public function BInvoke(array $lastMonth, array $currentMonth)
  // {
  //   $lastMonthCriteria = $this->countСriterias($lastMonth);

  //   $currentMonthCriteria = $this->countСriterias($currentMonth);

  //   [
  //     'lastMonthNormalizeCriteria' => $lastMonthNormalizeCriteria,
  //     'currentMonthNormalizeCriteria' => $currentMonthNormalizeCriteria
  //   ] = $this->normalizeCriterias($lastMonthCriteria, $currentMonthCriteria);

  //   $lastMonthAdditiveCritearia = $this->countAdditiveCriteria($lastMonthNormalizeCriteria);
  //   $currentMonthAdditiveCritearia = $this->countAdditiveCriteria($currentMonthNormalizeCriteria);

  //   $response = [
  //     'lastMonthCritery' => $lastMonthCriteria,
  //     'currentMonthCritery' => $currentMonthCriteria,
  //     'lastMonthNormalizeCriteria' => $lastMonthNormalizeCriteria,
  //     'currentMonthNormalizeCriteria' => $currentMonthNormalizeCriteria,
  //     'lastMonthAdditiveCritearia' => $lastMonthAdditiveCritearia,
  //     'currentMonthAdditiveCritearia' => $currentMonthAdditiveCritearia
  //   ];

  //   $rawData = [
  //     'lastMonth' => $lastMonth,
  //     'currentMonth'  => $currentMonth
  //   ];
  //   $fileData = (new CreatePerfomanceReport)->createPerfomanceReport($response, $rawData);

  //   return [
  //     'rawData' => $rawData,
  //     'criterias' => $response,
  //     'fileData' => $fileData
  //   ];
  // }



  private function BnormalizeCriterias(array $lastMonthCriteria, array $currentMontsCriteria)
  {
    $lastMonthNormalizeCriteria = [];
    $currentMonthNormalizeCriteria = [];

    foreach ($lastMonthCriteria as $key => $criteria) {
      $lastMonthNormalizeCriteria[$key] = $criteria / max($lastMonthCriteria[$key], $currentMontsCriteria[$key]);
    }

    foreach ($currentMontsCriteria as $key => $criteria) {
      $currentMonthNormalizeCriteria[$key] = $criteria / max($lastMonthCriteria[$key], $currentMontsCriteria[$key]);
    }

    return [
      'lastMonthNormalizeCriteria' => $lastMonthNormalizeCriteria,
      'currentMonthNormalizeCriteria' => $currentMonthNormalizeCriteria
    ];
  }


  private function countСriterias(array $arrayOfTables): array
  {
    $criteria = [
      'placementTasks' => 0,
      'shipmentTasks' => 0,
      'intraWarehouseTasks' => 0,
      'lateness' => 0,
      'efficiency' => 0,
    ];

    $onlyFirstAuthorizationHistory = $this->getOnlyFirstAuthOfDay($arrayOfTables['authorizationHistory']);

    foreach ($arrayOfTables['placementTasks'] as $task) {
      $criteria['placementTasks'] += $this->findDifferenceBetweenDates($task['date_end'], $task['time_completion']);
    }
    foreach ($arrayOfTables['shipmentTasks'] as $task) {
      $criteria['shipmentTasks'] += $this->findDifferenceBetweenDates($task['date_end'], $task['time_completion']);
    }
    foreach ($arrayOfTables['intraWarehouseTasks'] as $task) {
      $criteria['intraWarehouseTasks'] += $this->findDifferenceBetweenDates($task['date_end'], $task['time_completion']);
    }
    foreach ($onlyFirstAuthorizationHistory as $authorization) {
      $criteria['lateness'] += $this->countLateness($authorization);
    }

    $criteria['efficiency'] = $arrayOfTables['numberOfTasks'];

    return $criteria;
  }

  private function getOnlyFirstAuthOfDay(Collection $authorizationHistory)
  {
    $users = [];
    $filterAuthorizationHistory = [];

    foreach ($authorizationHistory as $authorization) {
      if (!array_key_exists($authorization['user_id'], $users)) {
        $users[$authorization['user_id']] = [];
      }

      $timeAuthorization = date('Y-m-d', strtotime($authorization['time_authorization']));

      if (!in_array($timeAuthorization, $users[$authorization['user_id']], true)) {
        array_push($users[$authorization['user_id']], $timeAuthorization);
        array_push($filterAuthorizationHistory, $authorization);
      }
    }
    return $filterAuthorizationHistory;
  }

  private function findDifferenceBetweenDates(string $firstDate, string $secondDate)
  {
    $dateEnd = new DateTime($firstDate);
    $dateCompletion = new DateTime($secondDate);
    $interval = $dateEnd->diff($dateCompletion);

    $result = $interval->days * 24 + $interval->h;

    if ($interval->invert === 1) {
      $result *= -1;
    }
    return $result;
  }

  private function countLateness(Model $authorization)
  {
    $timeAuthorization = (string) $authorization['time_authorization'];
    $schedules = $authorization->user->work_schedules;

    $timeAuthorizationDate = new DateTime($timeAuthorization);
    $dayOfWeekAuthorization = (int) $timeAuthorizationDate->format('w');

    $userSheduleInThisDayArray = $schedules->filter(function ($shedule) use ($dayOfWeekAuthorization) {
      if ($shedule['day_of_week'] === $dayOfWeekAuthorization) {
        return true;
      } else {
        return false;
      }
    })->take(1);
    $userSheduleInThisDay = $userSheduleInThisDayArray[$userSheduleInThisDayArray->keys()[0]];


    $startWorkTime = new DateTime($userSheduleInThisDay['start_time']);
    $startWorkHour = (int) $startWorkTime->format("H");

    $timeAuthorizationDate = new DateTime($timeAuthorization);
    $authorizationDateHour = (int) $timeAuthorizationDate->format("H");

    return $authorizationDateHour - $startWorkHour;
  }
}
