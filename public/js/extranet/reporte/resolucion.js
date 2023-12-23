$(document).ready(function(){
	var href = 0;
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
       table.draw();

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
    $("#autorizacion").on("change",function(){
    	table.draw();
    });

    $("#imprimir").on("click",function(){
    	$.print("#table-data");
    });
	var table = $('#table-data').DataTable({
		processing:true,
		serverSide:true,
		language: {
	        url:'/js/spanish.json'
	    },
		ajax:{
			url:'/extranet/reporte/resolucion?datatable=true',
			data: function (d) {
	            // d.autorizacion = ida;
	            d.empresa = $("#empresa").val();
	            d.autorizacion = $("#autorizacion").val();
	        }
		},
		columns:[
			{data:'Empresa',name:'Empresa'},
			{data:'Resolucion',name:'Resolucion'},
			{data:'Tipo',name:'Tipo'},
			{data:'FechaIni',name:'FechaIni'},
			// {data:'Estado',name:'Estado'},
		],
	    rowCallback: function( row, data, index ) {
	  
		},
	    // order: [[ 1, 'desc' ]]
	    lengthMenu: [[-1], ["Todo"]],
	    ordering: false
	});

	$("#estado,#empresa").on("change",function(){
		table.draw();
	});
});