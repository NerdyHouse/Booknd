<div class="bg-box innerALL-small catbox">
    <h4 class="text-blue margin-none">BROWSE AUTHORS</h4>
    <div class="div-line spacer-small"></div>
    <div class="row catbox-links">
        @foreach($boxAuthors as $boxAuthor)
        <div class="col-xs-6 catbox-link">
            <a href="{{ url('/author/') }}/{{ $boxAuthor->id }}"><i class="fa fa-angle-double-right"></i> {{str_limit($boxAuthor->name,12)}}</a>
        </div>
        @endforeach
        <div class="col-xs-6 catbox-link-more">
            <a href="{{ url('/authors/') }}">MORE AUTHORS <i class="fa fa-angle-double-right"></i></a>
        </div>
    </div>
</div>