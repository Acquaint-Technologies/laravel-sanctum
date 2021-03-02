<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            'data' => auth()->user(),
            'success' => true,
        ]);
    }
}
