$("#arrow-up").click(function(){
	let inp=$("#age_input").val()
	$("#age_input").val(+inp+1)
})

$("#arrow-down").click(function(){
	let inp=$("#age_input").val()
	if(inp>1){
		$("#age_input").val(+inp-1)
	}
})

$("#menu").click(function(e){
	e.stopPropagation()
	$("#hidden-menu").toggleClass('hiddenMenu');
})

$("#hidden-menu").click(function(e){
	e.stopPropagation();
})

$('body').click(function(){
	$("#hidden-menu").addClass('hiddenMenu');
})