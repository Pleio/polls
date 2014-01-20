<?php
elgg_load_library('elgg:polls');

$poll = elgg_extract('entity', $vars);

if ($msg = elgg_extract('msg', $vars)) {
	echo '<div>' . $msg . '</div>';
}

$results_display = "";
$voted_text = "";
$show_text = elgg_echo('polls:show_poll');
if (elgg_is_logged_in()) {
	$can_vote = !polls_check_for_previous_vote($poll, elgg_get_logged_in_user_guid());
	
	//if user has voted, show the results
	if (!$can_vote) {
		$voted_text = elgg_echo("polls:voted");
	} else {
		$results_display = "hidden";
		$show_text = elgg_echo('polls:show_results');
		
		// is the poll closed
		if (isset($poll->close_date) && $poll->close_date < time()) {
			$can_vote = false;
			$results_display = "";
			$voted_text = elgg_echo("polls:vote_ended", array(elgg_view("output/date", array("value" => $poll->close_date))));
		}
	}
} else {
	$voted_text = elgg_echo('polls:login');
	$can_vote = false;
}


echo "<div id='poll-post-body-" . $poll->getGUID() ."' class='poll_post_body " . $results_display . "'>";
echo elgg_view('polls/results_for_widget', array('entity' => $poll));
if (!$can_vote && !empty($voted_text)) {
	echo "<div>" . $voted_text . "</div>";
}
echo "</div>";

if ($can_vote) {
	echo elgg_view_form('polls/vote', array('id' => 'poll-vote-form-' . $poll->getGUID()), array('entity' => $poll, 'callback' => 1));
	
	echo "<div class='center'>";
	echo elgg_view("output/url", array("href" => "#poll-post-body-" . $poll->getGUID(), "text" => $show_text, "rel" => "toggle", "class" => "poll-show-link"));
	echo "</div>";
}
