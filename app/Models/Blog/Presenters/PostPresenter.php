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
            get: fn ($value) => Carbon::now()->diffInHours($value) < 24
                ? Carbon::parse($value)->diffForHumans()
                : Carbon::parse($value)->isoFormat('llll'),
            // set: function ($value, array $attributes) {
            //     if(empty($value) && $this->status == 1) {
            //         $attributes['published_at'] == Carbon::now();

            //         return $attributes;
            //     }

            //     return $value;
            // }
        );
    }

    protected function createdAtFormat(): Attribute
    {
        Carbon::setlocale('id');
        return Attribute::make(
            get: fn ($value, $attributes) => Carbon::now()->diffInHours($attributes['created_at']) < 24
                ? Carbon::parse($attributes['created_at'])->diffForHumans()
                : Carbon::parse($attributes['created_at'])->isoFormat('llll'),
        );
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            // get: function ($value, array $attributes) {
            //     $status = "";
            //     switch ($value) {
            //         case 0:
            //             $status = '<span class="py-1 px-2 rounded-full text-white text-xs bg-red-800 italic">Unpublished</span>';
            //             break;

            //         case 1:
            //             if ($attributes['published_at'] >= Carbon::now()) {
            //                 $status = '<span class="py-1 px-2 rounded-full bg-yellow-500 text-gray-600">Scheduled (' . $attributes['published_at'] . ')</span>';
            //             }

            //             $status = '<span class="py-1 px-2 rounded-full text-white text-xs bg-secondary italic">Published</span>';
            //             break;

            //         case 2:
            //             $status = '<span class="py-1 px-2 rounded-full bg-yellow-500 text-white text-xs italic">Draft</span>';
            //             break;

            //         default:
            //             $status = '<span class="py-1 px-2 rounded-full bg-red-500">Status:' . $value . '</span>';
            //             break;
            //     }
            //     return $status;
            // },
            set: function ($value, array $attributes) {

                if ($value == 1 && empty($attributes['published_at'])) {
                    $attributes['status'] = $value;
                    $attributes['published_at'] = Carbon::now();

                    return $attributes;
                } else {
                    return $value;
                }
            }
        );
    }

    protected function statusFormated(): Attribute
    {
        return Attribute::make(
            get: function ($value, array $attributes) {
                $status = "";
                switch ($attributes['status']) {
                    case 0:
                        $status = '<span class="py-1 px-2 rounded-full text-white text-xs bg-red-800 italic">Unpublished</span>';
                        break;

                    case 1:
                        if ($attributes['published_at'] >= Carbon::now()) {
                            $status = '<span class="py-1 px-2 rounded-full bg-yellow-500 text-gray-600">Scheduled (' . $attributes['published_at'] . ')</span>';
                        }

                        $status = '<span class="py-1 px-2 rounded-full text-white text-xs bg-secondary italic">Published</span>';
                        break;

                    case 2:
                        $status = '<span class="py-1 px-2 rounded-full bg-yellow-500 text-white text-xs italic">Draft</span>';
                        break;

                    default:
                        $status = '<span class="py-1 px-2 rounded-full bg-red-500">Status:' . $attributes['status'] . '</span>';
                        break;
                }
                return $status;
            },
        );
    }
}
