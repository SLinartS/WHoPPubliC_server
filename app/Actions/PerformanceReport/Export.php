<?php

namespace App\Actions\PerformanceReport;

use App\Services\File as ServicesFile;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Export
{
  public function exportPerformanceReport(array $criteriaList, array $normalizedCriteriaList, array $additiveCriteriaList, array $signs)
  {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $this->setDefaultStyles($sheet, $spreadsheet);

    $ratio =  $this->calculateRatio($criteriaList, $normalizedCriteriaList, $additiveCriteriaList);
    $recommendations = $this->generateRecommendations($additiveCriteriaList);

    $keysMonthDate = array_keys($criteriaList);
    $keysOfCriteriaList = array_keys($criteriaList[$keysMonthDate[0]]);

    $monthDateOffset = 2;
    $columnOffset = 4;

    for ($indexMonth = 0; $indexMonth < count($criteriaList); $indexMonth++) {
      $sheet->mergeCells('B' .  $monthDateOffset . ':B' . $monthDateOffset + 3);

      $sheet->setCellValue('B' . $monthDateOffset, substr($keysMonthDate[$indexMonth], 0, 7));

      $titles = [
        'Критерии',
        'Значения',
        'Отклонение от предыдущего месяца',
        'Вывод'
      ];

      $titleOfCriteriaList = [
        'Посрочки задач распределения, часов',
        'Посрочки задач отгрузки, часов',
        'Посрочки внутрискладских задач, часов',
        'Опоздания персонала, часов',
        'Количество выполненных задач, штук'
      ];

      for ($indexTitleRow = 0; $indexTitleRow < 4; $indexTitleRow++) {
        $sheet->setCellValue('C' . $indexTitleRow + $monthDateOffset, $titles[$indexTitleRow]);
      }

      for ($indexRow = 0; $indexRow < 4; $indexRow++) {
        for ($indexColumn = 0; $indexColumn < 5; $indexColumn++) {
          switch ($indexRow) {
            case 0:
              $sheet->setCellValueByColumnAndRow(
                $indexColumn + $columnOffset,
                $indexRow + $monthDateOffset,
                $titleOfCriteriaList[$indexColumn]
              );
              break;
            case 1:
              $this->setValueAndColorInCell(
                $sheet,
                $indexRow + $monthDateOffset,
                $indexColumn,
                $columnOffset,
                $criteriaList[$keysMonthDate[$indexMonth]][$keysOfCriteriaList[$indexColumn]],
                $signs,
                false
              );
              break;
            case 2:
              $this->setValueAndColorInCell(
                $sheet,
                $indexRow + $monthDateOffset,
                $indexColumn,
                $columnOffset,
                $ratio['criteriaList'][$keysMonthDate[$indexMonth]][$keysOfCriteriaList[$indexColumn]],
                $signs,
                true
              );
              break;
          }
        }
      }

      $sheet->mergeCells('D' .  $monthDateOffset + 3 . ':H' . $monthDateOffset + 3);
      $sheet->setCellValue('D' . $monthDateOffset + 3, $recommendations[$keysMonthDate[$indexMonth]]['text']);
      $sheet->getStyle('D' . $monthDateOffset + 3)->getFill()
        ->setFillType(Fill::FILL_SOLID)
        ->getStartColor()->setARGB($recommendations[$keysMonthDate[$indexMonth]]['color']);
      ;
      ;

      $sheet->getStyle('D' . $monthDateOffset + 3)->getFont()->setBold(true);
      $sheet->getStyle('D' . $monthDateOffset + 3)->getFont()->setSize(16);

      $monthDateOffset += 5;
    }

    $fileTitle = 'performance-report-' . date('Y-m-d_H-i-s') . '.xlsx';
    $filePath = __DIR__ . '\\..\\..\\..\\storage\\app\\public\\performance-reports\\' . $fileTitle;
    $writer = new Xlsx($spreadsheet);
    $writer->save($filePath);

    (new ServicesFile())->saveInfo($fileTitle);

    return ['fileTitle' => $fileTitle];
  }

  private function setDefaultStyles(Worksheet $sheet, Spreadsheet $spreadsheet)
  {
    $standardRange = $sheet->getStyle('A1:O20');

    $standardRange->getFont()->setSize(12);
    $standardRange->getAlignment()->setWrapText(true);
    $sheet->getStyle('A1:O20')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    $sheet->getStyle('A1:O20')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    $sheet->getDefaultRowDimension()->setRowHeight(45);
    $sheet->getDefaultColumnDimension()->setWidth(20);
  }

  private function setValueAndColorInCell(Worksheet $sheet, int $indexRow, int $indexColumn, int $columnOffset, string $value, array $signs, bool $percent)
  {
    $sign = (int) $value * $signs[$indexColumn];

    $cellStyle = $sheet->getCellByColumnAndRow($indexColumn + $columnOffset, $indexRow)->getStyle();

    if ((int) $value !== 0) {
      if ($sign < 0) {
        $cellStyle->getFill()
          ->setFillType(Fill::FILL_SOLID)
          ->getStartColor()->setARGB('FF8785');
        ;
      } else {
        $cellStyle->getFill()
          ->setFillType(Fill::FILL_SOLID)
          ->getStartColor()->setARGB('52FF89');
        ;
      }
    }

    $styleCellArray = [
      'borders' => [
        'outline' => [
          'borderStyle' => Border::BORDER_THIN,
          'color' => ['argb' => '000000'],
        ],
      ],
    ];

    $cellStyle->applyFromArray($styleCellArray);

    $percentMark = '';
    if ($percent) {
      $percentMark = '%';
    }

    $sheet->setCellValueByColumnAndRow(
      $indexColumn + $columnOffset,
      $indexRow,
      $value . $percentMark
    );
  }

  private function calculateRatio(array $criteriaList, array $normalizedCriteriaList, array $additiveCriteriaList)
  {
    $compareMonthReports = [];


    $keysOfMonth = array_keys($normalizedCriteriaList);
    for ($indexMonth = 0; $indexMonth < count($normalizedCriteriaList); $indexMonth++) {
      $keysOfCriteria = array_keys($normalizedCriteriaList[$keysOfMonth[$indexMonth]]);
      for ($indexCriteria = 0; $indexCriteria < count($normalizedCriteriaList[$keysOfMonth[$indexMonth]]); $indexCriteria++) {
        if ($indexMonth === 0) {
          $compareMonthReports[$keysOfMonth[$indexMonth]][$keysOfCriteria[$indexCriteria]] = '0';
        } else {
          $compareMonthReports[$keysOfMonth[$indexMonth]][$keysOfCriteria[$indexCriteria]] =
            round(100 *
              ($normalizedCriteriaList[$keysOfMonth[$indexMonth]][$keysOfCriteria[$indexCriteria]] -
                $normalizedCriteriaList[$keysOfMonth[$indexMonth - 1]][$keysOfCriteria[$indexCriteria]]) /
              abs($normalizedCriteriaList[$keysOfMonth[$indexMonth - 1]][$keysOfCriteria[$indexCriteria]]), PHP_ROUND_HALF_DOWN);
        }
      }
    }

    $compareMonthReportsResult = [];

    for ($indexMonth = 0; $indexMonth < count($additiveCriteriaList); $indexMonth++) {
      $keysOfCriteria = array_keys($additiveCriteriaList);

      if ($indexMonth === 0) {
        $compareMonthReportsResult[$keysOfMonth[$indexMonth]] = '0';
      } else {
        $compareMonthReportsResult[$keysOfMonth[$indexMonth]] =
          round(100 *
            ($additiveCriteriaList[$keysOfMonth[$indexMonth]] -
              $additiveCriteriaList[$keysOfMonth[$indexMonth - 1]]) /
            abs($additiveCriteriaList[$keysOfMonth[$indexMonth - 1]]), PHP_ROUND_HALF_DOWN);
      }
    }

    $ratio = [
      'criteriaList' => $compareMonthReports,
      'results' => $compareMonthReportsResult,
    ];

    return $ratio;
  }

  private function generateRecommendations(array $additiveCriteriaList)
  {
    $conclusion = [];

    $answers = [
      '0.5' => [
        'text' => 'Прекрасные результаты',
        'color' => '65FF47',
      ],
      '0' => [
        'text' => 'Хорошие результаты',
        'color' => 'C7FF99',
      ],
      '-0.5' => [
        'text' => 'В пределах нормы',
        'color' => 'FFFFFF',
      ],
      '-1' => [
        'text' => 'Плохие результаты',
        'color' => 'FF8785',
      ],
      '-1.5' => [
        'text' => 'Ужасные результаты',
        'color' => 'FF332E',
      ],
    ];

    foreach ($additiveCriteriaList as $monthDateKey => $month) {
      foreach ($answers as $score => $answer) {
        if ($month <= $score) {
          $conclusion[$monthDateKey] = $answer;
        }
      }
    }

    return $conclusion;
  }
}
