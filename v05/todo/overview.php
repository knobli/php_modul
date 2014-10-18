<?php
if(!Helper::checkLogin(false)): ?>
	<form class="form" action="main.php?page=login" method="post">
		<p>
			<input type="text" name="user" placeholder="Username" required />
			<input type="password" name="password" placeholder="Password" required />
			<input type="submit" name="login" value="Login" />
			<br>
			Test login data (testUser - test1234)
		</p>
	</form>
<?php else: ?>
	<a href="main.php?page=create"><span class="glyphicon glyphicon-plus"></span> Create Entry</a><br/>
	
	<h2>Your open todos</h2>	
	<?php
	$currentUser=Helper::getCurrentUser();
	$todos=TodoEntryRepository::loadOpenTodos($currentUser);
	
	foreach ($todos as $todo): ?>
		<div class="row <?=Priority::getPriorityString($todo->getPriority())?> 
			<?php if($todo->deadlineReached()){
				echo " deadline";
			}?>">
  			<div class="col-md-6"><b><?=$todo->getTitle()?></b></div>
  			<div class="col-md-3">Deadline: <?=$todo->getDeadline()?></div>
			<div class="col-md-3 text-right">
				<a href="main.php?page=edit&todoId=<?=$todo->getId()?>"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span> edit</button></a>
				<a href="main.php?page=delete&todoId=<?=$todo->getId()?>" onclick="return confirm('Are you sure, you want to delete this todo?')"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span> delete</button></a>
				<a href="main.php?page=close&todoId=<?=$todo->getId()?>"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-ok"></span> close</button></a>
			</div>			
		</div>
	<?php		
	endforeach;
endif; ?>