<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Validator;

class GenreController extends Controller
{
    public function store(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:genres,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first('name'),
            ], 422);
        }

        // Create the genre
        $genre = Genre::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'success' => true,
            'genre' => $genre,
        ]);
    }
}
