<?php

namespace App\Http\Controllers\Api_v1;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $groups = $request->user()->groups;
        return response()->json($groups);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'currency' => 'required|string',
            'members' => 'required|array',
        ]);

        $group = Group::create([
            'name' => $request->name,
            'currency' => $request->currency,
        ]);

        $group->users()->attach($request->members);

        return response()->json($group, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        return response()->json($group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $request->validate([
            'name' => 'sometimes|required|string',
            'currency' => 'sometimes|required|string',
            'members' => 'sometimes|required|array',
        ]);

        if ($request->has('name')) {
            $group->name = $request->name;
        }

        if ($request->has('currency')) {
            $group->currency = $request->currency;
        }

        $group->save();

        if ($request->has('members')) {
            $group->users()->sync($request->members);
        }

        return response()->json($group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        if ($group->balances()->exists()) {
            return response()->json(['message' => 'Cannot delete group with pending balances'], 400);
        }

        $group->delete();
        return response()->json(['message' => 'Group deleted']);
    }
}
