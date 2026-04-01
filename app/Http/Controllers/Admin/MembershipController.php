<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\Membership;

class MembershipController extends Controller
{
    public function index()
    {
        $memberships = Membership::orderBy('created_at', 'asc')->get();
        return view('admin.membership.index', compact('memberships'));
    }

    public function create()
    {
        return view('admin.membership.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:memberships,name',
            'priority' => 'required|integer|min:0',
            'color' => 'nullable|string|max:7',
            'description' => 'nullable|string',
        ]);

        Membership::create([
            'name' => Str::ucwords($data['name']),
            'slug' => Str::slug($data['name']),
            'priority' => $data['priority'],
            'color' => $data['color'],
            'description' => $data['description'] ?? null,
        ]);

        return redirect()->route('admin.membership')->with('success', 'Thêm gói dịch vụ thành công');
    }

    public function edit($id)
    {
        $membership = Membership::findOrFail($id);
        return view('admin.membership.eidt', compact('membership'));
    }

    public function update(Request $request, $id)
    {
        $membership = Membership::findOrFail($id);

        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('memberships', 'name')->ignore($id),
            ],
            'priority' => 'required|integer|min:0',
            'color' => 'nullable|string|max:7',
            'description' => 'nullable|string',
        ]);

        $membership->update([
            'name' => Str::ucwords($data['name']),
            'slug' => Str::slug($data['name']),
            'priority' => $data['priority'],
            'color' => $data['color'],
            'description' => $data['description'],
        ]);

        return redirect()->route('admin.membership')
            ->with('success', 'Cập nhật gói thành công');
    }

    public function destroy($id)
    {
        $membership = Membership::findOrFail($id);
        $membership->delete();
        return redirect()->route('admin.membership')
            ->with('success', 'Xoá gói thành công');
    }

    public function show($id)
    {
        $membership = Membership::with('membershipPackages')->findOrFail($id);

        return view('admin.membership.show', compact('membership'));
    }

    public function demo()
    {
        $membership = Membership::with('membershipPackages')
            ->orderByDesc('priority')  // thêm dòng này
            ->get();
        return view('admin.membership.demo', compact('membership'));
    }
}
