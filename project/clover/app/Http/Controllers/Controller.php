<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    protected function internalServerError(\Throwable $error)
    {
        Log::logException($error);

        return response()->json(
            [
                'error' => $error->getPrevious() ? $error->getPrevious()->getMessage() : $error->getMessage(),
                'code'  => $error->getPrevious() ? $error->getPrevious()->getCode() : $error->getCode(),
            ],
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    protected function errorRequest(\Throwable $error, int $code): \Illuminate\Http\JsonResponse
    {
        return response()->json(
            [
                'error' => $error->getMessage(),
                'code'  => $error->getCode(),
            ],
            $code
        );
    }

    protected function getLimit(Request $request): int
    {
        return ($request->get('limit', 20)) > 20 ? 20 : $request->get('limit', 20);
    }

    protected function getOffset(Request $request): int
    {
        return ($request->get('offset', 0)) > 20 ? 20 : $request->get('offset', 0);
    }
}
