$(function(){

	console.log('Initialising tooltips!');
	$('.simple-tippy-tooltip').each(function(){
		tippy(this, {
			interactive: true,
			allowHTML: true,
			content: $(this).data('tippy-content')
		});
	});

});
