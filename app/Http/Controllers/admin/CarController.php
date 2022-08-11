<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use File;
class CarController extends Controller
{
    //

    public function index() {
        $cars =Car::get();
        return view('admin.car', compact('cars'));
    }
    public function store(Request $request)
    {
        // Validate user inputs
        $request->validate([
            'carName' => 'required',
            'carDescription' => 'required',
            'carPrice' => 'required|regex:/^\d+(\.\d{1,2})?/',
            'carEstCost' => 'required|regex:/^\d+(\.\d{1,2})?/',
            'carSize' => 'required',
            'carImage' => 'required|mimes:jpg,png,jpeg|max:10240'
        ]);
        
        $newImageName = time() . '-' . $request->carName . '.' .
        $request->carImage->extension();
        $request->carImage->move(public_path('carImages'), $newImageName);

        // Create new car item and save into database
        $newCarItem = new Car();
        $newCarItem->type = $request->carType;
        $newCarItem->name = $request->carName;
        $newCarItem->description = $request->carDescription;
        $newCarItem->price = $request->carPrice;
        $newCarItem->estCost = $request->carEstCost;
        $newCarItem->image = $newImageName;
        $newCarItem->size = $request->carSize;
        $newCarItem->normal= ($request->normal ?: 0);
        $newCarItem->special = ($request->special ?: 0);
        $newCarItem->advance = ($request->advance ?: 0);
        $newCarItem->save();
        
        return redirect('/car/filter?carType=');
    }

    // Display the specific car item details fields for edit
    public function showDetails($id)
    {
        $car = Car::find($id);
        return view('admin.editCarDetails', ['car' => $car]);
    }

    // Display the specific car image field for edit
    public function showImages($id)
    {
        $car = Car::find($id);
        return view('admin.editCarImages', ['car' => $car]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateDetails(Request $request)
    {
        // Validate user inputs
        $request->validate([
            'carName' => 'required',
            'carDescription' => 'required',
            'carPrice' => 'required|regex:/^\d+(\.\d{1,2})?/',
            'carEstCost' => 'required|regex:/^\d+(\.\d{1,2})?/',
            'carSize' => 'required',
        ]);
        
        // Update car details
        $car = Car::find($request->carID);
        $car->type = $request->carType;
        $car->name = $request->carName;
        $car->description = $request->carDescription;
        $car->price = $request->carPrice;
        $car->estCost = $request->carEstCost;
        $car->size = $request->carSize;
        $car->normal = $request->carNormal;
        $car->special = $request->carSpecial;
        $car->advance = $request->carAdvance;
        $car->save();

        return redirect()->route('car');
    }

    public function updateImages(Request $request)
    {
        if($request->hasFile('carImage'))
        {
            $car = Car::find($request->carID);

            // Validate user input
            $request->validate([
                'carImage' => 'required|mimes:jpg,png,jpeg,webp|max:10240'
            ]);
            
            // Delete the original image in the public/carImages folder
            $imagePath = 'carImages/' . $car->image;

            if(File::exists($imagePath))
            {
                File::delete($imagePath);
            }


            // Save the file locally in the storage/public/ folder under a new folder named /carImages
            $newImageName = time() . '-' . $car->name . '.' .
            $request->carImage->extension();

            $request->carImage->move(public_path('carImages'), $newImageName);


            $car->image = $newImageName;
            $car->save();
        }   
        return redirect()->route('car');
    }

    // Query database according to filtering options
    public function filter(Request $request)
    {
        $car = Car::query();

        if($request->filled('carType'))
        {
            $car->where('type', $request->carType);
        }

        if($request->filled('fromPrice'))
        {
            $car->where('price', '>=', $request->fromPrice);
        }

        if($request->filled('toPrice'))
        {
            $car->where('price', '<=', $request->toPrice);
        }

        if($request->filled('carSize'))
        {
            $car->where('size', $request->carSize);
        }

        if($request->filled('carNormal'))
        {
            $car->where('normal', $request->carNormal);
        }

        if($request->filled('carSpecial'))
        {
            $car->where('special', $request->carSpecial);
        }

        if($request->filled('carAdvance'))
        {
            $car->where('advance', $request->carAdvance);
        }

        return view('admin.car', [
            'cars' => $car->get()
        ]);
    }

    /**
     * Remove the specified car item from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $car = Car::find($id);
        $imagePath = 'carImages/' . $car->image;
        // Delete the image in the public/carImages folder
        if(File::exists($imagePath))
        {
            File::delete($imagePath);
        }

        $car->delete();
        return redirect()->route('car');
    }
}

