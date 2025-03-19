<?php

namespace App\Http\Controllers\Api_v1;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function summary(Request $request)
    {
        $summary = [
            'total_income' => $request->user()->income,
            'total_expenses' => $request->user()->expenses->sum('amount'),
            'balance' => $request->user()->income - $request->user()->expenses->sum('amount'),
        ];

        return response()->json($summary);
    }

    public function custom(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $expenses = $request->user()->expenses()
            ->whereBetween('created_at', [$request->start_date, $request->end_date])
            ->get();

        return response()->json($expenses);
    }
}
