import "./../styles/book.css";

const $ = require("jquery");
global.$ = global.jQuery = $;

$(document).ready(function () {
  $("input[type='radio']").click(function () {
    var rating = $("input[type='radio']:checked").val();
    $(".myratings").text(rating);

    var url = "https://localhost:8000/rateBook";
    console.log(url);

    $.ajax({
      type: "POST",
      url: url,
      data: rating,
      success: function () {
        console.log("success");
      },
    });
  });
});
