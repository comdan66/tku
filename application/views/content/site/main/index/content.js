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
  var i = 1,z = 0;

  setInterval (function () {
    var a = $body.find ('>figure>a>img:nth-child(' + i + ')');
    if (z > 0)
      a.css ('z-index', z);
    i = (i % $body.find ('>figure>a>img').length) + 1;
    a = $body.find ('>figure>a>img:nth-child(' + i + ')');
    z = a.css ('z-index');
    a.css ({'z-index': 998});
  }, 1000);
});