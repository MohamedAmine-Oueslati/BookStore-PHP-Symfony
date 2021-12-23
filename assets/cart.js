import "./styles/cart.css";

const $ = require("jquery");
global.$ = global.jQuery = $;

$(document).ready(function () {
  $(".radio-group .radio").click(function () {
    $(".radio").addClass("gray");
    $(this).removeClass("gray");
  });

  $("#btn-checkout").click(function () {
    var value = $("#checkout").text();
    console.log(Number(value));

    $.ajax({
      url: "/BookList",
      type: "POST",
      data: {
        output: Number(value),
      },
      success: function () {
        console.log("SUCCES");
      },
      error: function () {
        console.log("ERROR");
      },
    });
  });
});
