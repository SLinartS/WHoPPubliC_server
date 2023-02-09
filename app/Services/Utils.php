<?php

namespace App\Services;

use App\Models\Product as ModelsProduct;
use App\Models\Task as ModelsTask;

class Utils
{
  public function generateProductArticle()
  {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $charactersLength = strlen($characters);

    $result = '';
    for ($i = 0; $i < 5; $i++) {
      $result .=  $characters[rand(0, $charactersLength)];
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
      $result .= $characters[rand(0, $charactersLength)];
    }

    $isFindArticle = ModelsTask::select('article')->where('article', $result)->first();
    if ($isFindArticle) {
      return $this->generateTaskArticle();
    }
    return $result;
  }


}
