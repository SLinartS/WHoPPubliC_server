<?php

namespace App\Services;

use App\Models\Product as ModelsProduct;
use App\Models\Task as ModelsTask;
use App\Models\Zone as ModelsZone;

class Utils
{
  public function generateProductArticle()
  {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $charactersLength = strlen($characters);

    $result = '';
    for ($i = 0; $i < 5; $i++) {
      $result .=  $characters[rand(0, $charactersLength - 1)];
    }

    $isFindArticle = ModelsProduct::select('article')->where('article', $result)->first();
    if ($isFindArticle) {
      return $this->generateProductArticle();
    }
    return $result;
  }

  public function generateTaskArticle()
  {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $charactersLength = strlen($characters);

    $result = '';
    for ($i = 0; $i < 5; $i++) {
      $result .= $characters[rand(0, $charactersLength - 1)];
    }

    $isFindArticle = ModelsTask::select('article')->where('article', $result)->first();
    if ($isFindArticle) {
      return $this->generateTaskArticle();
    }
    return $result;
  }

  public function generateZoneLetter()
  {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);

    $result = '';
    for ($i = 0; $i < 1; $i++) {
      $result .= $characters[rand(0, $charactersLength - 1)];
    }

    $isFindLetter = ModelsZone::select('letter')->where('letter', $result)->first();
    if ($isFindLetter) {
      return $this->generateZoneLetter();
    }
    return $result;
  }
}
