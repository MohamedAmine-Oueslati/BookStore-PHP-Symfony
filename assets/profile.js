import "./styles/cart.css";

const $ = require("jquery");
global.$ = global.jQuery = $;

$(document).ready(function () {
  $("#edit_profile").click(function () {
    $("#edit_modal").removeClass("d-none").addClass("active");
    $("#edit_profile").addClass("active");
    $("#blog_post").removeClass("active");
    $("#followers").removeClass("active");
    // $("#profile_modal").addClass("d-none");
  });
  $("#blog_post").click(function () {
    $("#edit_modal").addClass("d-none");
    $("#blog_post").addClass("active");
    $("#edit_profile").removeClass("active");
    $("#followers").removeClass("active");
    // $( "#blog_modal" ).removeClass( "d-none" );
  });
  $("#followers").click(function () {
    $("#edit_modal").addClass("d-none");
    $("#followers").addClass("active");
    $("#blog_post").removeClass("active");
    $("#edit_profile").removeClass("active");
    // $( "#followers_modal" ).removeClass( "d-none" );
  });
});
