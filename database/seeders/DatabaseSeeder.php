<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    $this->call([
      RoleSeeder::class,
      UserSeeder::class,
      AuthorizationHistorySeeder::class,
      WorkScheduleSeeder::class,
      ProductTypeSeeder::class,
      CategorySeeder::class,
      ProductSeeder::class,
      BookSeeder::class,
      AudienceSeeder::class,
      RegularitySeeder::class,
      MagazineSeeder::class,
      ZoneSeeder::class,
      SectionSeeder::class,
      BlockSeeder::class,
      FloorSeeder::class,
      ProductFloorSeeder::class,
      TypeOfTaskSeeder::class,
      TaskSeeder::class,
      TypeOfPointSeeder::class,
      PointSeeder::class,
      ProductPointSeeder::class,
      ProductTaskSeeder::class,
      FileSeeder::class,
    ]);
  }
}
