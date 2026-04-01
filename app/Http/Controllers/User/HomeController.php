<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Amenity;
use App\Models\Province;

class HomeController extends Controller
{
   public function index()
   {
      return view('user.profile.index');
   }

   public function create()
   {
      $categories = Category::orderBy('name', 'asc')->get();
      $provinces = Province::orderBy('name', 'asc')->get();
      $amenities = Amenity::orderBy('name', 'asc')->get();
      return view('user.post.create', compact('categories', 'provinces', 'amenities'));
   }

}
