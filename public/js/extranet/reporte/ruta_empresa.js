$(document).ready(function(){
	var href = 0;
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
			url:'/extranet/reporte/ruta/empresa?datatable=true',
			data: function (d) {
	            d.autorizacion = ida;
	            d.estado = $("#estado").val();
	        }
		},
		columns:[
			// {data:'Botones',name:'Botones'},
			{data:'Origen',name:'Origen'},
			{data:'Destino',name:'Destino'},
			{data:'Frecuencia',name:'Frecuencia'},
			{data:'Itinerario',name:'Itinerario'},
			{data:'Resolucion',name:'Resolucion'},
			{data:'FechaIni',name:'FechaIni'},
			{data:'Comentario',name:'Comentario'},
			{data:'Estado',name:'Estado'},
		],
	    rowCallback: function( row, data, index ) {
	  //   	var btn = '<a href="'+data.RowId+'" class="editar h5 text-dark col-xs-4" title="Editar"><i class="fas fa-pencil-alt"></i></a> ';
	  //   	 btn += '<a href="/extranet/empresa/ruta/'+data.RowId+'" class="rutas h5 text-dark col-xs-4" title="Rutas"><i class="fas fa-road"></i></a> ';
	  //   	 btn += '<a href="/extranet/empresa/vehiculo/'+data.RowId+'" class="vehiculos h5 text-dark col-xs-4" title="Vehiculos"><i class="fas fa-car"></i></a> ';
	  //   	 btn += '<a href="/extranet/empresa/terminal/'+data.RowId+'" class="otros h5 text-dark col-xs-4" title="Otros Datos"><i class="far fa-file-alt"></i></a> ';
	  //   	$('td:eq(0)', row).html(btn);

	  //   	$('td:eq(0)', row).delegate('.editar','click',function(e){ 
			// 	href = $(this).attr('href');
			// 	$.ajax({
   //                  type: "GET",
   //                  dataType: "json",
   //                  url:"/extranet/empresa/"+href+"/edit",
   //                  success: function(data) {
   //                  	$(".form-control").removeClass("is-valid");
			// 			$(".form-control").removeClass("is-invalid");

			// 			$(".input-group").removeClass("is-valid");
			// 			$(".input-group").removeClass("is-invalid");
   //                  	$("#razon_social").val(data.data.razon_social);
	  //                   $("#ruc").val(data.data.ruc);
	  //                   $("#nombre_imprimir").val(data.data.nombre_imprimir);
	  //                   $("#telefono").val(data.data.telefono);
	  //                   $("#ficha_registro").val(data.data.ficha_registro);
	  //                   $("#partida_electronico").val(data.data.partida_electronico);

   //                  },
   //                  error: function(result) {
   //                  }
   //              });
   //              $('#modal-datatable').modal('show');
			// 	e.preventDefault();
			// });
			// $('td:eq(0) a', row).tooltip();
		},
	    // order: [[ 1, 'desc' ]]
	    lengthMenu: [[-1], ["Todo"]],
	    ordering: false
	});

	$("#estado").on("change",function(){
		table.draw();
	});
});