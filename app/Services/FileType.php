<?php

namespace App\Services;

use App\Actions\ResponsePrepare\Option;
use App\Models\TypeOfFile as ModelsTypeOfFile;

class FileType
{
  public function index()
  {
    $filesTypes = ModelsTypeOfFile::select('id', 'title', 'alias')->get();

    return (new Option())($filesTypes);
  }
}
