<?php

use Illuminate\Database\Seeder;

class AdsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $data = [];
        for($i = 0; $i < 50; $i++) {
            $data[] = [
            'text' => str_random(50),
            'user_id' => rand(1,7),
            'photo' => 'images/no_photo.png', 
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
            'published' => rand(0,1), 
            ];
        }
        
        DB::table('ads')->insert($data);
    }
}
