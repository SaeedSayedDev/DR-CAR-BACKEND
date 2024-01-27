<?php

namespace Database\Seeders;

use App\Models\Admin\Category;
use App\Models\Admin\CategoryTranslation;
use App\Models\Admin\Item;
use App\Models\Admin\ItemTranslation;
use App\Models\Admin\PaymentMethod;
use App\Models\Admin\Service;
use App\Models\Admin\ServiceTranslation;
use App\Models\Admin\StatusOrder;
use App\Models\Commission;
use App\Models\OptionsGroup;
use App\Traits\AdminTrailt;
use App\Models\Role;
use App\Models\Slide;
use App\Models\Taxe;
use App\Models\WeekDays;
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
            $category = Category::create();
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


        $paymentMethods = AdminTrailt::$paymentMethods;
        foreach ($paymentMethods as $paymentMethod) {
            PaymentMethod::create($paymentMethod);
        }


        $optionGroups = AdminTrailt::$optionGroups;
        foreach ($optionGroups as $optionGroup) {
            OptionsGroup::create($optionGroup);
        }

        $taxes = AdminTrailt::$taxes;
        foreach ($taxes as $taxe) {
            Taxe::create($taxe);
        }

        $statusOrders = AdminTrailt::$statusOrders;
        foreach ($statusOrders as $statusOrder) {
            StatusOrder::create($statusOrder);
        }

        Commission::create([
            'commission' => 10,
            'type' => 0,
            'commission_from' => 0
        ]);
    }
}
