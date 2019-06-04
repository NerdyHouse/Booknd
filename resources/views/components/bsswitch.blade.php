<div class="user-book-status-container tool btn btn-teal">
    <select class="user_book_status" data-book="{{$id}}">
        <option value="in" @if($status === 'in')selected="selected"@endif()>Not Read</option>
        <option value="reading" @if($status === 'reading')selected="selected"@endif()>Reading</option>
        <option value="read" @if($status === 'read')selected="selected"@endif()>Read</option>
    </select>
    <i class="fa fa-book"></i>
</div>