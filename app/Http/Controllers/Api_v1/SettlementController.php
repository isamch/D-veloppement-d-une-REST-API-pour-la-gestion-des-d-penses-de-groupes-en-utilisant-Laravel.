<?php

namespace App\Http\Controllers\Api_v1;

use App\Models\Group;
use App\Models\Settlement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettlementController extends Controller
{
    public function store(Request $request, Group $group)
    {
        $request->validate([
            'from_user_id' => 'required|exists:users,id',
            'to_user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric',
        ]);

        $settlement = Settlement::create([
            'from_user_id' => $request->from_user_id,
            'to_user_id' => $request->to_user_id,
            'amount' => $request->amount,
            'group_id' => $group->id,
        ]);

        return response()->json($settlement, 201);
    }

    public function index(Group $group)
    {
        $settlements = $group->settlements;
        return response()->json($settlements);
    }
}
