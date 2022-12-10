<?php

namespace App\Actions\AdditiveCriterion;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PerfomanceReportExport
{
  public function exportPerfomanceReport(array $additiveCriteriasValue, array $importance, array $signs, array $maxValues)
  {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $this->setDefaultStyles($sheet, $spreadsheet);

    $keysOfArray = array_keys($additiveCriteriasValue);
    $keysOfCriterias = array_keys($additiveCriteriasValue[$keysOfArray[0]]);

    $sheet->mergeCells('B3:B4');

    $sheet->mergeCells('B8:B9');

    $sheet->mergeCells('B10:B11');

    $stringArray = [
      ['B3', 'Абсолютные значения'],
      ['B8', 'Нормализованные значения'],
      ['B10', 'Норм * знач * знак'],
      ['C3', 'Прошлый месяц'],
      ['C8', 'Прошлый месяц'],
      ['C4', 'Текущий месяц'],
      ['C9', 'Текущий месяц'],
      ['C10', 'Текущий месяц'],
      ['C11', 'Текущий месяц'],
      ['C5', 'Максимальное значение'],
      ['C6', 'Значимость'],
      ['C7', 'Знак'],
      ['D2', 'Просрочки задач распределения'],
      ['E2', 'Просрочки задач отгурзки'],
      ['F2', 'Просрочки внутрискладских задач'],
      ['G2', 'Суммарные опоздания сотрудников'],
      ['H2', 'Эффективность работы сотрудников'],
      ['I2', 'Сравнительный рейтинг'],
    ];


    $this->setValueInCells($sheet, $stringArray, true);

    // $sheet->getDefaultRowDimension()->setRowHeight(45);
    $sheet->getDefaultColumnDimension()->setWidth(20);

    for ($row = 3; $row < 5; $row++) {
      for ($column = 4; $column < 9; $column++) {

        $cellValue = $additiveCriteriasValue[$keysOfArray[$row - 3]][$keysOfCriterias[$column - 4]];

        $sheet->setCellValueByColumnAndRow($column, $row, $cellValue);
      }
    }

    for ($column = 4; $column < 9; $column++) {
      $keys = array_keys($maxValues);
      $cellValue = $maxValues[$keys[$column - 4]];

      $sheet->setCellValueByColumnAndRow($column, 5, $cellValue);
    }

    for ($column = 4; $column < 9; $column++) {

      $cellValue = $importance[$column - 4];

      $sheet->setCellValueByColumnAndRow($column, 6, $cellValue);
    }

    for ($column = 4; $column < 9; $column++) {

      $cellValue = $signs[$column - 4];

      $sheet->setCellValueByColumnAndRow($column, 7, $cellValue);
    }

    for ($row = 8; $row < 10; $row++) {
      for ($column = 4; $column < 9; $column++) {

        $cellValue = $additiveCriteriasValue[$keysOfArray[$row - 6]][$keysOfCriterias[$column - 4]];

        $sheet->setCellValueByColumnAndRow($column, $row, $cellValue);
      }
    }

    for ($row = 10; $row < 12; $row++) {
      for ($column = 4; $column < 9; $column++) {

        $cellValue = $additiveCriteriasValue[$keysOfArray[$row - 8]][$keysOfCriterias[$column - 4]] * $importance[$column - 4] * $signs[$column - 4];

        $sheet->setCellValueByColumnAndRow($column, $row, $cellValue);
      }
    }

    $sheet->setCellValueByColumnAndRow(9, 10, $additiveCriteriasValue[$keysOfArray[4]]);
    $sheet->setCellValueByColumnAndRow(9, 11, $additiveCriteriasValue[$keysOfArray[5]]);

    $writer = new Xlsx($spreadsheet);
    $writer->save(__DIR__ . '/../../../performanceReports/perfomance-report-' . date('Y-m-d H-i-s') . '.xlsx');
  }


  private function setDefaultStyles(Worksheet $sheet, Spreadsheet $spreadsheet)
  {
    $standartRange = $sheet->getStyle('A1:O20');
    $spreadsheet->getDefaultStyle()->getFont()->setName('Tahoma');
    $standartRange->getFont()->setSize(12);
    $standartRange->getAlignment()->setWrapText(true);
    $standartRange->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    $standartRange->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
  }

  private function setValueInCells(Worksheet $sheet, array $values, bool $wrap)
  {
    foreach ($values as $value) {
      $sheet->setCellValue($value[0], $value[1]);
      $cell = $sheet->getCell($value[0]);
      if ($wrap) {
        $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffc924');
        $cell->getStyle()->getFont()->setBold(true);
        $sheet->getRowDimension(substr($value[0], 1))->setRowHeight(45);

        $styleArray = [
          'borders' => [
            'allBorders' => [
              'borderStyle' => Border::BORDER_THIN,
              'color' => ['argb' => '000000'],

            ],
          ],
        ];

        $cell->getStyle()->applyFromArray($styleArray);
      }
    }
  }
}
