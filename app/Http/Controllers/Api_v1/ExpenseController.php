<?php

namespace App\Http\Controllers\Api_v1;

use App\Models\Expense;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExpenseController extends Controller
{
    public function store(Request $request, Group $group)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'description' => 'required|string',
        ]);

        $expense = Expense::create([
            'amount' => $request->amount,
            'description' => $request->description,
            'user_id' => $request->user()->id,
            'group_id' => $group->id,
        ]);

        return response()->json($expense, 201);
    }

    public function index(Group $group)
    {
        $expenses = $group->expenses;
        return response()->json($expenses);
    }

    public function show(Expense $expense)
    {
        return response()->json($expense);
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'amount' => 'numeric',
            'description' => 'string',
        ]);

        $expense->update($request->all());
        return response()->json($expense);
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return response()->json(['message' => 'Expense deleted']);
    }
}
