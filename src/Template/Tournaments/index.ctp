<?php $this->extend('/Common/common'); ?>
<table>
  <th>Tournaments</th>
  <th>Teams</th>
  <?php foreach($tournaments as $tournament) { ?>
            <tr>
              <td><?php echo $this->Html->link($tournament['name'], ['action' => 'view', $tournament['id']]); ?></td>
              <td>
                <?php foreach($tournament['teams'] as $team) { ?>
                    <?php echo $team['name']; ?>; 
                <?php } ?>
              </td>
            </tr>
  <?php } ?>
</table>

<?php echo $this->Html->link('New Tournament', array('action' => 'add')); ?>
<br>
<?php echo $this->Html->link('Teams', array('controller' => 'teams', 'action' => 'index')); ?>
