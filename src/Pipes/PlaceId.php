<?php

namespace Wingly\GooglePlaces\Pipes;

use Wingly\GooglePlaces\Builder;

class PlaceId
{
    public function handle(Builder $builder, $next): mixed
    {
        if (request()->has('place_id')) {
            $builder->setPlaceId(request('place_id', ''));
        }

        return $next($builder);
    }
}
