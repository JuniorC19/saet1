$(document).ready(function(){

    $("#empresa").select2({
        allowClear: true,
        theme: 'bootstrap4',
        language: "es",
        placeholder: "Seleccione un empresa",
        ajax: {
            url:"/extranet/select2/empresa",
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
        $('.page-wrapper').loader('show');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "/extranet/select/autorizacion/"+e.params.data.id,
            success:function(data){
                console.log(data);
                var html = "<option value=''>--Seleccionar--</option>";
                $.each(data.data,function(i,val){
                    html+="<option value='"+val.id+"'>"+val.numero+" -|- "+val.Tipo+"</option>";
                });
                $("#autorizacion").html(html);
                $('.page-wrapper').loader('hide');
            },
            error:function(result){
                $('.page-wrapper').loader('hide');

            }
        });
    });

	var validator = $("#formulary").validate({
        // ignore: [],
        rules:{
            'empresa':{
                required:true
            },
            'autorizacion':{
                required:true
            }       
        },
        messages:{
            'empresa':{
                required:"Este campo es requerido."
            },
            'autorizacion':{
                required:"Este campo es requerido."
            }
        }
    });


    $("#guardar").on("click",function(){
    	var validar = validator.form();
    	if(validar == true){
            // $('.page-wrapper').loader('show');
    		// id = $("#empresa").val();
    		// $(location).attr('href', '/extranet/modificacion/vehiculos/baja/empresa/'+id);
    	}
        else{
            validator.focusInvalid();
        }
    });

});