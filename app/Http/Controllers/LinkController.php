<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;

class LinkController extends Controller
{
    /**
     * Store a newly created link in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:60',
            'url' => 'required|url|max:255',
        ]);

        Link::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'url' => $request->url,
        ]);

        return redirect()->route('dashboard');
    }

    /**
     * Show the form for editing the specified link.
     *
     * @param Link $link
     * @return void
     */
    public function edit(Link $link)
    {
        return view('links.edit', compact('link'));
    }

    /**
     * Update the specified link in storage.
     *
     * @param Request $request
     * @param Link $link
     * @return void
     */
    public function update(Request $request, Link $link)
    {
        $request->validate([
            'title' => 'required|max:60',
            'url' => 'required|url|max:255',
        ]);

        $link->update([
            'title' => $request->title,
            'url' => $request->url,
        ]);

        return redirect()->route('dashboard');
    }

    /**
     * Undocumented function
     *
     * @param Link $link
     * @return void
     */
    public function destroy(Link $link)
    {
        $link->delete();
        return redirect()->route('dashboard');
    }

    /**
     * Update the order of links.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateOrder(Request $request)
    {
        $order = $request->input('order'); // Get the ordered array of link IDs

        if (!is_array($order)) {
            return response()->json(['message' => 'Invalid order data'], 400);
        }

        foreach ($order as $position => $linkId) {
            Link::where('id', $linkId)
                ->where('user_id', auth()->id()) // Ensure the user owns the link
                ->update(['order' => $position]);
        }

        return response()->json(['message' => 'Link order updated successfully']);
    }
}
