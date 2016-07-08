$(document).ready(function(){
	$(".upload_photo").click(function(e) {
		e.preventDefault();
		$("#upload_photo").click();
	});

	$(".menu_lateral li a.sub_menu").on("click", function (e) {
		e.preventDefault();
		var _a  = $(this);
		var _li = _a.parent();

		_a.toggleClass("active");
		$("ul", _li).stop(true).slideToggle();
	});

	$(document).on('click', '.popup .close_popup', function (e) {
		e.preventDefault();
		$(this).parent().parent().hide();
	});

	$(document).on('click', '.open_popup_foros_asuntos', function (e) {
		e.preventDefault();
		$('.popup_foro_asuntos_publicos').show();
	});

	$(document).on('click', '.popup_realizar_reporte', function (e) {
		e.preventDefault();
		$('.realizar_reporte').show();
	});

	$(document).on('click', '.popup_mi_busqueda .popup_close', function (e) {
		e.preventDefault();
		$(this).parent().parent().hide();
	});

	$(document).on('click', '.box_content_option .btn_votation_item', function (e) {
	    e.preventDefault();
	    var obj = $(this);
	    var div = obj.parent();
	    console.log(div.data("id"));
	    if(!obj.hasClass("active")){
		var apply = false;

		$(".col_right_options .box_votation_small").each(function(){
		    var _div = $(this);
		    if(apply == false){
			if(_div.attr("data-option") == ""){
			    apply = true;
			    _div.addClass("active");
			    _div.attr("data-option", div.data("id"));
			    
			    $(".box_votacion_content", _div).html(div.data("title"));
			    
			    $("#input_votation_"+ _div.data("id")).val(div.data("id"));
			    
			    $.ajax({
				url:  'votacioninterna',
				type: 'GET',
				async: true,
				data: {id:div.data("id")},
				success: function(data){
				    
				}
			    });
			}
		    }
		});

		if(apply){
		    obj.addClass("active");
		}else{
		    alert("Solo se pueden agregar 3 opciones.");
		}
	    }
	});

	$(document).on('click', '.col_right_options .box_votation_small .icon_delete_box', function (e) {
		e.preventDefault();
		var obj = $(this);
		var div = obj.parent();
		
		if(div.hasClass("active")){
			div.removeClass("active");
			
			$(".col_left_options .box_content_option").each(function(){
				var _div = $(this);

				if(_div.attr("data-id") == div.attr("data-option")){
					var id=div.attr("data-option");// console.log(div.attr("data-option"));
					div.attr("data-option", "")
					console.log(div.attr("data-option"));
					$(".btn_votation_item", _div).removeClass("active");

					$("#input_votation_"+ div.attr("data-id")).val("");
					
					$.ajax({
					    url:  'votacioninternaeliminar',
					    type: 'GET',
					    async: true,
					    data: {id:id},
					    success: function(data){
						
					    }
					});
				}
			});
		}
	});

	$(document).on('click', '.btn-send-votation', function (e) {
		e.preventDefault();
		var o = $(this);
		var d = o.parent();
		
		var numOptions = 0;
		
		$(".input_votation_option").each(function(){
			var obj = $(this);
			if(obj.val() != "") numOptions++;
		});
		
		if(numOptions == 3){
			d.addClass("form_send");
			o.hide();
			
			$.ajax({
			    url: 'finalizarvotacioninterna',
			    type: 'GET',
			    async: true,
			    success: function(data){
				if (data==1) {
				    $.notify({
					// options
					message: 'Ha finalizado el proceso de votación interna' 
				    },{
					// settings
					type: 'success',
					z_index: 1000000,
					placement: {
						from: 'bottom',
						align: 'right'
					},
				    });
				    setTimeout(function(){
					    window.location.reload(1);
					}, 2000);
				}
			    }
			});
		}else{
		    $.notify({
			// options
			message: 'Debes votar por 3 proyectos' 
		    },{
			// settings
			type: 'danger',
			z_index: 1000000,
			placement: {
				from: 'bottom',
				align: 'right'
			},
		    });
			//alert("Se deben seleccionar 3 opciones para culminar la votación.");
		}
	});
});
