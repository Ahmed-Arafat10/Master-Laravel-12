- convert a collection into a paginate
````php
 protected function paginate(Collection &$collection)
    {
        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 15;
        $result = $collection->slice(($page - 1) * $perPage, $perPage)->values();
        $paginated = new LengthAwarePaginator($result, $collection->count(), $perPage, $page, [
            'path' =>url()->current()
        ]);
        //$paginated->appends(request()->all());
        $collection = $paginated;
        return $paginated;

    }
````

- you can also allow user to custom `per_page` number with some restrictions
````php
protected function paginate(Collection &$collection)
    {
        $rules = [
            'per_page' => 'integer|min:2|max:50'
        ];
        $validator = Validator::make(request()->all(), $rules);
        if ($validator->fails())
            return $this->errorResponse($validator->getMessageBag(), 409);

        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 15;
        if (request()->has('per_page'))
            $perPage = request()->per_page;
        $result = $collection->slice(($page - 1) * $perPage, $perPage)->values();
        $paginated = new LengthAwarePaginator($result, $collection->count(), $perPage, $page, [
            'path' => url()->current()
        ]);
        //$paginated->appends(request()->all());
        $collection = $paginated;
        return $paginated;

    }
````