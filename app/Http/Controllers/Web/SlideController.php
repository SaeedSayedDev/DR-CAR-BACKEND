<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Web\SlideInterface;

class SlideController extends Controller
{
    public function __construct(private SlideInterface $slideInterface)
    {
    }

    public function __invoke()
    {
        return $this->slideInterface->index();
    }
}
