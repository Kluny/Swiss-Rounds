<?php

//we only allow 1-5 points in polo. But this could be determined by tournament settings.
//$scoreOptions = [0,1,2,3,4,5];
$scoreOptions = range(0, $tournament->max_score);

//get an array of teams and ids that can be selected if there's uneven teams.
$teams = $tournament->toArray()['teams'];
$teamOptions = array_column($teams, 'name', 'id');

foreach($matches as $i => $match) {
    $team1 = $match[0];
	$team2 = '';

	$team2input = $this->Form->input('teams.2.id', ['label' => 'Choose team', 'type' => 'select', 'options' => $teamOptions]);

	if(isset($match[1])) {
		$team2 = $match[1];
        $team2input = $this->Form->input('teams.2.id', ['type' => 'hidden', 'value' => $team2['id']]);
    }

    echo $this->Form->create('Match', ['class' => 'ajax-submit new-match',
                                        'url' => [ 'controller' => 'matches',
                                                    'action' => 'ajax-save-match',
                                                    $tournament['id']
                                        ]]
                            );

//keep the cancel button far away from the save button.
echo $this->Html->link('Cancel Match', ['#'], ['class' => 'cancel', 'style' => 'float:right;']);


//hidden values for associating teams and rounds
    echo $this->Form->input('round_id', ['type' => 'hidden', 'value' => $round->id]);
    echo $this->Form->input('teams.1.id', ['type' => 'hidden', 'value' => $team1['id']]);

//join data
	echo $this->Form->input('teams.1._joinData.points_scored', ['type' => 'select', 'options' => $scoreOptions, 'label' => $team1['name']]); ?>
<span class="vs">VS</span>
<?php
//optional input if the number of teams is uneven
//it's also possible to make all the teams selectable, in case the tournament runner wants more flexibility.
	echo $team2input;

//join data
	echo $this->Form->input('teams.2._joinData.points_scored', ['type' => 'select', 'options' => $scoreOptions, 'label' => isset($team2['name']) ? $team2['name'] : '']);
	echo $this->Form->button('Save Match', ['class' => 'ajax_submit']);

	echo $this->Form->end(); ?>

<? } ?>
<div class="clear"></div>

<?php echo $this->Match->addMatch($tournament['id'], $round->id); ?>

<?php echo $this->Html->link("Finish Round", ['controller' => 'rounds', 'action' => 'finish-round', $round->id], ['class' => 'finish']); ?>
