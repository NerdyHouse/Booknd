jQuery(document).ready(function($) {
    
    /*
     * 
     * bookshelf stuff
     */
    
    // Handle the bookshelf
    var bs_url = "booknd/public/bookshelf/";
   
    // Add a book to the user shelf
    $(document).on('click','.user_book_add',function(e) {
        
        e.preventDefault();
        var bookID      = $(this).data('book');
        var $clicked    = $(this);
        var $tools      = $clicked.parent('.book-tools');
        
        var addBook = add_book(bookID,function(data) {
            var html;
            if(data.code == 0) {
                html = '<div class="alert alert-danger" data-dismissable="true">'+data.message+'</div>';
            } else if (data.code == 1) {
                html = '<div class="alert alert-success" data-dismissable="true">'+data.message+'</div>';
                $clicked.remove();
                
                var $wrap   = $('<div class="user-book-status-container tool btn btn-teal"></div>');
                var $select = $('<select>',{
                    'class':'user_book_status',
                    html:'<option value="in">Not Read</option><option value="reading">Reading</option><option value="read">Read</option>',
                    attr: {
                        'data-book':bookID
                    }
                }).appendTo($wrap);
                $wrap.append('<i class="fa fa-book"></i>');
                
                $tools.prepend($wrap);
                
            }
            $('#book_messages').html(html);
            setTimeout(function() {
                $('.alert').alert('close');
            },3000);
        });
    });
    
    // Add a new book
    function add_book(bookID,callback) {
        var add_url      = "/booknd/public/bookshelf";
        var formData = { book: bookID };
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
        });
        $.ajax({
            type: "POST",
            dataType: "json",
            url: add_url,
            data:formData,
            success: function (data) {
                if(typeof callback === "function") {
                    callback(data);
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }
    
    // Update a book status / active
    $(document).on('change','.user_book_status',function() {
        var newStatus   = $(this).val();
        var bookID     = $(this).data('book');
        var formData = { book:bookID,status: newStatus };
        var udBook = update_book(formData,function(data) {
            var html;
            if(data.code == 0) {
                html = '<div class="alert alert-danger" data-dismissable="true">'+data.message+'</div>';
            } else if (data.code == 1) {
                html = '<div class="alert alert-success" data-dismissable="true">'+data.message+'</div>';
            }
            $('#book_messages').html(html);
            setTimeout(function() {
                $('.alert').alert('close');
            },2000);
        });
    });
    
    // Remove a book from shelf
    $(document).on('click','.user_book_remove',function(e) {
        e.preventDefault();
        
        var $block = $(this).parent('.bookshelf-single-book');
        
        var bookID     = $(this).data('book');
        var formData = {book:bookID, active: 0 };
        var conf = confirm('Really remove this book?');
        
        if(conf) {
            var delBook = update_book(formData,function(data) {
                var html;
                if(data.code == 0) {
                    html = '<div class="alert alert-danger" data-dismissable="true">'+data.message+'</div>';
                } else if (data.code == 1) {
                    html = '<div class="alert alert-success" data-dismissable="true">'+data.message+'</div>';
                    $block.fadeOut('fast');
                }
                $('#book_messages').html(html);
                setTimeout(function() {
                    $('.alert').alert('close');
                },2000);
            });
        }
    });
    
    // Update a book
    function update_book(formData,callback) {
        var ud_url      = "/booknd/public/bookshelf/update";
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
        });
        $.ajax({
            type: "POST",
            dataType: "json",
            url: ud_url,
            data:formData,
            success: function (data) {
                if(typeof callback === "function") {
                    callback(data);
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    };
    
    
    
    /*
     * 
     * Friend stuff
     */
    
    // Send request
    $(document).on('click','.user-friend-request',function(e) {
        e.preventDefault();
        
        //var working  = true;
        var $clicked = $(this);
        
        // make sure the functionality can't be repeated once button clicked
        //if(!working) {
            $(this).addClass('disabled');
            $(this).find('.working').show();

            var userID     = $(this).data('user');
            var friendReq = send_friend_request(userID,function(data) {
                
                console.log(data);
                var html;
                if(data.code == 0) {
                    html = '<div class="alert alert-danger" data-dismissable="true">'+data.message+'</div>';
                    $clicked.removeClass('disabled');
                    $clicked.find('.working').hide();
                } else if (data.code == 1) {
                    html = '<div class="alert alert-success" data-dismissable="true">'+data.message+'</div>';
                    $clicked.parent().html('<span class="friend-request-sent">Request Sent <i class="fa fa-check-circle-o"></i></span>');
                }
                $('#book_messages').html(html);
                setTimeout(function() {
                    $('.alert').alert('close');
                    //working = false;
                },3000);
            });
        //}
        
    });
    
    // Send a friend request
    function send_friend_request(userID,callback) {
        
        var req_url      = "/booknd/public/friendrequest";
        var formData = { friend: userID };
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
        });
        $.ajax({
            type: "POST",
            dataType: "json",
            url: req_url,
            data:formData,
            success:function(data) {
                if(typeof callback === "function") {
                    callback(data);
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
        
    }
    
    // Accept a friend request
    $(document).on('click','.accept-friend-request',function(e) {
        e.preventDefault();
        
        var reqID   = $(this).data('request');
        var $block  = $('#pending-friend-'+reqID);
        
        var acceptReq = accept_friend_request(reqID,function(data) {
            var html;
            if(data.code == 0) {
                html = '<div class="alert alert-danger" data-dismissable="true">'+data.message+'</div>';
            } else if (data.code == 1) {
                html = '<div class="alert alert-success" data-dismissable="true">'+data.message+'</div>';
                
                var $blockHTML = $block.clone();
                $blockHTML.find('.user-actions').remove();
                $block.fadeOut('fast');
                if($('.no-friends-warning').length) {
                   $('.no-friends-warning').remove(); 
                }
                $('#friends').prepend($blockHTML);
            }
            $('#book_messages').html(html);
            setTimeout(function() {
                $('.alert').alert('close');
            },3000);
        });
    });
    
    function accept_friend_request(reqID,callback) {
        var req_url      = "/booknd/public/acceptrequest";
        var formData = { req: reqID };
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
        });
        $.ajax({
            type: "POST",
            dataType: "json",
            url: req_url,
            data:formData,
            success: function (data) {
                if(typeof callback === "function") {
                    callback(data);
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }
    
    // Delete a friend request
    $(document).on('click','.delete-friend-request',function(e) {
        e.preventDefault();
        var reqID     = $(this).data('request');
        var $block  = $('#pending-friend-'+reqID);
        var conf = confirm('Are you sure you want to delete?');
        if(conf) {
            var delReq = delete_friend_request(reqID,function(data) {
                var html;
                if(data.code == 0) {
                    html = '<div class="alert alert-danger" data-dismissable="true">'+data.message+'</div>';
                } else if (data.code == 1) {
                    html = '<div class="alert alert-success" data-dismissable="true">'+data.message+'</div>';
                    $block.fadeOut('fast');
                }
                $('#book_messages').html(html);
                setTimeout(function() {
                    $('.alert').alert('close');
                },3000);
            });
        }
    });
    
    function delete_friend_request(reqID,callback) {
        var req_url      = "/booknd/public/deleterequest";
        var formData = { req: reqID };
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
        });
        $.ajax({
            type: "POST",
            dataType: "json",
            url: req_url,
            data:formData,
            success: function (data) {
                if(typeof callback === "function") {
                    callback(data);
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }
    
    // Reviews tools
    $(document).on('click','.user_book_review',function(e) {
        e.preventDefault();
        var book = $(this).data('book');
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/booknd/public/reviewcheck",
            data:{book:book},
            success: function (data) {
                console.log(data);
                if(data.error) {
                    var html = '<div class="alert alert-danger" data-dismissable="true">'+data.message+'</div>';
                    $('#book_messages').html(html);
                    setTimeout(function() {
                        $('.alert').alert('close');
                    },2000);
                } else {
                    if(data.review) {
                        var conf = confirm('You have already reviewed this book. Would you look to edit your review?');
                        if(conf) {
                            $('#review-modal .modal-title .review-book-title').html(data.book.title);
                            $('#review-modal #book-review-text').val(data.review.review);
                            $('#review-modal #book-review-rating').val(data.review.rating);
                            $('#book-review-book').val(data.book.id);
                            $('#book-review-stars-selector .star').removeClass('active').removeClass('selected');
                            for(var i = 0; i < data.review.rating; i++) {
                                $('#book-review-stars-selector .star').eq(i).addClass('active');
                            }
                            setTimeout(function() {
                                $('#review-modal').modal('show');
                            },100)
                        }
                    } else if(data.book) {
                        $('#review-modal .modal-title .review-book-title').html(data.book.title);
                        $('#review-modal #book-review-text').val('');
                        $('#review-modal #book-review-rating').val('');
                        $('#book-review-book').val(data.book.id);
                        $('#book-review-stars-selector .star').removeClass('active').removeClass('selected');
                        setTimeout(function() {
                            $('#review-modal').modal('show');
                        },100)
                    }
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    
    $(document).on('mouseenter','#book-review-stars-selector .star',function(e) {
        var hoverVal = $(this).data('rating');
        $('#book-review-stars-selector .star').each(function() {
            if($(this).data('rating') < hoverVal) {
                $(this).addClass('hovered');
            } else {
                if(!$(this).hasClass('active') && !$(this).hasClass('selected')) {
                    $(this).removeClass('hovered');
                }
            }
        });
    });
    $(document).on('mouseleave','#book-review-stars-selector',function(e) {
        if(!$(this).hasClass('active') && !$(this).hasClass('selected')) {
            $('#book-review-stars-selector .star').removeClass('hovered');
        }
    });
    $(document).on('click','#book-review-stars-selector .star',function(e) {
        var selectedVal = $(this).data('rating');
        $('#book-review-rating').val(selectedVal);
        $(this).addClass('selected');
        $('#book-review-stars-selector .star').each(function() {
            if($(this).data('rating') < selectedVal) {
                $(this).addClass('active').removeClass('selected');
            } else if($(this).data('rating') > selectedVal) {
                $(this).removeClass('active').removeClass('selected');
            }
        });
    });
    
    // Save review
    $(document).on('click','#book-review-save',function(e) {
        e.preventDefault();
        var book = $(this).data('book');
        
        var formData = {
            book: $('#book-review-book').val(),
            rating:$('#book-review-rating').val(),
            review:$('#book-review-text').val()
        };
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/booknd/public/reviewsave",
            data:formData,
            success: function (data) {
                console.log(data);
                if(data.error) {
                    $('#review-error').html(data.message).fadeIn('fast');
                    setTimeout(function() {
                        $('#review-error').fadeOut('fast');
                    },2500);
                } else {
                    $('#review-success').html(data.message).fadeIn('fast');
                    setTimeout(function() {
                        $('#review-success').fadeOut('fast');
                        $('#review-modal').modal('hide');
                    },1500);
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    
    // Handle marking notification as read on click
    $(document).on('click','.notification-link',function(e) {
        e.preventDefault();
        
        var redirect = $(this).attr('href');
        var nid = $(this).data('notification');
        var formData = { notif: nid };
        
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
        });
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/booknd/public/notifications/markread",
            data:formData,
            success: function (data) {
                console.log(data);
                if(data.code == 1) {
                    window.location = redirect;
                } else {}
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
});