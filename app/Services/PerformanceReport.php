<?php

namespace App\Services;

use App\Actions\PerformanceReport\Count as PerformanceReportCount;
use App\Actions\PerformanceReport\Export as PerformanceReportExport;
use App\Models\AuthorizationHistory;
use App\Models\Category as ModelsCategory;
use App\Models\Product as ModelsProduct;
use App\Models\Task;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Services\File as ServicesFile;
use DateTime;
use Illuminate\Database\Eloquent\Collection;

class PerformanceReport
{
  public function index()
  {
  }

  public function store($intervals)
  {
    $criteriaList = [];

    foreach ($intervals as $interval) {
      $criteriaList[$interval[0]] = $this->requestCriteriaList($interval);
    }

    list($criteriaList, $normalizedCriteriaList, $additiveCriteriaList, $signs) = (new PerformanceReportCount)($criteriaList);

    $spreadsheet = (new PerformanceReportExport())->exportPerformanceReport($criteriaList, $normalizedCriteriaList, $additiveCriteriaList, $signs);

    return $this->saveFile($spreadsheet);
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
      AuthorizationHistory::select(
        'authorization_history.user_id',
        'authorization_history.time_authorization',
        'authorization_history.current_start_time'
      )
      ->join('users', 'authorization_history.user_id', 'users.id')
      ->where('authorization_history.time_authorization', '>=', $intervalStart)
      ->where('authorization_history.time_authorization', '<=', $intervalEnd)
      ->orderBy('authorization_history.user_id', 'asc')
      ->orderBy('authorization_history.time_authorization', 'asc')
      ->get();

    $intervalData['authorizationHistory'] =
      $this->getSumOnlyFirstAuthOfDay($intervalData['authorizationHistory']);

    $intervalData['numberOfTasks'] =
      Task::select('id')
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
      $startTime = new DateTime($authorization['current_start_time']);

      $timeAuthorizationHour = (int) $timeAuthorization->format("H");
      $startTimeHour = (int) $startTime->format("H");

      $sumTimeOfDelays += $timeAuthorizationHour - $startTimeHour;
    }

    return $sumTimeOfDelays;
  }

  private function saveFile(Spreadsheet $spreadsheet)
  {
    $fileTitle = 'performance-report-' . date('Y-m-d_H-i-s') . '.xlsx';
    $filePath = __DIR__ . '\\..\\..\\storage\\app\\public\\reports\\performance\\' . $fileTitle;
    $writer = new Xlsx($spreadsheet);
    $writer->save($filePath);

    (new ServicesFile())->saveInfo($fileTitle, 1);

    return ['fileTitle' => $fileTitle];
  }
}
