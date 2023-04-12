<?php
namespace App\Imports;

use App\Models\DislikeGroup;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
         new DislikeGroup([
            'name' => $row['name'],
            'name_ar' => $row['name_ar'],
        ]);
    }
}