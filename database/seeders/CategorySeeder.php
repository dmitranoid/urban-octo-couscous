<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->truncate();

        DB::table('categories')->insert([
            ['name'=> 'S7-300', 'slug'=> 's7-300', 'image' => '', 'description'=> '', 'parent_id' => null, 'is_active' => 1, 'manufacturer_id'=> 1],
            ['name'=> 'SIMATIC DP', 'slug'=> Str::slug('SIMATIC_DP'), 'image' => '', 'description'=> '', 'parent_id' => null, 'is_active' => 1, 'manufacturer_id'=> 2],
            ['name'=> 'HMI', 'slug'=> Str::slug('HMI'), 'image' => '', 'description'=> '', 'parent_id' => null, 'is_active' => 1, 'manufacturer_id'=> 2],
            ['name'=> 'SITOP', 'slug'=> Str::slug('SITOP'), 'image' => '', 'description'=> '', 'parent_id' => null, 'is_active' => 1, 'manufacturer_id'=> 1],
            ['name'=> 'SINAMICS', 'slug'=> Str::slug('SINAMICS'), 'image' => '', 'description'=> '', 'parent_id' => null, 'is_active' => 1, 'manufacturer_id'=> 3],
            ['name'=> 'SIMATIC S7', 'slug'=> Str::slug('SIMATIC S7'), 'image' => '', 'description'=> '', 'parent_id' => null, 'is_active' => 1, 'manufacturer_id'=> 3],
            ['name'=> 'ET 200SP', 'slug'=> Str::slug('ET 200SP'), 'image' => '', 'description'=> '', 'parent_id' => null, 'is_active' => 1, 'manufacturer_id'=> 1],
            ['name'=> 'ET 200AL', 'slug'=> Str::slug('ET 200AL'), 'image' => '', 'description'=> '', 'parent_id' => null, 'is_active' => 1, 'manufacturer_id'=> 2],
            ['name'=> 'S7-1500', 'slug'=> Str::slug('S7-1500'), 'image' => '', 'description'=> '', 'parent_id' => null, 'is_active' => 1, 'manufacturer_id'=> 1],
            ['name'=> 'MICROMASTER', 'slug'=> Str::slug('MICROMASTER'), 'image' => '', 'description'=> '', 'parent_id' => null, 'is_active' => 1, 'manufacturer_id'=> 2],
            ['name'=> 'SIWAREX', 'slug'=> Str::slug('SIWAREX'), 'image' => '', 'description'=> '', 'parent_id' => null, 'is_active' => 1, 'manufacturer_id'=> 3],
            ['name'=> 'SCALANCE', 'slug'=> Str::slug('SCALANCE'), 'image' => '', 'description'=> '', 'parent_id' => null, 'is_active' => 1, 'manufacturer_id'=> 3],
            ['name'=> 'SENTRON', 'slug'=> Str::slug('SENTRON'), 'image' => '', 'description'=> '', 'parent_id' => null, 'is_active' => 1, 'manufacturer_id'=> 3],
            ['name'=> 'SIRIUS', 'slug'=> Str::slug('SIRIUS'), 'image' => '', 'description'=> '', 'parent_id' => null, 'is_active' => 1, 'manufacturer_id'=> 1],
            ['name'=> 'SIMOCODE', 'slug'=> Str::slug('SIMOCODE'), 'image' => '', 'description'=> '', 'parent_id' => null, 'is_active' => 1, 'manufacturer_id'=> 2],
        ]);
    }
}
