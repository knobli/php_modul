<?php if(Helper::checkLogin(true)){

	if (!isset($_GET['todoId'])) {
	    die("INVALID INPUT");
	}
	
	if (($todoId = trim($_GET['todoId'])) === '') {
	    die("EMPTY INPUT");
	}	
	
	$todo = TodoEntryRepository::loadByID($todoId);
	
?>
	<h2>Update Todo Entry</h2>
	<form role="form" action="main.php?page=create_entry" method="post">
	<div class="form-group">
		<label for="title">Title</label>
		<input type="text" class="form-control" id="title" name="title" placeholder="Title" value="<?=$todo->getTitle()?>">
	</div>
	<div class="form-group">
		<label for="priority">Priority</label>
		<select class="form-control" name="priority">
			<?php foreach(Priority::getPriorities() as $value => $name){ ?>
				<option value="<?=$value?>" <?php if($todo->getPriority() == $value){
					echo "checked";
				} ?>><?=$name?></option>
			<?php } ?>
		</select>
	</div>
	<div class="form-group">
		<label for="deadline">Deadline</label>
        <div class='input-group date' id='datetimepicker1'>
            <input type='text' class="form-control" name="deadline" id="deadline" value="<?=$todo->getDeadline()?>"/>
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
	</div>
	<input type="submit" value="Save" class="btn btn-default" />		
</form>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker({
        	useSeconds: false,               //en/disables the seconds picker
        });
    });
</script>	
<?php } ?>