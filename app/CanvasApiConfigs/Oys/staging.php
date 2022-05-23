<?php

namespace App\CanvasApiConfigs\Oys;

use Illuminate\Support\Facades\Session;
use Uncgits\CanvasApi\CanvasApiConfig;

class Staging extends CanvasApiConfig
{
    public function __construct()
    {

        $this->setApiHost(config('canvas-api.configs.oys.staging.host'));
        $this->setToken(Session::get("access_token"));

        if (config('canvas-api.configs.oys.staging.proxy.use', false)) {
            $this->setUseProxy(true);
            $this->setProxyHost(config('canvas-api.configs.oys.staging.proxy.host'));
            $this->setProxyPort(config('canvas-api.configs.oys.staging.proxy.port'));
        }
    }
}
