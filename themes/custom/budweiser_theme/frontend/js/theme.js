(function ($, Drupal) {
  Drupal.behaviors.registry = {
    attach: function (context, settings) {
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
      $.validator.addMethod(
        "customphone",
        function (value, element) {
          return this.optional(element) || /^[3]+[0-9]\d{8}$/g.test(value);
        },
        "Número de celular no es válido"
      );
      $("#user-register-form").validate({
        rules: {
          "field_celular[0][value]": "customphone",
          "field_identificacion[0][value]": {
            number: true,
          }
        },
      });
    },
  };
  Drupal.behaviors.ageGateSlide2 = {
    attach: function (context, settings) {
      var yearReal,
        mounthReal = false;
      $("input.form-number").on("keyup", function (e) {
        //Validate field year and month is real
        if (e.target.id == "edit-year1") {
          yearReal = false;
          if (e.key <= 2) {
            yearReal = true;
            focusInput(e.which, $(this).val().length, $(this));
          }
        }
        if (e.target.id == "edit-month1") {
          mounthReal = false;
          if (e.key == 1) {
            console.log("real");
            mounthReal = true;
            focusInput(e.which, $(this).val().length, $(this));
          }
        }
        //When not validate field
        if (
          e.target.id != "edit-year1" &&
          yearReal == true &&
          e.target.id != "edit-month1" &&
          e.target.id != "edit-month2"
        ) {
          focusInput(e.which, $(this).val().length, $(this));
        }
        if (e.target.id != "edit-month1" && mounthReal == true) {
          focusInput(e.which, $(this).val().length, $(this));
        }
        //Focus next group
        if (e.target.id == "edit-year4" && $(this).val().length != 0) {
          $("#edit-row-1-2").addClass("active");
          $(this)
            .parents(".form-group")
            .next()
            .find(".form-item-month1 input.form-number")
            .focus();
        }
        if (e.target.id == "edit-month2" && $(this).val().length != 0) {
          $("#edit-row-1-2").removeClass("active");
          $("#edit-row-1-2").addClass("activemonth");
          $(this)
            .parents(".form-group")
            .next()
            .find(".form-item-day1 input.form-number")
            .focus();
        }
        if (e.target.id == "edit-day2" && $(this).val().length != 0) {
          $("#edit-remember").focus();
        }
      });

      function focusInput(which, val, $this) {
        console.log("funcion", which, val);
        if (!isNaN(String.fromCharCode(which)) && val != 0) {
          $this
            .parents(".js-form-item")
            .next()
            .find("input.form-number")
            .focus();
        }
      }
    },
  };
})(jQuery, Drupal);
