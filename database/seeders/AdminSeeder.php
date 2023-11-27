<?php

namespace Database\Seeders;

use App\Models\Admin\Category;
use App\Models\Admin\CategoryTranslation;
use App\Models\Admin\Item;
use App\Models\Admin\ItemTranslation;
use App\Models\Admin\Service;
use App\Models\Admin\ServiceTranslation;
use App\Traits\AdminTrailt;
use App\Models\Role;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {

        $roles = AdminTrailt::$roles;
        foreach ($roles as $role) {
            Role::create($role);
        }


        $categories = AdminTrailt::$categories;
        foreach ($categories as $categoryData) {
            $category = Category::create([
                'image' => 'text.jpg',
            ]);
            foreach (['en', 'ar'] as $locale) {
                CategoryTranslation::create([
                    'category_id' => $category->id,
                    'locale' => $locale,
                    'name' => $categoryData['name'][$locale],
                    'desc' => $categoryData['desc'][$locale],
                ]);
            }
        }

        
        $items = AdminTrailt::$items;
        foreach ($items as $itemData) {
            $item = Item::create([
                'image' => 'text.jpg',
                'category_id' => $itemData['category_id'],
            ]);
            foreach (['en', 'ar'] as $locale) {
                ItemTranslation::create([
                    'item_id' => $item->id,
                    'locale' => $locale,
                    'name' => $itemData['name'][$locale],
                    'desc' => $itemData['desc'][$locale],
                ]);
            }
        }


        $services = AdminTrailt::$services;
        foreach ($services as $serviceData) {
            $service = Service::factory()->create([
                'image' => 'text.jpg',
            ]);
            $service->items()->attach($serviceData['item_ids']);
            foreach (['en', 'ar'] as $locale) {
                ServiceTranslation::create([
                    'service_id' => $service->id,
                    'locale' => $locale,
                    'name' => $serviceData['name'][$locale],
                    'desc' => $serviceData['desc'][$locale],
                ]);
            }
        }
    }
}
