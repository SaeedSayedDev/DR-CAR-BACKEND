<?php

namespace Database\Seeders;

use App\Models\Media;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i < 6; $i++) {
            Media::create([
                'type' => 'category',
                'type_id' => $i,
                'image' => url("api/images/Category/$i.jpg")
            ]);
        }

        for ($i = 1; $i < 10; $i++) {
            Media::create([
                'type' => 'item',
                'type_id' => $i,
                'image' => url("api/images/Item/0$i.jpg")
            ]);
        }

        for ($i = 1; $i < 6; $i++) {
            Media::create([
                'type' => 'slide',
                'type_id' => $i,
                'image' => url("api/images/Slide/0$i.jpg")
            ]);
        }

        for ($i = 1; $i < 6; $i++) {
            Media::create([
                'type' => 'service',
                'type_id' => $i,
                'image' => url("api/images/Service/$i.jpg")
            ]);
        }

        for ($i = 1; $i < 9; $i++) {
            Media::create([
                'type' => 'user',
                'type_id' => $i,
                'image' => url("api/images/Provider/$i.jpg")
            ]);
        }

        for ($i = 1; $i < 5; $i++) {
            Media::create([
                'type' => 'garage_data',
                'type_id' => $i,
                'image' => url("api/images/Provider/$i.jpg")
            ]);
        }

        Media::create([
            'type' => 'logo',
            'type_id' => '0',
            'image' => url("api/images/App/logo.png")
        ]);
    }
}
