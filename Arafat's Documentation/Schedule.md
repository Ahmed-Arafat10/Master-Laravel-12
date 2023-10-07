- At `app` > `console` > `kernal.php`

````php
 protected function schedule(Schedule $schedule): void
    {
        $schedule->command('sanctum:prune-expired --hours=24')->daily();
    }
````

- list all schedules

````php
php artisan schedule:list
````