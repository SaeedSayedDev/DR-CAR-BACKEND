<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\FavouriteInterface;
use App\Http\Interfaces\OptionInterface;
use App\Models\Favourite;
use App\Models\Options;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;

class OptionRepository implements OptionInterface
{
    function __construct(private ImageService $imageService)
    {
    }

    public function store($request)
    {
        $requestData = request()->all();
        DB::beginTransaction();

        $option = Options::create($requestData);
        $this->imageService->storeMedia($request, $option->id, 'options', 'public/images/options', url("api/images/Options/"));
        DB::commit();

        return response()->json(['message' => 'success']);
    }

    public function update($request, $option_id)
    {
        $option =  Options::findOrFail($option_id);
        DB::beginTransaction();

        $option->update($request->all());
        $this->imageService->storeMedia($request, $option->id, 'options', 'public/images/options', url("api/images/Options/"));
        DB::commit();

        return response()->json(['message' => 'success']);
    }
}
