<?php

namespace App\Services;

use App\Models\Category as ModelsCategory;
use App\Models\Product as ModelsProduct;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Services\File as ServicesFile;

class BalanceReport
{
  public function index()
  {
  }

  public function store()
  {
    $products = ModelsProduct::select('id', 'article', 'title', 'category_id', 'number')
      ->addSelect(['category' => ModelsCategory::select('alias')->whereColumn('id', 'category_id')->limit(1)])
      ->get();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $offsetRow = 3;
    $offsetColumn = 3;

    $titles = [
      'ID',
      'Артикул',
      'Название',
      'Количество',
      'Вид',
    ];

    for ($indexColumn = 0; $indexColumn < count($titles); $indexColumn++) {
      $sheet->setCellValue([$offsetColumn + $indexColumn, $offsetRow], $titles[$indexColumn]);
    }

    for ($indexRow = 0; $indexRow < count($products); $indexRow++) {
      $sheet->setCellValue([$offsetColumn + 0, $offsetRow + 1 + $indexRow], $products[$indexRow]->id);
      $sheet->setCellValue([$offsetColumn + 1, $offsetRow + 1 + $indexRow], $products[$indexRow]->article);
      $sheet->setCellValue([$offsetColumn + 2, $offsetRow + 1 + $indexRow], $products[$indexRow]->title);
      $sheet->setCellValue([$offsetColumn + 3, $offsetRow + 1 + $indexRow], $products[$indexRow]->number);
      $sheet->setCellValue([$offsetColumn + 4, $offsetRow + 1 + $indexRow], $products[$indexRow]->category);
    }

    for ($i = 1; $i <= 26; $i++) {
      $sheet->getColumnDimensionByColumn($i)->setAutoSize(TRUE);
    }

    return $this->saveFile($spreadsheet);
  }

  private function saveFile(Spreadsheet $spreadsheet)
  {
    $fileTitle = 'balance-report-' . date('Y-m-d_H-i-s') . '.xlsx';
    $filePath = __DIR__ . '\\..\\..\\storage\\app\\public\\reports\\balance\\' . $fileTitle;
    $writer = new Xlsx($spreadsheet);
    $writer->save($filePath);

    (new ServicesFile())->saveInfo($fileTitle, 2);

    return ['fileTitle' => $fileTitle];
  }
}
