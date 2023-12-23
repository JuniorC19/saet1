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
			url:'/extranet/empresa/terminal/'+ide+'?datatable=true'
		},
		columns:[
			{data:'Botones',name:'Botones'},
			{data:'Direccion',name:'Direccion'},
			{data:'CertificadoHabilitacion',name:'CertificadoHabilitacion'},
			// {data:'Resolucion',name:'Resolucion'},
		],
	    rowCallback: function( row, data, index ) {
	    	var btn = '<a href="'+data.RowId+'" class="editar h5 text-dark col-xs-4" title="Editar"><i class="fas fa-pencil-alt"></i></a> ';
	    	 
	    	$('td:eq(0)', row).html(btn);

	    	$('td:eq(0)', row).delegate('.editar','click',function(e){ 
				href = $(this).attr('href');
				$("#title-datatable").html("Editar Terminal");
				$.ajax({
                    type: "GET",
                    dataType: "json",
                    url:"/extranet/terminal/"+href+"/edit",
                    success: function(data) {
                    	console.log(data);
                    	editar=1;
                    	$(".form-control").removeClass("is-valid");
        				$(".form-control").removeClass("is-invalid");
                    	$("#direccion").val(data.data.direccion);
                    	$("#certificado_habilitacion").val(data.data.certificado_habilitacion);

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
            'direccion':{
                required:true
            }         
        },
        messages:{
            'direccion':{
                required:"Este campo es requerido."
            }
        }
    });

	$("#nuevo").on("click",function(){
		$(".form-control").removeClass("is-valid");
		$(".form-control").removeClass("is-invalid");

		$(".input-group").removeClass("is-valid");
		$(".input-group").removeClass("is-invalid");
    	editar = 0;
    	$("#title-datatable").text("Nuevo terminal");
    	$("#direccion").val("");
    	$("#certificado_habilitacion").val("");
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
			        url: "/extranet/terminal/"+href,
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
			        url: "/extranet/terminal",
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