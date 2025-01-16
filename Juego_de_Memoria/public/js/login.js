$(document).ready(function () {
  $("#show_hide_password a").on('click', function (event) {
      event.preventDefault();
      if ($('#show_hide_password input').attr("type") == "text") {
          $('#show_hide_password input').attr('type', 'password');
          $('#show_hide_password i').addClass("ri-eye-off-line");
          $('#show_hide_password i').removeClass("ri-eye-line");
      } else if ($('#show_hide_password input').attr("type") == "password") {
          $('#show_hide_password input').attr('type', 'text');
          $('#show_hide_password i').removeClass("ri-eye-off-line");
          $('#show_hide_password i').addClass("ri-eye-line");
      }
  });
});