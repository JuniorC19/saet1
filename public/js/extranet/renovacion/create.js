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


	var validator = $("#formulary").validate({
        rules:{
        	'tipo':{
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
            },
            'fecha_ini':{
                required:true
            },
            'fecha_fin':{
                required:true
            }       
        },
        messages:{
        	'tipo':{
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
            },
            'fecha_ini':{
                required:"Este campo es requerido."
            },
            'fecha_fin':{
                required:"Este campo es requerido."
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
      //       $('.page-wrapper').loader('show');
    		// data = $("#formulary").serialize()+"&empresa="+ide+"&autorizacion="+ida;
      //       $.ajax({
      //           type: "GET",
      //           dataType: "json",
      //           url: "/extranet/renovacion/modificacion",
      //           data:data,
      //           success:function(data){
      //               $('.page-wrapper').loader('hide');

      //               if(data.status == true){
      //                   // table.draw();
      //                   $.confirm({
      //                       title: 'Satisfactorio',
      //                       content: data['message'],
      //                       type: 'green',
      //                       theme: 'modern',
      //                       // closeIcon: true,
      //                       icon: 'fas fa-check',
      //                       buttons: {
      //                         confirm: {
      //                             text:"Aceptar",
      //                             btnClass: 'btn-green',
      //                             action: function(){
      //                               $(location).attr('href',"/extranet/renovacion");
      //                             }
      //                         }
      //                       }
      //                   });

      //               }else{
      //                   $.confirm({
      //                       title: 'Error!',
      //                       content: data['message'],
      //                       type: 'orange',
      //                       theme: 'modern',
      //                       closeIcon: true,
      //                       icon: 'fas fa-exclamation-triangle',
      //                       buttons: {
      //                         confirm: {
      //                             text:"Intentar de nuevo",
      //                             btnClass: 'btn-green',
      //                             action: function(){
      //                             }
      //                         },
      //                         cancel:{
      //                             text:"Salir",
      //                             action:function(){
                                     
      //                             }
      //                         }
      //                       }
      //                   });
      //               }
      //               // table.draw();
      //               // $('#modal-proveedor').modal('hide');
      //           },
      //           error:function(result){

      //           }
      //       });
    	}
        else{
            validator.focusInvalid();
        }
    });

});