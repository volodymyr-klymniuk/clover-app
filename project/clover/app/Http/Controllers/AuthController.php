<?php

namespace App\Http\Controllers;

use App\Events;
use App\Events\UserEvent;
use App\Exceptions\ApplicationException;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signIn(Request $request): JsonResource
    {
        $email = $request->get('email');
        $password = $request->get('password');
        $usr = DB::table('user')->where('email', '=', $email)->first();

        event(new UserEvent(
            $usr->id,
            Events::USER_AUTHENTICATION_FAILED,
            new \DateTime()
        ));

        if (Hash::check($password, $usr->password)) {
            return new JsonResource([ 'api_token' => $usr->api_token, ]);
        }

        event(new UserEvent(
            $usr->id,
            Events::USER_AUTHENTICATION_SUCCESSFUL,
            new \DateTime()
        ));

        throw new ApplicationException('Password does not match', 401);
    }
}
