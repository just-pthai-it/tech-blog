<?php

namespace App\Http\Resources\User;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInteractionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array|JsonSerializable|Arrayable|null
     */
    public function toArray ($request) : array|JsonSerializable|Arrayable|null
    {
        if ($this == null)
        {
            return null;
        }
        else
        {
            return [
                'isLike'  => $this->pivot->is_like,
                'isShare' => $this->pivot->is_share,
                'isSave'  => $this->pivot->is_save,
            ];
        }
    }
}
