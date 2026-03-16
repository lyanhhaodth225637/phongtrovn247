<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.category.index', compact('categories'));
    }
    public function create()
    {
        return view('admin.category.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:categories,name',
        ]);

        $slug = Str::slug($request->name);
        $path = null;

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $ext = $file->getClientOriginalExtension();
            $filename = $slug . '.' . $ext;
            Storage::disk('public')->putFileAs('avatars', $file, $filename);
            $path = 'avatars/' . $filename;
        }

        Category::create([
            'name' => Str::ucfirst($request->name),
            'slug' => $slug,
            'avatar' => $path
        ]);
        return redirect()->route('admin.category')->with('success', 'Thêm danh mục thành công');
    }

    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('categories')->ignore($id),
            ],
        ]);


        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.category')->with('success', 'Cập nhật danh mục thành công');
    }

    public function destroy(string $id)
    {
        Category::findOrFail($id)->delete();
        return redirect()->route('admin.category')->with('success', 'Xóa danh mục thành công');
    }
}
