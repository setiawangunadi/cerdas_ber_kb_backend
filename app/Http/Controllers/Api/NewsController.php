<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\FavoriteNews;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::latest()->get(); // Or use News::latest()->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Password changed successfully',
            'data' => $news
        ], 200);
    }

    public function fetchNews()
    {
        $news = News::latest()->take(4)->get(); // Get 4 newest news items
        return response()->json([
            'status' => 'success',
            'message' => 'Latest news fetched successfully',
            'data' => $news
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|image|max:2048',
        ]);

        // Upload image
        $imagePath = $request->file('image')->store('news_images', 'public');
        $url_image = Storage::url($imagePath);

        // Create news
        $news = News::create([
            'title' => $request->title,
            'description' => $request->description,
            'url_image' => $url_image,
        ]);

        return response()->json($news, 201);
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


    public function addFavorite(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'news_id' => 'required',
        ]);

        //create user
        $user = FavoriteNews::create([
            'news_id' => $request->news_id,
            'user_id' => $user->id,
        ]);

        //return response
        return response()->json([
            'status' => 'success',
            'message' => 'News added to favorite successfully',
        ], 200);
    }
}
