<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\CarRequest;
use App\Models\Car;
use App\Services\ImageService;

class CarController extends Controller
{
    function __construct(private ImageService $imageService)
    {
    }

    public function index()
    {
        $cars = Car::paginate(10);

        return view('cars.index', ['dataTable' => $cars]);
    }
    
    public function create()
    {
        return view('cars.create');
    }
    
    public function store(CarRequest $request)
    {
        $requestData = $request->validated();

        $car = Car::create($requestData);
        if ($request->hasFile('image')) {
            $car->media()->create([
                'type' => 'car',
                'image' => $this->imageService->store($request->image, 'admin/cars', 'Car')
            ]);
        }

        return redirect()->route('cars.index')->with([
            'success' => 'Created successfully'
        ]);
    }
    
    public function edit(Car $car)
    {
        return view('cars.edit', compact('car'));
    }

    public function update(CarRequest $request, Car $car)
    {
        $requestData = $request->validated();

        $car->update($requestData);
        if ($request->hasFile('image')) {
            $car->media()->updateOrCreate([
                'type' => 'car'
            ], [
                'image' => $this->imageService->update($car->media()->first()?->imageName(),  $request->image, 'admin/cars', 'Car')
            ]);
        }

        return redirect()->route('cars.index')->with([
            'success' => 'Updated successfully',
        ]);
    }

    public function destroy(Car $car)
    {
        $this->imageService->delete($car->media()->first()?->imageName(), 'admin/cars');
        $car->media()->delete();
        $car->delete();
        
        return redirect()->route('cars.index')->with([
            'success' => 'Deleted successfully'
        ]);
    }
}
