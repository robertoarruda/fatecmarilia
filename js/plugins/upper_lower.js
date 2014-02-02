$(document).ready(function(){
	$('.upper').change(function(){
		$(this).val($(this).val().toUpperCase());
	});
	$('.lower').change(function(){
		$(this).val($(this).val().toLowerCase());
	});
});