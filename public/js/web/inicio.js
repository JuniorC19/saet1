$(document).ready(function(){

	var validator = $("#formulary").validate({
        rules:{
            'placa':{
                required:true,
                minlength:7,
                maxlength:7
            }  
        },
        messages:{
            'placa':{
                required:"Este campo es requerido.",
                minlength:"Solo se permite 7 numeros",
                maxlength:"Solo se permite 7 numeros"
            }
        }
    });
	
	$("#consultar").on("click",function(){

            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                $('#recaptchaError').removeClass('d-none');
                $('#recaptchaError').addClass('d-block');
            }else {
                $('#recaptchaError').addClass('d-none');
                $('#recaptchaError').removeClass('d-block');

                $("#formulary").submit();
            }
	});
});