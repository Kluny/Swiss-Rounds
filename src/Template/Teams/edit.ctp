<?php $this->extend('/Common/common'); ?>
<h4><?php
if($team->tournament_id) {
	echo $this->Html->link($team->tournament->name,
        ['controller' => 'tournaments',
            'action' => 'view',
            $team->tournament->id
        ]);
} ?></h4>
<h4>Tournament points: <?php echo $team->tournament_points; ?></h4>

<nav class="plugin-actions">
<?php  // echo $this->Html->link('Delete this team', ['action' => 'delete', $team->id]); ?>
</nav>

<h4>Edit Team Data</h4>

<?php

echo $this->Form->create($team);
echo $this->Form->input('name', array('label' => 'Team Name'));
echo $this->Form->input('id', array('type' => 'hidden'));

for($i = 0; $i < $team->tournament->players_per_team; $i++) {
	echo $this->Form->input('players.' . $i . '.name', array('label' => 'Player ' . ($i + 1)));
	echo $this->Form->input('players.' . $i . '.id', array('type' => 'hidden'));
}

/* echo $this->Form->input('players.1.name', array('label' => 'Player 2'));
echo $this->Form->input('players.1.id', array('type' => 'hidden'));

echo $this->Form->input('players.2.name', array('label' => 'Player 3'));
echo $this->Form->input('players.2.id', array('type' => 'hidden')); */

echo $this->Form->input('tournament_id', array('empty' => 'Select', 'type' => 'select', 'options' => $tournaments, 'label' => 'Join Tournament:'));

echo $this->Form->submit("Update team");
echo $this->Form->end(); ?>

<div class="clear"></div>


<h4>Match results</h4>
<?php foreach($team->matches as $match) {

        $result = "";

        if($match->_joinData->winner){
            $result = "Winner!";
        } else if($match->_joinData->tie) {
            $result = "Tie";
        }

        if(!empty($result)) { ?>
        <div class="finished-match">
            Round: <?php echo $match->round_id; ?><br>
            Match: <?php echo $match->round_id; ?><br>
            <?php echo $result; ?>
        </div>
        <?php }
    } ?>

<div class="clear"></div>
