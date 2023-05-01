<?php

namespace App\Http\Controllers;

use App\Events;
use App\Events\UserEvent;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RecoverController extends Controller
{
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function createRecoverRequest(Request $request)
    {
        //    - https://domain.com/api/user/recover-password
        //    — method POST/PATCH
        //    — fields: email [string] // allow to update the password via email token
        $token = Str::random(64);
        $email = $request->get('email');
        $userStd = DB::table('user')->where('email', '=', $email)->first();

        if (null === $email) {
            throw new NotFoundHttpException(\sprintf("User with email: %s not found", $email));
        }

        if ($userStd->active !== true) {
            throw new BadRequestException(\sprintf("User with email: %s aren't active", $email));
        }

        DB::table('user')
            ->where('id', $userStd->id)
            ->update([ 'reset_password_token' => $token, 'active' => null,]);

        event(new UserEvent(
            $userStd->id,
            Events::USER_RECOVER_PASSWORD_REQUESTED,
            new \DateTime()
        ));

        return new JsonResponse([ 'reset_token' => $token, ], 201,);
    }

    public function updateRecoverRequest(Request $request)
    {
        //    - https://domain.com/api/user/recover-password
        //    — method POST/PATCH
        //    — fields: email [string] // allow to update the password via email token
        $email = $request->get('email');
        $token = $request->get('activate_token');
        $userStd = DB::table('user')->where('email', '=', $email)->first();

        if (null === $email) {
            event(new UserEvent(
                $userStd->id,
                Events::USER_RECOVER_PASSWORD_FAILED,
                new \DateTime()
            ));

            throw new BadRequestException(\sprintf("User with email: %s not found", $email), 404);
        }

        if ($userStd->active === true) {
            event(new UserEvent(
                $userStd->id,
                Events::USER_RECOVER_PASSWORD_FAILED,
                new \DateTime())
            );

            throw new BadRequestException(\sprintf("User with email: %s already active", $email));
        }

        if ($userStd->reset_password_token !== $token) {
            event(new UserEvent(
                $userStd->id,
                Events::USER_RECOVER_PASSWORD_FAILED,
                new \DateTime()
            ));

            throw new BadRequestException(\sprintf("User with email: %s activate token does not match.", $email));
        }

        DB::table('user')->where('id', $userStd->id)->update([ 'reset_password_token' => null, 'active' => true,]);

        event(new UserEvent(
            $userStd->id,
            Events::USER_RECOVER_PASSWORD_SUCCESSFUL,
            new \DateTime()
        ));

        return [ 'status' => 'ok', ];
    }
}
