<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\History;
use App\Wallet;

class AdminController extends Controller
{

    function login (Request $req) {
        $password = $req->input('pass');
        if ($password === '123456789qwe!') {
            $histories = History::where('stats', '=', 0)->get();
            foreach ($histories as $value) {
                $add = $value['wallet'];
                $value['wallet'] = Wallet::where('id', '=', $add)->first();
            }
            return response_data(true, $histories);
        } else {
            return response_data(false, null);
        }
    }

    function paid (Request $req) {
        $id = $req->input('id');
        History::where('id', '=', $id)->update(['stats' => 1]);
        return response_data(true, null);
    }
}
