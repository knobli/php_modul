<?php
if(Helper::checkLogin(false)): ?>
	<h2>Your closed todos</h2>	
	<?php
	$currentUser=Helper::getCurrentUser();
	$todos=TodoEntryRepository::loadClosedTodos($currentUser);
	
	foreach ($todos as $todo): ?>
		<div class="row <?=Priority::getPriorityString($todo->getPriority())?>">
  			<div class="col-md-6"><b><?=$todo->getTitle()?></b></div>
  			<div class="col-md-3">Deadline: <?=$todo->getDeadline()?></div>
			<div class="col-md-3 text-right">
				<a href="main.php?page=edit&todoId=<?=$todo->getId()?>"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span> edit</button></a>
				<a href="main.php?page=delete&todoId=<?=$todo->getId()?>" onclick="return confirm('Are you sure, you want to delete this todo?')"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span> delete</button></a>
				<a href="main.php?page=reopen&todoId=<?=$todo->getId()?>"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-repeat"></span> reopen</button></a>
			</div>			
		</div>
	<?php		
	endforeach;
endif; ?>