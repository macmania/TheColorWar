$(function() {
  $(".pair .question").click(function() {
    $(this).parents(".pair").find(".answer").slideToggle();
  })
})