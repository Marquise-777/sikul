<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class GuardianController extends Controller
{
    public function index()
    {    
         $user = user::get();
         return view('guardian.student', compact('user'));
    }  
}
