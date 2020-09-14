(function ($, Drupal) {
  Drupal.behaviors.registry = {
    attach: function (context, settings) {
      $.validator.addMethod(
        "customphone",
        function (value, element) {
          return (
            this.optional(element) ||
            /^(3-?)?(\([0-9]\d{2}\)|[0-9]\d{2})-?[0-9]\d{2}-?\d{4}$/.test(value)
          );
        },
        "Número de celular no  válido"
      );


        $("#user-register-form").validate({

          rules: {
            'field_celular[0][value]': "customphone",
          },
        });



      let userRegister = document.querySelector(".user-register-form");
      console.log(userRegister);

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

})(jQuery, Drupal);
