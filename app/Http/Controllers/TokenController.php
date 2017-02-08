<?php
namespace App\Http\Controllers;

use App\User;
use App\UserToken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class TokenController extends Controller {

    public function getToken(Request $request) {
        $email = $request->getUser();
        $password = $request->getPassword();

        $user = User::where('email', $email)
            ->where('password', $password)
            ->first();

        if (empty($user)) {
            return response()->json('notAuthorized', 401);
        } else {
            $token_string = sha1(uniqid());
            $token = new UserToken();
            $token->user_id = $user->id;
            $token->token = $token_string;
            $token->save();
            $user->token = $token;

            Cache::add($token_string, json_encode($user), Carbon::now()->addDays(3));
            return response()->json($user, 200);
        }
    }

}