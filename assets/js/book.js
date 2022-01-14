import "./../styles/book.css";

const $ = require("jquery");
global.$ = global.jQuery = $;

$(document).ready(function () {
  $(".radio").click(function () {
    var rating = Number($(".radio:checked").val());

    var url = window.location.href;
    var bookId = Number(url.substr(url.indexOf("/Book") + 6));
    var data = { rating, bookId };

    $.ajax({
      url: "/rateBook",
      type: "POST",
      data: data,
      success: function (newWebRating) {
        $(".myratings").text(rating);
        $(".web-ratings").text(newWebRating);
        console.log("SUCCES");
      },
      error: function () {
        console.log("ERROR");
      },
    });
  });
});
