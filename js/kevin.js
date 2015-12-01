var offset = 5;

$(document).ready(function() {
    $("#whereskevin").click(function(e){
        e.preventDefault();
        $("#kevin").animate({left: "0"}, 1500).delay(500).animate({left:"-271px"}, 1500);
    });

    $('.comments').live('click', function(e){
        e.preventDefault();

        if ($(this).text() != 'no comments')
        {
            $(this).siblings('.commentitem').toggle('slow');
        }
    });

    $('.addcomment').live('click', function(e){
        e.preventDefault();
        $(this).next('form').toggle('slow');
    });

    $('.inputbox').live('click', function(e){
        $(this).next('.error').hide();
    });

    $('#more').click(function(e){
        e.preventDefault();

        if ($(this).hasClass('more'))
        {
            $.ajax({
                type: "POST",
                url: "/more",
                data: 'offset='+offset,
                success: function(data) {
                    if (data=='')
                    {
                        $('#more').css('color','#CCC');
                        $('#more').text('no more posts');
                        $('#more').removeClass('more');
                        
                    }
                    else
                    {
                        $('#content').append(data);
                        offset = offset + 5;    
                    }
                }
            });
        }
    });

    $('.submitcomment').live('click', function(e){
        e.preventDefault();

        var sendit = true;

        var author = $(this).siblings('.inputauthor').val();
        var message = $(this).siblings('.inputmessage').val();
        var email = $(this).siblings('.inputemail').val();
        var tweetid = $(this).siblings('.inputtweetid').val();

        if (author=='')
        {
            $(this).siblings('.inputauthor').next('.error').show();
            sendit = false;
        }

        if (message == '')
        {
            $(this).siblings('.inputmessage').next('.error').show();
            sendit = false;
        }

        if (email.search(/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,6}$/i) == -1 && email != '') //validate email address
        {
            $(this).siblings('.inputemail').next('.error').show();
            sendit = false;
        }

        if (sendit)
        {
            var dataString = 'author='+ author + '&email=' + email + '&message=' + message + '&tweetid=' + tweetid;
            $.ajax({
                type: "POST",
                url: "/addcomment",
                data: dataString
            });

            var newcomment = '<li><em>'+author+'</em> said:<br />'+message+'</li>';

            $(this).parent('form').siblings('.commentitem').children('ul').append(newcomment);
            $(this).parent('form').hide('slow');

            if ($(this).parent('form').siblings('.comments').text()=='no comments')
            {
                $(this).parent('form').siblings('.comments').html('comments (<p class="commentcount">1</p>)');
            }
            else
            {
                var count = $(this).parent('form').siblings('.comments').children('.commentcount').text();
                count = parseInt(count)+1;
                $(this).parent('form').siblings('.comments').children('.commentcount').text(count);
            }
            $(this).parent('form').siblings('.commentitem').delay(1000).show('slow');
        }
    });
});