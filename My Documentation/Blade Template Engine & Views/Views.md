- To Access GET URL Variables in your `view` you have many methods
````php
# get id from route URL method #1
{{ Request::route('id') 
# get id from route URL method #2
{{ request()->route()->parameter('id') }}
# get id from route URL method #3
{{ request()->id; }}
# returns an array of all parameters of the current route
{{ request()->route()->parameters(); }}
# returns an array of all parameters Names (numeric index refers to parameter name)
{{ request()->route()->parameterNames(); }}
````