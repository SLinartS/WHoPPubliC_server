<?php



namespace App\Http\Controllers;

use App\Actions\AdditiveCriterion\PerfomanceReportCount;
use Illuminate\Support\Facades\DB;

class AdditiveCriterionController extends Controller
{

  public function index(PerfomanceReportCount $perfomanceReportCount)
  {
    $criterias = [
      'lastMonth' => [],
      'currentMonth' => [],
    ];

    $criterias['lastMonth'] = $this->requestCriterias('2021-06-01 00:00:00', '2021-06-30 00:00:00');
    $criterias['currentMonth'] = $this->requestCriterias('2021-07-01 00:00:00', '2021-07-31 00:00:00');

    $response = $perfomanceReportCount($criterias);

    return response()->json(
      [
        'message' => 'Perfomance report has been created',
        'data' => $response,
      ],
      200
    );
  }

  private function requestCriterias(string $intervalStart, string $intervalEnd)
  {

    $intervalData = [
      'placementTasks' => [],
      'shipmentTasks' => [],
      'intraWarehouseTasks' => [],
      'authorizationHistory' => [],
      'numberOfTasks' => [],
    ];


    $intervalData['placementTasks'] =  DB::select(
      'SELECT SUM(TIMESTAMPDIFF(HOUR, date_end, time_completion)) as delay
            FROM tasks 
            WHERE date_start >= ? AND date_start <= ? AND type_id = ?',
      [$intervalStart, $intervalEnd, 1]
    )[0]->delay;

    $intervalData['shipmentTasks'] =  DB::select(
      'SELECT SUM(TIMESTAMPDIFF(HOUR, date_end, time_completion)) as delay
            FROM tasks 
            WHERE date_start >= ? AND date_start <= ? AND type_id = ?',
      [$intervalStart, $intervalEnd, 2]
    )[0]->delay;

    $intervalData['intraWarehouseTasks'] =  DB::select(
      'SELECT SUM(TIMESTAMPDIFF(HOUR, date_end, time_completion)) as delay
            FROM tasks 
            WHERE date_start >= ? AND date_start <= ? AND type_id = ?',
      [$intervalStart, $intervalEnd, 3]
    )[0]->delay;

    $intervalData['authorizationHistory'] = DB::select(
      'SELECT SUM(HOUR(auth.time_authorization) - HOUR(ws.start_time)) as lateness
            FROM authorization_history as auth
            JOIN users ON auth.user_id = users.id
            JOIN work_schedules as ws ON users.id = ws.user_id
            WHERE auth.time_authorization >= ? AND auth.time_authorization <= ?
            AND DAYOFWEEK(auth.time_authorization) = ws.day_of_week',
      [$intervalStart, $intervalEnd]
    )[0]->lateness;

    $intervalData['numberOfTasks'] = DB::select(
      'SELECT COUNT(id) as efficiency
            FROM tasks 
            WHERE date_start >= ? AND date_start <= ?',
      [$intervalStart, $intervalEnd]
    )[0]->efficiency;

    return $intervalData;
  }
}