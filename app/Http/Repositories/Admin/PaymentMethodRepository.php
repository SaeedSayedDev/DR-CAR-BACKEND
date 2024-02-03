<?php

namespace App\Http\Repositories\Admin;

use App\Http\Interfaces\Admin\PaymentMethodInterface;
use App\Models\Admin\PaymentMethod;
use App\Services\ImageService;

class PaymentMethodRepository implements PaymentMethodInterface
{
    function __construct(private ImageService $imageService)
    {
    }

    public function index()
    {
        $paymentMethods = PaymentMethod::all();
    
        return response()->json([
            'success' => true,
            'data' => $paymentMethods,
            "message" => "Payments retrieved successfully"
        ]);
        
    }

    public function store($request)
    {
        $requestData = $request->all();

        $paymentMethod = PaymentMethod::create($requestData);
        if ($request->hasFile('image')) {
            $paymentMethod->media()->create([
                'type' => 'payment_method',
                'image' => $this->imageService->store($request->logo, 'admin/payment_methods', 'Logo')
            ]);
        }

        return response()->json([
            'message' => 'stored successfully',
            'data' => $paymentMethod,
        ]);
    }

    public function show($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        return response()->json([
            'data' => $paymentMethod
        ]);
    }

    public function update($request, $id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        $requestData = $request->validated();

        $paymentMethod->update($requestData);
        if ($request->hasFile('image')) {
            $paymentMethod->media()->updateOrCreate([
                'type' => 'payment_method'
            ], [
                'image' => $this->imageService->update($paymentMethod->media()->first()?->imageName(), $request->logo, 'admin/payment_methods', 'Logo')
            ]);
        }

        return response()->json([
            'message' => 'updated successfully',
            'data' => $paymentMethod,
        ]);
    }

    public function delete($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        
        $this->imageService->delete($paymentMethod->media()->first()?->imageName(), 'admin/payment_methods');
        $paymentMethod->delete();
        
        return response()->json([
            'message' => 'deleted successfully'
        ]);
    }
}
