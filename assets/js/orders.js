
function add(){
	var template = $('#template').html();
	var count = $('#orders_itens div').length;

	var orders_itens = template.replace(/\{n}/g, count);

	$('#orders_itens').append(orders_itens);
}

function remove(elemt){
	$(elemt).parent().parent().remove();
}
