$(document).ready(function(){
	var editar = 0;
	var href = 0;
	var table = $('#table-data').DataTable({
		processing:true,
		serverSide:true,
		language: {
	        url:'/js/spanish.json'
	    },
		ajax:{
			url:'/extranet/configuracion/carroceria?datatable=true'
		},
		columns:[
			{data:'Botones',name:'Botones'},
			{data:'RowId',name:'RowId'},
			{data:'Nombre',name:'Nombre'},
			{data:'Categoria',name:'Categoria'},
		],
	    rowCallback: function( row, data, index ) {
	    	$('td:eq(0)', row).html('<a href="'+data.RowId+'" class="editar btn btn-dark btn-sm col-xs-4"><i class="fa fa fa-pencil-square-o" aria-hidden="true"></i>Editar</a>');
	    	$('td:eq(0)', row).delegate('.editar','click',function(e){ 
				href = $(this).attr('href');
				editar = 1;
				// alert(href);
				$("#title-datatable").text("Editar Carroceria");
				$.ajax({
                    type: "GET",
                    dataType: "json",
                    url:"/extranet/configuracion/carroceria/"+href+"/edit",
                    success: function(data) {
                       $("#nombre").val(data.data.nombre);
                       $("#categoria").val(data.data.id_categoria);
                    },
                    error: function(result) {
                    }
                });
                $('#modal-datatable').modal('show');
				e.preventDefault();
			});

		},
	    order: [[ 1, 'asc' ]]
	});

	var validator = $("#formulary").validate({
        rules:{
            'nombre':{
                required:true
            },
            'categoria':{
                required:true
            }           
        },
        messages:{
            'nombre':{
                required:"Este campo es requerido."
            },
            'categoria':{
                required:"Este campo es requerido."
            }
        }
    });

	$("#nuevo").on("click",function(){
    	editar = 0;
    	$("#title-datatable").text("Nueva Carroceria");
    	$("#nombre").val("");
    	$("#categoria").val("");
		$('#modal-datatable').modal('show');
	});

    $("#guardar").on("click",function(){
    	var validar = validator.form();
    	if(validar == true){
    		data = $("#formulary").serialize();
    		// load.open();
    		$('.page-wrapper').loader('show');
    		if(editar==1){
			    $.ajax({
			        type: "PUT",
			        dataType: "json",
			        url: "/extranet/configuracion/carroceria/"+href,
			        data:data,
			        success:function(data){
			          // console.log(data);
			          // load.close();
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
								      text:"OK",
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
			        url: "/extranet/configuracion/carroceria",
			        data:data,
			        success:function(data){
			          // console.log(data);
			          // load.close();
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
								      text:"OK",
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
    	}
    })

    // $("#tipo_f").on("change",function(){
    // 	table.draw();
    // })
});