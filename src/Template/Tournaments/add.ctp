<?php $this->extend('/Common/common'); ?>
<?php
echo $this->Form->create('Tournaments');
echo $this->Form->input('name');

echo $this->Form->input('max_score', ['label' => "Maximum score per match", 'type' => 'number']);
echo $this->Form->input('players_per_team', ['label' => "Maximum players per team", 'type' => 'number']);

echo $this->Form->submit("Create tournament");
echo $this->Form->end();

?>
