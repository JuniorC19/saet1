$(document).ready(function(){
     // console.log(moment());
	$('#fecha_ini').datepicker({
         autoclose: true,
         todayHighlight: true,
         format: 'dd/mm/yyyy'
    }).on('changeDate', function(e) {

        var dateini = $('#fecha_ini').datepicker('getDate');
        var d = new Date(dateini);
        var year = d.getFullYear();
        var month = d.getMonth();
        var day = d.getDate();
        var c = new Date(year + 4, month, day);
        $('#fecha_fin').datepicker('update',  c);
    });
    $('#fecha_fin').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'dd/mm/yyyy'
    });
    $('#anio').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy',
        viewMode: "years", 
        minViewMode: "years"
        // language:"es"
    });

    $("#buscar").on("click",function(e){
        
        var ruc = $("#ruc").val();
        // load.open();
        $('.page-wrapper').loader('show');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "/api/sunat/ruc/"+ruc,
            success:function(data){
              // console.log(data);
                $('.page-wrapper').loader('hide');
                if(data.status == true){
                      // var objeto = JSON.parse(data['message']);
                    $("#razon_social").val(data.datos.razonSocial);
                    $("#nombre").val(data.datos.razonSocial);
                    // table.draw();
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
                // table.draw();
            },
            error:function(result){

            }
        });
        e.preventDefault();
    });

	var validator = $("#formulary").validate({
        rules:{
            'ruc':{
                required:true,
                minlength:11,
                maxlength:11,
                number:true
            },
            'razon_social':{
                required:true
            },
            'nombre':{
                required:true
            },
            'tipo':{
                required:true
            },
            'telefono':{
                number:true
            },
            'partida':{
                required:true,
                number:true,
                maxlength:8,
                minlength:8
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
            },
            'fecha_ini':{
                required:true
            },
            'fecha_fin':{
                required:true
            },
            'rutas':{
                required:true,
                number:true
            },
            'vehiculos':{
                required:true,
                number:true
            }       
        },
        messages:{
            'ruc':{
                required:"Este campo es requerido.",
                minlength:"Minimo 11 digitos.",
                maxlength:"Maximo 11 digitos.",
                number:"Solo se permite numeros."
            },
            'razon_social':{
                required:"Este campo es requerido."
            },
            'nombre':{
                required:"Este campo es requerido."
            },
            'tipo':{
                required:"Este campo es requerido."
            },
            'telefono':{
                number:"Solo se permite numeros."
            },
            'partida':{
                required:"Este campo es requerido.",
                number:"Solo se permite numeros.",
                maxlength:"Maximo 8 digitos.",
                minlength:"Minimo 8 digitos."
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
            },
            'fecha_ini':{
                required:"Este campo es requerido."
            },
            'fecha_fin':{
                required:"Este campo es requerido."
            },
            'rutas':{
                required:"Este campo es requerido.",
                number:"Solo se permite numeros."
            },
            'vehiculos':{
                required:"Este campo es requerido.",
                number:"Solo se permite numeros."
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
                url: "/extranet/empresa",
                data:data,
                success:function(data){
                    $('.page-wrapper').loader('hide');

                    if(data.status == true){
                        // table.draw();
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
                                    $(location).attr('href',"/extranet/empresa/ruta/"+data.id);
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
                    // table.draw();
                    // $('#modal-proveedor').modal('hide');
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