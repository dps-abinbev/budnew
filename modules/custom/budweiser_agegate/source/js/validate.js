(function ($) {
  //validator messages
  jQuery.extend(jQuery.validator.messages, {
    required: "Campo obligatorio",
    lettersonly: "Por favor, rellena este campo solo con letras.",
    remote: "Por favor, rellena este campo.",
    email: "Por favor, escribe una dirección de correo válida.",
    url: "Por favor, escribe una URL válida.",
    date: "Por favor, escribe una fecha válida.",
    dateITA: "Por favor, escribe una fecha válida.",
    dateISO: "Por favor, escribe una fecha (ISO) válida.",
    number: "Por favor, escribe un número válido.",
    digits: "Por favor, escribe sólo dígitos.",
    creditcard: "Por favor, escribe un número de tarjeta válido.",
    equalTo: "Por favor, escribe el mismo valor de nuevo.",
    extension: "Por favor, escribe un valor con una extensión aceptada.",
    maxlength: $.validator.format("Por favor, no escribas más de {0} dígitos."),
    minlength: $.validator.format("Por favor, no escribas menos de {0} dígitos."),
    rangelength: $.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
    range: $.validator.format("Por favor, escribe un valor entre {0} y {1}."),
    max: $.validator.format("Por favor, escribe un valor menor o igual a {0}."),
    min: $.validator.format("Por favor, escribe un valor mayor o igual a {0}."),
  });

  Drupal.agegateValidate = {};
  Drupal.agegateValidate.submit = false;

  $('#agegate-form').validate({
    submitHandler: function (form) {
      var formId = form.id;
      if (!Drupal.agegateValidate.submit) {
        Drupal.agegateValidate.submit = true;

        document.getElementById(formId).submit();
      } else {
        return false;
      }
    }
  });
}(jQuery));
