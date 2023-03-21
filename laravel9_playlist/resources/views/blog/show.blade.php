<html>
<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    />
    <meta
        http-equiv="X-UA-Compatible"
        content="ie=edge"
    />

    <meta name="description"
          content="{{ $SinglePost->meta ? $SinglePost->meta->meta_description : ''  }}">

    <meta name="keywords"
          content="{{ $SinglePost->meta ? $SinglePost->meta->meta_keywords : ''  }}">

    <meta name="robots"
          content="{{ $SinglePost->meta ? $SinglePost->meta->meta_robots : ''  }}">

    <title>Laravel App</title>
    @vite('resources/css/app.css')
</head>
<body>
<div class="w-4/5 mx-auto">
    <div class="pt-10">
        <a href="{{ URL::previous() }}"
           class="text-green-500 italic hover:text-green-400 hover:border-b-2 border-green-400 pb-3 transition-all py-20">
            < Back to previous page
        </a>
    </div>

    <h4 class="text-left sm:text-center text-2xl sm:text-4xl md:text-5xl font-bold text-gray-900 py-10 sm:py-20">
        {{ $SinglePost->title }}
    </h4>
    <p class="pt-4 italic">
        Categories: @foreach($SinglePost->categories as $singleCat)
            {{ $singleCat->title  }}
        @endforeach
    </p>
    <img height="100px" width="100px" src="{{ $SinglePost->image_path }}" alt="" srcset="">
    <div class="block lg:flex flex-row">
        <div class="basis-9/12 text-center sm:block sm:text-left">
                <span
                    class="text-left sm:text-center sm:text-left sm:inline block text-gray-900 pb-10 sm:pt-0 pt-0 sm:pt-10 pl-0 sm:pl-4 -mt-8 sm:-mt-0">
                    Made by:
                    <a
                        href=""
                        class="font-bold text-green-500 italic hover:text-green-400 hover:border-b-2 border-green-400 pb-3 transition-all py-20">
                        Code With Dary
                    </a>
                    On  {{ $SinglePost->updated_at }}
                </span>
        </div>
    </div>

    <div class="pt-10 pb-10 text-gray-900 text-xl">
        <p class="font-bold text-2xl text-black pt-10">
            {{ $SinglePost->excerpt }}
        </p>

        <p class="text-base text-black pt-10">
            {{ $SinglePost->body }}
        </p>
    </div>
    @if(Auth::id() === $SinglePost->user_id)
        <a
            href="{{ route('GetPostToUpdate',$SinglePost->id) }}"
            class="font-bold text-green-500 italic hover:text-green-400 hover:border-b-2 border-green-400 pb-3 transition-all py-20">
            Edit Post
        </a>
        <form
            action="{{ route('DeleteAPost',$SinglePost->id) }}"
            method="POST"
            class="font-bold text-green-500 italic hover:text-green-400 hover:border-b-2 border-green-400 pb-3 transition-all py-20">
            @csrf
            @method('DELETE')
            <button type="submit">Delete The Post</button>
        </form>
    @endif
</div>
</body>
</html>
