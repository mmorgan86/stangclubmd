$(document).ready(function() {
  // button for profile post (post something button)
  $('#submit_profile_post').click(function() {

    // ajax call
    $.ajax({
      type: "POST",
      url: "includes/handlers/ajax_submit_profile_post.php",
      data: $('form.profile_post').serialize(),
      success: function(msg) {
        $("post_form").modal('hide');
        location.reload();
      },
      error: function() {
        alert('Failed');
      }
    });
  });
});