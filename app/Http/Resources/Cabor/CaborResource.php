<?php

namespace App\Http\Resources\Cabor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class CaborResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "cabor_name" => $this->cabor_name,
            "initial" => $this->initial,
            "logo" => $this->logo ? URL::route('image', ['path' => $this->logo, 'w' => 100, 'h' => 100, 'fit' => 'crop']) : null,
        ];
    }
}
