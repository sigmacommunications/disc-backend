<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            
            $query = Notification::where('user_id', $user->id)
                ->with(['artist', 'track'])
                ->orderBy('created_at', 'desc');
            
            // Filter by read/unread
            if ($request->has('status')) {
                if ($request->status == 'unread') {
                    $query->where('is_read', false);
                } elseif ($request->status == 'read') {
                    $query->where('is_read', true);
                }
            }
            
            // Filter by type
            if ($request->has('type') && $request->type != 'all') {
                $query->where('type', $request->type);
            }
            
            // Pagination (default 15 per page)
            $perPage = $request->get('per_page', 15);
            $notifications = $query->paginate($perPage);
            
            // Get counts
            $unreadCount = Notification::where('user_id', $user->id)
                ->where('is_read', false)
                ->count();
            
            $totalCount = Notification::where('user_id', $user->id)->count();
            
            return response()->json([
                'success' => true,
                'data' => [
                    'notifications' => $notifications->items(),
                    'pagination' => [
                        'current_page' => $notifications->currentPage(),
                        'last_page' => $notifications->lastPage(),
                        'per_page' => $notifications->perPage(),
                        'total' => $notifications->total(),
                        'next_page_url' => $notifications->nextPageUrl(),
                        'prev_page_url' => $notifications->previousPageUrl()
                    ],
                    'counts' => [
                        'unread' => $unreadCount,
                        'total' => $totalCount
                    ]
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch notifications',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function markAsRead($id)
    {
        try {
            $notification = Notification::where('user_id', Auth::id())
                ->where('id', $id)
                ->first();
            
            if (!$notification) {
                return response()->json([
                    'success' => false,
                    'message' => 'Notification not found'
                ], 404);
            }
            
            $notification->update(['is_read' => true]);
            
            return response()->json([
                'success' => true,
                'message' => 'Notification marked as read'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark as read'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $notification = Notification::where('user_id', Auth::id())
                ->where('id', $id)
                ->first();
            
            if (!$notification) {
                return response()->json([
                    'success' => false,
                    'message' => 'Notification not found'
                ], 404);
            }
            
            $notification->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Notification deleted'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete notification'
            ], 500);
        }
    }
}
