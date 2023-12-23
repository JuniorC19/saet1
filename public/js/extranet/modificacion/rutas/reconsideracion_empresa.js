$(document).ready(function(){
     // console.log(moment());
	$('#fecha_ini').datepicker({
         autoclose: true,
         todayHighlight: true,
         format: 'dd/mm/yyyy'
    })
   $('#anio').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy',
        viewMode: "years", 
        minViewMode: "years"
        // language:"es"
    });
	$(".check_ruta").on("click",function(){
		tr = $(this).parent().parent().parent();
		input = $(tr).find(".form-control");
		eliminar = $(tr).find(".eliminar_itinerario");
		agregar = $(tr).find(".new_itinerario");
		// new_itinerario
		// name_itinerario
		// eliminar_itinerario
		// console.log();
		if($(this).is(':checked')) {
			console.log("check");
			$(input).prop("disabled",false);
			$(eliminar).prop("disabled",false);
			$(agregar).prop("disabled",false);
		}else{
			console.log("no check");
			$(input).prop("disabled",true);
			$(eliminar).prop("disabled",true);
			$(agregar).prop("disabled",true);

		}
	});

	$(".new_itinerario").on("click",function(e){
    	num = $(this).attr("numero");
      	iti = $(this).next();
      	$("#clon_itinerario div:eq(0)").find(".name_itinerario").attr("name","itinerario["+num+"][]")
      	$("#clon_itinerario div:eq(0)").clone().appendTo($(iti));
    });
    $(".itinerario").delegate(".eliminar_itinerario","click",function(){
    	console.log("fed");
    	$(this).parent().parent().parent().remove();
    });

	var validator = $("#formulary").validate({
		// ignore: [],
        rules:{
            'resolucion':{
                required:true
            },
            'fecha_ini':{
                required:true
            },
            'resolucion':{
                required:true,
                number:true,
                maxlength:4,
                minlength:4
            },
            'anio':{
                required:true,
                number:true,
                maxlength:4,
                minlength:4
            }          
        },
        messages:{
            'resolucion':{
                required:"Este campo es requerido."
            },
            'fecha_ini':{
                required:"Este campo es requerido."
            },
            'resolucion':{
                required:"Este campo es requerido.",
                number:"Solo se permite numeros.",
                maxlength:"Maximo 4 digitos.",
                minlength:"Minimo 4 digitos."
            },
            'anio':{
                required:"Este campo es requerido.",
                number:"Solo se permite numeros.",
                maxlength:"Maximo 4 digitos.",
                minlength:"Minimo 4 digitos."
            }
        }
    });

    // $(".remove-materno").on("click",function(e){
    //     $("#materno").rules("remove");
    //     $("#materno").val('');
    //     $("#materno").removeClass("is-valid");
    //     $("#materno").removeClass("is-invalid");
    //     e.preventDefault();
    // });

    $("#guardar").on("click",function(){
    	var validar = validator.form();
    	if(validar == true){
            $('.page-wrapper').loader('show');
    		data = $("#formulary").serialize()+"&empresa="+ide+"&autorizacion="+ida;
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "/extranet/modificacion/rutas/reconsideracion/save",
                data:data,
                success:function(data){
                    $('.page-wrapper').loader('hide');

                    if(data.status == true){
                        $.confirm({
                            title: 'Satisfactorio',
                            content: data['message'],
                            type: 'green',
                            theme: 'modern',
                            // closeIcon: true,
                            icon: 'fas fa-check',
                            buttons: {
                              confirm: {
                                  text:"Aceptar",
                                  btnClass: 'btn-green',
                                  action: function(){
                                    $(location).attr('href',"/extranet/modificacion/rutas/reconsideracion");
                                  }
                              }
                            }
                        });

                    }else{
                        $.confirm({
                            title: 'Error!',
                            content: data['message'],
                            type: 'orange',
                            theme: 'modern',
                            closeIcon: true,
                            icon: 'fas fa-exclamation-triangle',
                            buttons: {
                              confirm: {
                                  text:"Intentar de nuevo",
                                  btnClass: 'btn-green',
                                  action: function(){
                                  }
                              },
                              cancel:{
                                  text:"Salir",
                                  action:function(){
                                     
                                  }
                              }
                            }
                        });
                    }
                },
                error:function(result){

                }
            });
    	}
        else{
            validator.focusInvalid();
        }
    });

});