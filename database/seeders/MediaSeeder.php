<?php

namespace Database\Seeders;

use App\Models\Media;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    private $baseUrl;
    
    public function __construct()
    {
        $this->baseUrl = rtrim(config('app.url'), '/');
        if (strpos($this->baseUrl, 'localhost') !== false && strpos($this->baseUrl, ':') !== false) {
            $this->baseUrl .= ':8000';
        }
        $this->baseUrl .= '/api/images';
    }

    public function run()
    {
        for ($i = 1; $i < 6; $i++) {
            Media::create([
                'type' => 'category',
                'type_id' => $i,
                'image' => "$this->baseUrl/Category/$i.jpg",
            ]);
        }

        for ($i = 1; $i < 10; $i++) {
            Media::create([
                'type' => 'item',
                'type_id' => $i,
                'image' => "$this->baseUrl/Item/0$i.jpg"
            ]);
        }

        for ($i = 1; $i < 6; $i++) {
            Media::create([
                'type' => 'slide',
                'type_id' => $i,
                'image' => "$this->baseUrl/Slide/0$i.jpg"
            ]);
        }

        for ($i = 1; $i < 6; $i++) {
            Media::create([
                'type' => 'service',
                'type_id' => $i,
                'image' => "$this->baseUrl/Service/$i.jpg"
            ]);
        }

        for ($i = 1; $i < 9; $i++) {
            Media::create([
                'type' => 'user',
                'type_id' => $i,
                'image' => "$this->baseUrl/Provider/$i.jpg"
            ]);
        }

        Media::create([
            'type' => 'default',
            'type_id' => '0',
            'image' => "$this->baseUrl/App/default.jpeg"
        ]);

        Media::create([
            'type' => 'logo',
            'type_id' => '0',
            'image' => "$this->baseUrl/App/logo.png"
        ]);    

        Media::create([
            'type' => 'none',
            'type_id' => '0',
            'image' => "$this->baseUrl/App/none.png"
        ]);
    }
}