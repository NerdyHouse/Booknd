<?php

namespace App\Library;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Search;
use ApaiIO\ApaiIO;
use Nathanmac\Utilities\Parser\Facades\Parser;

class RemoteSearch
{
    // This will primarily handle our Amazon API calls
    protected $country;
    protected $apiKey;
    protected $apiSecret;
    protected $tag;


    public function __construct()
    {
        $this->country      = 'com';
        $this->apiKey       = 'AKIAJSJB3N5EJ2CVPXKA';
        $this->apiSecret    = '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';
        $this->tag          = 'bo08f-20';
    }
    
    public function amazon(Request $request) {
        
        if($request->has('search_query')) {
            
            $query = $request->search_query;
            
            $conf = new GenericConfiguration();
            $client = new \GuzzleHttp\Client();
            $request = new \ApaiIO\Request\GuzzleRequest($client);
            
            $conf
            ->setCountry($this->country)
            ->setAccessKey($this->apiKey)
            ->setSecretKey($this->apiSecret)
            ->setAssociateTag($this->tag)
            ->setRequest($request);
            
            $apaiIo = new ApaiIO($conf);
            
            $search = new Search();
            $search->setCategory('Books');
            $search->setKeywords($query);
            $search->setResponsegroup(array('ItemAttributes'));
            
            $response = $apaiIo->runOperation($search);
            
            $parsedResponse = Parser::xml($response);
            
            return view('add-book',['query' => $query, 'results' => $parsedResponse]);
            
        } else {
            return view('add-book');
        }
        
    }
    
    /*
     * This will search the Harvard library API
     */
    public function harvard(Request $request) {
        if($request->has('search_query')) {
            
            $query = $request->search_query;
            
            $apiURL = 'https://api.lib.harvard.edu/v2/items?q='.$query.'&limit=50&resourceType=text';
            
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', $apiURL, ['verify' => false]);
            
            $parsedResponse = Parser::xml($res->getBody()->getContents());
            
            $resp = array();
            $resp['raw'] = $parsedResponse;
            $resp['items'] = array();
            
            foreach($parsedResponse['items'] as $searchItems) {
                foreach($searchItems as $searchItem) {
                    
                    $bookItem = array();
                    
                    // assemble title
                    $bookItemTitle = '';
                    $tLoopI = 0;
                    foreach($searchItem['mods:titleInfo'] as $titleItem) {
                        if(is_array($titleItem) && $tLoopI === 0) {
                            foreach($titleItem as $titleItemEl) {
                                $bookItemTitle .= $titleItemEl.'&nbsp';
                            }
                        } elseif(!is_array($titleItem)) {
                            $bookItemTitle .= $titleItem.'&nbsp';
                        }
                    }
                    $bookItem['title'] = $bookItemTitle;
                    // END Title
                    
                    $resp['items'][] = $bookItem;
                    
                }
            }
            
            return view('add-book',['query' => $query, 'results' => $resp]);
        } else {
            return view('add-book');
        }
    }
    
    /*
     * This will search the Open library API
     */
    public function openLibSearch($query,$searchFor=false,$limit=20,$offset=0) {
        
        if($searchFor) {
            $urlBase = 'http://openlibrary.org/search.json?';
            
            // what we searching by?    
            if($searchFor === 'title') {
                $qsParts = 'title='.urlencode($query);
            } else if($searchFor === 'isbn') {
                $qsParts = 'isbn='.$query;
            } else if($searchFor === 'olid') {
                $qsParts = 'q='.$query;
            } else if($searchFor === 'bauthor') {
                $qsParts = 'author='.$query;
            } else {
                $qsParts = 'q='.$query;
            }
            $apiURL = $urlBase.$qsParts.'&mode=everything&limit='.$limit.'&offset='.$offset;
            
        } else {
            $apiURL = 'http://openlibrary.org/search.json?title='.urlencode($query).'&mode=everything&limit='.$limit.'&offset='.$offset;
        }
        
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $apiURL, ['verify' => false]);
        $parsedResponse = Parser::json($res->getBody()->getContents());

        return $parsedResponse;
        
    }
    
    /*
     * This will pull openlib data based on olid
     */
    public function openLibBooks($bibs) {
        
        //$apiURL = 'https://openlibrary.org/api/books?bibkeys='.$bibs.'&format=json&jscmd=data';
        $apiURL = 'https://openlibrary.org/api/books?bibkeys='.$bibs.'&format=json&jscmd=data';
        //$apiURL = 'http://openlibrary.org/search.json?q='.$bookid;
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $apiURL, ['verify' => false]);
        $parsedResponse = Parser::json($res->getBody()->getContents());

        return $parsedResponse;
    }
    
}
