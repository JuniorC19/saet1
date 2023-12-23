$(document).ready(function(){
	var href = 0;
	$("#resolucion").prop('disabled',true);

	$("#editar").on("change",function(){
		if ($('#editar').is(':checked')) {
			$("#resolucion").prop('disabled',false);
		}else{
			$("#resolucion").prop('disabled',true);

		}
	});
	var table = $('#table-data').DataTable({
		processing:true,
		serverSide:true,
		language: {
	        url:'/js/spanish.json'
	    },
		ajax:{
			url:'/extranet/empresa?datatable=true',
			data:function(d){
				d.tipo = $("#tipo").val();
			}
		},
		columns:[
			{data:'Botones',name:'Botones'},
			{data:'RowId',name:'RowId'},

			{
			data:'Nombre',
			name:'Nombre',
			render: function(data, type, row, meta){
	            if(type === 'display'){
	                data = '<a href="/extranet/empresa/vehiculo/'+row.RowId +'">'+data+'</a>';
	            }
	            return data;
	         }

			},

			{data:'Ruc',name:'Ruc'},
			{data:'Telefono',name:'Telefono'},
			{data:'ResolucionPrimaria',name:'ResolucionPrimaria'},
			{data:'NumeroRegistro',name:'NumeroRegistro'},
			{data:'NumeroElectronico',name:'NumeroElectronico'},
		],
	    rowCallback: function( row, data, index ) {
	    	var btn = '<a href="'+data.RowId+'" class="editar h5 text-dark col-xs-4" title="Editar"><i class="fas fa-pencil-alt"></i></a> ';
	    	 btn += '<a href="/extranet/empresa/ruta/'+data.RowId+'" class="rutas h5 text-dark col-xs-4" title="Rutas"><i class="fas fa-road"></i></a> ';
	    	 btn += '<a href="/extranet/empresa/vehiculo/'+data.RowId+'" class="vehiculos h5 text-dark col-xs-4" title="Vehiculos"><i class="fas fa-car"></i></a> ';
	    	 btn += '<a href="/extranet/empresa/terminal/'+data.RowId+'" class="otros h5 text-dark col-xs-4" title="Otros Datos"><i class="far fa-file-alt"></i></a> ';
	    	$('td:eq(0)', row).html(btn);

	    	$('td:eq(0)', row).delegate('.editar','click',function(e){ 
				href = $(this).attr('href');
				$.ajax({
                    type: "GET",
                    dataType: "json",
                    url:"/extranet/empresa/"+href+"/edit",
                    success: function(data) {
                    	$("#resolucion").prop('disabled',true);
                    	$("#editar").prop('checked',false);

                    	$(".form-control").removeClass("is-valid");
						$(".form-control").removeClass("is-invalid");

						$(".input-group").removeClass("is-valid");
						$(".input-group").removeClass("is-invalid");
                    	// console.log(data);
                    	$("#razon_social").val(data.data.razon_social);
	                    $("#ruc").val(data.data.ruc);
	                    $("#nombre_imprimir").val(data.data.nombre_imprimir);
	                    $("#telefono").val(data.data.telefono);
	                    $("#ficha_registro").val(data.data.ficha_registro);
	                    $("#partida_electronico").val(data.data.partida_electronico);
	                    $("#resolucion").val(data.data.resolucion);

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

	var validator = $("#formulary").validate({
        rules:{
            'razon_social':{
                required:true
            },
            'nombre_imprimir':{
                required:true
            }            
        },
        messages:{
            'razon_social':{
                required:"Este campo es requerido."
            },
            'nombre_imprimir':{
                required:"Este campo es requerido."
            }
        }
    });

	// $("#nuevo").on("click",function(){
 //    	editar = 0;
 //    	$("#title-datatable").text("Nuevo Categoria");
 //    	$("#nombre").val("");
	// 	$('#modal-datatable').modal('show');
	// });

    $("#guardar").on("click",function(){
    	var validar = validator.form();
    	if(validar == true){
    		data = $("#formulary").serialize();
    		// load.open();
    		$('.page-wrapper').loader('show');
		    $.ajax({
		        type: "PUT",
		        dataType: "json",
		        url: "/extranet/empresa/"+href,
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
    	}
    })

    $("#tipo").on("change",function(){
    	table.draw();
    });
});