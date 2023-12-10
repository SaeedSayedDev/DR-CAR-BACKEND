<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Admin\PaymentMethodInterface;
use App\Http\Requests\Admin\PaymentMethodRequest;

class PaymentMethodController extends Controller
{
    public function __construct(private PaymentMethodInterface $paymentMethodInterface)
    {
    }

    public function index()
    {
        return $this->paymentMethodInterface->index();
    }

    public function store(PaymentMethodRequest $request)
    {
        return $this->paymentMethodInterface->store($request);
    }

    public function show(string $id)
    {
        return $this->paymentMethodInterface->show($id);
    }

    public function update(PaymentMethodRequest $request, string $id)
    {
        return $this->paymentMethodInterface->update($request, $id);
    }

    public function delete(string $id)
    {
        return $this->paymentMethodInterface->delete($id);
    }
}
