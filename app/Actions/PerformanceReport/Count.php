<?php

namespace App\Actions\PerformanceReport;

class Count
{
  public function __invoke(array $criteriaList)
  {
    $maxValues = $this->findMaxValues($criteriaList);

    $normalizedCriteriaList =  $this->normalizeCriteriaList($criteriaList, $maxValues);

    $importance = [1, 0.7, 0.5, 1, 0.5];
    $signs = [-1, -1, -1, -1, 1];

    $additiveCriteriaList = $this->countAdditiveCriteriaList($normalizedCriteriaList, $importance, $signs);

    (new Export())->exportPerformanceReport($criteriaList, $normalizedCriteriaList, $additiveCriteriaList, $signs);
  }

  private function findMaxValues(array $criteriaList)
  {
    $maxValues = [];

    foreach ($criteriaList as $month) {
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

  private function normalizeCriteriaList(array $criteriaList, array $maxValues)
  {
    $normalizedCriteriaList = [];

    foreach ($criteriaList as $monthDateKey => $month) {
      foreach ($month as $key => $criteria) {
        $normalizedCriteriaList[$monthDateKey][$key] = $criteria / $maxValues[$key];
      }
    }

    return $normalizedCriteriaList;
  }

  private function countAdditiveCriteriaList(array $criteriaList, array $importance, array $signs)
  {
    $additiveCriteriaList = [];
    foreach ($criteriaList as $monthDateKey => $month) {
      $sum = 0;
      foreach ($month as $key => $criteria) {
        $index = array_search($key, array_keys($month), true);
        $sum += $importance[$index] * $signs[$index] * $criteria;
      }
      $additiveCriteriaList[$monthDateKey] = $sum;
    }
    return $additiveCriteriaList;
  }
}
