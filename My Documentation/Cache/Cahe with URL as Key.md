- cache response with key equal to URL (with query parameters irrespective to there order as they will be sorted)
````php
    protected function cacheResponse(Collection $collection)
    {
        $url = request()->url();
        $queryParams = request()->query();
        ksort($queryParams);
        $queryString = http_build_query($queryParams);
        $fullUrl = "{$url}?{$queryString}";

        return Cache::remember($fullUrl, 30, function () use ($collection) {
            return $collection;
        });
    }
````