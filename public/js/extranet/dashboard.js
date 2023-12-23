$(document).ready(function(){
	$('#fecha_semana').datepicker({
         autoclose: true,
         todayHighlight: true,
         format: 'yyyy-mm-dd'
    })

	
	var fecha_s = $("#fecha_semana").val();
	var usuario = $("#usuario").val();
	semana(fecha_s+"|"+usuario);
	$("#enviarSemana").on("click",function(){
		fecha_s = $("#fecha_semana").val();
		usuario = $("#usuario").val();
		semana(fecha_s+"|"+usuario);
		
	});

	
});

function semana(fecha){
	$.ajax({
        type: "GET",
        dataType: "json",
        url:"/extranet/semana/"+fecha,
        // data:data,
        success:function(data){
        	console.log(data);
        	// $(".totalDia").text(data.data);
        	$.each(data.datos,function(i,val){
        		$(".total_"+i).text(val);
        		$(".f_"+i).text(data.fechas[i]);
        	});

        	$(".totalSemana").text(data.total);
        },
        error:function(result){

        }

      });
}
