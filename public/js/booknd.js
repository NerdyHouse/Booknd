jQuery(document).ready(function($) {
    
    $('.sharing-icons .fb').on('click',function(e) {
        e.preventDefault();
        var bookURL = $(this).attr('href');
        fbShare(bookURL);
    });
    $('.sharing-icons .tw').on('click',function(e) {
        e.preventDefault();
        var bookURL = $(this).attr('href');
        twitterShare(bookURL);
    });
    $('.sharing-icons .gp').on('click',function(e) {
        e.preventDefault();
        var bookURL = $(this).attr('href');
        googleShare(bookURL);
    });
    
    function fbShare(bookURL) {
        var url = bookURL;
        FB.ui(
         {
             method: 'share',
             href: url,
         }, function(response){}); 
    }
    
    function twitterShare(bookURL) {
        var url = bookURL;
        var text = "From @BookndApp";
        window.open('http://twitter.com/share?url='+encodeURIComponent(url)+'&text='+encodeURIComponent(text), '', 'left=0,top=0,width=550,height=450,personalbar=0,toolbar=0,scrollbars=0,resizable=0');
    }
    
    function googleShare(bookURL) {
        var url = "https://plus.google.com/share?url="+bookURL;
        window.open(url,'','left=0,top=0,width=550,height=450,personalbar=0,toolbar=0,scrollbars=0,resizable=0');
    }
});