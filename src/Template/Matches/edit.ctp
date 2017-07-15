<?php $this->extend('/Common/common'); ?>
<h4><?php echo $this->Html->link('Return to tournament',
        ['controller' => 'tournaments',
            'action' => 'view',
            $match->round->tournament_id
        ]); ?></h4>

<h2>Edit Match Data</h2>

<h3>Round <?php echo $match->round_id; ?></h3>
<?php
    $scoreOptions = [0,1,2,3,4,5];

    echo $this->Form->create($match);


//hidden values for associating teams and rounds
    echo $this->Form->input('round_id', ['type' => 'hidden', 'value' => $match->round_id]);
    echo $this->Form->input('teams.0.id', ['type' => 'hidden', 'value' => $match->teams[0]->id]);
    echo $this->Form->input('teams.1.id', ['type' => 'hidden', 'value' => $match->teams[1]->id]);

//join data
	echo $this->Form->input('teams.0._joinData.points_scored',
                                ['type' => 'select',
                                        'options' => $scoreOptions,
                                        'label' => $match->teams[0]->name]
                            ); ?>
<span class="vs">VS</span>

<?php

//join data
	echo $this->Form->input('teams.1._joinData.points_scored',
                                ['type' => 'select',
                                    'options' => $scoreOptions,
                                    'label' => $match->teams[1]->name]
                            );

	echo $this->Form->button('Save Changes');

	echo $this->Form->end();
