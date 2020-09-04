jQuery(document).ready(function($) {
    if ($("body").hasClass("landing-bacaneria")) {
        $(window).on('load',function(){
            $('#myModal').modal('show');
        });
    }
})
