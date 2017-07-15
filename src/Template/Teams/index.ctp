<?php $this->extend('/Common/common'); ?>
<table>
  <th>Team</th>
  <th colspan="3">Players</th>
  <th>Delete</th>
  <?php foreach($teams as $team) { ?>
            <tr>
              <td><?php echo $this->Html->link($team['name'], ['action' => 'edit', $team['id']]); ?></td>
              <td>
              <?php foreach($team['players'] as $player) { ?>
                  <?php echo $player['name']; ?>; 
              <?php } ?>
              </td>
              <td><?php echo $this->Html->link('X', ['action' => 'delete', $team['id']]); ?></td>
            </tr>
  <?php } ?>
</table>

<?php echo $this->Html->link('New Team', array('action' => 'add')); ?>
<br>
<?php echo $this->Html->link('Tournaments', array('controller' => 'tournaments', 'action' => 'index')); ?>
