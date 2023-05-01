<?php

namespace App\Http\Controllers;

use App\Events;
use App\Events\UserEvent;
use App\Exceptions\ApplicationException;
use App\Models\User;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function register(Request $request)
    {
        $email = $request->get('email');


        if (null !== Auth::user()) {
            throw new ApplicationException('User already authorized', 401);
        }

        $user = DB::table('user')->where('email', '=', $email)->first();

        if (null !== $user) {
            throw new ApplicationException('User already exists');
        }

        try {
            $user = new User();
            $user->first_name = $request->get('first_name');
            $user->last_name = $request->get('last_name');
            $user->email = $email;
            $user->password = $request->get('password');
            $user->phone = $request->get('phone');
            $user->api_token = Str::random(64);
            $user->save();

            event(new UserEvent(
                $user->id,
                Events::USER_CREATED,
                new \DateTime()
            ));

            return new JsonResponse([ 'id' => $user->id,],  201);
        } catch (\Throwable $err) {
            throw new ApplicationException("Сant create user", 400);
        }
    }
}
