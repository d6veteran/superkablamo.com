$(document).ready(function() {
  var f = $.farbtastic('#picker');
  var p = $('#picker').css('opacity', 0.25);
  var selected;
  $('.form-item-use-colorpicker')
    .each(function () {
      f.linkTo(this);
    })
    .focus(function() {
      f.linkTo(this);
      p.css('opacity', 1);
      selected = this;
    })
    .blur(function() {
      p.css('opacity', 0.25);
    });
});
