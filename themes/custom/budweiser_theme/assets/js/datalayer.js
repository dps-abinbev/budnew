function init() {
  const createrEventDataLayer = (idform, category, action, label) => {
    if (jQuery(idform).valid()) {
      //event.preventDefault();
      dataLayer.push({
        event: "trackEvent",
        eventCategory: category,
        eventAction: action,
        eventLabel: label,
        eventValue: "_VALUE_",
      });
    }
  };

  jQuery(document).ajaxComplete(function () {
    jQuery(".webform-submission-registro-costena-form .webform-button--submit")
      .unbind("click")
      .bind("click", function (e) {
        var hash = CryptoJS.SHA256(jQuery(".form-email").val());
        var texthash = hash.words.toString();
        createrEventDataLayer(
          ".webform-submission-registro-costena-form",
          "Costeña",
          "Clic",
          texthash
        );
      });
  });

  // Productos Home
  jQuery(".view-baccan-products .views-field-body a").click(function (e) {
    e.preventDefault();
    var valor = jQuery(this)
      .parents(".col-md-3")
      .find(".views-field-field-price");
    dataLayer.push({
      event: "trackEvent",
      eventCategory: "producto",
      eventAction: "clic a producto",
      eventLabel: valor[0].innerText,
      eventValue: "_VALOR_",
    });
  });

  // Registro Bacanería
  jQuery(document).ajaxComplete(function () {
    jQuery(
      ".webform-submission-registro-hey-bacaneria-form .webform-button--submit"
    )
      .unbind("click")
      .bind("click", function (e) {
        //event.preventDefault();
        e.stopPropagation();
        //console.log(jQuery(".form-email").val());
        var hash = CryptoJS.SHA256(jQuery(".form-email").val());
        var texthash = hash.words.toString();
        createrEventDataLayer(
          ".webform-submission-registro-hey-bacaneria-form",
          "bacaneria",
          "registro bacaneria",
          texthash
        );
      });
  });

  // Descargar Ahora Wallpers Desktop/Mobile content
  jQuery(document).ajaxComplete(function () {
    jQuery(".descarga-wallpers-zip")
      .unbind("click")
      .bind("click", function (e) {
        dataLayer.push({
          event: "trackEvent",
          eventCategory: "bacaneria",
          eventAction: "carrusel",
          eventLabel: "Descargar ahora",
        });
      });
  });

  // Popup Ir a Descargas
  jQuery(".modal-content .ir-descargas").click(function (e) {
    //e.preventDefault();
    var btnid = jQuery("button.ir-descargas").text();
    //console.log(btnid);
    dataLayer.push({
      event: "trackEvent",
      eventCategory: "bacaneria",
      eventAction: "pop up",
      eventLabel: btnid,
    });
  });

  // Seguir Ahora
  jQuery(".seguir-ahora-banner").click(function (e) {
    //e.preventDefault();
    var valora = jQuery("a.seguir-ahora-banner").text();
    //console.log(valora);
    dataLayer.push({
      event: "trackEvent",
      eventCategory: "bacaneria",
      eventAction: "banner",
      eventLabel: valora,
    });
  });
  jQuery(".descarga-stickers-zip a")
    .unbind("click")
    .bind("click", function (e) {
      var btns = jQuery(".descarga-stickers-zip a").text();
      //console.log(btns);
      //e.preventDefault();
      dataLayer.push({
        event: "trackEvent",
        eventCategory: "bacaneria",
        eventAction: "playlist",
        eventLabel: btns,
      });
    });
}
jQuery(window).on("load", init);