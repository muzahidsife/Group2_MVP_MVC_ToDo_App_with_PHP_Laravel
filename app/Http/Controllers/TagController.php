<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $tags = $request->user()->tags()
            ->withCount('tasks')
            ->latest()
            ->get();

        return view('tags.index', compact('tags'));
    }

    public function store(StoreTagRequest $request)
    {
        $request->user()->tags()->create($request->validated());

        return back()->with('success', 'Tag created!');
    }

    public function update(StoreTagRequest $request, Tag $tag)
    {
        $this->authorize('update', $tag);

        $tag->update($request->validated());

        return back()->with('success', 'Tag updated!');
    }

    public function destroy(Tag $tag)
    {
        $this->authorize('delete', $tag);

        $tag->delete();

        return back()->with('success', 'Tag deleted!');
    }
}
