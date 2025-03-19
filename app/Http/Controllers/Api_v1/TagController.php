<?php

namespace App\Http\Controllers\Api_v1;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $tag = Tag::create($request->all());
        return response()->json($tag, 201);
    }

    public function index()
    {
        $tags = Tag::all();
        return response()->json($tags);
    }

    public function show(Tag $tag)
    {
        return response()->json($tag);
    }

    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'string',
        ]);

        $tag->update($request->all());
        return response()->json($tag);
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response()->json(['message' => 'Tag deleted']);
    }
}
