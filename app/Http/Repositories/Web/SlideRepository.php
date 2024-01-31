<?php

namespace App\Http\Repositories\Web;

use App\Http\Interfaces\Web\SlideInterface;
use App\Models\Slide;

class SlideRepository implements SlideInterface
{
    public function index()
    {
        $slides = Slide::paginate(10);
        return view('slides.index', ['dataTable' => $slides]);
    }
}