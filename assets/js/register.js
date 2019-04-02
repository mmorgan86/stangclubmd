$(document).ready(function() {

  // onclick signup, hide login and show registration form
  $('#signup').click(function() {
    $("#login_div").slideUp("slow", function() {
      $("#register_div").slideDown('slow');
    });
  });

  // onclick login, hide signup and show login form
  $('#login').click(function() {
    $("#register_div").slideUp("slow", function() {
      $("#login_div").slideDown('slow');
    });
  });


});