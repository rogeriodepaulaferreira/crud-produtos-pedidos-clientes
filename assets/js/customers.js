
function add(){
	var template = $('#template').html();
	var count = $('#adresses div').length;

	var address = template.replace(/\{n}/g, count);

	$('#adresses').append(address);
}

function remove(elemt){
	$(elemt).parent().parent().remove();
}
