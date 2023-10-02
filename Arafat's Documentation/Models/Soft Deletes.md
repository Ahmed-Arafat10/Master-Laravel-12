the Soft Deletes feature allows you to "soft delete" records from your database by marking them as deleted rather than
physically removing them. This is useful for scenarios where you want to retain a record's data for auditing purposes or
in case you need to restore it later.

Here's how you can use Soft Deletes in Laravel:

1. Define the `deleted_at` Column:
   In your database migration, make sure you have a `deleted_at` column in the table you want to enable soft deletes
   for. You can use Laravel's `softDeletes` method in your migration file:

   ```php
   Schema::table('your_table_name', function (Blueprint $table) {
       $table->softDeletes();
   });
   ```

2. Use the SoftDeletes Trait:
   In your model, use the `SoftDeletes` trait. Typically, you'll find this trait in
   the `Illuminate\Database\Eloquent\SoftDeletes` namespace. Import it at the top of your model file:

   ```php
   use Illuminate\Database\Eloquent\SoftDeletes;
   ```

   Then, add the `SoftDeletes` trait to your model class:

   ```php
   class YourModel extends Model
   {
       use SoftDeletes;
   }
   ```

3. Soft Delete Records:
   To soft delete a record, you can use the `delete()` method on an instance of your model:

   ```php
   $record = YourModel::find($id);
   $record->delete();
   ```

   This will set the `deleted_at` timestamp for the record, marking it as deleted.

4. Querying Soft Deleted Records:
   To retrieve soft deleted records, you can use the `withTrashed()` method:

   ```php
   $records = YourModel::withTrashed()->get();
   ```

   To retrieve only soft deleted records, you can use the `onlyTrashed()` method:

   ```php
   $deletedRecords = YourModel::onlyTrashed()->get();
   ```

5. Restoring Soft Deleted Records:
   To restore a soft deleted record, you can use the `restore()` method on the model:

   ```php
   $record = YourModel::withTrashed()->find($id);
   $record->restore();
   ```

Again, please note that the information provided is based on Laravel 8 and earlier versions. If Laravel 9 has been
released since my last update, I recommend checking the official Laravel documentation or release notes for any changes
or updates related to Soft Deletes or any other features.