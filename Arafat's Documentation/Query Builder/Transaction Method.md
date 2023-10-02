In Laravel, the DB class provides a convenient way to work with database transactions. Transactions are useful when you
want to ensure that a series of database operations are performed atomically, meaning either all of them succeed or none
of them do. This helps maintain data integrity and consistency in your database.

- An example when a user make a transaction to buy a product
````php
return DB::transaction(function () use ($request, $product, $buyer) {
      $product->quantity -= $request->quantity;
      $product->save();
      $transaction = Transaction::create([
          'buyer_id' => $buyer->id,
          'product_id' => $product->id,
          'quantity' => $request->quantity
      ]);
````