<?php

namespace App\Http\Transformers;

use App\Models\Admin;
use League\Fractal\TransformerAbstract;

class AdminTransformer extends TransformerAbstract {

    public function transform(Admin $item) {
        return [
            'id' => $item->id,
            'username' => $item->username,
            'avatar' => $item->avatar ? $item->avatar : config('admin.default_avatar')
        ];
    }

}
