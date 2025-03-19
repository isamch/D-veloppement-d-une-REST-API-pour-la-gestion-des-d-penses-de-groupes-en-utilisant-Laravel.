<?php

namespace App\Http\Controllers\Api_v1;

use App\Models\Group;
use App\Models\Balance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BalanceController extends Controller
{
    public function index(Group $group)
    {
        $balances = $group->balances;
        return response()->json($balances);
    }
}
