<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Amenity;
use Illuminate\Validation\Rule;


class AmenityController extends Controller
{
    public function index()
    {
        $amenities = Amenity::orderBy('name')->get();
        return view('admin.amenity.index', compact('amenities'));
    }

    public function create()
    {
        return view('admin.amenity.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:amenities,name',
        ]);

        Amenity::create([
            'name' => Str::ucfirst($request->name),
            'slug' => Str::slug($request->name),
        ]);
        return redirect()->route('admin.amenity')->with('success', 'Thêm tiện ích thành công');
    }

    public function edit(string $id)
    {
        $amenity = Amenity::findOrFail($id);
        return view('admin.amenity.edit', compact('amenity'));
    }

    public function update(Request $request, string $id)
    {
        $category = Amenity::findOrFail($id);
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('amenities')->ignore($id),
            ],
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.amenity')->with('success', 'Cập nhật danh mục thành công');
    }

    public function destroy(string $id)
    {
        Amenity::findOrFail($id)->delete();
        return redirect()->route('admin.amenity')->with('success', 'Xóa danh mục thành công');
    }
}
