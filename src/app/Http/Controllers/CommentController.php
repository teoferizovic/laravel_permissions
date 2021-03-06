<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request) {
    	var_dump("index");die;
    }

    public function create(Request $request) {
    	var_dump("create");die;
    }

    public function update(Request $request) {
    	var_dump("update");die;
    }

    public function delete(Request $request) {
    	var_dump("delete");die;
    }
}
