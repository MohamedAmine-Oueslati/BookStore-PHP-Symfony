import "./../styles/cart.css";

const $ = require("jquery");
global.$ = global.jQuery = $;

$(document).ready(function () {
  $(".radio-group .radio").click(function () {
    $(".radio").addClass("gray");
    $(this).removeClass("gray");
  });
});
