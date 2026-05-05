<?php

namespace Database\Seeders;

use DB;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MerchItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $artistIds = [1, 2];
        $imagePath = 'images/merch/pmwbsr4zxo8Qe0ZeoXOFjVDePVOms9jsfTCww5jw.png';
        $count = 50;

        for ($i = 0; $i < $count; $i++) {
            $now = now();

            // Insert into merch_items table with all fields
            $itemId = DB::table('merch_items')->insertGetId([
                'artist_id' => $artistIds[array_rand($artistIds)],
                'name' => $faker->unique()->words(3, true),
                'description' => $faker->paragraph(),
                'price' => $faker->randomFloat(2, 5, 200),
                'approved' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            // Insert into merch_item_images table with all fields
            DB::table('merch_item_images')->insert([
                'merch_item_id' => $itemId,
                'image_path' => $imagePath,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
