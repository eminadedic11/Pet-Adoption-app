$(document).ready(function () {
  var app = $.spapp({
    defaultView: "#homePage",
    templateDir: "../views/"
  });

  app.run();

  if (typeof updateNavbar === 'function') {
    updateNavbar();
  }
});
