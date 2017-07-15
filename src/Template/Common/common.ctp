<?php echo $this->Html->css('SwissRounds.stylesheet'); ?>
<?php
   $this->assign('title', $this->Html->link('Tournaments', array('controller' => 'tournaments', 'action' => 'index')));
   $this->assign('nav1', $this->Html->link('Teams', array('controller' => 'teams', 'action' => 'index')));
   $this->assign('nav2', $this->Html->link('Home', '/'));
?>


<?= $this->fetch('content') ?>
