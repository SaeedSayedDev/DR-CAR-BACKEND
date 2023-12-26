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
        $requestData['logo'] = $this->imageService->store($request, 'admin/payment_methods', 'logo');
        $paymentMethod = PaymentMethod::create($requestData);
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
        $requestData = $request->all();
        $requestData['logo'] = $this->imageService->update($request, $paymentMethod, 'admin/payment_methods', 'logo');
        $paymentMethod->update($requestData);
        return response()->json([
            'message' => 'updated successfully',
            'data' => $paymentMethod,
        ]);
    }

    public function delete($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        $this->imageService->delete($paymentMethod, 'admin/payment_methods', 'logo');
        $paymentMethod->delete();
        return response()->json([
            'message' => 'deleted successfully'
        ]);
    }
}
