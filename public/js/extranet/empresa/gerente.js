$(document).ready(function(){
	var href = 0;
	var editar =0;
	var table = $('#table-data').DataTable({
		processing:true,
		serverSide:true,
		language: {
	        url:'/js/spanish.json'
	    },
		ajax:{
			url:'/extranet/empresa/gerente/'+ide+'?datatable=true'
		},
		columns:[
			{data:'Botones',name:'Botones'},
			{data:'Documento',name:'Documento'},
			{data:'Apellidos',name:'Apellidos'},
			{data:'Nombres',name:'Nombres'},
			{data:'Telefono',name:'Telefono'},
			{data:'Direccion',name:'Direccion'},
			{data:'Email',name:'Email'},
			{data:'Estado',name:'Estado'},
		],
	    rowCallback: function( row, data, index ) {
	    	var btn = '<a href="'+data.RowId+'" class="editar h5 text-dark col-xs-4" title="Editar"><i class="fas fa-pencil-alt"></i></a> ';
	    	 
	    	$('td:eq(0)', row).html(btn);

	    	$('td:eq(0)', row).delegate('.editar','click',function(e){ 
				href = $(this).attr('href');
				$("#title-datatable").html("Editar Gerente");
				$.ajax({
                    type: "GET",
                    dataType: "json",
                    url:"/extranet/gerente/"+href+"/edit",
                    success: function(data) {
                    	console.log(data);
                    	editar=1;
                    	$(".form-control").removeClass("is-valid");
        				$(".form-control").removeClass("is-invalid");

                    	$("#documento").val(data.data.documento);
                    	$("#nombres").val(data.data.nombres);
                    	$("#paterno").val(data.data.paterno);
                    	$("#materno").val(data.data.materno);
                    	$("#telefono").val(data.data.telefono);
                    	$("#email").val(data.data.email);
                    	$("#direccion").val(data.data.direccion);

                    	if(data.data.estado==1){
                    		$('#activo').prop( 'checked', true );
                    	}else{
                    		$('#activo').prop( 'checked', false )
                    	}

                    },
                    error: function(result) {
                    }
                });
                $('#modal-datatable').modal('show');
				e.preventDefault();
			});
			$('td:eq(0) a', row).tooltip();
		},
	    order: [[ 1, 'desc' ]]
	});

	$("#new_itinerario").on("click",function(){
		$("#clon div:eq(0)").clone().appendTo("#itinerario");
	});
	$("#itinerario").delegate(".eliminar","click",function(e){
      	$(this).parent().parent().parent().remove();
    });  	
	var validator = $("#formulary").validate({
        rules:{
            'documento':{
                required:true,
                number:true
            },
            'paterno':{
                required:true
            },
            'materno':{
                required:true
            },
            'nombres':{
                required:true
            },
            'telefono':{
                number:true,
                maxlength:9
            },
            'email':{
                email:true
            }         
        },
        messages:{
            'documento':{
                required:"Este campo es requerido.",
                number:"Solo se permite numeros."
            },
            'paterno':{
                required:"Este campo es requerido."
            },
            'materno':{
                required:"Este campo es requerido."
            },
            'nombres':{
                required:"Este campo es requerido."
            },
            'telefono':{
                number:"Solo se permite numeros.",
                maxlength:"Maximo 9 digitos"
            },
            'email':{
                email:"No es un email."
            }
        }
    });

	$("#nuevo").on("click",function(){
		$("#title-datatable").html("Nuevo Gerente");
		$(".form-control").removeClass("is-valid");
		$(".form-control").removeClass("is-invalid");

		$(".input-group").removeClass("is-valid");
		$(".input-group").removeClass("is-invalid");
    	editar = 0;
    	$("#documento").val("");
    	$("#nombres").val("");
    	$("#paterno").val("");
    	$("#materno").val("");
    	$("#telefono").val("");
    	$("#email").val("");
    	$("#direccion").val("");

    		$('#activo').prop('checked',false)

		$('#modal-datatable').modal('show');
	});

    $("#guardar").on("click",function(){
    	// alert("hols");
    	var validar = validator.form();
    	if(validar == true){
    		data = $("#formulary").serialize()+"&ide="+ide;
    		$('.page-wrapper').loader('show');
    		if(editar==1){
			    $.ajax({
			        type: "PUT",
			        dataType: "json",
			        url: "/extranet/gerente/"+href,
			        data:data,
			        success:function(data){
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
			        url: "/extranet/gerente",
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
    })

});