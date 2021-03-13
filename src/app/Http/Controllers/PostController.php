<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        var_dump("posts index");die;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        var_dump("posts create");die;
    }

    public function update(Request $request) {
        var_dump("posts update");die;
    }

    public function delete(Request $request) {
        var_dump("posts delete");die;
    }

    
}
