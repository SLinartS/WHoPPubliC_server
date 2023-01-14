<?php

namespace App\Actions\PerfomanceReport;

class Count
{
  public function __invoke(array $criterias)
  {
    $maxValues = $this->findMaxValues($criterias);

    $normalizedCriterias =  $this->normalizeCriterias($criterias, $maxValues);

    $importance = [1, 0.7, 0.5, 1, 0.5];
    $signs = [-1, -1, -1, -1, 1];

    $additiveCritearias = $this->countAdditiveCriterias($normalizedCriterias, $importance, $signs);

    $response = [
      'criterias' => $criterias,
      'normalizedCriterias' => $normalizedCriterias,
      'importance' => $importance,
      'signs' => $signs,
      'additiveCritearias' => $additiveCritearias
    ];

    $fileData = (new Export())->exportPerfomanceReport($criterias, $normalizedCriterias, $additiveCritearias, $signs);

    return $fileData;
  }

  private function findMaxValues(array $criterias)
  {
    $maxValues = [];

    foreach ($criterias as $month) {
      foreach ($month as $key => $criteria) {
        if (!array_key_exists($key, $maxValues)) {
          $maxValues[$key] = $criteria;
        }

        if ($maxValues[$key] < $criteria) {
          $maxValues[$key] = $criteria;
        }
      }
    }

    return $maxValues;
  }

  private function normalizeCriterias(array $criterias, array $maxValues)
  {
    $normalizedCriterias = [];

    foreach ($criterias as $monthDateKey => $month) {
      foreach ($month as $key => $criteria) {
        $normalizedCriterias[$monthDateKey][$key] = $criteria / $maxValues[$key];
      }
    }

    return $normalizedCriterias;
  }

  private function countAdditiveCriterias(array $criterias, array $importance, array $signs)
  {
    $additiveCritearias = [];
    foreach ($criterias as $monthDateKey => $month) {
      $sum = 0;
      foreach ($month as $key => $criteria) {
        $index = array_search($key, array_keys($month), true);
        $sum += $importance[$index] * $signs[$index] * $criteria;
      }
      $additiveCritearias[$monthDateKey] = $sum;
    }
    return $additiveCritearias;
  }
}
