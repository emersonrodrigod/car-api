<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ExecuteServices;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use ExecuteServices;
}
