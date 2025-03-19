<?php


namespace App\Http\Controllers\Api_v1;

use App\Models\Budget;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BudgetController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
            'limit' => 'required|numeric',
        ]);

        $budget = Budget::create([
            'category' => $request->category,
            'limit' => $request->limit,
            'user_id' => $request->user()->id,
        ]);

        return response()->json($budget, 201);
    }

    public function index(Request $request)
    {
        $budgets = $request->user()->budgets;
        return response()->json($budgets);
    }

    public function update(Request $request, Budget $budget)
    {
        $request->validate([
            'category' => 'string',
            'limit' => 'numeric',
        ]);

        $budget->update($request->all());
        return response()->json($budget);
    }

    public function destroy(Budget $budget)
    {
        $budget->delete();
        return response()->json(['message' => 'Budget deleted']);
    }
}
