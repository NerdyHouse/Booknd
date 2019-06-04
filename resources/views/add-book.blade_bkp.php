@extends('layouts.app')

@section('content')

@component('components/header',['title' => 'Add a Book'])
@endcomponent

<!-- main section - search and sidebar -->
<div class="page-main">
    <div class="page-content">
        <div class="site-contain row">

            <!-- left col -->
            <div class="col-md-8 left-col">
                
                <form class="book-search-form" method="post" action="{{ url('/add-book') }}">
                    {{ csrf_field() }}
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control search-query" value="@isset($query){{$query}}@endisset" name="search_query" placeholder="Search for a book">
                        <span class="input-group-btn">
                            <button class="btn btn-default btn-orange" type="submit"><i class="fa fa-book"></i> SEARCH</button>
                        </span>
                    </div>
                </form>
                
                <div class="amzn-disclaimer">CERTAIN CONTENT THAT APPEARS ON BOOKND COMES FROM AMAZON SERVICES LLC. THIS CONTENT IS PROVIDED 'AS IS' AND IS SUBJECT TO CHANGE OR REMOVAL AT ANY TIME.</div>
                
                <!-- was there a search? -->
                @isset($results)

                    <!-- did the search have results? -->
                    @empty($results)
                        <div id="search-results" class="search-results no-results text-center">
                        No Results Matched Your Search.
                        </div>
                    @else

                    <div id="search-results" class="search-results">
                        
                        <a href="{{$results['Items']['MoreSearchResultsUrl']}}" target="_blank">More results on Amazon!</a>
                        
                        @php
                        dd($results)
                        @endphp
                        
                        @foreach($results['Items']['Item'] as $searchItem)
                        @isset($searchItem['ItemAttributes']['ISBN'])
                        <a style="display: block; position: relative;" data-isbn="{{$searchItem['ItemAttributes']['ISBN']}}" href="{{$searchItem['DetailPageURL']}}" target="_blank">
                            <div class="row">
                                <div class="col-xs-2">
                                    <img src="{{ asset('images/books/book-placeholder.png') }}" class="img-responsive" />
                                </div>
                                <div class="col-xs-10">
                                    <div>{{$searchItem['ItemAttributes']['Title']}}</div>
                                    <div>By
                                        @if(is_array($searchItem['ItemAttributes']['Author']))
                                            {{implode(", ",$searchItem['ItemAttributes']['Author'])}}
                                        @else
                                            {{$searchItem['ItemAttributes']['Author']}}
                                        @endif
                                        &bull; Published {{$searchItem['ItemAttributes']['PublicationDate']}}
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endisset
                        @endforeach

                    </div>

                    @endempty

                @else
                    <div id="search-results" class="search-results no-query text-center">
                        Search Amazon for a book you can't find on Booknd
                    </div>
                @endisset
                
            </div>

            <!-- right col -->
            <div class="col-md-4">
            </div>

        </div>
    </div>
</div>

@endsection
