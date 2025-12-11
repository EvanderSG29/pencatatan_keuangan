<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of users as cards.
     */
    public function index()
    {
        $user = auth()->user();
        return view('User.index', compact('user'));
    }
}
