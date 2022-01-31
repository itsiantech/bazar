<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExportView implements FromView, ShouldAutoSize, WithStyles
{
    public function view(): View
    {
        return view('Exports.users', [
            'users' => User::where('type', 'customer')->with('profile')->get()
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setOutlineLevel(1);
    }



}
