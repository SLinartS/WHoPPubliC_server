<?php

namespace App\Http\Controllers;

use App\Actions\PerformanceReport\Count as PerformanceReportCount;
use App\Models\AuthorizationHistory;
use App\Models\Task;
use App\Services\File as ServicesFile;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class PerformanceReportController extends Controller
{
  public function index(Request $request, ServicesFile $servicesFile)
  {
    $search = $request->query('search');
    $response = $servicesFile->index($search);
    return $response;
  }

  public function store(PerformanceReportCount $performanceReportCount)
  {
    $criteriaList = [];

    $intervals = [
      ['2021-06-01', '2021-06-30'],
      ['2021-07-01', '2021-07-31'],
    ];

    foreach ($intervals as $interval) {
      $criteriaList[$interval[0]] = $this->requestCriteriaList($interval);
    }

    $performanceReportCount($criteriaList);

    return response()->json(
      [
        'message' => 'Performance report has been created'
      ],
      200
    );
  }

  public function download(int $id, ServicesFile $servicesFile)
  {
    return $servicesFile->download($id);
  }

  public function destroy(int $id, ServicesFile $servicesFile)
  {
    return $servicesFile->destroy($id);
    return response()->json([
      'message' => 'The performance report has been deleted'
    ], 200);
  }

  private function requestCriteriaList(array $interval): array
  {
    $intervalStart = $interval[0];
    $intervalEnd = $interval[1];

    $intervalData = [];

    $intervalData['placementTasks'] =
      Task::selectRaw('TIMESTAMPDIFF(HOUR, time_end, time_completion) as time')
      ->where('time_start', '>=', $intervalStart)
      ->where('time_start', '<=', $intervalEnd)
      ->where('type_id', 1)
      ->get()->sum('time');

    $intervalData['shipmentTasks'] =
      Task::selectRaw('TIMESTAMPDIFF(HOUR, time_end, time_completion) as time')
      ->where('time_start', '>=', $intervalStart)
      ->where('time_start', '<=', $intervalEnd)
      ->where('type_id', 2)
      ->get()->sum('time');

    $intervalData['intraWarehouseTasks'] =
      Task::selectRaw('TIMESTAMPDIFF(HOUR, time_end, time_completion) as time')
      ->where('time_start', '>=', $intervalStart)
      ->where('time_start', '<=', $intervalEnd)
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
      ->where('time_start', '>=', $intervalStart)
      ->where('time_start', '<=', $intervalEnd)
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
