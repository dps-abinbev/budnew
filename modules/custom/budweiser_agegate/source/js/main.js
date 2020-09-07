(function ($, Drupal) {

	window.fbAsyncInit = function() {
		FB.init({
			appId            : '2774810422538741',
			autoLogAppEvents : true,
			xfbml            : true,
			version          : 'v3.2'
		});
	};


	Drupal.behaviors.sabm_age_gate_face = {
		attach: function (context, settings) {
			function facebook_validation() {
				FB.api('/me', {fields: 'birthday'}, function (response) {
					var birthday = response.birthday;
					var b_split = birthday.split("/");
					var submit_form = Drupal.settings.sabm_age_gate.submit_form;

					$('#age_checker_month').val(b_split[0]);
					$('#age_checker_day').val(b_split[1]);
					$('#age_checker_year').val(b_split[2]);

					if (submit_form == "1" || submit_form == 1) {
						age_checker.verify();
					}
				});
			}
		}
	};

	function getCookie(cname) {
		var name = cname + "=";
		var decodedCookie = decodeURIComponent(document.cookie);
		var ca = decodedCookie.split(';');
		for(var i = 0; i <ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') {
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
			}
		}
		return "";
	}

	Drupal.behaviors.mod_agegate = {
		attach: function (context, settings) {
			if(window.location.pathname !== '/agegate') {
				if(!getCookie('STYXKEY_age_verified')) {
					//document.cookie = "STYXKEY_url="+window.location.href.replace(window.location.origin+'/', '')+"; expires=Thu, 19 Jun 2022 20:47:11 UTC; path=";
					document.cookie = "STYXKEY_url="+window.location.href+"; expires=Thu, 19 Jun 2022 20:47:11 UTC; path=*";
					window.location = '/agegate?destination='+window.location.href;
				}
				/*else{
                    var url=getCookie('STYXKEY_url');
                    if(window.location.href.includes("PANTHEON_STRIPPED") && url) {
                        document.cookie = 'STYXKEY_url=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                        window.location.href = url;
                    }
                }*/
			}
		}
	};
})(jQuery, Drupal);