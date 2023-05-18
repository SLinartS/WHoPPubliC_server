<?php

namespace App\Services;

use App\Actions\ResponsePrepare\File as ResponsePrepareFile;
use App\Models\File as ModelsFile;
use App\Models\TypeOfFile;
use Illuminate\Support\Facades\Storage;

class File
{
  public function index(string | null $search)
  {
    $files = ModelsFile::select('id', 'title', 'type_id')
      ->addSelect(['type_alias' => TypeOfFile::select('alias')->whereColumn('id', 'type_id')->limit(1)])
      ->orderBy('title', 'desc');

    if ($search) {
      $searchField = '%' . $search . '%';
      $files = $files->where('title', 'like', $searchField)->get();
    } else {
      $files = $files->get();
    }

    return (new ResponsePrepareFile)($files);
  }

  public function saveInfo(string $title, int $typeId)
  {
    $file = new ModelsFile();
    $file->title = $title;
    $file->type_id = $typeId;
    $file->save();
  }

  public function download(int $id)
  {
    list($title, $typeTitle) = $this->getFileInfoById($id);
    return Storage::download('reports/' . $typeTitle . '/' . $title, $title);
  }

  public function destroy(int $id)
  {
    list($title, $typeTitle) = $this->getFileInfoById($id);
    ModelsFile::where('id', $id)->delete();
    Storage::delete('reports/' . $typeTitle . '/' . $title);
  }

  private function getFileInfoById(int $id)
  {
    $file = ModelsFile::select('title', 'type_id')->where('id', $id)
      ->addSelect(['type_title' => TypeOfFile::select('title')->whereColumn('id', 'type_id')->limit(1)])
      ->first();
    return [$file->title, $file->type_title];
  }
}
