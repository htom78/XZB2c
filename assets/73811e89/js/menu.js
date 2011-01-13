$(document).ready(function (){
$('#nav li.parent').mouseover(function(){
    
    $(this).addClass("over");
});

$('#nav li.parent').mouseleave(function(){
    $(this).removeClass("over");
});

$('#product_tabs li a').click(function(){
    $('#product_tabs li a').removeClass('active');
    $(this).toggleClass('active');
    $('.content_col').hide();
 
    $('#'+this.id+'_content').show();
});

$('#index_grid_tab li a ').click(function(){
  $('#index_grid_tab li a').removeClass('active');
   $(this).toggleClass('active');
   $('.content_col').hide();
    var id=this.id;
    $('#'+id+'_content').show();
    return false;
});
});


