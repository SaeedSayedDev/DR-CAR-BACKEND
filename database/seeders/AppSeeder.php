<?php

namespace Database\Seeders;

use App\Models\Media;
use Illuminate\Database\Seeder;

class AppSeeder extends Seeder
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
