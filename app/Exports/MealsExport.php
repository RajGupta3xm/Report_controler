<?php
namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MealsExport implements FromView, WithHeadings
{
    use Exportable;

    private $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function view(): View
    {
        return view('admin.Meal.export', [
            'users' => $this->users
        ]);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
           
        ];
    }
}