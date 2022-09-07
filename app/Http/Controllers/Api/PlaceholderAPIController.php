<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class PlaceholderAPIController extends Controller
{
    public function index()
    {
        $response = Http::get('https://jsonplaceholder.typicode.com/users');
        return $response->json();
    }
}
