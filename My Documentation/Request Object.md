- check if an input exists
````php
if ($request->has('name'))
````

<br>
<br>
<br>


- Difference between `$request->all()` & `$request->request->all()`
  In Laravel, both `$request->all()` and `$request->request->all()` are used to retrieve the input data sent with an HTTP request, but they access different parts of the request object.

1. **$request->all()**:
    - `$request->all()` is a convenient method that retrieves all input data from the request, including data from the request's query parameters, form fields, and JSON payload (if applicable).
    - It combines data from the `request()->input()` method, which fetches input data from all possible sources, including the query string, form fields, and JSON payloads.
    - Essentially, `$request->all()` returns an array that includes data from all input sources in a single merged array.

2. **$request->request->all()**:
    - `$request->request` is a specific property of the `Request` object in Laravel that specifically represents data from the request's form fields or posted data.
    - `$request->request->all()` retrieves only the data that was sent as form fields in a POST request, ignoring query parameters and JSON payloads.
    - It's useful when you want to specifically access and work with data submitted via HTML forms.

Here's a quick example to illustrate the difference:

Suppose you have a form with a text field named "name" and you submit the form using a POST request:

```html
<form method="POST">
    <input type="text" name="name" value="John Doe">
</form>
```

If you use `$request->all()` and `$request->request->all()` in your Laravel controller, you will get the following results:

- `$request->all()` might return an array like this:
  ```php
  [
      'name' => 'John Doe',
      // Other data (if present) from query string or JSON payload
  ]
  ```

- `$request->request->all()` will specifically return an array like this:
  ```php
  [
      'name' => 'John Doe',
  ]
  ```

In summary, `$request->all()` provides all input data from various sources, while `$request->request->all()` focuses on data submitted via form fields, making it useful when working with HTML forms.