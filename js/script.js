
$('#sm-box').delay(3000).slideUp();

$('.delete-post-btn').on('click', function(){
    
    if ( confirm('Are you sure?') ){
        
    }else {
        return false;
    }
});

$('.sc-top').on('click', function(){
  $('html, body').animate({scrollTop:1100}, 'slow');
});

$(window).on('scroll', function(){
  
  var $sctop =  $('.sc-top');
  
  if($(this).scrollTop() > 10 ){
     $sctop.fadeIn();
  }else{
     $sctop.fadeOut();
  }
});


//---

$('.sc-top-md').on('click', function(){
  $('html, body').animate({scrollTop: 0}, 'slow');
});

$(window).on('scroll', function(){

  
  var $sctopMD =  $('.sc-top-md');
  
  if($(this).scrollTop() > 20 ){
     $sctopMD.fadeIn();
  }else{
     $sctopMD.fadeOut();
  }
});
