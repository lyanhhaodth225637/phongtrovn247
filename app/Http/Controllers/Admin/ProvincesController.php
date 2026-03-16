<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Province;
use Illuminate\Validation\Rule;

class ProvincesController extends Controller
{
    //method get/ lấy dữ liệu hiện ra view  
    public function index()
    {
        $provinces = Province::orderBy('name')->get();
        return view('admin.province.index', compact('provinces'));
    }


    //get thêm Tỉnh thành
    public function create()
    {
        return view('admin.province.create');
    }


    public function store(Request $request)
    {
        //post thêm
        $request->validate([
            'name' => 'required|string|max:50|unique:provinces,name',
            'type' => 'required'
        ]);



        Province::create([
            'name' => Str::ucwords($request->name),
            'slug' => Str::slug($request->name),
            'type' => $request->type,
        ]);

        return redirect()->route('admin.province')
            ->with('success', 'Thêm thành công');
    }


    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //gọi method get form sửa   
        $province = Province::findOrFail($id);
        return view('admin.province.edit', compact('province'));

    }

public function update(Request $request, string $id)
{
    $province = Province::findOrFail($id);

    $request->validate([
        'name' => [
            'required',
            'string',
            'max:50',
            Rule::unique('provinces')->ignore($id)
        ],
        'type' => 'required'
    ]);

    $province->update([
        'name' => Str::ucwords($request->name),
        'slug' => Str::slug($request->name),
        'type' => $request->type
    ]);

    return redirect()->route('admin.province')
        ->with('success','Cập nhật thành công');
}

    public function destroy(string $id)
    {
        Province::findOrFail($id)->delete();
        return redirect()->route('admin.province')->with('success','Xóa thành công');
    }
}
