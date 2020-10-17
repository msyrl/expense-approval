<?php

namespace App\Http\Controllers;

use App\Exports\ExpensesExport;
use Illuminate\Http\Request;

class ExpenseExport extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $this->authorize('access-expenses');

        return new ExpensesExport();
    }
}
