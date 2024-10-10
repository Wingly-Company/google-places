<?php

namespace Wingly\GooglePlaces;

use Illuminate\Contracts\Cache\Repository;
use Wingly\GooglePlaces\Engines\Engine;

class Builder
{
    /** @var string */
    public $language;

    /** @var string */
    public $types;

    /** @var string */
    public $fields;

    /** @var string */
    public $country;

    /** @var string */
    public $query;

    /** @var string */
    public $placeId;

    /** @var Engine */
    public $engine;

    /** @var Repository */
    public $cache;

    public string|null $locationBias = null;

    public function __construct(string $query, Engine $engine, Repository $cache)
    {
        $this->query = $query;

        $this->engine = $engine;

        $this->cache = $cache;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function setTypes(string $types): self
    {
        $this->types = $types;

        return $this;
    }

    public function setFields(string $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    public function setPlaceId(string $placeId): self
    {
        $this->placeId = $placeId;

        return $this;
    }

    public function setLocationBias(string $locationBias): self
    {
        $this->locationBias = $locationBias;

        return $this;
    }

    public function get(): mixed
    {
        $cacheKey = $this->engine->getHashedCacheKey($this);

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $results = $this->engine->search($this);

        return $this->cacheResponse($cacheKey, $results);
    }

    public function cacheResponse(string $key, $results): array
    {
        $this->cache->put($key, $results, config('google-places.cache_lifetime'));

        return $results;
    }
}
