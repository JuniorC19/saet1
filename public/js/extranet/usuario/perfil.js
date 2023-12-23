$(document).ready(function(){
	$("#edit_pass").on("click",function(){
		if ($("#edit_pass").is(':checked')) {
			$("#password").prop('disabled', false);
		}else{
			$("#password").prop('disabled', true);
		}
	});
	var validator = $("#formulary").validate({
        rules:{
            'nombre':{
                required:true
            },
            'password':{
                required:true,
                minlength:6
            }
        },
        messages:{
            'nombre':{
                required:"Este campo es requerido."
            }, 
            'password':{
                required:"Este campo es requerido.",
                minlength:'Minimo como 6 caracteres.'
            }
        }
    });


    $("#guardar").on("click",function(){
    	var validar = validator.form();
    	if(validar == true){
    		data = $("#formulary").serialize();
    		// load.open();
    		$('.page-wrapper').loader('show');
			$.ajax({
		        type: "PUT",
		        dataType: "json",
		        url: "/extranet/usuario/save/perfil",
		        data:data,
		        success:function(data){
		          // console.log(data);
		          	$('.page-wrapper').loader('hide');
		          	if(data.status == true){
			              // var objeto = JSON.parse(data['message']);
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
							      	location.reload();
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
		        },
		        error:function(result){

		        }
		    });
    	}
    })

    // $("#tipo_f").on("change",function(){
    // 	table.draw();
    // })
});