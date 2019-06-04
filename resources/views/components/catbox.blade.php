<div class="bg-box innerALL-small catbox">
    <h4 class="text-blue margin-none">BROWSE GENRES</h4>
    <div class="div-line spacer-small"></div>
    <div class="row catbox-links">
        @foreach($boxCategories as $boxCat)
        <div class="col-xs-6 catbox-link">
            <a href="{{ url('/category/') }}/{{ $boxCat->id }}"><i class="fa fa-angle-double-right"></i> {{str_limit($boxCat->name,12)}}</a>
        </div>
        @endforeach
        <div class="col-xs-6 catbox-link-more">
            <a href="{{ url('/category/') }}">MORE GENRES <i class="fa fa-angle-double-right"></i></a>
        </div>
    </div>
</div>