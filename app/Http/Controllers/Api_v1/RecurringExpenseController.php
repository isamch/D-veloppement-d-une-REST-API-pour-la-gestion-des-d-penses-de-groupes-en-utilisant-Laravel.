<?php

namespace App\Http\Controllers\Api_v1;

use App\Models\RecurringExpense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecurringExpenseController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'frequency' => 'required|string',
        ]);

        $recurringExpense = RecurringExpense::create([
            'amount' => $request->amount,
            'frequency' => $request->frequency,
            'user_id' => $request->user()->id,
        ]);

        return response()->json($recurringExpense, 201);
    }

    public function index(Request $request)
    {
        $recurringExpenses = $request->user()->recurringExpenses;
        return response()->json($recurringExpenses);
    }

    public function destroy(RecurringExpense $recurringExpense)
    {
        $recurringExpense->delete();
        return response()->json(['message' => 'Recurring expense deleted']);
    }
}
