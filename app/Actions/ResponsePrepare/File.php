<?php

namespace App\Actions\ResponsePrepare;

use Illuminate\Database\Eloquent\Collection;

class File
{
  public function __invoke(Collection $files)
  {
    $response = [];

    foreach ($files as $file) {
      array_push($response, [
        'id' => [
          'value' => $file->id,
          'alias' => 'ID'
        ],
        'title' => [
          'value' => $file->title,
          'alias' => 'Название'
        ],
        'typeId' => [
          'value' => $file->type_id,
          'alias' => 'typeId'
        ],
        'typeAlias' => [
          'value' => $file->type_alias,
          'alias' => 'Тип'
        ],
      ]);
    }

    return $response;
  }
}
