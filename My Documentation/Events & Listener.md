To create an event that sends an email when a new user is inserted into the database in Laravel, you can follow these
steps:

1. **Create an Event:**

   First, create an event using Laravel's Artisan command-line tool. Run the following command to generate a new event
   class:

   ```
   php artisan make:event NewUserRegistered
   ```

   This command will create a new event class in the `app/Events` directory, such as `NewUserRegistered.php`.

2. **Define Event Data:**

   Inside the `NewUserRegistered` event class, define any data that you want to pass to the email. For example, you can
   pass the newly registered user instance:

   ```php
   public $user;

   public function __construct(User $user)
   {
       $this->user = $user;
   }
   ```

   In this example, we're passing the `User` model instance as data.

3. **Create an Event Listener:**

   Next, create an event listener that will handle the event and send the email. Run the following command to generate
   an event listener:

   ```
   php artisan make:listener SendWelcomeEmail --event=NewUserRegistered
   ```

   This command will create a new event listener class in the `app/Listeners` directory, such as `SendWelcomeEmail.php`.

4. **Define the Email Logic:**

   Inside the `SendWelcomeEmail` listener class, you can define the logic for sending the email. Typically, you'll use
   Laravel's Mail facade to send the email. For example:

   ```php
   use App\Mail\WelcomeEmail;
   use Illuminate\Support\Facades\Mail;

   public function handle(NewUserRegistered $event)
   {
       Mail::to($event->user->email)->send(new WelcomeEmail($event->user));
   }
   ```

   In this example, we're assuming you have a `WelcomeEmail` Mailable class that you'll send to the user.

5. **Register the Event and Listener:**

   In Laravel, you need to register the event and listener in the `EventServiceProvider` class. Open
   the `app/Providers/EventServiceProvider.php` file and add your event and listener to the `$listen` property:

   ```php
   protected $listen = [
       NewUserRegistered::class => [
           SendWelcomeEmail::class,
       ],
   ];
   ```

6. **Dispatch the Event:**

   Whenever a new user is inserted into the database, you should dispatch the `NewUserRegistered` event. This is
   typically done in your registration or user creation logic. For example:

   ```php
   use App\Events\NewUserRegistered;

   // Create a new user
   $user = User::create([
       'name' => 'John Doe',
       'email' => 'johndoe@example.com',
       // Other user attributes...
   ]);

   // Dispatch the event
   event(new NewUserRegistered($user));
   ```

   Make sure to replace the user creation code with your actual user registration logic.

7. **Create the Mailable:**

   Finally, create the `WelcomeEmail` Mailable class that defines the email content and view. You can use
   the `php artisan make:mail` command to generate this class.

That's it! With these steps, you've set up an event and listener to send an email whenever a new user is inserted into
the database in Laravel. When you create a new user and dispatch the `NewUserRegistered` event, the listener will handle
it by sending the welcome email to the user.

#### Q: so what is the difference between that & just writing the  Mail::to($event->user->email)->send(new WelcomeEmail($event->user)); in store method after creating a user

The key difference between dispatching an event to send an email when a new user is created and sending the email
directly in the `store` method after creating a user lies in separation of concerns and decoupling your application's
components.

Here are some advantages of using events and listeners for this purpose over sending the email directly in the `store`
method:

1. **Separation of Concerns:**

    - Using events and listeners follows the principle of separation of concerns. The `store` method in your controller
      is primarily responsible for handling the storage of user data in the database. By dispatching an event, you
      separate the concern of user creation from the concern of sending an email.

    - This makes your code more maintainable and easier to understand because each piece of functionality has its own
      place and responsibility.

2. **Decoupling:**

    - Dispatching an event decouples the user creation process from the email sending process. This means that you can
      add or remove listeners for the `NewUserRegistered` event without modifying the `store` method or affecting the
      user creation process. For example, you might want to send additional notifications or perform other actions when
      a user is registered in the future.

    - It also allows you to change the email sending logic without altering the user creation code. If, for example, you
      decide to change the email sending service or template, you can do so without affecting the `store` method.

3. **Testing:**

    - Using events and listeners makes it easier to write unit tests. You can write tests specifically for the event and
      listener without involving the email sending logic. This isolation makes testing and debugging more
      straightforward.

4. **Scalability:**

    - As your application grows, you may need to introduce more complex logic related to user registration or send
      notifications to multiple channels (e.g., email, SMS, push notifications). Using events and listeners allows you
      to extend your application's functionality without bloating the `store` method.

5. **Maintainability:**

    - Separating email sending into an event listener makes your codebase cleaner and more maintainable. When you
      revisit your code or collaborate with other developers, it's easier to understand and modify.

In summary, while you can send an email directly in the `store` method, using events and listeners follows good software
design principles, improves maintainability, and allows for greater flexibility and scalability as your application
grows. It promotes a modular and decoupled architecture, making your code more organized and easier to work with in the
long run.

<br>
<br>
<br>

- dealing with Failing-Prone actions with `retry()` helper :

````php
  retry(5, function () use ($user) {
            event(new NewUserRegistered($user));
        }, 100);
````

> try 5 times between each 100 milliseconds then if fails throw an exception
