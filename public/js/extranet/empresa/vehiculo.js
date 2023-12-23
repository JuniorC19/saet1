$(document).ready(function(){
	var href = 0;
	var editar =0;

	var n_vehiculos = $("#autorizacion option:selected").attr("data-vehiculos");
    var Cerrar = $("#autorizacion option:selected").attr("data-estado");
    if(Cerrar==1){
            $("#cerrar").hide("slow");
        }else{
            $("#cerrar").show("slow");
        }

	$(".n_vehiculos").text(n_vehiculos); 
	nV = n_vehiculos;
    // Cerrar = estado;
	ida = $("#autorizacion").val();

	$("#autorizacion").on("change",function(){
		n_vehiculos = $("#autorizacion option:selected").attr("data-vehiculos");
        Cerrar = $("#autorizacion option:selected").attr("data-estado");
        if(Cerrar==1){
            $("#cerrar").hide("slow");
        }else{
            $("#cerrar").show("slow");
        }
		$(".n_vehiculos").text(n_vehiculos); 
		nV = n_vehiculos;
		ida = $("#autorizacion").val();
		table.draw();
		// console.log(n_rutas);
	});



	$('#fecha').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'dd/mm/yyyy'
    });
    $('#vencimiento').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'dd/mm/yyyy'
    });
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

    $("#departamento").prop('disabled', true);
    $("#provincia").prop('disabled', true);
    $("#distrito").prop('disabled', true);

    $('#editar').on('change', function(event){
        if ($('#editar').is(':checked')){
            $("#departamento").prop('disabled', false);
            $("#provincia").prop('disabled', true);
            $("#distrito").prop('disabled', true);
            $("#btnUpdateUbigeo").prop('disabled', false);
            $("#departamento").val('').trigger('change');
            $("#provincia").val('').trigger('change');
            $("#distrito").val('').trigger('change');
        }else{
            $("#departamento").prop('disabled', true);
            $("#provincia").prop('disabled', true);
            $("#distrito").prop('disabled', true);
            $("#btnUpdateUbigeo").prop('disabled', true);
            $("#departamento").val('').trigger('change');
            $("#provincia").val('').trigger('change');
            $("#distrito").val('').trigger('change');

        } 

    });


    var departamento = 0;
    var provincia = 0;
    $("#departamento").select2({
        allowClear: true,
        theme: 'bootstrap4',
        language: "es",
        placeholder: "Seleccione un marca",
        ajax: {
            url:"/extranet/select2departamento/",
            dataType: 'json',
            // delay: 250,
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
        $("#provincia").prop('disabled', false);

        departamento = e.params.data.id;
        $("#provincia").val('').trigger('change');
        $("#distrito").val('').trigger('change');

        $("#distrito").prop('disabled', true);
    });

    $("#provincia").select2({
      allowClear: true,
        theme: 'bootstrap4',
        language: "es",
        placeholder: "Seleccione un marca",
      ajax: {
        url:"/extranet/select2provincia/",
        dataType: 'json',
        // delay: 250,
        data: function (params) {
            return {
                q: params.term,
                departamento:departamento 
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
        $("#distrito").prop('disabled', false);
        provincia = e.params.data.id;
        $("#distrito").val('').trigger('change');
        console.log(e.params.data);
    });

    $("#distrito").select2({
      allowClear: true,
        theme: 'bootstrap4',
        language: "es",
        placeholder: "Seleccione un marca",
      ajax: {
        url:"/extranet/select2distrito",
        dataType: 'json',
        // delay: 250,
        data: function (params) {
            return {
                q: params.term,
                departamento:departamento, 
                provincia:provincia 
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
    })
    .on("select2:select", function (e) {
        // $("#distrito").prop('disabled', false);
        console.log(e.params.data);
    });


    $("#asignar").on("change",function(){
        if ($('#asignar').is(':checked')) {

            $("#documento").prop("disabled",false);
            $("#paterno").prop("disabled",false);
            $("#materno").prop("disabled",false);
            $("#nombres").prop("disabled",false);
            $("#cat").prop("disabled",false);
            $("#estado_licencia").prop("disabled",false);
            $("#vencimiento").prop("disabled",false);

            $("#conductor").show("slow");
        }else{
            $("#conductor").hide("slow");
            
            $("#documento").val("");
            $("#documento").prop("disabled",true);
            $("#paterno").val("");
            $("#paterno").prop("disabled",true);
            $("#materno").val("");
            $("#materno").prop("disabled",true);
            $("#nombres").val("");
            $("#nombres").prop("disabled",true);
            $("#cat").val("");
            $("#cat").prop("disabled",true);
            $("#estado_licencia").val("");
            $("#estado_licencia").prop("disabled",true);
            $("#vencimiento").val("");
            $("#vencimiento").prop("disabled",true);
        }
    });

	$("#vehiculo").select2({
        allowClear: true,
        theme: 'bootstrap4',
        language: "es",
        placeholder: "Seleccione un vehiculo",
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
    });
	var table = $('#table-data').DataTable({
		processing:true,
		serverSide:true,
		language: {
	        url:'/js/spanish.json'
	    },
		ajax:{
			url:'/extranet/empresa/vehiculo/'+ide+'?datatable=true',
			data: function (d) {
	            d.autorizacion = $('#autorizacion').val();
	        }
		},
		columns:[
			{data:'Botones',name:'Botones'},
			{data:'Placa',name:'Placa'},
			{data:'Marca',name:'Marca'},
			{data:'Categoria',name:'Categoria'},
			{data:'Fabricacion',name:'Fabricacion'},
			{data:'Resolucion',name:'Resolucion'},
			{data:'Estado',name:'Estado'},
		],
	    rowCallback: function( row, data, index ) {
	    	var btn = '<a href="'+data.RowId+'" class="editar h5 text-dark float-right ml-1" title="Editar"><i class="fas fa-pencil-alt"></i></a>';
	    		btn += '<a href="'+data.RowId+'" class="historial h5 text-dark float-right ml-1" title="Historial"><i class="fas fa-list-ul"></i></a>';
                btn += '<a href="'+data.RowId+'-'+data.RowIdA+'" class="tuc h4 text-dark float-right ml-1" title="Tarjerta Unica de Circulacion"><i class="mdi mdi-certificate"></i></a>';
	    	 
	    	$('td:eq(0)', row).html(btn);

	    	$('td:eq(0)', row).delegate('.editar','click',function(e){ 
				href = $(this).attr('href');
				$("#title-datatable").html("Editar Vehiculo");
				$.ajax({
                    type: "GET",
                    dataType: "json",
                    url:"/extranet/vehiculo/"+href+"/edit",
                    success: function(data) {
                    	console.log(data);
                    	editar=1;
                    	$(".form-control").removeClass("is-valid");
        				$(".form-control").removeClass("is-invalid");

        				$(".input-group").removeClass("is-valid");
        				$(".input-group").removeClass("is-invalid");

						$("#fecha").val(data.vehiculo.Fecha);
                        $("#placa").val(data.vehiculo.placa);
						$("#placa").prop("disabled",true);
						$("#fabricacion").val(data.vehiculo.fabricacion);
						$("#estado").val(data.vehiculo.estado);
						// $("#marca").val(data.vehiculo.id_marca);
                        if(data.vehiculo.Carroceria==null)
                        {
                            $('#carroceria').val(null).trigger('change');
                        }else{
    					    var optionCarroceria = new Option(data.vehiculo.Carroceria, data.vehiculo.id_carroceria, true, true);
    					        carroceria.append(optionCarroceria).trigger('change');
                        }

                        if(data.vehiculo.Marca==null){
                            $('#marca').val(null).trigger('change');
                        }else{
						    var optionMarca = new Option(data.vehiculo.Marca, data.vehiculo.id_marca, true, true);
					           marca.append(optionMarca).trigger('change');
                        }

						$("#categoria").val(data.vehiculo.id_categoria);
						$("#clase").val(data.vehiculo.clase);
						$("#anio_fabrica").val(data.vehiculo.anio_fabrica);
						$("#modelo").val(data.vehiculo.modelo);
						$("#combustible").val(data.vehiculo.combustible);
						// $("#carroceria").val(data.vehiculo.carroceria);
						$("#color").val(data.vehiculo.color);
						$("#n_motor").val(data.vehiculo.n_motor);
						$("#n_chasis").val(data.vehiculo.n_chasis);
						$("#n_ejes").val(data.vehiculo.n_ejes);
						$("#n_cilindros").val(data.vehiculo.n_cilindros);
						$("#n_ruedas").val(data.vehiculo.n_ruedas);
						$("#n_pasajeros").val(data.vehiculo.n_pasajeros);
						$("#n_asientos").val(data.vehiculo.n_asientos);
						$("#peso_neto").val(data.vehiculo.peso_neto);
						$("#peso_bruto").val(data.vehiculo.peso_bruto);
						$("#carga_util").val(data.vehiculo.carga_util);
						$("#largo").val(data.vehiculo.largo);
						$("#alto").val(data.vehiculo.alto);
						$("#ancho").val(data.vehiculo.ancho);
						$("#acc_seguridad").val(data.vehiculo.acc_seguridad);
						$("#n_puertas").val(data.vehiculo.n_puertas);
						$("#tacografo").val(data.vehiculo.tacografo);
						$("#n_salida_emergencia").val(data.vehiculo.n_salida_emergencia);
						$("#reg_seguridad").val(data.vehiculo.reg_seguridad);
						$("#limitador_seguridad").val(data.vehiculo.limitador_seguridad);
						$("#sistema_comunicacion").val(data.vehiculo.sistema_comunicacion);
						$("#observacion").val(data.vehiculo.observacion);

                        if(data.vehiculo.conductor==1){
                            $("#conductor").show("slow");
                            $("#asignar").prop("checked",true);
                            $("#documento").val(data.vehiculo.documento);
                            $("#paterno").val(data.vehiculo.paterno);
                            $("#materno").val(data.vehiculo.materno);
                            $("#nombres").val(data.vehiculo.nombres);
                            $("#cat").val(data.vehiculo.cat);
                            $("#estado_licencia").val(data.vehiculo.estado_licencia);
                            $("#vencimiento").val(data.vehiculo.vencimiento);
                            $("#documento").prop("disabled",false);
                            $("#paterno").prop("disabled",false);
                            $("#materno").prop("disabled",false);
                            $("#nombres").prop("disabled",false);
                            $("#cat").prop("disabled",false);
                            $("#estado_licencia").prop("disabled",false);
                            $("#vencimiento").prop("disabled",false);
                            $("#nombre_ubigeo").text(data.departamento.nombre+"/"+data.provincia.nombre+"/"+data.distrito.nombre);


                        }else{
                            $("#asignar").prop("checked",false);
                            $("#conductor").hide("slow");

                            $("#documento").val("");
                            $("#documento").prop("disabled",true);
                            $("#paterno").val("");
                            $("#paterno").prop("disabled",true);
                            $("#materno").val("");
                            $("#materno").prop("disabled",true);
                            $("#nombres").val("");
                            $("#nombres").prop("disabled",true);
                            $("#cat").val("");
                            $("#cat").prop("disabled",true);
                            $("#estado_licencia").val("");
                            $("#estado_licencia").prop("disabled",true);
                            $("#vencimiento").val("");
                            $("#vencimiento").prop("disabled",true);


                            $("#nombre_ubigeo").text("");
                        }

					        

                    },
                    error: function(result) {
                    }
                });
                $('#modal-datatable').modal('show');
				e.preventDefault();
			});

			$('td:eq(0)', row).delegate('.historial','click',function(e){
				href = $(this).attr('href');
				$.ajax({
                    type: "GET",
                    dataType: "json",
                    url:"/extranet/vehiculo/historial/"+href,
                    success: function(data) {
                    	var html = "";
                    	$.each(data.historial,function(i,val){
                    		 
                			html +="<tr>"+
				                "<td>"+(i+1)+"</td>"+
				                "<td>"+val.Ruc+"</td>"+
				                "<td>"+val.RazonSocial+"</td>"+
				                "<td>"+val.Resolucion+"</td>"+
				                "<td>"+val.FechaIni+"</td>"+
				                "<td>"+val.FechaFin+"</td>"+
				                "<td>"+val.Estado+"</td>"+
				              "</tr>";
                    	});
                    	$("#historial").html(html);
                    },
                    error: function(result) {
                    }
                });
                $('#modal-datatable-historial').modal('show');
				e.preventDefault();
			});

            $('td:eq(0)', row).delegate('.tuc','click',function(e){ 
                href = $(this).attr('href');
                var win = window.open('/extranet/empresa/vehiculo/pdftuc/'+href, '_blank');
                if (win) {
                    win.focus();
                }
                e.preventDefault();
            });

			$('td:eq(0) a', row).tooltip();
		},
	    order: [[ 1, 'desc' ]]
	}).on( 'draw.dt', function () {
        if(Cerrar==0){
    		if(table.page.info().recordsTotal<parseInt(nV)){
    			$("#new-add").show("slow");
    		}else{
    			$("#new-add").hide("slow");
    		}
        }else{
            $("#new-add").hide("slow");
        }
	    // console.log( table.page.info().recordsTotal,nV);
	});

	$("#new_itinerario").on("click",function(){
		$("#clon div:eq(0)").clone().appendTo("#itinerario");
	});
	$("#itinerario").delegate(".eliminar","click",function(e){
      	$(this).parent().parent().parent().remove();
    });  	
	var validator = $("#formulary").validate({
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
    	editar = 0;
    	$("#title-datatable").text("Nuevo Vehiculo");
    	$(".form-control").removeClass("is-valid");
		$(".form-control").removeClass("is-invalid");

		$(".input-group").removeClass("is-valid");
		$(".input-group").removeClass("is-invalid");

		$("#fecha").val("");
        $("#placa").val("");
		$("#placa").prop("disabled",false);
		$("#fabricacion").val("");
		$("#estado").val("");
		$('#marca').val(null).trigger('change');
        $('#carroceria').val(null).trigger('change');
		$("#categoria").val("");
		$("#clase").val("");
		$("#anio_fabrica").val("");
		$("#modelo").val("");
		$("#combustible").val("");
		// $("#carroceria").val("");
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

        $("#asignar").prop("checked",false);
        $("#conductor").hide("slow");
        $("#documento").val("");
        $("#documento").prop("disabled",true);
        $("#paterno").val("");
        $("#paterno").prop("disabled",true);
        $("#materno").val("");
        $("#materno").prop("disabled",true);
        $("#nombres").val("");
        $("#nombres").prop("disabled",true);
        $("#cat").val("");
        $("#cat").prop("disabled",true);
        $("#estado_licencia").val("");
        $("#estado_licencia").prop("disabled",true);
        $("#vencimiento").val("");
        $("#vencimiento").prop("disabled",true);

        $("#editar").prop('checked', false);
        $("#departamento").prop('disabled', true);
        $("#provincia").prop('disabled', true);
        $("#distrito").prop('disabled', true);
        $("#departamento").val('').trigger('change');
        $("#provincia").val('').trigger('change');
        $("#distrito").val('').trigger('change');

        $("#nombre_ubigeo").text("");

		$('#modal-datatable').modal('show');
	});

    $("#guardar").on("click",function(){
    	// alert("hols");
    	var validar = validator.form();
    	if(validar == true){
    		data = $("#formulary").serialize()+"&ide="+ide+"&ida="+ida;
    		$('.page-wrapper').loader('show');
    		if(editar==1){
			    $.ajax({
			        type: "PUT",
			        dataType: "json",
			        url: "/extranet/vehiculo/"+href,
			        data:data,
			        success:function(data){
			          // console.log(data);
			           $('.page-wrapper').loader('hide');
			          	if(data.status == true){
				              // var objeto = JSON.parse(data['message']);
							table.draw();
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
		                // table.draw();
		                $('#modal-datatable').modal('hide');
			        },
			        error:function(result){

			        }
			    });
    		}else{
    			$.ajax({
			        type: "POST",
			        dataType: "json",
			        url: "/extranet/vehiculo",
			        data:data,
			        success:function(data){
			          // console.log(data);
			          	$('.page-wrapper').loader('hide');
			          	if(data.status == true){
				              // var objeto = JSON.parse(data['message']);
							table.draw();
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
		                // table.draw();
		                $('#modal-datatable').modal('hide');
			        },
			        error:function(result){

			        }
			    });
    		}
    	}else{
            validator.focusInvalid();
        }
    });

    var validatorVehiculo = $("#formularyVehiculo").validate({
        rules:{
            'vehiculo':{
                required:true
            }
        },
        messages:{
            'vehiculo':{
                required:"Este campo es requerido."
            }        
        }
    });

    $("#add-vehiculo").on("click",function(){
    	var validarVehiculo = validatorVehiculo.form();
    	if(validarVehiculo == true){
    		// alert("hols");
    		data = $("#formularyVehiculo").serialize();
    		$.confirm({
				title: 'Alerta!',
				content: '¿Esta seguro se agregar este Vehiculo?',
				type: 'green',
				theme: 'modern',
				closeIcon: true,
				icon: 'fa fa-question',
				buttons: {
				  confirm: {
					text:"Agregar",
					btnClass: 'btn-green',
					action: function(){
						$('.page-wrapper').loader('show');
						$.ajax({
					        type: "PUT",
					        dataType: "json",
					        url: "/extranet/empresa/add_vehiculo/"+ida+"?ide="+ide,
					        data:data,
					        success:function(data){
					          // console.log(data);
					          	$('.page-wrapper').loader('hide');
					          	if(data.status == true){
						              // var objeto = JSON.parse(data['message']);
									table.draw();
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
										      	$('#vehiculo').val(null).trigger('change');
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
				                // table.draw();
					        },
					        error:function(result){

					        }
					    });
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
    });

    $("#cerrar").on("click",function(){
        // $('.page-wrapper').loader('show');
        $.ajax({
            type: "PUT",
            dataType: "json",
            url: "/extranet/autorizacion/cerrar/"+ida,
            success:function(data){
              // console.log(data);
                // $('.page-wrapper').loader('hide');
                if(data.status == true){
                      // var objeto = JSON.parse(data['message']);
                    Cerrar = 1;
                    $("#cerrar").hide("slow");
                    $("#new-add").hide("slow");
                    $("#autorizacion option:selected").attr("data-estado",1);
                    table.draw();
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
                                // $('#vehiculo').val(null).trigger('change');
                                // table.draw();

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
                // table.draw();
            },
            error:function(result){

            }
        });


    });


});