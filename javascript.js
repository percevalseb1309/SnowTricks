<script src="{{ asset('js/jquery.collection.js') }}"></script>

	<script type="text/javascript">
	    $('.pictures-collection').collection({
	    	position_field_selector: '.my-position',
	    	allow_duplicate: true
        });
	</script>	

	<script type="text/javascript">
		// setup an "add a tag" link
		/*var $addTagLink = $('<a href="#" class="add_tag_link">Add a tag</a>');
		var $newLinkLi = $('<li></li>').append($addTagLink);

		jQuery(document).ready(function() {
		    // Get the ul that holds the collection of tags
		   var $collectionHolder = $('ul.tags');
		    
		    // add the "add a tag" anchor and li to the tags ul
		    $collectionHolder.append($newLinkLi);
		    
		    // count the current form inputs we have (e.g. 2), use that as the new
		    // index when inserting a new item (e.g. 2)
		    $collectionHolder.data('index', $collectionHolder.find(':input').length);
		    
		    $addTagLink.on('click', function(e) {
		        // prevent the link from creating a "#" on the URL
		        e.preventDefault();
		        
		        // add a new tag form (see code block below)
		        addTagForm($collectionHolder, $newLinkLi);
		    });
		    
		    
		});

		function addTagForm($collectionHolder, $newLinkLi) {
		    // Get the data-prototype explained earlier
		    var prototype = $collectionHolder.data('prototype');
		    
		    // get the new index
		    var index = $collectionHolder.data('index');
		    
		    // Replace '$$name$$' in the prototype's HTML to
		    // instead be a number based on how many items we have
		    var newForm = prototype.replace(/__name__/g, index);
		    
		    // increase the index with one for the next item
		    $collectionHolder.data('index', index + 1);
		    
		    // Display the form in the page in an li, before the "Add a tag" link li
		    var $newFormLi = $('<li></li>').append(newForm);
		    
		    // also add a remove button, just for this example
		    $newFormLi.append('<a href="#" class="remove-tag">x</a>');
		    
		    $newLinkLi.before($newFormLi);
		    
		    // handle the removal, just for this example
		    $('.remove-tag').click(function(e) {
		        e.preventDefault();
		        
		        $(this).parent().remove();
		        
		        return false;
		    });
		}*/
		
	  	/*$(document).ready(function() {
	    	// On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
	    	var $container = $('div#snowtricksbundle_trick_pictures');

	    	// On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
	    	var index = $container.find(':input').length;

	    	// On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
	    	$('#add_picture').click(function(e) {
	      		addPicture($container);

	      		e.preventDefault(); // évite qu'un # apparaisse dans l'URL
	      		return false;
	    	});

	    	// On ajoute un premier champ automatiquement s'il n'en existe pas déjà un (cas d'une nouvelle annonce par exemple).
	    	if (index == 0) {
	      		addPicture($container);
	    	} else {
	      		// S'il existe déjà des images, on ajoute un lien de suppression pour chacune d'entre elles
	      		$container.children('div').each(function() {
	        	addDeleteLink($(this));
	      		});
	    	}

	    	// La fonction qui ajoute un formulaire PictureType
	    	function addPicture($container) {
		      	// Dans le contenu de l'attribut « data-prototype », on remplace :
		      	// - le texte "__name__label__" qu'il contient par le label du champ
		      	// - le texte "__name__" qu'il contient par le numéro du champ
		      	var template = $container.attr('data-prototype')
		        	.replace(/__name__label__/g, 'Picture n°' + (index+1))
		        	.replace(/__name__/g,        index);

		      	// On crée un objet jquery qui contient ce template
		      	var $prototype = $(template);

		      	// On ajoute au prototype un lien pour pouvoir supprimer l'image
		      	addDeleteLink($prototype);

		      	// On ajoute le prototype modifié à la fin de la balise <div>
		      	$container.append($prototype);

		      	// Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
		      	index++;
	    	}

	    	// La fonction qui ajoute un lien de suppression d'une image
	    	function addDeleteLink($prototype) {
	      		// Création du lien
	      		var $deleteLink = $('<a href="#" class="btn btn-danger">Delete</a>');

	      		// Ajout du lien
	      		$prototype.append($deleteLink);

	      		// Ajout du listener sur le clic du lien pour effectivement supprimer l'image'
	      		$deleteLink.click(function(e) {
	        	$prototype.remove();

	        	e.preventDefault(); // évite qu'un # apparaisse dans l'URL
	        		return false;
	      		});
	    	}
	  	});*/
	</script>