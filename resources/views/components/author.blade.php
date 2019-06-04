<a class="author-block" href="{{url('/author')}}/{{$author->id}}">
    <div class="row">

        <div class="col-sm-2 col-xs-4 book-image-container">
            {{-- image --}}
            @empty($author->image)
            <img class="img-responsive" src="{{ asset('images/books/book-placeholder.png') }}" />
            @else
            <img class="img-responsive" src="{{ $author->image }}" />
            @endempty
        </div>

        <div class="col-sm-10 col-xs-8 author-info-container">
            <h4>{{$author->name}}</h4>
            <p class="author-info">{{count($author->books)}} Books on Booknd</p>
        </div>

    </div>
</a>