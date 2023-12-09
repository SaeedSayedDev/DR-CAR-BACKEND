<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\ReviewInterface;
use App\Http\Requests\ReviewRequest;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    private $reviewInterface;

    public function __construct(ReviewInterface $reviewInterface)
    {
        $this->reviewInterface = $reviewInterface;
    }

    
    public function store(ReviewRequest $request)
    {
        return $this->reviewInterface->store($request);
    }

    public function update(ReviewRequest $request, $review_id)
    {

        return $this->reviewInterface->update($request, $review_id);
    }
    public function delete($review_id)
    {
        return $this->reviewInterface->delete($review_id);
    }
}
