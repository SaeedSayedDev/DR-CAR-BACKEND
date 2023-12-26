<?php

namespace App\Http\Repositories\Admin;

use App\Http\Interfaces\Admin\StatusOrderInterface;
use App\Models\Admin\StatusOrder;

class StatusOrderRepository implements StatusOrderInterface
{
    public function index()
    {
        $statusOrders = StatusOrder::all();
     
        return response()->json([
            'success' => true,
            'data' => $statusOrders,
            "message" => "Statuss retrieved successfully"
        ]);
    }

    public function store($request)
    {
        $requestData = $request->all();
        $statusOrder = StatusOrder::create([]);

        foreach (['en', 'ar'] as $locale) {
            $statusOrder->translations()->create([
                'locale' => $locale,
                'name' => $requestData['name'][$locale],
            ]);
        }

        return response()->json(['message' => 'success']);
    }

    public function show($id)
    {
        $statusOrder = StatusOrder::findOrFail($id);
        return response()->json([
            'data' => $statusOrder
        ]);
    }

    public function update($request, $id)
    {
        $statusOrder = StatusOrder::findOrFail($id);
        $requestData = $request->all();

        foreach (['en', 'ar'] as $locale) {
            $statusOrder->translateOrNew($locale)->name = $requestData['name'][$locale];
        }

        $statusOrder->save();

        return response()->json(['message' => 'success']);

    }

    public function delete($id)
    {
        $statusOrder = StatusOrder::findOrFail($id);
        $statusOrder->delete();

        return response()->json(['message' => 'success']);

    }
}
