<?php

namespace App\Exports;

use App\Models\Expense;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Excel;

class ExpensesExport implements FromCollection, Responsable
{
    use Exportable;

    private $expenses;

    private $fileName = 'expenses.xlsx';

    private $writerType = Excel::XLSX;

    private $headers = [
        'Content-Type' => 'text/xlsx',
    ];

    public function __construct()
    {
        $this->setExpenses();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->getCollection();
    }

    private function setExpenses(): Collection
    {
        $expenses = Expense::with(['source', 'category', 'approvals.approval_status', 'approvals.user']);

        if (request()->filled('source_id')) {
            $expenses = $expenses->where('source_id', request()->get('source_id'));
        }

        if (request()->filled('category_id')) {
            $expenses = $expenses->where('category_id', request()->get('category_id'));
        }

        $expenses = $expenses
            ->withSortables()
            ->get()
            ->map(function ($expense) {
                $approvals = [];

                foreach ($expense->approvals as $index => $approval) {
                    $no = $index + 1;
                    $approvals[] =  "{$no}. {$approval->user->name} ({$approval->approval_status->name})";
                }

                return (object) [
                    'ID' => $expense->id,
                    'SOURCE' => $expense->source->name,
                    'CATEGORY' => $expense->category->name,
                    'RECIPIENT' => $expense->recipient,
                    'AMOUNT' => $expense->amount,
                    'DESCRIPTION' => $expense->description,
                    'APPROVALS' => implode(', ', $approvals),
                    'CREATED AT' => $expense->created_at->toDateTimeString(),
                    'LAST UPDATED' => $expense->updated_at->toDateTimeString(),
                ];
            });

        return $this->expenses = $expenses;
    }

    private function getCollection(): Collection
    {
        $collection = collect([]);

        $header = array_keys((array) $this->expenses->first());

        $collection->push($header);

        foreach ($this->expenses as $expense) {
            $collection->push($expense);
        }

        return $collection;
    }
}
