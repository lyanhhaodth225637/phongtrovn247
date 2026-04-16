<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\UserMembership;
use App\Models\WalletTransaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::SUNDAY);
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // tài khoản
        $totalUsers = User::count();
        $totalAdmins = User::role('admin')->count();
        $totalNormalUsers = User::role('user')->count();
        $totalLandlords = User::role('landlord')->count();
        $lockedUsers = User::where('status', 'locked')->count();
        $bannedUsers = User::where('status', 'banned')->count();
        $newUsersToday = User::whereDate('created_at', $today)->count();

        // bài viết
        $totalPosts = Post::count();
        $approvedPosts = Post::where('status', 'approved')->count();
        $pendingPosts = Post::where('status', 'pending')->count();
        $rejectedPosts = Post::where('status', 'rejected')->count();
        $hiddenPostsByAdmin = Post::where('is_visible_admin', false)->count();
        $hiddenPostsByOwner = Post::where('is_visible_owner', false)->count();
        $postsThisMonth = Post::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

        // gói thành viên
        $usersRegisteredMembership = UserMembership::distinct('user_id')->count('user_id');
        $activeUserMemberships = UserMembership::where('status', 'active')->count();

        // doanh thu
        $revenueTypes = ['deposit'];

        $revenueToday = WalletTransaction::where('status', 'success')
            ->whereIn('type', $revenueTypes)
            ->whereDate('created_at', $today)
            ->sum('amount');

        $revenueThisWeek = WalletTransaction::where('status', 'success')
            ->whereIn('type', $revenueTypes)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->sum('amount');

        $revenueThisMonth = WalletTransaction::where('status', 'success')
            ->whereIn('type', $revenueTypes)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        // giao dịch
        $totalTransactions = WalletTransaction::count();
        $successTransactions = WalletTransaction::where('status', 'success')->count();
        $failedTransactions = WalletTransaction::where('status', 'failed')->count();

        return view('admin.home', compact(
            'totalUsers',
            'totalAdmins',
            'totalNormalUsers',
            'totalLandlords',
            'lockedUsers',
            'bannedUsers',
            'newUsersToday',

            'totalPosts',
            'approvedPosts',
            'pendingPosts',
            'rejectedPosts',
            'hiddenPostsByAdmin',
            'hiddenPostsByOwner',
            'postsThisMonth',

            'usersRegisteredMembership',
            'activeUserMemberships',

            'revenueToday',
            'revenueThisWeek',
            'revenueThisMonth',

            'totalTransactions',
            'successTransactions',
            'failedTransactions',
        ));
    }
}