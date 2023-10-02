````php
        $product = Product::findOrFail(1);
        # will add the relationship each time (even if the relationship already exists between both product & category)
        $product->categories()->attach([$category->id]);
        # will remove all relationship between that product & other categories then add the new one
        $product->categories()->sync([$category->id]);
        # will not remove all relationship between that product & other categories then add the new one
        $product->categories()->syncWithoutDetaching([$category->id]);
````