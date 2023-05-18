<?php

namespace App\Http\Controllers;

use App\Services\BalanceReport as ServicesBalanceReport;
use App\Services\File as ServicesFile;
use App\Services\PerformanceReport as ServicesPerformanceReport;
use Exception;
use Illuminate\Http\Request;

class FileController extends Controller
{
  public function index(Request $request, ServicesFile $servicesFile)
  {
    $search = $request->query('search');
    $response = $servicesFile->index($search);
    return $response;
  }

  public function store(Request $request, ServicesPerformanceReport $servicePerfomance, ServicesBalanceReport $serviceBalance)
  {
    $reportType = $request->reportType;

    $intervals = [
      ['2021-06-01', '2021-06-30'],
      ['2021-07-01', '2021-07-31'],
    ];

    $response = [];

    switch ($reportType) {
      case 'performance':
        $response = $servicePerfomance->store($intervals);
        break;
      case 'balance':
        $response = $serviceBalance->store($intervals);
        break;
      default:
        throw new Exception('Error report type');
    }

    return response()->json(
      [
        'message' => 'Report has been created',
        'data' => $response,
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
}
