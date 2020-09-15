(function ($) {
  /**
   * @file
   * Datalayers events
   */
  Drupal.behaviors.datalayers = {
    attach: function (context, settings) {
      $('#edit-submit').on('click', function(event){
        // $('#user-register-form').attr('onsubmit','return false;');
        if ($('#user-register-form').length > 0 && $('#user-register-form').valid()) {
          var hash = CryptoJS.SHA256($("#edit-mail").val());
          var texthash = hash.words.toString();
          dataLayer.push({
            'event': 'trackEvent',
            'eventCategory': 'kingsdata', // Categoría del evento (String). Requerido.
            'eventAction': 'registrarme', // Acción o subcategoría del evento (String). Requerido.
            'eventLabel': texthash, // Etiqueta de descripción del evento (String). Requerido.
          });
        }
      });
    },
  };
})(jQuery);
