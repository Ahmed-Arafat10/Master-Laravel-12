````php
'user_id' => User::all()->random()->id,
'name' => $this->faker->unique()->sentence(),
'description' => $this->faker->text(),
'name' => $this->faker->word,
'description' => $this->faker->paragraph()
'description' => $this->faker->paragraph(2),
'quantity' => $this->faker->numberBetween(1,10),
'status' => $this->faker->boolean,
'image' => $this->faker->imageUrl,
'seller_id' => User::inRandomOrder()->first()->id , // User::all()->random()->id
'name' => $this->faker->name,
'email' => $this->faker->unique()->safeEmail,
'password' => Hash::make('password'), // You can change 'password' to your desired default password
'remember_token' => Str::random(10),
'verified' => $verified = $this->faker->randomElement([User::UNVERIFIED_USER, User::VERIFIED_USER]),
'verification_token' => $verified == User::UNVERIFIED_USER ? user::generateVerificationCode() : null, // or generate a verification token if needed
````