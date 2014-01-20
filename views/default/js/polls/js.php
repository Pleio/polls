<?php ?>
//<script>
elgg.provide('elgg.polls');

elgg.polls.init = function() {
	$('.poll-show-link').live('click', elgg.polls.toggleResults);
	$('.poll-vote-button').live('click', function(e) {
		e.preventDefault();
		var guid = $(this).attr("rel");
		// prevent multiple clicks
		$(this).attr("disabled", "disabled");
		// submit the vote and display the response when it arrives
	    elgg.action('action/polls/vote', {data: $('#poll-vote-form-'+guid).serialize(),
			success : function(response) {
			        	$('#poll-container-'+guid).html(response.result);
			        }
	        });
    });
};

elgg.polls.toggleResults = function() {
	// toggle form
	$(this).parent().siblings("form.elgg-form-polls-vote").slideToggle();

	var text = $(this).html();

	if (text == elgg.echo("polls:show_poll")) {
		$(this).html(elgg.echo("polls:show_results"));
	} else {
		$(this).html(elgg.echo("polls:show_poll"));
	}
}

elgg.register_hook_handler('init', 'system', elgg.polls.init);
