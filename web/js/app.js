$(document).ready(function(){
	$(".upload_photo").click(function(e) {
		e.preventDefault();
		$("#upload_photo").click();
	})

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
	})
});
