<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipPackage;
use App\Models\Membership;

class MembershipPackageController extends Controller
{
    public function create()
    {

        $memberships = Membership::All();
        return view('admin.membership_package.create', compact('memberships'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'membership_id' => 'required|exists:memberships,id',
            'duration_days' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'is_active' => 'nullable|boolean',
            'description' => 'nullable|string',
        ]);

       
        $data['is_active'] = $request->has('is_active');

        
        $exists = MembershipPackage::where('membership_id', $data['membership_id'])->where('duration_days', $data['duration_days'])->exists();

        if ($exists) {
            return back()
                ->withErrors(['duration_days' => 'Gói này với số ngày này đã tồn tại'])
                ->withInput();
        }

        MembershipPackage::create([
            'membership_id' => $data['membership_id'],
            'duration_days' => $data['duration_days'],
            'price' => $data['price'],
            'is_active' => $request->has('is_active'), // xử lý checkbox
            'description' => $data['description'] ?? null,
        ]);

        return redirect()->route('admin.membership_package.store')
            ->with('success', 'Thêm gói dịch vụ thành công');
    }

    public function edit($id)
    {
        $membershipPackage = MembershipPackage::With('membership')->findOrFail($id);
        $memberships = Membership::orderBy('name')->get();
        return view('admin.membership_package.edit', compact('membershipPackage', 'memberships'));
    }

    public function update(Request $request, $id)
    {

        $membershipPackage = MembershipPackage::findOrFail($id);


        $data = $request->validate([
            'membership_id' => 'required|exists:memberships,id',
            'duration_days' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0|max:99999999.99',
            'is_active' => 'nullable|boolean',
            'description' => 'nullable|string',
        ]);

        $data['is_active'] = $request->has('is_active');
        $membershipPackage->update([
            'membership_id' => $data['membership_id'],
            'duration_days' => $data['duration_days'],
            'price' => $data['price'],
            'is_active' => $request->has('is_active'),
            'description' => $data['description'] ?? null,
        ]);
        return redirect()
            ->route('admin.membership.show', [
                'id' => $membershipPackage->membership->id,
                'slug' => $membershipPackage->membership->slug
            ])
            ->with('success', 'Cập nhật gói thành viên thành công!');
    }
}
