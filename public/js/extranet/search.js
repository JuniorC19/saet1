$(document).ready(function(){
	var href = 0;
	var editar =0;

	var table_vehiculo = $('#table-data-vehiculo').DataTable({
		processing:true,
		serverSide:true,
		lengthMenu: [ 5, 10, 25, 50, 100 ],
		language: {
	        url:'/js/spanish.json'
	    },
		ajax:{
			url:'/extranet/search?vehiculo=true',
			data: function (d) {
	            d.search = search;
	        }
		},
		columns:[
			{data:'Botones',name:'Botones'},
			{data:'Placa',name:'Placa'},
			{data:'Marca',name:'Marca'},
			{data:'Categoria',name:'Categoria'},
			{data:'Fabricacion',name:'Fabricacion'},
		],
	    rowCallback: function( row, data, index ) {
	    	var btn = '<a href="'+data.RowId+'" class="historial h5 text-dark float-right ml-1" title="Historial"><i class="fas fa-list-ul"></i></a>';
	    	$('td:eq(0)', row).delegate('.historial','click',function(e){
				href = $(this).attr('href');
				$.ajax({
                    type: "GET",
                    dataType: "json",
                    url:"/extranet/vehiculo/historial/"+href,
                    success: function(data) {
                    	var html = "";
                    	$.each(data.historial,function(i,val){
                    		 
                			html +="<tr>"+
				                "<td>"+(i+1)+"</td>"+
				                "<td>"+val.Ruc+"</td>"+
				                "<td>"+val.RazonSocial+"</td>"+
				                "<td>"+val.Resolucion+"</td>"+
				                "<td>"+val.Comentario+"</td>"+
				                "<td>"+val.FechaIni+"</td>"+
				                "<td>"+val.FechaFin+"</td>"+
				                "<td>"+val.Estado+"</td>"+
				              "</tr>";
                    	});
                    	$("#historial").html(html);
                    },
                    error: function(result) {
                    }
                });
                $('#modal-datatable-historial').modal('show');
				e.preventDefault();
			}); 
	    	$('td:eq(0)', row).html(btn);

			$('td:eq(0) a', row).tooltip();
		},
	    order: [[ 1, 'desc' ]]
	});

	var table_ruta = $('#table-data-ruta').DataTable({
		processing:true,
		serverSide:true,
		lengthMenu: [ 5, 10, 25, 50, 100 ],
		language: {
	        url:'/js/spanish.json'
	    },
		ajax:{
			url:'/extranet/search?ruta=true',
			data: function (d) {
	            d.search = search;
	            d.estado = $("#estado").val();
	        }
		},
		columns:[
			// {data:'Botones',name:'Botones'},
			{data:'Ruc',name:'Ruc'},
			{data:'Empresa',name:'Empresa'},
			{data:'Resolucion',name:'Resolucion'},
			// {data:'Comentario',name:'Comentario'},
			{data:'Origen',name:'Origen'},
			{data:'Destino',name:'Destino'},
			{data:'Frecuencia',name:'Frecuencia'},
			{data:'Itinerario',name:'Itinerario'},
			{data:'Estado',name:'Estado'},
		],
	    rowCallback: function( row, data, index ) {
	    	// var btn = '<a href="'+data.RowId+'" class="editar h5 text-dark col-xs-4" title="Editar"><i class="fas fa-pencil-alt"></i></a> ';
	    	 
	    	// $('td:eq(0)', row).html(btn);

			$('td:eq(0) a', row).tooltip();
		},
	    order: [[ 1, 'desc' ]]
	});



    $("#estado").on("change",function(){
		table_ruta.draw();
    });
});