In Laravel, global scopes are a powerful feature that allows you to define certain conditions that should always be applied to database queries for a specific model. This can be useful for filtering or modifying query results before they are fetched from the database. Global scopes are typically defined in the model itself.

Here's how you can define and use global scopes in Laravel models:

1. **Creating a Global Scope Class:**
   First, you need to create a global scope class that implements the `Illuminate\Database\Eloquent\Scope` interface. This class should define the conditions or modifications you want to apply to all queries for the associated model. For example, you might create a scope to only retrieve active records.

   ```php
   // app/Scopes/ActiveScope.php

   namespace App\Scopes;

   use Illuminate\Database\Eloquent\Builder;
   use Illuminate\Database\Eloquent\Model;
   use Illuminate\Database\Eloquent\Scope;

   class ActiveScope implements Scope
   {
       public function apply(Builder $builder, Model $model)
       {
           $builder->where('active', true);
       }
   }
   ```

2. **Adding the Global Scope to the Model:**
   In your model, use the `addGlobalScope` method to add the global scope. Typically, this is done in the model's `boot` method.

   ```php
   // app/Models/User.php

   namespace App\Models;

   use App\Scopes\ActiveScope;
   use Illuminate\Database\Eloquent\Model;

   class User extends Model
   {
       protected static function boot()
       {
           parent::boot();

           static::addGlobalScope(new ActiveScope);
       }
   }
   ```

   In this example, the `ActiveScope` will be applied to all queries for the `User` model, ensuring that only active users are retrieved.

3. **Using the Model with Global Scope:**
   Now, whenever you perform queries on the `User` model, the global scope will automatically apply the condition defined in the `ActiveScope` class.

   ```php
   // Retrieve all active users
   $activeUsers = User::all();

   // Retrieve a single active user by ID
   $user = User::find(1);
   ```

   The global scope ensures that the `active` condition is always applied to these queries without the need to explicitly specify it each time.

4. **Disabling Global Scopes (Optional):**
   You can temporarily disable a global scope if needed using the `withoutGlobalScope` method. For example:

   ```php
   $usersWithoutScope = User::withoutGlobalScope(ActiveScope::class)->get();
   ```

   This allows you to retrieve records without the global scope's condition.

Global scopes are a convenient way to encapsulate common query constraints or modifications at the model level, making your code more maintainable and readable. They are particularly useful when you want to enforce certain conditions throughout your application for a specific model.