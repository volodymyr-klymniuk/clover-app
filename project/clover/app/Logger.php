<?php

namespace App;

//use App\Exceptions\InvalidSessionIdException;
//use ProBillerNG\Logger\Config\FileConfig;
//use ProBillerNG\Logger\Log;
//use ProBillerNG\Logger\Logger as NGLogger;
//use Ramsey\Uuid\Uuid;
//use Illuminate\Http\Request;

trait Logger
{
    /**
     * @var FileConfig
     */
    private $config;

    public function initLogger(string $fileParam, Request $request)
    {
        $config = new FileConfig(storage_path() . '/logs/' . env($fileParam));
        $config->setServiceName(config('app.name'));
        $config->setServiceVersion(config('app.version'));

        if ($request->hasHeader('X-CORRELATION-ID')) {
            $config->setCorrelationId((string) $request->headers->get('X-CORRELATION-ID'));
        }

        if ($request->attributes->has('sessionId')) {
            $config->setSessionId($request->attributes->get('sessionId'));
        }

        $logLevels   = CloverLogger::getLevels();
        $configLevel = strtoupper(env('APP_LOG_LEVEL'));
        $config->setLogLevel($logLevels[$configLevel] ?? CloverLogger::ERROR);

        Log::setConfig($config);
    }
}
