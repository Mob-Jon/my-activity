<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function welcome() {
        return view('welcome');
    }

    public function Home() {
        return view('home');
    }

    public function accountsListPage(){

        $users = DB::select('select * from users');
 
        return view('accountsList', ['users' => $users]);
    }

}
