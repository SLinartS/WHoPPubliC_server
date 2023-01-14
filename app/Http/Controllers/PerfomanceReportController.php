<?php

namespace App\Http\Controllers;

use App\Actions\PerfomanceReport\Count as PerfomanceReportCount;
use App\Models\AuthorizationHistory;
use App\Models\Task;
use DateTime;
use Illuminate\Database\Eloquent\Collection;

class PerfomanceReportController extends Controller
{
  public function index(PerfomanceReportCount $perfomanceReportCount)
  {
    $criterias = [];

    $intervals = [
      ['2021-06-01', '2021-06-30'],
      ['2021-07-01', '2021-07-31'],
    ];

    foreach ($intervals as $interval) {
      $criterias[$interval[0]] = $this->requestCriterias($interval);
    }

    $response = $perfomanceReportCount($criterias);

    return response()->json(
      [
        'message' => 'Perfomance report has been created',
        'fileData' => $response,
      ],
      200
    );
  }

  private function requestCriterias(array $interval): array
  {
    $intervalStart = $interval[0];
    $intervalEnd = $interval[1];

    $intervalData = [];

    $intervalData['placementTasks'] =
      Task::selectRaw('TIMESTAMPDIFF(HOUR, date_end, time_completion) as time')
      ->where('date_start', '>=', $intervalStart)
      ->where('date_start', '<=', $intervalEnd)
      ->where('type_id', 1)
      ->get()->sum('time');

    $intervalData['shipmentTasks'] =
      Task::selectRaw('TIMESTAMPDIFF(HOUR, date_end, time_completion) as time')
      ->where('date_start', '>=', $intervalStart)
      ->where('date_start', '<=', $intervalEnd)
      ->where('type_id', 2)
      ->get()->sum('time');

    $intervalData['intraWarehouseTasks'] =
      Task::selectRaw('TIMESTAMPDIFF(HOUR, date_end, time_completion) as time')
      ->where('date_start', '>=', $intervalStart)
      ->where('date_start', '<=', $intervalEnd)
      ->where('type_id', 3)
      ->get()->sum('time');

    $intervalData['authorizationHistory'] =
      AuthorizationHistory::select('authorization_history.user_id', 'authorization_history.time_authorization', 'work_schedules.start_time')
      ->join('users', 'authorization_history.user_id', 'users.id')
      ->join('work_schedules', 'users.id', 'work_schedules.user_id')
      ->where('authorization_history.time_authorization', '>=', $intervalStart)
      ->where('authorization_history.time_authorization', '<=', $intervalEnd)
      ->whereRaw('DAYOFWEEK(authorization_history.time_authorization) = work_schedules.day_of_week')
      ->orderBy('authorization_history.user_id', 'asc')
      ->orderBy('authorization_history.time_authorization', 'asc')
      ->get();

    $intervalData['authorizationHistory'] = $this->getSumOnlyFirstAuthOfDay($intervalData['authorizationHistory']);

    $intervalData['numberOfTasks'] = Task::select('id')
      ->where('date_start', '>=', $intervalStart)
      ->where('date_start', '<=', $intervalEnd)
      ->get()->count('id');

    return $intervalData;
  }

  private function getSumOnlyFirstAuthOfDay(Collection $authorizationHistory): int
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

    $sumTimeOfDelays = 0;
    foreach ($filterAuthorizationHistory as $authorization) {
      $timeAuthorization = new DateTime($authorization['time_authorization']);
      $startTime = new DateTime($authorization['start_time']);

      $timeAuthorizationHour = (int) $timeAuthorization->format("H");
      $startTimeHour = (int) $startTime->format("H");

      $sumTimeOfDelays += $timeAuthorizationHour - $startTimeHour;
    }

    return $sumTimeOfDelays;
  }
}
