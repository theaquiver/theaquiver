<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wallet;
use App\Satoshi;
use App\History;

class WalletController extends Controller
{
    function check (Request $req) {
        $address = $req->input('address');
        $wallet = Wallet::where('wallet', '=', $address)->first();
        if ($wallet) {
            $wallet['histories'] = History::where('wallet', '=', $wallet['id'])->get();
            return response_data(true, $wallet);
        } else {
            return response_data(false, 'Wallet does not exist');
        }
    }

    function claim (Request $req) {
        $address = $req->input('address');
        $token = $req->input('token');
        $isTokenAlreadyInUse = $this->checkToken($token);
        if (!$isTokenAlreadyInUse['success']) {
            return response_data(false, $isTokenAlreadyInUse['message']);
        }
        $wallet = Wallet::where('wallet', '=', $address)->first();
        $value = $this->generateValue();
        if ($wallet) {
            Wallet::where('wallet', '=', $address)->increment('satoshi', $value);
        } else {
            Wallet::insert(['wallet' => $address, 'satoshi' => $value]);
        }
        Satoshi::where('token', '=', $token)->update(['is_used' => 1]);
        return response_data(true, $value);
    }

    function generateValue () {
        return 10;
    }

    function checkToken ($token) {
        $result = Satoshi::where('token', '=', $token)->first();
        if ($result) {
            if ($result['is_used'] == 0) {
                return [
                    'success' => true
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Code already in use'
                ];
            }
        } else {
            return ['success' => false, 'message' => 'Code does not exist'];
        }
    }

    function withdraw (Request $req) {
        $address = $req->input('address');
        $wallet = Wallet::where('wallet', '=', $address)->first();
        if ($wallet) {
            if ($wallet['satoshi'] >= 1000) {
                $history = History::create([
                    'wallet' => $wallet['id'], 'date' => date("Y-m-d H:i:s"),
                    'stats' => 0, 'amount' => $wallet['satoshi']
                ]);
                Wallet::where('wallet', '=', $address)->update(['satoshi' => 0]);
                return response_data(true, $history);
            } else {
                return response_data(false, null);
            }
        } else {
            return response_data(false, null);
        }
    }

}
