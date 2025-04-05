$(document).ready(function () {
  // Ocultar loader y mostrar contenido
  $("#loader").fadeOut(500, function () {
    $("#content-wrapper").fadeIn(500);
  });

  // Función para actualizar botones con clases de Bootstrap
  function updateButtonsDarkMode() {
    $("button.btn, a.btn")
      .not(".dark-mode-toggle")
      .each(function () {
        if ($("body").hasClass("dark-mode")) {
          // Forzar fondo negro a los botones con btn-dark
          $(this).removeClass("btn-light").addClass("btn-dark");
        } else {
          $(this).removeClass("btn-dark").addClass("btn-light");
        }
      });
  }

  // Leer preferencia almacenada en localStorage
  if (localStorage.getItem("darkMode") === "enabled") {
    $("body").addClass("dark-mode");
    $("#toggleDarkMode").text("Modo Claro");
    $("#loader").css("background", "#343a40");
  }

  // Actualizar tablas y botones
  $("table.table").toggleClass("table-dark", $("body").hasClass("dark-mode"));
  updateButtonsDarkMode();

  // Alternar modo oscuro
  $("#toggleDarkMode").click(function () {
    $("body").toggleClass("dark-mode");
    $("#loader").toggleClass("dark-mode-loader");
    if ($("body").hasClass("dark-mode")) {
      localStorage.setItem("darkMode", "enabled");
      $(this).text("Modo Claro");
    } else {
      localStorage.setItem("darkMode", "disabled");
      $(this).text("Modo Oscuro");
    }
    $("table.table").toggleClass("table-dark", $("body").hasClass("dark-mode"));
    updateButtonsDarkMode();
  });
});
