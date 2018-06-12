<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Satoshi;

class SatoshiController extends Controller
{
    function getToken (Request $req) {
        $token = Satoshi::where('is_used', '=', 0)->first();
        return response_data(true, $token);
    }

    function checkToken (Request $req) {
        $token = $req->input('token');
        $result = Satoshi::where('token', '=', $token)->first();
        if ($result) {
            return response_data(true, $result);
        } else {
            return response_data(false, null);
        }
    }
}
