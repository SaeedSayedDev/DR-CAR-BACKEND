<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\ReviewInterface;
use App\Models\Review;

class ReviewRepository implements ReviewInterface
{
    // function __construct(private ReviewService $reviewService)
    // {
    // }

    function index()
    {
        if (isset(auth()->user()->garage_data)) {
            $reviews =  Review::with('user.media')->whereHas('service', function ($query) {
                $query->where('provider_id', auth()->user()->garage_data->id);
            })->with('service')->get();
            return response()->json([
                "success" => true,
                'data' => $reviews,
                'message' => 'Review retrive successfully'
            ]);
        }
        return response()->json([
            "success" => true,
            'message' => 'please create garageData'
        ]);
    }

    function store($request)
    {
        $user = auth()->user();
        // هنعمل check علشان نشوف ف معاملة حصلت م بين اليوزر وال خدمة اللي بيقدمها صاحب الجراج
        // $getServiceReview = $this->reviewService->checkService($user->id, $request->service_id);
        // if ($getCompanyReview) {

        if ($user->role_id == 2) {
            Review::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'service_id' => $request->service_id,
                ],
                [
                    'review_value' => $request->review_value,
                    'review' => $request->review,
                ]
            );
            return response()->json(['message' => 'success']);
        }
        // }
        return response()->json(['message' => 'You have not deal with this service'], 404);
    }

    function update($request, $id)
    {

        $user_id = auth()->user()->id;
        $review = Review::where('user_id', $user_id)->findOrFail($id);

        $review->update([
            'user_id' => $user_id,
            'service_id' => $review->service_id,
            'review_value' => $request->review_value,
            'review' => $request->review,
        ]);
        return response()->json(['message' => 'sucsess']);
    }


    function delete($id)
    {
        $user_id = auth()->user()->id;
        Review::where('user_id', $user_id)->findOrFail($id)->delete();
        return response()->json(['message' => 'sucsess']);
    }
}