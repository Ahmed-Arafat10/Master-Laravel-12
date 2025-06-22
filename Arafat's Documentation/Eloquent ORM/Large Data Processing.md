### Large Data Processing

### chunk() with Eloquent Relationships

```php
Post::with('author')->where('year', 2020)->chunk(100, function($posts) {
    $posts->each->author->increment(['reputation' => 5]);
});
```

> Retrieves 100 posts at a time, eager loads authors, and increments each author's reputation. Chunking helps manage
> memory in large datasets.

### chunkById() for Safe Updates

```php
Post::where('year', 2020)->chunkById(100, function($posts) {
    $posts->each->update(['archived_at' => now()]);
});
```

> Prefer `chunkById()` when updating records to prevent acting on already-updated records. Uses primary key to paginate
> safely.

### lazy() for Stream-Like Processing

```php
Post::where('year', 2020)->lazy()->each->update(['archived_at' => now()]);
```

> `lazy()` returns a `LazyCollection` to stream records. Reduces memory usage but not safe for updates if order changes
> or data is updated during iteration.

### lazyById() for Safe Streamed Updates

```php
Post::where('year', 2020)->lazyById()->each->update(['archived_at' => now()]);
```

> Combines benefits of `lazy()` and `chunkById()` for safe, low-memory updates using primary key pagination.

### cursor() for Lightweight Streaming

```php
$posts = Post::cursor()->filter(function($post) {
    return $post->likes > 500;
});
```

> `cursor()` fetches one record at a time with a single query. Best for low-DB load streaming. However, it doesn’t
> support eager loading and may still consume memory over time.

> ⚠️ Summary:

* Use `chunk()` for read-only batch processing.
* Use `chunkById()` for safe batched updates.
* Use `lazy()` or `lazyById()` for streaming with low memory.
* Use `cursor()` when minimal queries are preferred, but avoid for Eager Relationships.
