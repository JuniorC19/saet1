$(document).ready(function(){
	var editar = 0;
	var href = 0;
	$("#edit_pass").on("click",function(){
		if ($("#edit_pass").is(':checked')) {
			$("#password").prop('disabled', false);
		}else{
			$("#password").prop('disabled', true);
		}
	});
	var table = $('#table-data').DataTable({
		processing:true,
		serverSide:true,
		language: {
	        url:'/js/spanish.json'
	    },
		ajax:{
			url:'/extranet/usuario?datatable=true'
		},
		columns:[
			{data:'Botones',name:'Botones'},
			{data:'RowId',name:'RowId'},
			{data:'Name',name:'Name'},
			{data:'Email',name:'Email'},
			{data:'Rol',name:'Rol'},
		],
	    rowCallback: function( row, data, index ) {
	    	$('td:eq(0)', row).html('<a href="'+data.RowId+'" class="editar btn btn-dark btn-sm col-xs-4"><i class="fa fa fa-pencil-square-o" aria-hidden="true"></i>Editar</a>');
	    	$('td:eq(0)', row).delegate('.editar','click',function(e){ 
				href = $(this).attr('href');
				editar = 1;
				$("#edit_pass").removeClass("hidden_checkbox");
				$("#password").prop('disabled', true);
				$("#password").val('');
				$("#edit_pass").prop('checked', false);
				// alert(href);
				$("#title-datatable").text("Editar Usuario");
				$.ajax({
                    type: "GET",
                    dataType: "json",
                    url:"/extranet/usuario/"+href+"/edit",
                    success: function(data) {
                       $("#nombre").val(data.data.name);
				    	$("#user").val(data.data.email);
				    	$("#password").val("");
				    	$("#rol").val(data.data.role_id);
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
            'user':{
                required:true
            },
            'password':{
                required:true,
                minlength:6
            },
            'rol':{
                required:true
            }
        },
        messages:{
            'nombre':{
                required:"Este campo es requerido."
            }, 
            'user':{
                required:"Este campo es requerido."
            },
            'password':{
                required:"Este campo es requerido.",
                minlength:'Minimo como 6 caracteres.'
            },
            'rol':{
                required:"Este campo es requerido."
            }
        }
    });

	$("#nuevo").on("click",function(){
    	$("#edit_pass").addClass("hidden_checkbox");
		$("#edit_pass").prop('checked', false);
		$("#password").prop('disabled', false);
    	editar = 0;
    	$("#title-datatable").text("Nuevo Usuario");
    	$("#nombre").val("");
    	$("#user").val("");
    	$("#password").val("");
    	$("#rol").val(1);
		$('#modal-datatable').modal('show');
	});

    $("#guardar").on("click",function(){
    	var validar = validator.form();
    	if(validar == true){
    		data = $("#formulary").serialize();
    		$('.page-wrapper').loader('show');
    		if(editar==1){
			    $.ajax({
			        type: "PUT",
			        dataType: "json",
			        url: "/extranet/usuario/"+href,
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
								icon: 'fa fa-check',
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
								icon: 'fa fa-warning',
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
			        url: "/extranet/usuario",
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
								icon: 'fa fa-check',
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
								icon: 'fa fa-warning',
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