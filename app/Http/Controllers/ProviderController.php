<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\ProviderInterface;
use Illuminate\Http\Request;

class ProviderController extends Controller
{


    public function __construct(private ProviderInterface $providerInterface)
    {
    }

    public function show($id)
    {
        return $this->providerInterface->show($id);
    }


  
}
