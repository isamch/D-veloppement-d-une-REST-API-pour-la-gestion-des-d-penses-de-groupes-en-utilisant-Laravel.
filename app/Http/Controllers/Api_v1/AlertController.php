<?php


namespace App\Http\Controllers\Api_v1;

use App\Models\Alert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AlertController extends Controller
{
    public function index(Request $request)
    {
        $alerts = $request->user()->alerts;
        return response()->json($alerts);
    }
}
