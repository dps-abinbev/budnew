(function ($, Drupal) {
  Drupal.behaviors.registry = {
    attach: function (context, settings) {
      $.validator.addMethod(
        "customphone",
        function (value, element) {
          return this.optional(element) || /^[3]+[0-9]\d{8}$/g.test(value);
        },
        "Número de celular no  válido"
      );
      //^[3]+[0-9]\d{8}$/g
      ///^(3-?)?(\([0-9]\d{2}\)|[0-9]\d{2})-?[0-9]\d{2}-?\d{4}$/
      $("#user-register-form").validate({
        rules: {
          "field_celular[0][value]": "customphone",
        },
      });

      let userRegister = document.querySelector(".user-register-form");
      //console.log(userRegister);

      /*  if (userRegister.length >0) {
        console.log("hola ricky ");
        $(".user-register-form").validate({
          submitHandler: function (form) {
            var formId = form.id;
            if (!Drupal.agegateValidate.submit) {
            $("#edit-field-celular-0-value").validate({
              rules: {
                nomTelefono: "customphone",
              },
            });
            } else {
              return false;
            }
          },
        });
      } */
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
