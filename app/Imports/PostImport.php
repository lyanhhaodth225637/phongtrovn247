<?php

namespace App\Imports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PostImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Post([
            'user_id' => $row['user_id'],
            'category_id' => $row['category_id'],
            'ward_id' => $row['ward_id'],
            'membership_id' => $row['membership_id'],
            'title' => $row['title'],
            'slug' => $row['slug'],
            'description' => $row['description'],
            'price' => $row['price'],
            'area' => $row['area'],
            'address' => $row['address'],
            'latitude' => $row['latitude'],
            'longitude' => $row['longitude'],
            'status' => $row['status'],
            'is_visible_admin' => $row['is_visible_admin'],
            'is_visible_owner' => $row['is_visible_owner'],
            'expires_at' => $row['expires_at']
        ]);
    }
}
