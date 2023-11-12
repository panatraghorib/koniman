<?php

namespace App\Models\Blog\Presenters;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;


trait PostPresenter
{

    protected function featuredImage(): Attribute
    {
        return Attribute::make(
            fn ($value) => Str::startsWith($value, "https://picsum.photos")
                ? $value . '?random=' . $this->id
                : $value,
        );
    }

    protected function publishedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value < 24
                ? $value->diffForHumans()
                : $value->isoFormat('llll'),
            set: fn ($value) => empty($value) && $this->status == 1
                ? Carbon::now()
                : $value,
        );
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            function ($value) {
                switch ($value) {
                    case '0':
                        return '<span class="badge bg-danger">Unpublished</span>';
                        break;

                    case '1':
                        if ($this->published_at >= Carbon::now()) {
                            return '<span class="badge bg-yellow-500 text-gray-600">Scheduled (' . $this->published_at . ')</span>';
                        }

                        return '<span class="badge bg-green-600">Pubished</span>';
                        break;

                    case '2':
                        return '<span class="badge bg-blue-600">Draft</span>';
                        break;

                    default:
                        return '<span class="badge bg-red-500">Status:' . $value . '</span>';
                        break;
                }
            },
        );
    }
}
