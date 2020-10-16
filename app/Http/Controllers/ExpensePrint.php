<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

class ExpensePrint extends Controller
{
    protected $pdf;

    public function __construct(PDF $pdf)
    {
        $this->pdf = $pdf;
    }

    public function __invoke(Expense $expense)
    {
        $this->authorize('access-expenses');

        $expense->load(['approvals.approval_status', 'approvals.user', 'categories']);

        return $this
            ->pdf
            ->setPaper('a5', 'landscape')
            ->loadView('expenses.print', [
                'expense' => $expense,
            ])
            ->stream();;
    }
}
