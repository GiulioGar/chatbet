<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Aggiungi questa linea
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // Logica per raccogliere dati da visualizzare nella dashboard
        $users = User::all();
        $roles = Role::all();
        return view('admin.dashboard', compact('users', 'roles'));
    }
}
