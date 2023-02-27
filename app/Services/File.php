<?php

namespace App\Services;

use App\Models\File as ModelsFile;
use Illuminate\Support\Facades\Storage;

class File
{
  public function index(string | null $search)
  {
    $files = ModelsFile::select('id', 'title')->orderBy('title', 'desc');

    if ($search) {
      $searchField = '%' . $search . '%';
      $files = $files->where('title', 'like', $searchField)->get();
    } else {
      $files = $files->get();
    }

    return $files;
  }

  public function saveInfo(string $title)
  {
    $file = new ModelsFile();
    $file->title = $title;
    $file->save();
  }

  public function download(int $id)
  {
    $title = ModelsFile::select('title')->where('id', $id)->first()->title;
    return Storage::download('public/performance-reports/' . $title, $title);
  }

  public function destroy(int $id)
  {
    $title = ModelsFile::select('title')->where('id', $id)->first()->title;
    ModelsFile::where('id', $id)->delete();
    Storage::delete('public/performance-reports/' . $title);
  }
}
