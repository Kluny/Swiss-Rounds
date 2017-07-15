<?php $this->extend('/Common/common'); ?>

<h2><?php echo $tournament['name']; ?></h2>
<nav class="plugin-actions">
<?php echo $this->Html->link('Edit Tournament Details', ['action' => 'edit', $tournament['id']]); ?>
<?php echo $this->Html->link('All Teams', ['controller' => 'teams', 'action' => 'index']); ?>
<?php echo $this->Html->link('Clear Scores', ['action' => 'clear_scores', $tournament['id']], ['class' => 'delete']); ?>
<?php echo $this->Html->link('Clear Teams and Players', ['action' => 'clear_teams_players', $tournament['id']], ['class' => 'delete']); ?>
<?php echo $this->Html->link('+New Team', ['controller' => 'teams', 'action' => 'add']); ?>
</nav>

<table>
  <th>Team</th>
  <th>Players</th>
  <th>Points</th>
  <th>Spread</th>
  <?php foreach($tournament['teams'] as $team) { ?>
            <tr>
              <td><?php echo $this->Html->link($team['name'], ['controller' => 'teams' , 'action' => 'edit', $team['id']]); ?></td>
              <td>
              <?php foreach($team['players'] as $player) { ?>
                <?php echo $player['name']; ?>;
              <?php } ?>
              </td>
              <td><?php echo $team['tournament_points']; ?></td>
              <td><?php echo $team['points_spread']; ?></td>

            </tr>
  <?php } ?>
</table>

<h2>Rounds</h2>

<?php if($this->request->session()->read('Round.inProgress')) {
    echo $this->element('rounds/add_row', $this->request->session()->read('Round.inProgress'));

} else { ?>
    <span id="add_round">
	<?php echo $this->Html->link('+', ['controller' => 'rounds',
										'action' => 'ajax_add_round',
										$tournament['id']
                                    ], ['class' => 'add']); ?>
    </span>
<?php } ?>

<hr>
<?php
    $i = 0;
    foreach($tournament['rounds'] as $round) {
        if(count($round['matches']) > 0) { ?>
            <?php $i++; ?>
            <div class="round-group">
                <h3>Round <?php echo $i; ?></h3>
                <?php foreach($round['matches'] as $match) {
                    echo $this->element('SwissRounds.matches/match', ['match' => $match]);
                } ?>
            </div>
            <hr>
<?php }
} ?>

<div class="clear"></div>

<?php echo $this->Html->script('SwissRounds.tournaments-view'); ?>
