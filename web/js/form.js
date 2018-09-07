$('.pictures-collection').collection({
	min: 0,
    max: 4,
	// add: '<a href="#" class="collection-add btn btn-default" title="Add picture"><span class="glyphicon glyphicon-plus-sign"></span></a>',
	add: '<a href="#" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign"></span> Add picture</a>',
    // position_field_selector: '.my-position',
    allow_duplicate: false,
    add_at_the_end: true,
});	    

$('.videos-collection').collection({
	min: 0,
    max: 4,
	add: '<a href="#" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign"></span> Add video</a>',
    allow_duplicate: false,
    add_at_the_end: true,
});