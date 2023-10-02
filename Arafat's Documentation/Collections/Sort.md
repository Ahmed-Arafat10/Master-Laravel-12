- sort a collection
````php
    protected function sortData(Collection &$collection)
    {
        if (request()->has('sort_by')) {
            $attribute = request()->sort_by;
            $isDesc = request()->has('desc');
            $collection = $collection->sortBy($attribute, null, $isDesc);
        }
        return $collection;
    }
````