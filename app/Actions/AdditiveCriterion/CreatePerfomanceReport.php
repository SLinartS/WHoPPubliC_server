<?php

namespace App\Actions\AdditiveCriterion;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CreatePerfomanceReport
{

  // $response = [
  //   'lastMonthCritery' => $lastMonthCriteria,
  //   'currentMonthCritery' => $currentMonthCriteria,
  //   'lastMonthNormalizeCriteria' => $lastMonthNormalizeCriteria,
  //   'currentMonthNormalizeCriteria' => $currentMonthNormalizeCriteria,
  //   'lastMonthAdditiveCritearia' => $lastMonthAdditiveCritearia,
  //   'currentMonthAdditiveCritearia' => $currentMonthAdditiveCritearia
  // ];

  public function createPerfomanceReport(array $additiveCriteriasValue)
  {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $this->setDefaultStyles($sheet, $spreadsheet);

    $keysOfArray = array_keys($additiveCriteriasValue);
    $keysOfCriterias = array_keys($additiveCriteriasValue[$keysOfArray[0]]);

    $sheet->mergeCells('B3:B4');

    $sheet->mergeCells('B5:B6');

    $stringArray = [
      ['B3', 'Абсолютные значения'],
      ['B5', 'Нормализованные значения'],
      ['C3', 'Прошлый месяц'],
      ['C5', 'Прошлый месяц'],
      ['C4', 'Текущий месяц'],
      ['C6', 'Текущий месяц'],
      ['D2', 'Просрочки задач распределения'],
      ['E2', 'Просрочки задач отгурзки'],
      ['F2', 'Просрочки внутрискладских задач'],
      ['G2', 'Суммарные опоздания сотрудников'],
      ['H2', 'Эффективность работы сотрудников'],
      ['I2', 'Сравнительный рейтинг'],
    ];


    $this->setValueInCells($sheet, $stringArray, true);

    $sheet->getDefaultRowDimension()->setRowHeight(60);
    $sheet->getDefaultColumnDimension()->setWidth(15);

    for ($row = 3; $row < 7; $row++) {
      for ($column = 4; $column < 9; $column++) {

        $cellValue = $additiveCriteriasValue[$keysOfArray[$row - 3]][$keysOfCriterias[$column - 4]];

        $sheet->setCellValueByColumnAndRow($column, $row, $cellValue);
      }
    }

    $sheet->setCellValueByColumnAndRow(9, 5, $additiveCriteriasValue[$keysOfArray[4]]);
    $sheet->setCellValueByColumnAndRow(9, 6, $additiveCriteriasValue[$keysOfArray[5]]);

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
