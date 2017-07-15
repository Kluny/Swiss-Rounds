<?php $this->extend('/Common/common'); ?>
<?php
echo $this->Form->create('Teams');
echo $this->Form->input('Teams.name', array('label' => 'Team Name'));
echo $this->Form->input('Teams.id', array('type' => 'hidden'));

echo $this->Form->input('players.0.name', array('label' => 'Player 1'));
echo $this->Form->input('players.1.name', array('label' => 'Player 2'));
echo $this->Form->input('players.2.name', array('label' => 'Player 3'));

echo $this->Form->input('tournament_id', array('empty' => 'Select', 'type' => 'select', 'options' => $tournaments, 'label' => 'Join Tournament:'));

echo $this->Form->submit("Create team");
echo $this->Form->end();

?>
