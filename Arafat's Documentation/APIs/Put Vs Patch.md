Q: difference between PUT and PATCH in RESTful APIs in details

PUT and PATCH are two HTTP methods used in RESTful APIs for updating resources. They have distinct purposes and behaviors:

1. PUT (Update Whole Resource):
    - Purpose: PUT is used to update an existing resource or create a new one if it doesn't exist at the specified URI.
    - Idempotence: PUT is considered idempotent, meaning that making the same request multiple times will have the same result. Repeated PUT requests with the same data will not produce different outcomes.
    - Complete Replacement: When you send a PUT request, you typically send the entire resource representation in the request body. This means that if you only send a subset of the resource's properties, the missing properties will be overwritten with null or default values.
    - Example: If you have a resource at `/users/123`, a PUT request with a full user object in the request body would replace the entire resource at `/users/123`.

2. PATCH (Partial Update):
    - Purpose: PATCH is used to partially update an existing resource. It allows you to make changes to specific fields or properties of a resource without affecting the rest of the resource.
    - Idempotence: PATCH is also considered idempotent. Sending the same PATCH request multiple times will produce the same result as long as the initial state of the resource remains the same.
    - Partial Update: In a PATCH request, you send only the fields that need to be updated in the request body. The server applies these changes to the resource while leaving other fields intact.
    - Example: If you have a resource at `/users/123`, a PATCH request with a request body like `{"email": "new.email@example.com"}` would update only the email field of the user resource at `/users/123`.

Here are some key differences between PUT and PATCH:

- **Completeness**: PUT requires sending the complete resource representation, while PATCH allows for partial updates by sending only the fields that need to be changed.

- **Overwriting**: PUT overwrites the entire resource with the data provided in the request, while PATCH selectively updates specific fields, leaving the rest of the resource unchanged.

- **Idempotence**: Both PUT and PATCH are idempotent, but PUT is expected to perform a complete replacement, which means sending the same data twice with PUT will result in the same resource state. For PATCH, the same is true, but only for the fields you actually update.

- **Safety**: PUT is often considered a "safe" operation because it replaces a resource with a known state. PATCH, when used carefully, can also be considered safe since it modifies an existing resource in a controlled manner.

In summary, the choice between PUT and PATCH depends on the desired behavior for your RESTful API. Use PUT when you want to replace the entire resource, and use PATCH when you want to make partial updates to a resource.