@foreach ($books as $book)
<div class="bookshelf-single-book book-block">
        <a class="user_book_remove" href="#" data-shelf="{{$book->pivot->id}}">X Remove Book</a>
        <a href="{{ URL::to('bookshelf/' . $book->id) }}">
            <img src="{{$book->image}}" />
            <h3>{{ $book->title }}</h3>
            <p>{{$book->summary}}</p>
        </a>
        <a href="">    
            <p>{{$book->author->name}}</p>
        </a>
        <a href="">
            Reviews Go Here
        </a>
        <select class="user_book_status" data-shelf="{{$book->pivot->id}}">
            <option value="in" @if($book->pivot->status === 'in')selected="selected"@endif()>Not Read</option>
            <option value="reading" @if($book->pivot->status === 'reading')selected="selected"@endif()>Reading</option>
            <option value="read" @if($book->pivot->status === 'read')selected="selected"@endif()>Read</option>
        </select>
        <a href="">Review This Book</a>
    </div>
@endforeach