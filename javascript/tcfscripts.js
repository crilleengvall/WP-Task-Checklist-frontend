$('.tcf-btn').bind('click', function(){
  $(this).toggleClass('tcf-active');
  if($(this).hasClass('tcf-active')) {
    Cookies.set(this.id, 'active');
  }
  else {
    Cookies.remove(this.id);
  }
});

$( document ).ready(function() {
  $('.tcf-btn').each(function( index ){
    if(Cookies.get(this.id)) {
      $(this).toggleClass('tcf-active');
    }
  });
});
