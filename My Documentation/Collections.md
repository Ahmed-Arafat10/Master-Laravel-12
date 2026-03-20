#### Q6: what about collection global helper
Sure! The `collect()` global helper function in Laravel is used to create a new instance of a collection class, which provides a convenient way to work with arrays of data. Here's an example of how to use it:

```php
// A collection ia an array of arrays
$data = [
    ['name' => 'John', 'age' => 32],
    ['name' => 'Mary', 'age' => 25],
    ['name' => 'Peter', 'age' => 40],
];

$collection = collect($data);
 
echo $data[1]['name']; // Mary
 
// Filter the collection to include only people who are over 30 years old
$filtered = $collection->filter(function ($item) {
    return $item['age'] > 30;
});

// Get the names of the filtered items
$names = $filtered->pluck('name');

// Output the result
dd($names); // Outputs: Illuminate\Support\Collection {#3322 ▼
            //     all: [
            //         "John",
            //         "Peter",
            //     ]
            // }
```

In this example, we're creating a new collection instance from an array of data, and then filtering the collection to include only people who are over 30 years old. We're then using the `pluck()` method to extract the names of the filtered items, and finally outputting the result.

The `collect()` function is a powerful tool for working with data in Laravel, as it provides a wide range of methods for filtering, transforming, and manipulating collections.
<hr>

#### Q7: what are main methods with collect()
The `collect()` function in Laravel returns an instance of the `Illuminate\Support\Collection` class, which provides a wide range of methods for working with collections of data. Here are some of the main methods you can use:

1. `all()`: Returns all items in the collection as an array.

2. `average($callback = null)`: Returns the average value of all items in the collection. If a callback is provided, it will be used to extract a value for each item.

3. `count()`: Returns the number of items in the collection.

4. `each($callback)`: Applies a callback function to each item in the collection.

5. `filter($callback = null)`: Returns a new collection containing only the items that pass a truth test. If a callback is provided, it will be used as the truth test.

6. `first($callback = null, $default = null)`: Returns the first item in the collection that passes a truth test. If no items pass the test, the `$default` value will be returned. If a callback is not provided, the first item in the collection will be returned.

7. `flatMap($callback)`: Returns a new collection created by applying a callback function to each item in the collection and flattening the results.

8. `map($callback)`: Returns a new collection created by applying a callback function to each item in the collection.

9. `pluck($column)`: Returns a new collection containing the values of a specified column for each item in the collection.

10. `reduce($callback, $initial = null)`: Reduces the collection to a single value by applying a callback function to each item. If an initial value is provided, it will be used as the starting value for the reduction.

11. `reject($callback)`: Returns a new collection containing only the items that fail a truth test.

12. `reverse()`: Returns a new collection with the items in reverse order.

13. `sort($callback = null)`: Returns a new collection sorted by a specified callback function.

14. `sum($callback = null)`: Returns the sum of all items in the collection. If a callback is provided, it will be used to extract a value for each item.

15. `toArray()`: Returns all items in the collection as an array.

These are just a few of the methods available in the `Illuminate\Support\Collection` class. For a complete list of methods, you can refer to the Laravel documentation.
<hr>