<?php

namespace App\Http\Controllers\Concerns;

trait ExecuteServices
{
    /**
     * @return mixed
     * @var $service
     *
     * @var $args
     */
    public function execute()
    {
        $args = collect(func_get_args());
        $service = $args->shift();

        return call_user_func_array($service, $args->all());
    }
}
