- new `filterData()` after using `UserResource` with response
````php
    protected function filterData(Collection &$collection, $resourceClass = null)
    {
        $allowedAtt = User::getAttributesArray((new User())->find(1));
        foreach (request()->query() as $att => $val) {
            if ($resourceClass) $att = $resourceClass::originalAttribute($att);
            if (key_exists($att, $allowedAtt) && isset($val)) {
                $collection = $collection->where($att, $val)->values();
            }
        }
        return $collection;
    }
````
> {{URL}}/users?isVerified=1