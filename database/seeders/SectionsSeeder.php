<?php

namespace Database\Seeders;

use App\Models\sections;
use Illuminate\Database\Seeder;

class SectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // sections::truncate();
       foreach(range(1,100) as $range){
        sections::create([
            'section_name' => 'section' .$range,
            'description' => 'description' .$range,
            'created_by'=>'ziad ehab'
        ]);
       }
    }
}
