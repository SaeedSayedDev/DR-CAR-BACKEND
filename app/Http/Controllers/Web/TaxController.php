<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Web\TaxInterface;

class TaxController extends Controller
{
    public function __construct(private TaxInterface $taxInterface)
    {
    }

    public function __invoke()
    {
        return $this->taxInterface->index();
    }
}
