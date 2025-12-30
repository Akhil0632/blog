<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $currentUserId = Auth::id();
        

        $posts = BlogPost::with('user')
            ->select('*')
            ->addSelect(DB::raw("CASE WHEN user_id = {$currentUserId} THEN 0 ELSE 1 END as is_current_user"))
            ->orderBy('is_current_user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('home', compact('posts', 'currentUserId'));
    }
}
