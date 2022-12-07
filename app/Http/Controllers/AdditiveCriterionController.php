<?php



namespace App\Http\Controllers;

use App\Actions\AdditiveCriterion\AdditiveCriterionCount;
use App\Models\AuthorizationHistory;
use App\Models\Task;

class AdditiveCriterionController extends Controller
{
    public function index(AdditiveCriterionCount $additiveCriterionCount)
    {
        $lastMonth = [
            'placementTasks' => [],
            'shipmentTasks' => [],
            'intraWarehouseTasks' => [],
            'authorizationHistory' => [],
            'numberOfTasks' => [],
        ];

        $lastMonth['placementTasks'] = Task::select('date_end', 'time_completion')
            ->where([['date_start', '>=', '2021-06-01 00:00:00'], ['date_start', '<=', '2021-06-30 00:00:00'], ['type_id', '=', 1]])
            ->get();

        $lastMonth['shipmentTasks'] = Task::select('date_end', 'time_completion')
            ->where([['date_start', '>=', '2021-06-01 00:00:00'], ['date_start', '<=', '2021-06-30 00:00:00'], ['type_id', '=', 2]])
            ->get();

        $lastMonth['intraWarehouseTasks'] = Task::select('date_end', 'time_completion')
            ->where([['date_start', '>=', '2021-06-01 00:00:00'], ['date_start', '<=', '2021-06-30 00:00:00'], ['type_id', '=', 3]])
            ->get();

        $lastMonth['authorizationHistory'] = AuthorizationHistory::select('time_authorization', 'user_id')
            ->where([['time_authorization', '>=', '2021-06-01 00:00:00'], ['time_authorization', '<=', '2021-06-30 00:00:00']])
            ->get();

        $lastMonth['numberOfTasks'] =
            $lastMonth['placementTasks']->count() +
            $lastMonth['shipmentTasks']->count() +
            $lastMonth['intraWarehouseTasks']->count();


        $currentMonth = [
            'placementTasks' => [],
            'shipmentTasks' => [],
            'intraWarehouseTasks' => [],
            'authorizationHistory' => [],
            'numberOfTasks' => [],
        ];

        $currentMonth['placementTasks'] = Task::select('date_end', 'time_completion')
            ->where([['date_start', '>=', '2021-07-01 00:00:00'], ['date_start', '<=', '2021-07-31 00:00:00'], ['type_id', '=', 1]])
            ->get();

        $currentMonth['shipmentTasks'] = Task::select('date_end', 'time_completion')
            ->where([['date_start', '>=', '2021-07-01 00:00:00'], ['date_start', '<=', '2021-07-31 00:00:00'], ['type_id', '=', 2]])
            ->get();

        $currentMonth['intraWarehouseTasks'] = Task::select('date_end', 'time_completion')
            ->where([['date_start', '>=', '2021-07-01 00:00:00'], ['date_start', '<=', '2021-07-31 00:00:00'], ['type_id', '=', 3]])
            ->get();

        $currentMonth['authorizationHistory'] = AuthorizationHistory::select('time_authorization', 'user_id')
            ->where([['time_authorization', '>=', '2021-07-01 00:00:00'], ['time_authorization', '<=', '2021-07-31 00:00:00']])
            ->get();

        $currentMonth['numberOfTasks'] =
            $currentMonth['placementTasks']->count() +
            $currentMonth['shipmentTasks']->count() +
            $currentMonth['intraWarehouseTasks']->count();


        $response = $additiveCriterionCount($lastMonth, $currentMonth);

        return response()->json(
            [
                'message' => 'Perfomance report have been created',
                'criterias' => $response['criterias'],
                'fileName' => $response['fileData']
            ],
            200
        );
    }
}
