<?php

namespace App\Http\Controllers;

use App\Mail\TourPaymentConfirmation;
use Illuminate\Http\Request;
use App\Models\TourPackage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TourPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tourPackages = TourPackage::paginate(10);
        return view('admin-dashboard.tour-packages.index', compact('tourPackages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin-dashboard.tour-packages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'price_unit' => 'required|string|max:20',
            'duration' => 'nullable|string|max:100',
            'includes' => 'nullable|array',
            'includes.*' => 'string|max:200',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'notes' => 'nullable|string',
            'difficulty_level' => 'required|in:easy,moderate,challenging',
            'min_participants' => 'required|integer|min:1',
            'max_participants' => 'nullable|integer|min:1',
            'is_active' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            // Process includes
            $includes = $validated['includes'] ?? [];
            $includes = array_filter($includes, function($include) {
                return !empty(trim($include));
            });

            // Handle image upload
            $imagePath = 'assets/img/tours/helicopter1.jpg'; // Default image
            if ($request->hasFile('image_file')) {
                $image = $request->file('image_file');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('upload/tours'), $imageName);
                $imagePath = 'upload/tours/' . $imageName;
            }

            $tourPackage = TourPackage::create([
                'name' => $validated['name'],
                'subtitle' => $validated['subtitle'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'price_unit' => $validated['price_unit'],
                'duration' => $validated['duration'],
                'includes' => $includes,
                'image_path' => $imagePath,
                'notes' => $validated['notes'],
                'difficulty_level' => $validated['difficulty_level'],
                'min_participants' => $validated['min_participants'],
                'max_participants' => $validated['max_participants'],
                'is_active' => $validated['is_active'] ?? true
            ]);

            DB::commit();

            return redirect()->route('tour-packages.index')
                           ->with('success', 'Tour package created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withInput()
                         ->with('error', 'Failed to create tour package. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TourPackage $tourPackage)
    {
        return view('admin-dashboard.tour-packages.show', compact('tourPackage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TourPackage $tourPackage)
    {
        return view('admin-dashboard.tour-packages.edit', compact('tourPackage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TourPackage $tourPackage)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'price_unit' => 'required|string|max:20',
            'duration' => 'nullable|string|max:100',
            'includes' => 'nullable|array',
            'includes.*' => 'string|max:200',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'notes' => 'nullable|string',
            'difficulty_level' => 'required|in:easy,moderate,challenging',
            'min_participants' => 'required|integer|min:1',
            'max_participants' => 'nullable|integer|min:1',
            'is_active' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            // Process includes
            $includes = $validated['includes'] ?? [];
            $includes = array_filter($includes, function($include) {
                return !empty(trim($include));
            });

            // Handle image upload
            $imagePath = $tourPackage->image_path; // Keep existing image by default
            if ($request->hasFile('image_file')) {
                // Delete old image if it's in upload directory
                if ($tourPackage->image_path && str_starts_with($tourPackage->image_path, 'upload/tours/')) {
                    $oldImagePath = public_path($tourPackage->image_path);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                
                // Upload new image
                $image = $request->file('image_file');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('upload/tours'), $imageName);
                $imagePath = 'upload/tours/' . $imageName;
            }

            $tourPackage->update([
                'name' => $validated['name'],
                'subtitle' => $validated['subtitle'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'price_unit' => $validated['price_unit'],
                'duration' => $validated['duration'],
                'includes' => $includes,
                'image_path' => $imagePath,
                'notes' => $validated['notes'],
                'difficulty_level' => $validated['difficulty_level'],
                'min_participants' => $validated['min_participants'],
                'max_participants' => $validated['max_participants'],
                'is_active' => $validated['is_active'] ?? true
            ]);

            DB::commit();

            return redirect()->route('tour-packages.index')
                           ->with('success', 'Tour package updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withInput()
                         ->with('error', 'Failed to update tour package. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TourPackage $tourPackage)
    {
        try {
            $tourPackage->delete();
            return redirect()->route('tour-packages.index')
                           ->with('success', 'Tour package deleted successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete tour package. Please try again.');
        }
    }

    /**
     * Toggle tour package status
     */
    public function toggleStatus(TourPackage $tourPackage)
    {
        $tourPackage->update(['is_active' => !$tourPackage->is_active]);
        
        $status = $tourPackage->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Tour package {$status} successfully!");
    }

    /**
     * Show single tour package for booking
     */
    public function viewPackage(TourPackage $tourPackage)
    {
        return view('public-site.view-package', compact('tourPackage'));
    }
}
