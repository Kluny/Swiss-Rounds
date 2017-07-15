<?php $this->extend('/Common/common'); ?>
<?php
echo $this->Form->create($tournament);
echo $this->Form->input('name');


echo $this->Form->input('max_score', ['label' => "Maximum score per match", 'type' => 'number']);
echo $this->Form->input('players_per_team', ['label' => "Maximum players per team", 'type' => 'number', 'size' => 4]);

echo $this->Form->submit("Save tournament");
echo $this->Form->end();

?>

<nav class="plugin-actions">
    <?php echo $this->Html->link('View', ['action' => 'view', $tournament['id']]); ?>
    <?php echo $this->Html->link('Clear Scores', ['action' => 'clear_scores', $tournament['id']], ['class' => 'delete']); ?>
    <?php echo $this->Html->link('Clear Teams and Players', ['action' => 'clear_teams_players', $tournament['id']], ['class' => 'delete']); ?>
    <?php echo $this->Html->link('All tournaments', ['action' => 'index']); ?>
</nav>

<table>
  <th>Team</th>
  <th>Players</th>
  <th>Points</th>
  <?php foreach($tournament['teams'] as $team) { ?>
            <tr>
              <td><?php echo $this->Html->link($team['name'], ['controller' => 'teams', 'action' => 'edit', $team['id']]); ?></td>
              <td>
              <?php foreach($team['players'] as $player) { ?>
                  <?php echo $player['name']; ?>;
              <?php } ?>
              </td>
              <td><?php echo $team['tournament_points']; ?></td>

            </tr>
  <?php } ?>
</table>

<?php echo $this->Html->script('SwissRounds.tournaments-edit'); ?>
