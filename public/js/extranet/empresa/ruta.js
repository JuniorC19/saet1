$(document).ready(function(){
	var href = 0;
	var editar =0;

	var n_rutas = $("#autorizacion option:selected").attr("data-rutas");
	$(".n_rutas").text(n_rutas); 
	nR = n_rutas;
	ida = $("#autorizacion").val();

	$("#autorizacion").on("change",function(){
		n_rutas = $("#autorizacion option:selected").attr("data-rutas");
		$(".n_rutas").text(n_rutas); 
		nR = n_rutas;
		ida = $("#autorizacion").val();
		table.draw();
		// console.log(n_rutas);
	})


	var table = $('#table-data').DataTable({
		processing:true,
		serverSide:true,
		language: {
	        url:'/js/spanish.json'
	    },
		ajax:{
			url:'/extranet/empresa/ruta/'+ide+'?datatable=true',
			data: function (d) {
	            d.autorizacion = $('#autorizacion').val();
	        }
		},
		columns:[
			{data:'Botones',name:'Botones'},
			{data:'Origen',name:'Origen'},
			{data:'Destino',name:'Destino'},
			{data:'Frecuencia',name:'Frecuencia'},
			{data:'Itinerario',name:'Itinerario'},
			{data:'Resolucion',name:'Resolucion'},
		],
	    rowCallback: function( row, data, index ) {
	    	var btn = '<a href="'+data.RowId+'" class="editar h5 text-dark col-xs-4" title="Editar"><i class="fas fa-pencil-alt"></i></a> ';
	    	 
	    	$('td:eq(0)', row).html(btn);

	    	$('td:eq(0)', row).delegate('.editar','click',function(e){ 
				href = $(this).attr('href');
				$("#title-datatable").html("Editar Ruta");
				$.ajax({
                    type: "GET",
                    dataType: "json",
                    url:"/extranet/ruta/"+href+"/edit",
                    success: function(data) {
                    	// console.log(data);
                    	editar=1;
                    	$(".form-control").removeClass("is-valid");
        				$(".form-control").removeClass("is-invalid");
                    	$("#origen").val(data.ruta.origen);
                    	$("#destino").val(data.ruta.destino);
                    	$("#frecuencia").val(data.ruta.frecuencia);
                    	var html = "";
                    	$.each(data.itinerario,function(i,val){
                    		html+='<div class="form-group my-1">'+
								'<div class="input-group">'+
								  '<input type="text" class="form-control" name="itinerario[]" value="'+val.nombre+'">'+
								  '<div class="input-group-append">'+
								    '<button class="btn btn-outline-danger eliminar" type="button"><i class="fas fa-times"></i></button>'+
								  '</div>'+
								'</div>'+
							'</div>';
                    	});
                    	$("#itinerario").html(html);

                    },
                    error: function(result) {
                    }
                });
                $('#modal-datatable').modal('show');
				e.preventDefault();
			});
			$('td:eq(0) a', row).tooltip();
		},
	    orderable: false
	}).on( 'draw.dt', function () {
		if(table.page.info().recordsTotal<parseInt(nR)){
			$("#new-add").show("slow");
		}else{
			$("#new-add").hide("slow");
		}
	    // console.log( table.rows().count(),nV);
	});

	$("#new_itinerario").on("click",function(){
		$("#clon div:eq(0)").clone().appendTo("#itinerario");
	});
	$("#itinerario").delegate(".eliminar_itinerario","click",function(e){
      	$(this).parent().parent().parent().remove();
    });  	
	var validator = $("#formulary").validate({
        rules:{
            'origen':{
                required:true
            },
            'destino':{
                required:true
            },
            'frecuencia':{
                required:true
            },
            'itinerario[]':{
                required:true
            }          
        },
        messages:{
            'origen':{
                required:"Este campo es requerido."
            },
            'destino':{
                required:"Este campo es requerido."
            },
            'frecuencia':{
                required:"Este campo es requerido."
            },
            'itinerario[]':{
                required:"Este campo es requerido."
            } 
        }
    });

	$("#nuevo").on("click",function(){
    	editar = 0;
    	$("#title-datatable").text("Nueva Ruta");

    	$(".form-control").removeClass("is-valid");
		$(".form-control").removeClass("is-invalid");
    	$("#origen").val("");
    	$("#destino").val("");
    	$("#frecuencia").val("");

    	html = "";
    	$("#itinerario").html(html);

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
			        url: "/extranet/ruta/"+href,
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
			        url: "/extranet/ruta",
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