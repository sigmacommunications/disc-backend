<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Playlist;
use Auth;

class PlaylistController extends BaseController
{
    public function playlist_create(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if($validator->fails())
        {
		 return $this->sendError($validator->errors()->first());

        }
		
		$playlist = Playlist::create([
            'name' => $request->input('name'),
            'user_id' => Auth::id(),
        ]);
				
		return response()->json(['success'=>true,'message'=>'Playlist created successfully','playlist'=>$playlist]);
	}

    public function index()
    {
        $playlists = Playlist::with('tracks')->where('user_id',Auth::id())->get();
        return response()->json(['success'=>true,'message'=>'Playlist List','playlist'=>$playlists]);
    }

    public function playlist_store_track(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'playlist_id' => 'required',
            'track_id' => 'required',
        ]);

        if($validator->fails())
        {
		 return $this->sendError($validator->errors()->first());

        }
		
		$playlist = Playlist::find($request->input('playlist_id'));
		if($playlist && $playlist->user_id == Auth::id())
		{
			$playlist->tracks()->attach($request->input('track_id'));
			return response()->json(['success'=>true,'message'=>'Track added to playlist successfully','playlist'=>$playlist]);
		}
		return response()->json(['success'=>false,'message'=>'Playlist not found']);
    }

    public function playlist_remove_track(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'playlist_id' => 'required',
            'track_id' => 'required',
        ]);

        if($validator->fails())
        {
		 return $this->sendError($validator->errors()->first());

        }
		
		$playlist = Playlist::find($request->input('playlist_id'));
		if($playlist && $playlist->user_id == Auth::id())
		{
			$playlist->tracks()->detach($request->input('track_id'));
			return response()->json(['success'=>true,'message'=>'Track removed from playlist successfully','playlist'=>$playlist]);
		}
		return response()->json(['success'=>false,'message'=>'Playlist not found']);
    }

    public function playlist_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'playlist_id' => 'required',
            'name' => 'required',
        ]);

        if($validator->fails())
        {
		 return $this->sendError($validator->errors()->first());

        }
		
		$playlist = Playlist::find($request->input('playlist_id'));
		if($playlist && $playlist->user_id == Auth::id())
		{
			$playlist->update([
				'name' => $request->input('name'),
			]);
			return response()->json(['success'=>true,'message'=>'Playlist updated successfully','playlist'=>$playlist]);
		}
		return response()->json(['success'=>false,'message'=>'Playlist not found']);
    }

    public function playlist_delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'playlist_id' => 'required',
        ]);

        if($validator->fails())
        {
		 return $this->sendError($validator->errors()->first());

        }
		
		$playlist = Playlist::find($request->input('playlist_id'));
		if($playlist && $playlist->user_id == Auth::id())
		{
			$playlist->delete();
			return response()->json(['success'=>true,'message'=>'Playlist deleted successfully','playlist'=>$playlist]);
		}
		return response()->json(['success'=>false,'message'=>'Playlist not found']);
    }
}
