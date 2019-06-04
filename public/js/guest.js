jQuery(document).ready(function($) {
    
    //If guest clicks login or register
    $(document).on('click','.login-link,.register-link,.openlib_book_add',function(e){
        e.preventDefault();
        $('#login-modal .login-message').html('');
        $('#login-modal').modal('show');
    });
    
    // If guest tries to add book
    $(document).on('click','.user_book_add',function(e){
        e.preventDefault();
        $('#login-modal .login-message').html('You must create your FREE Booknd account before you can add a book to your bookshelf. Signup is quick and will never cost a dime.');
        $('#login-modal').modal('show');
    });
    
    // If guest tries to review book
    $(document).on('click','.user_book_review',function(e){
        e.preventDefault();
        $('#login-modal .login-message').html('You must create your FREE Booknd account before you can review books. Signup is quick and will never cost a dime.');
        $('#login-modal').modal('show');
    });
    
    // If guest tries to view user
    $(document).on('click','.user-link',function(e){
        e.preventDefault();
        $('#login-modal .login-message').html('You must create your FREE Booknd account before you can view users. Signup is quick and will never cost a dime.');
        $('#login-modal').modal('show');
    });
    
    
    // Handle login / register w/ AJAX
    /*
    $("#login-form").submit(function(e) {
        e.preventDefault();
        
        var login_url = $("#login-form").attr('action');
        var formData = {
            _token:$("#login-form input[name=_token]").val(),
            email:$("#login-form input[name=email]").val(),
            password:$("#login-form input[name=password]").val()
        };

        //console.log($("#login-form").serialize());

        $.ajax({   
            type: "POST",
            dataType: "json",
            url: login_url,
            data: formData,
            success: function (data) {
                console.log(data);
            },
            error: function (data) {
                console.log('Error:', data);
            }  
        });
    });
    */
    
});