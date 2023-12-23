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
    
    $('#fecha').datepicker({
         autoclose: true,
         todayHighlight: true,
         format: 'dd/mm/yyyy'
    })

    var marca = $("#marca").select2({
        allowClear: true,
        theme: 'bootstrap4',
        language: "es",
        placeholder: "Seleccione un marca",
        ajax: {
            url:"/extranet/select2/marca",
            dataType: 'json',
            data: function (params) {
                return {
                    q: params.term,
                    c:$("#categoria").val()
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
    });
    var carroceria = $("#carroceria").select2({
        allowClear: true,
        theme: 'bootstrap4',
        language: "es",
        placeholder: "Seleccione un carroceria",
        ajax: {
            url:"/extranet/select2/carroceria",
            dataType: 'json',
            data: function (params) {
                return {
                    q: params.term,
                    c:$("#categoria").val()
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
    });

    $("#vehiculo").select2({
        allowClear: true,
        theme: 'bootstrap4',
        language: "es",
        placeholder: "Seleccione un vehiculo para agregar",
        ajax: {
            url:"/extranet/select2/vehiculo",
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
        var datas ={'ide':ide,'vehiculo':e.params.data.id}
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "/extranet/modificacion/vehiculos/incremento/verificar",
            data:datas,
            success:function(data){
                if (data.status==true) {
                    $("#clon tr:eq(0)").find(".placa").html(e.params.data.placa);
                    $("#clon tr:eq(0)").find(".marca").html(e.params.data.marca);
                    $("#clon tr:eq(0)").find(".categoria").html(e.params.data.categoria);
                    $("#clon tr:eq(0)").find(".anio").html(e.params.data.fabricacion);
                    $("#clon tr:eq(0)").find(".input_vehiculo").val(e.params.data.id);

                    $("#clon tr:eq(0)").clone().appendTo("#vehiculos");
                    $('#vehiculo').val(null).trigger('change'); 

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
                                  // table.draw();

                              }
                          },
                          cancel:{
                              text:"Salir",
                              action:function(){
                                 
                              }
                          }
                        }
                    });
                     $('#vehiculo').val(null).trigger('change');
                }
            },
            error:function(result){
                $('.page-wrapper').loader('hide');

            }
        });
    });

    $("#vehiculos").delegate(".eliminar","click",function(){
        $(this).parent().parent().remove();
    });
    /***************************/
    var validatorVehiculo = $("#formularyVehiculo").validate({
        rules:{
            'placa':{
                required:true
            },
            'fecha':{
                required:true
            },
            'categoria':{
                // required:true
            },
            'marca':{
                // required:true
            },
            'fabricacion':{
                // required:true,
                minlength:4,
                maxlength:4,
                number:true
            },
            'modelo':{
                // required:true
            },
            'color':{
                // required:true
            },
            'n_chasis':{
                // required:true
            },
            'n_ejes':{
                // required:true,
                number:true
            },
            'n_ruedas':{
                number:true
            },
            'n_pasajeros':{
                number:true
            },
            'n_asientos':{
                // required:true,
                number:true
            },
            'peso_neto':{
                // required:true,
                number:true
            },
            'peso_bruto':{
                number:true
            },
            'carga_util':{
                // required:true,
                number:true
            },
            'largo':{
                // required:true,
                number:true
            },
            'ancho':{
                // required:true,
                number:true
            },
            'alto':{
                // required:true,
                number:true
            },
            'n_puertas':{
                number:true
            },
            'n_salida_emergencia':{
                number:true
            }          
        },
        messages:{
            'placa':{
                required:"Este campo es requerido."
            },
            'fecha':{
                required:"Este campo es requerido."
            },
            'categoria':{
                // required:"Este campo es requerido."
            },
            'marca':{
                // required:"Este campo es requerido."
            },
            'fabricacion':{
                // required:"Este campo es requerido.",
                minlength:"minimo 4 digitos",
                maxlength:"minimo 4 digitos",
                number:"Solo se permite numeros."
            },
            'modelo':{
                // required:"Este campo es requerido."
            },
            'color':{
                // required:"Este campo es requerido."
            },
            'n_chasis':{
                // required:"Este campo es requerido."
            },
            'n_ejes':{
                // required:"Este campo es requerido.",
                number:"Solo se permite numeros."
            },
            'n_ruedas':{
                number:"Solo se permite numeros."
            },
            'n_pasajeros':{
                number:"Solo se permite numeros."
            },
            'n_asientos':{
                // required:"Este campo es requerido.",
                number:"Solo se permite numeros."
            },
            'peso_neto':{
                // required:"Este campo es requerido.",
                number:"Solo se permite numeros."
            },
            'peso_bruto':{
                number:"Solo se permite numeros."
            },
            'carga_util':{
                // required:"Este campo es requerido.",
                number:"Solo se permite numeros."
            },
            'largo':{
                // required:"Este campo es requerido.",
                number:"Solo se permite numeros."
            },
            'ancho':{
                // required:"Este campo es requerido.",
                number:"Solo se permite numeros."
            },
            'alto':{
                // required:"Este campo es requerido.",
                number:"Solo se permite numeros."
            },
            'n_puertas':{
                number:"Solo se permite numeros."
            },
            'n_salida_emergencia':{
                number:"Solo se permite numeros."
            }           
        }
    });

    $("#new-vehiculo").on("click",function(){
        $("#title-datatable").text("Nuevo Vehiculo");
        $(".form-control").removeClass("is-valid");
        $(".form-control").removeClass("is-invalid");

        $(".input-group").removeClass("is-valid");
        $(".input-group").removeClass("is-invalid");

        $("#placa").val("");
        $("#fecha").val("");
        $("#placa").prop("disabled",false);
        $("#fabricacion").val("");
        $("#estado").val("");
        $('#marca').val(null).trigger('change');
        $("#categoria").val("");
        $("#clase").val("");
        $("#anio_fabrica").val("");
        $("#modelo").val("");
        $("#combustible").val("");
        $('#carroceria').val(null).trigger('change');
        $("#color").val("");
        $("#n_motor").val("");
        $("#n_chasis").val("");
        $("#n_ejes").val("");
        $("#n_cilindros").val("");
        $("#n_ruedas").val("");
        $("#n_pasajeros").val("");
        $("#n_asientos").val("");
        $("#peso_neto").val("");
        $("#peso_bruto").val("");
        $("#carga_util").val("");
        $("#largo").val("");
        $("#alto").val("");
        $("#ancho").val("");
        $("#acc_seguridad").val("");
        $("#n_puertas").val("");
        $("#tacografo").val("");
        $("#n_salida_emergencia").val("");
        $("#reg_seguridad").val("");
        $("#limitador_seguridad").val("");
        $("#sistema_comunicacion").val("");
        $("#observacion").val("");
        $('#modal-datatable').modal('show');
    });


    $("#guardarVehiculo").on("click",function(){
        
        var validarVehiculo = validatorVehiculo.form();
        if(validarVehiculo == true){
            data = $("#formularyVehiculo").serialize();
            $('.page-wrapper').loader('show');
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "/extranet/vehiculo",
                data:data,
                success:function(data){
                    $('.page-wrapper').loader('hide');


                    if(data.status == true){
                        if(marca.select2('data').length){
                            m_marca = marca.select2('data')[0].text;
                        }else{
                            m_marca = "";
                        }
                        if($("#categoria").val()!==""){
                            m_categoria = $("#categoria option:selected" ).text();
                        }else{
                            m_categoria = "";
                        }
                        $("#clon tr:eq(0)").find(".placa").html($("#placa").val());
                        $("#clon tr:eq(0)").find(".marca").html(m_marca);
                        $("#clon tr:eq(0)").find(".categoria").html(m_categoria);
                        $("#clon tr:eq(0)").find(".anio").html($("#fabricacion").val());
                        $("#clon tr:eq(0)").find(".input_vehiculo").val(data.id);

                        $("#clon tr:eq(0)").clone().appendTo("#vehiculos");
                        $('#vehiculo').val(null).trigger('change'); 

                        $.confirm({
                            title: 'Satisfactorio',
                            content: data['message']+" y Agregado",
                            type: 'green', 
                            theme: 'modern',
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
                                      table.draw();
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
                    $('#modal-datatable').modal('hide');
                },
                error:function(result){

                }
            });
            
        }else{
            validatorVehiculo.focusInvalid();
        }
    });
    /***************************/


	var validator = $("#formulary").validate({
        // ignore: [],
        rules:{
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

    $("#guardar").on("click",function(){
    	var validar = validator.form();
    	if(validar == true){
            $('.page-wrapper').loader('show');
    		data = $("#formulary").serialize()+"&empresa="+ide+"&autorizacion="+ida;
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "/extranet/modificacion/vehiculos/incremento/save",
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
                                    $(location).attr('href',"/extranet/modificacion/vehiculos/incremento");
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