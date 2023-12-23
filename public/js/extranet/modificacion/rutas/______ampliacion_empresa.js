$(document).ready(function(){
     // console.log(moment());
	$('#fecha_ini').datepicker({
         autoclose: true,
         todayHighlight: true
    })
   

    $("#empresa").select2({
        allowClear: true,
        theme: 'bootstrap4',
        language: "es",
        placeholder: "Seleccione un empresa",
        ajax: {
            url:"/extranet/select2/empresa",
            dataType: 'json',
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data.items
                };
            },

          cache: true
        },
        minimumInputLength: -1
    }).on("select2:select", function (e) {
        // $("#tipo").val(e.params.data.idTipo);
    });
    var numero = 2;
    $("#new_ruta").on("click",function(){
    	$("#clon_ruta div:eq(0)").find(".origen").attr("name","origen["+numero+"]");
    	$("#clon_ruta div:eq(0)").find(".destino").attr("name","destino["+numero+"]");
    	$("#clon_ruta div:eq(0)").find(".frecuencia").attr("name","frecuencia["+numero+"]");
    	$("#clon_ruta div:eq(0)").find(".new_itinerario").attr("numero",numero);
		$("#clon_ruta div:eq(0)").clone().appendTo("#ruta");
		numero++;
	});
	$("#ruta").delegate(".eliminar_ruta","click",function(e){
      	$(this).parent().parent().remove();
    });
    $("#ruta").delegate(".new_itinerario","click",function(e){
    	num = $(this).attr("numero");
      	iti = $(this).next();
      	$("#clon_itinerario div:eq(0)").find(".name_itinerario").attr("name","itinerario["+num+"][]")
      	$("#clon_itinerario div:eq(0)").clone().appendTo($(iti));
    });
    $("#ruta").delegate(".eliminar_itinerario","click",function(e){
      	$(this).parent().parent().parent().remove();
    });

	var validator = $("#formulary").validate({
		// ignore: [],
        rules:{
        	'empresa':{
        		required:true
        	},
            'resolucion':{
                required:true
            },
            'fecha_ini':{
                required:true
            }          
        },
        messages:{
        	'empresa':{
        		required:"Este campo es requerido."
        	},
            'resolucion':{
                required:"Este campo es requerido."
            },
            'fecha_ini':{
                required:"Este campo es requerido."
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
    		data = $("#formulary").serialize();
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "/extranet/modificacion/rutas/ampliacion/save",
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
                                    $(location).attr('href',"/extranet/modificacion/rutas/ampliacion");
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