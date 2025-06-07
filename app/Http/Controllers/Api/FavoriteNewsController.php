<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FavoriteNews;

class FavoriteNewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = FavoriteNews::all(); // Or use News::latest()->get();
        return response()->json($news);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $user = Auth::user();

        $request->validate([
            'news_id' => 'required',
        ]);

        //create user
        $user = User::create([
            'news_id' => $request->news_id,
            // 'user_id' => $user->id,
        ]);

        //return response
        return response()->json([
            'status' => 'success',
            'message' => 'News added to favorite successfully',
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
