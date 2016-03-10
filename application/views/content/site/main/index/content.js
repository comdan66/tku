/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2016 OA Wu Design
 */

$(function () {
  var $body = $('body');
  $('.fi-m, ._c').click (function () {
    $body.toggleClass ('m');
  });
  $('.fi-mr').click (function () {
    $(this).toggleClass ('s');
  });
  var i = 0,z = 0, $img = $body.find ('>figure>a>img'), $t = $body.find ('>figure>figcaption>time');

  setInterval (function () {
    var $a = $img.eq (i);
    if (z > 0) $a.css ('z-index', z);
    i = ++i % $body.find ('>figure>a>img').length;
    $a = $img.eq (i);
    z = $a.css ('z-index');
    $t.html ($.timeago (r = $a.css ({'z-index': 998}).data ('time')) + '<br/>' + r);
  }, 1000);
});