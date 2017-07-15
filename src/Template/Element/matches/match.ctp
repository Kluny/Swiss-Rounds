<?php if(isset($match)) { ?>
		<div class="finished-match">
	<?php echo $this->Html->link('Edit', ['controller' => 'matches', 'action' => 'edit', $match->id], ['class' => 'edit-match']); ?>
	<?php if(count($match->teams) == 2) { ?>
				<?php echo $match->teams[0]['name'] . ": " . $match->teams[0]['_joinData']['points_scored']; ?>
				<br>
				<?php echo $match->teams[1]['name'] . ": " . $match->teams[1]['_joinData']['points_scored']; ?>
				<br>

				<strong><?php echo $this->Match->prettyPrintWinnerWinner($match); ?></strong>
		<?php } else { ?>
			<strong><?php echo $this->Match->prettyPrintWinnerWinner($match); ?> </strong>
		<?php debug("Match id: " . $match->id);
		} ?>
		</div>
<?php } else {
//we only allow 1-5 points in polo. But this could be determined by tournament settings.


//$scoreOptions = [0,1,2,3,4,5];
$scoreOptions = range(0, $tournament->max_score);

//get an array of teams and ids that can be selected if there's uneven teams.
$teams = $tournament->toArray()['teams'];
$teamOptions = array_column($teams, 'name', 'id');


    echo $this->Form->create('Matches', ['class' => 'ajax-submit new-match',
                                        'url' => [ 'controller' => 'matches',
											'action' => 'ajax-save-match',
											$tournament['id']
                                        ]]
									);

//keep the cancel button far away from the save button.
	echo $this->Html->link('Cancel Match', ['#'], ['class' => 'cancel', 'style' => 'float:right;']);


//hidden values for associating teams and rounds
    echo $this->Form->input('round_id', ['type' => 'hidden', 'value' => $round->id]);
    echo  $this->Form->input('teams.1.id', ['label' => 'Choose team', 'type' => 'select', 'options' => $teamOptions]);;

//join data
	echo $this->Form->input('teams.1._joinData.points_scored', ['type' => 'select', 'options' => $scoreOptions, 'label' => 'Team 1']); ?>
<span class="vs">VS</span>
<?php
	echo $this->Form->input('teams.2.id', ['label' => 'Choose team', 'type' => 'select', 'options' => $teamOptions]);

//join data
	echo $this->Form->input('teams.2._joinData.points_scored', ['type' => 'select', 'options' => $scoreOptions, 'label' => 'Team 2']);

	echo $this->Form->button('Save Match', ['class' => 'ajax_submit']);

	echo $this->Form->end();

    echo $this->Match->addMatch($tournament['id'], $round->id ); ?>

<?php }

if(isset($unfinishedMatch)) { ?>
	This match could not be saved.
<?php  }
