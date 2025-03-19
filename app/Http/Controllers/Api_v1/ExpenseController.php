<?php

namespace App\Http\Controllers\Api_v1;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Group;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Group $group)
    {
        $expenses = $group->expenses;
        return response()->json($expenses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Group $group)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'description' => 'required|string',
            'payer_id' => 'required|exists:users,id',
            'split_type' => 'required|in:equal,percentage',
            'split_details' => 'required_if:split_type,percentage|array',
        ]);

        $expense = Expense::create([
            'amount' => $request->amount,
            'description' => $request->description,
            'payer_id' => $request->payer_id,
            'group_id' => $group->id,
            'split_type' => $request->split_type,
            'split_details' => $request->split_details,
        ]);

        return response()->json($expense, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        return response()->json($expense->load('tags'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        $expense->update($request->all());

        return response()->json($expense);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();
        return response()->json(['message' => 'Expense deleted']);
    }
}
