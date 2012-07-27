$(document).ready(function()
{
    $('a.login-window').click(function()
    {
        //Getting the variable's value from a link 
        var loginBox = $(this).attr('href');
        
        //Fade in the Popup
        $(loginBox).fadeIn(300);
        
        //Set the center alignment padding + border see css style
        var popMargTop = ($(loginBox).height() + 24) / 2; 
        var popMargLeft = ($(loginBox).width() + 24) / 2; 
        
        $(loginBox).css({ 
            'margin-top' : -popMargTop,
            'margin-left' : -popMargLeft
        });
        
        // Add the mask to body
        $('body').append('<div id="mask"></div>');
        $('#mask').fadeIn(300);
        
        return false;
    });
    
    // When clicking on the button close or the mask layer the popup closed
    $('a.close, #mask').live('click', function()
    { 
        $('#mask , .login-popup').fadeOut(300 , function()
        {
            $('#mask').remove();  
        }); 
    
        return false;
    });
    
    // star 1
    $('#star1').mouseover(function()
    {
        $('#star1').css('background', 'url("imgs/star_m.png")');
    });
    $('#star1').mouseout(function()
    {
        $('#star1').css('background', 'url("imgs/star_m_empty.png")');
    });
    
    // star 2
    $('#star2').mouseover(function()
    {
        $('#star1').css('background', 'url("imgs/star_m.png")');
        $('#star2').css('background', 'url("imgs/star_m.png")');
    });
    $('#star2').mouseout(function()
    {
        $('#star1').css('background', 'url("imgs/star_m_empty.png")');
        $('#star2').css('background', 'url("imgs/star_m_empty.png")');
    });
    
    // star 3
    $('#star3').mouseover(function()
    {
        $('#star1').css('background', 'url("imgs/star_m.png")');
        $('#star2').css('background', 'url("imgs/star_m.png")');
        $('#star3').css('background', 'url("imgs/star_m.png")');
    });
    $('#star3').mouseout(function()
    {
        $('#star1').css('background', 'url("imgs/star_m_empty.png")');
        $('#star2').css('background', 'url("imgs/star_m_empty.png")');
        $('#star3').css('background', 'url("imgs/star_m_empty.png")');
    });
    
    // star 4
    $('#star4').mouseover(function()
    {
        $('#star1').css('background', 'url("imgs/star_m.png")');
        $('#star2').css('background', 'url("imgs/star_m.png")');
        $('#star3').css('background', 'url("imgs/star_m.png")');
        $('#star4').css('background', 'url("imgs/star_m.png")');
    });
    $('#star4').mouseout(function()
    {
        $('#star1').css('background', 'url("imgs/star_m_empty.png")');
        $('#star2').css('background', 'url("imgs/star_m_empty.png")');
        $('#star3').css('background', 'url("imgs/star_m_empty.png")');
        $('#star4').css('background', 'url("imgs/star_m_empty.png")');
    });
    
    // star 5
    $('#star5').mouseover(function()
    {
        $('#star1').css('background', 'url("imgs/star_m.png")');
        $('#star2').css('background', 'url("imgs/star_m.png")');
        $('#star3').css('background', 'url("imgs/star_m.png")');
        $('#star4').css('background', 'url("imgs/star_m.png")');
        $('#star5').css('background', 'url("imgs/star_m.png")');
    });
    $('#star5').mouseout(function()
    {
        $('#star1').css('background', 'url("imgs/star_m_empty.png")');
        $('#star2').css('background', 'url("imgs/star_m_empty.png")');
        $('#star3').css('background', 'url("imgs/star_m_empty.png")');
        $('#star4').css('background', 'url("imgs/star_m_empty.png")');
        $('#star5').css('background', 'url("imgs/star_m_empty.png")');
    });
});