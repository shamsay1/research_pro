<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentExport implements FromCollection, WithHeadings,WithHeadingRow
{
    /**
     * Return empty collection
     * kwa sababu hii ni template tupu.
     */
    public function collection(): Collection
    {
        return collect([]);
    }

    /**
     * Headers za template.
     */
    public function headings(): array
    {
        return [
            'firstname',
            'middlename',
            'lastname',
            'email',
            'phone',
            'reg_number',
            'password'
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->getStyle('A1:G1')->getFont()->setBold(true);
                foreach (['A', 'B', 'C', 'D', 'E','F','G'] as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
        
        }
            }
         ];
}
}