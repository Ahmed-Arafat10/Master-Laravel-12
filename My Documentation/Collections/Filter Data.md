- filter collection something like `{{URL}}/users?verified=0`
````php
 protected function filterData(Collection &$collection)
    {
        $allowedAtt = User::getAttributesArray((new User())->find(1));
        foreach (request()->query() as $att => $val) {
            if (key_exists($att, $allowedAtt) && isset($val)) {
                $collection = $collection->where($att, $val)->values();
            }
        }
        return $collection;
    }
````