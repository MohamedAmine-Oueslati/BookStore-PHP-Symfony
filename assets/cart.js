import "./styles/cart.css";

const $ = require("jquery");
global.$ = global.jQuery = $;

$(document).ready(function () {
  $(".radio-group .radio").click(function () {
    $(".radio").addClass("gray");
    $(this).removeClass("gray");
  });
});

$(document).on("keyup mouseup", "#quantity", function () {
  var quantity = $("#quantity").val();
  var price = $("#price-unit").text();
  console.log(Number(price));
  $("#price").text((quantity * Number(price)).toFixed(2));
});

$(":input").each(function (index, val) {
  console.log(index, val);
  //   $(this).click(function () {
  //     alert(index + " has value: " + $(this).val());
  //   });
});
