<?php

namespace App\Http\Controllers;

use App\Facade\ParserService as Parser;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $news = Parser::parser();

        return view('welcome', ['news' => $news]);
    }
}
