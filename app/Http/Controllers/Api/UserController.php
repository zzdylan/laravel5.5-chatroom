<?php

namespace App\Http\Controllers\Api;

use App\Http\Transformers\UserTransformer;
use Illuminate\Http\Request;

class UserController extends BaseController {

    public function me() {
        return $this->response->item($this->user(), new UserTransformer());
    }

}
