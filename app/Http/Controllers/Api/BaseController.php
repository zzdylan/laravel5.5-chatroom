<?php

namespace App\Http\Controllers\Api;

use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Auth;

class BaseController extends Controller {

    use Helpers;

    public function guard() {
        return Auth::guard('api');
    }

}
