<?php

namespace App\Services;

use App\Actions\ResponsePrepare\Map as ResponsePrepareMap;
use App\Models\Block as ModelsBlock;
use App\Models\Floor as ModelsFloor;
use App\Models\Section as ModelsSection;
use App\Models\Zone as ModelsZone;
use Illuminate\Database\Eloquent\Model;

class Map
{
  public function index(string | null $search)
  {
    $zones = ModelsZone::select('id', 'number', 'letter')->get();
    $sections = ModelsSection::select('id', 'number', 'zone_id')->get();
    $blocks = ModelsBlock::select('id', 'number', 'section_id')->get();
    $floors = ModelsFloor::select('id', 'number', 'block_id', 'capacity')->get();

    return (new ResponsePrepareMap())(
      $zones,
      $sections,
      $blocks,
      $floors,
      $search
    );
  }

  public function update(array $zone)
  {
    $zoneWithIdFromRequest = ModelsZone::where('id', $zone['id'])->first();

    if ($zoneWithIdFromRequest) {
      $this->removeMapElements($zoneWithIdFromRequest, $zone);

      foreach ($zone['sections'] as $section) {
        $sectionDB = ModelsSection::where('id', $section['id'])->first();

        if ($sectionDB) {
          foreach ($section['blocks'] as $block) {
            $blockDB = ModelsBlock::where('id', $block['id'])->first();

            if ($blockDB) {
              foreach ($block['floors'] as $floor) {
                $floorDB = ModelsFloor::where('id', $floor['id'])->first();

                if (!$floorDB) {
                  $this->createFloor($floor, $block['id']);
                }
              }
            } else {
              $newBlock = $this->createBlock($block, $section['id']);
              foreach ($block['floors'] as $floor) {
                $this->createFloor($floor, $newBlock->id);
              }
            }
          }
        } else {
          $newSection = $this->createSection($section, $zone['id']);
          foreach ($section['blocks'] as $block) {
            $newBlock = $this->createBlock($block, $newSection->id);
            foreach ($block['floors'] as $floor) {
              $this->createFloor($floor, $newBlock->id);
            }
          }
        }
      }
    } else {
      $newZone = $this->createZone($zone);
      foreach ($zone['sections'] as $section) {
        $newSection = $this->createSection($section, $newZone->id);
        foreach ($section['blocks'] as $block) {
          $newBlock = $this->createBlock($block, $newSection->id);
          foreach ($block['floors'] as $floor) {
            $this->createFloor($floor, $newBlock->id);
          }
        }
      }
    }
  }

  public function destroy(int $zoneId)
  {
    $sectionIds = ModelsSection::select('id', 'zone_id')
    ->where('zone_id', $zoneId)
    ->get()
    ->pluck('id')
    ->toArray();

    $blockIds = ModelsBlock::select('id', 'section_id')
    ->whereIn('section_id', $sectionIds)
    ->get()
    ->pluck('id')
    ->toArray();

    ModelsFloor::select('id', 'block_id')
    ->whereIn('block_id', $blockIds)->delete();

    ModelsBlock::whereIn('id', $blockIds)->delete();
    ModelsSection::whereIn('id', $sectionIds)->delete();
    ModelsZone::where('id', $zoneId)->delete();
  }

  private function removeMapElements(Model $zoneDB, array $zoneRequest)
  {
    foreach ($zoneDB->sections as $sectionDB) {
      $sectionDeletedId = 0;
      $foundSectionRequest = null;
      foreach ($zoneRequest['sections'] as $sectionRequest) {
        if ($sectionDB->id === $sectionRequest['id']) {
          $sectionDeletedId = $sectionRequest['id'];
          $foundSectionRequest = $sectionRequest;
        }
      }

      if (!$sectionDeletedId) {
        $blockIds = ModelsBlock::select('id', 'section_id')
        ->where('section_id', $sectionDB->id)
        ->get()
        ->pluck('id')
        ->toArray();

        $floorIds = ModelsFloor::select('id', 'block_id')
        ->whereIn('block_id', $blockIds)
        ->get()
        ->pluck('id')
        ->toArray();

        ModelsFloor::whereIn('id', $floorIds)->delete();
        ModelsBlock::whereIn('id', $blockIds)->delete();
        ModelsSection::where('id', $sectionDB->id)->delete();
      } else {
        foreach ($sectionDB->blocks as $blockDB) {
          $blockDeletedId = 0;
          $foundBlockRequest = null;
          foreach ($foundSectionRequest['blocks'] as $blockRequest) {
            if ($blockDB->id === $blockRequest['id']) {
              $blockDeletedId = $blockRequest['id'];
              $foundBlockRequest = $blockRequest;
            }
          }

          if (!$blockDeletedId) {
            $floorIds = ModelsFloor::select('id', 'block_id')
            ->where('block_id', $blockDB->id)
            ->get()
            ->pluck('id')
            ->toArray();

            ModelsFloor::whereIn('id', $floorIds)->delete();
          } else {
            foreach ($blockDB->floors as $floorDB) {
              $floorDeletedId = 0;
              $floorsOfBlock = $foundBlockRequest['floors'];
              foreach ($floorsOfBlock as $floorRequest) {
                if ($floorDB->id === $floorRequest['id']) {
                  $floorDeletedId = $floorRequest['id'];
                }
              }

              if (!$floorDeletedId) {
                $floorIds = ModelsFloor::select('id', 'block_id')
                ->where('block_id', $blockDB->id)
                ->get()
                ->pluck('id')
                ->toArray();

                ModelsFloor::select('id', 'block_id')
                ->where('block_id', $blockDB->id)
                ->where('id', $floorDB->id)
                ->delete();
              }
            }
          }
        }
      }
    }
  }

  private function createZone(array $zone)
  {
    $newZone = new ModelsZone();
    $newZone->number = $zone['number'];
    $newZone->letter = $zone['zoneLetter'];
    $newZone->save();
    return $newZone;
  }

  private function createSection(array $section, int $zoneId)
  {
    $newSection = new ModelsSection();
    $newSection->number = $section['number'];
    $newSection->zone_id = $zoneId;
    $newSection->save();
    return $newSection;
  }

  private function createBlock(array $block, int $sectionId)
  {
    $newBlock = new ModelsBlock();
    $newBlock->number = $block['number'];
    $newBlock->section_id = $sectionId;
    $newBlock->save();
    return $newBlock;
  }

  private function createFloor(array $floor, int $blockId)
  {
    $newFloor = new ModelsFloor();
    $newFloor->capacity = $floor['capacity'];
    $newFloor->number = $floor['number'];
    $newFloor->block_id = $blockId;
    $newFloor->save();
  }
}
