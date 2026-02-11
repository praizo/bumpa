<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserAchievementResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserAchievementController extends Controller
{
    public function index(Request $request)
    {
        // In a real app, you might use $request->user() if checking own profile,
        // or a specific User model if checking others.
        // For this task, let's assume we are checking the authenticated user's progress.
        
        return new UserAchievementResource($request->user());
    }
    
    // If you need to check a specific user ID as per requirements "/users/{user}/achievements"
    public function show(User $user)
    {
        return new UserAchievementResource($user);
    }
}