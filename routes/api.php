<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RecommendationController;
use App\Http\Controllers\Api\NotificationController;



Route::post('register', [\App\Http\Controllers\Api\RegisterController::class, 'register']);
Route::get('noauth', [\App\Http\Controllers\Api\RegisterController::class, 'noauth'])->name('noauth');


Route::any('login', [\App\Http\Controllers\Api\RegisterController::class, 'login'])->name('login');
Route::any('verify', [\App\Http\Controllers\Api\RegisterController::class, 'verify']);
Route::post('password/email',  [\App\Http\Controllers\Api\ForgotPasswordController::class,'forget']);
Route::any('password/reset', [\App\Http\Controllers\Api\ForgotPasswordController::class,'update_reset_password']);
Route::post('password/code/check', [\App\Http\Controllers\Api\ForgotPasswordController::class,'code_verify']);


Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'auth'], function () {	


	Route::get('/notifications', [NotificationController::class, 'index']);
    // Mark single notification as read
    Route::put('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    
    // Delete notification
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);

    Route::post('profile', [\App\Http\Controllers\Api\UserController::class, 'profile']);
    Route::get('track-list', [\App\Http\Controllers\Api\TrackController::class, 'track_list']);
    Route::get('track-detail/{trackId}', [\App\Http\Controllers\Api\TrackController::class, 'track_details']);
    Route::get('album/{album_id}', [\App\Http\Controllers\Api\TrackController::class, 'album_tracks']);
    Route::post('playlist/create', [\App\Http\Controllers\Api\PlaylistController::class, 'playlist_create']);
    Route::get('playlist/list', [\App\Http\Controllers\Api\PlaylistController::class, 'index']);
    Route::get('playlist-detail/{id}', [\App\Http\Controllers\Api\PlaylistController::class, 'detail']);
	Route::post('playlist/add-track', [\App\Http\Controllers\Api\PlaylistController::class, 'playlist_store_track']);
	Route::post('playlist/remove-track', [\App\Http\Controllers\Api\PlaylistController::class, 'playlist_remove_track']);
	Route::post('playlist/update', [\App\Http\Controllers\Api\PlaylistController::class, 'playlist_update']);
	Route::post('playlist/delete', [\App\Http\Controllers\Api\PlaylistController::class, 'playlist_delete']);
	
	Route::post('search', [\App\Http\Controllers\Api\TrackController::class, 'search']);


	
	Route::get('/events-artist-id/{id}', [\App\Http\Controllers\Api\TrackController::class, 'events_by_artist']);

	
    Route::post('/track/{trackId}/play', [\App\Http\Controllers\Api\TrackController::class, 'trackPlay']);
	Route::post('/track/download/{trackId}', [\App\Http\Controllers\Api\TrackController::class, 'downloadTrack']);
	
	
	Route::get('/genres-list', [\App\Http\Controllers\Api\TrackController::class, 'genres_list']);
	Route::get('/genres-detail/{id}', [\App\Http\Controllers\Api\TrackController::class, 'genres_detail']);
    Route::get('/artists-list', [\App\Http\Controllers\Api\TrackController::class, 'artist_list']);
	Route::get('/events-list', [\App\Http\Controllers\Api\TrackController::class, 'events_list']);

	Route::post('/liked-songs/store', [\App\Http\Controllers\Api\LikedController::class, 'track_like_store']);
    Route::post('/liked-songs/remove', [\App\Http\Controllers\Api\LikedController::class, 'track_like_destroy']);
    Route::get('/liked-songs', [\App\Http\Controllers\Api\LikedController::class, 'getLikedTrack']);
	
	Route::post('/liked-artist/store', [\App\Http\Controllers\Api\LikedController::class, 'artist_like_store']);
    Route::post('/liked-artist/remove', [\App\Http\Controllers\Api\LikedController::class, 'artist_like_destroy']);
    Route::get('/liked-artist', [\App\Http\Controllers\Api\LikedController::class, 'getLikedArtist']);
	
	Route::post('/liked-event/store', [\App\Http\Controllers\Api\LikedController::class, 'event_like_store']);
    Route::post('/liked-event/remove', [\App\Http\Controllers\Api\LikedController::class, 'event_like_destroy']);
    Route::get('/liked-event', [\App\Http\Controllers\Api\LikedController::class, 'getLikedEvent']);

	Route::get('/trending-tracks', [RecommendationController::class, 'trending_tracks']);
	Route::get('/recently-played', [RecommendationController::class, 'recently_played']);
	Route::get('/featuring-artists', [RecommendationController::class, 'featuring_artists']);
	
	Route::prefix('recommendations')->group(function () {

		// Protected endpoints (require authentication)
		Route::get('/best-artists', [RecommendationController::class, 'bestArtists']);
		Route::get('/recommended-artist', [RecommendationController::class, 'recommendedForToday']);
		Route::get('/recommended-tracks', [RecommendationController::class, 'recommendedTracks']);
		Route::get('/recent-artists', [RecommendationController::class, 'recentArtists']);
		//	Route::get('/dashboard', [RecommendationController::class, 'recommendationDashboard']);
	});
});
?>