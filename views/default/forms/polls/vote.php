<?php

$poll = elgg_extract("entity", $vars);

if (empty($poll) || !elgg_instanceof($poll, "object", "poll")) {
	return true;
}

//convert $responses to radio inputs for form display
$responses = polls_get_choice_array($poll);

echo "<div>";
echo elgg_view('input/radio', array('name' => 'response', 'options' => $responses));
echo "</div>";

echo "<div class='elgg-foot'>";
echo elgg_view('input/submit', array('rel' => $poll->guid, 'class' => 'elgg-button-submit poll-vote-button', 'name' => 'submit_vote', 'value' => elgg_echo('polls:vote')));
echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $poll->guid));
echo elgg_view('input/hidden', array('name' => 'callback', 'value' => $vars['callback']));
echo "</div>";
