<?php 
include( 'inc/config.php');
include( 'inc/autoload.php');

include( 'inc/initDB.php');

include( 'class/post.class.php');
include( 'class/postTable.class.php');

	echo '<h1>Row Data Gateway Pattern</h1>';	
	
	echo "<b>Create Post1:</b><br>";	
	$post1 = new Post();
	$post1->create(array('title' => 'test1'));
	
	echo 'id: '.$post1->getID().'<br/>';
	echo 'title: '.$post1->getTitle().'<br/>';
	echo 'content: '.$post1->getContent().'<br/>';
	echo 'created: '.$post1->getCreated().'<br/>';
	
	echo "<hr>";
	
	echo "<b>Update Post1:</b><br>";
	$post1->update(array('content' => 'content1 after update'));
	
	echo 'id: '.$post1->getID().'<br/>';
	echo 'title: '.$post1->getTitle().'<br/>';
	echo 'content: '.$post1->getContent().'<br/>';
	echo 'created: '.$post1->getCreated().'<br/>';
	
	echo "<hr>";
	
	echo "<b>Delete Post1</b><br>";
	$post1->delete();
	echo "<hr>";	
	
	echo "<b>Create Post2 (short way):</b><br>";
	$post2 = new Post(array('title' => 'test2', 'content' => 'content2'));
	
	echo 'id: '.$post2->getID().'<br/>';
	echo 'title: '.$post2->getTitle().'<br/>';
	echo 'content: '.$post2->getContent().'<br/>';
	echo 'created: '.$post2->getCreated().'<br/>';
	
	echo "<hr>";
	
	echo "<b>Create Post3 (short way):</b><br>";
	$post3 = new Post(array('title' => 'test3', 'content' => 'content3'));
	
	echo 'id: '.$post3->getID().'<br/>';
	echo 'title: '.$post3->getTitle().'<br/>';
	echo 'content: '.$post3->getContent().'<br/>';
	echo 'created: '.$post3->getCreated().'<br/>';
	
	echo "<b>Find Post3 with id:</b><br>";
	$post3 = new Post();
	$post3->findByID(3);
	
	echo 'id: '.$post3->getID().'<br/>';
	echo 'title: '.$post3->getTitle().'<br/>';
	echo 'content: '.$post3->getContent().'<br/>';
	echo 'created: '.$post3->getCreated().'<br/>';
	
	echo "<b>Update found Post3:</b><br>";
	$post3->update(array('content' => 'content updated (find by id)'));
	
	echo 'id: '.$post3->getID().'<br/>';
	echo 'title: '.$post3->getTitle().'<br/>';
	echo 'content: '.$post3->getContent().'<br/>';
	echo 'created: '.$post3->getCreated().'<br/>';	
	
	echo "<hr>";
	
	echo '<h1>Table Data Gateway Pattern</h1>';
			
	$table = new PostTable();
	echo "<b>Create Table Post 1:</b><br>";
	$tablePost1 = $table->createPost(array('title' => 'tablepost1'));
	
	echo 'id: '.$tablePost1->getID().'<br/>';
	echo 'title: '.$tablePost1->getTitle().'<br/>';
	echo 'content: '.$tablePost1->getContent().'<br/>';
	echo 'created: '.$tablePost1->getCreated().'<br/>';
	
	
	echo "<hr>";
	
	echo "<b>Update Table Post 1:</b><br>";
	$tablePost1->update(array('content' => 'content 4 updated (table)'));
	
	echo 'id: '.$tablePost1->getID().'<br/>';
	echo 'title: '.$tablePost1->getTitle().'<br/>';
	echo 'content: '.$tablePost1->getContent().'<br/>';
	echo 'created: '.$tablePost1->getCreated().'<br/>';
	
	echo "<hr>";
	
	echo "<b>Update Table Post 1 with id:</b><br>";
	
	echo 'post id: (should be 4)'.$tablePost1->getID().'<br/>';
	$table->updatePost(4,array('content' => 'content 4 updated with id'));
	
	echo 'id: '.$tablePost1->getID().'<br/>';
	echo 'title: '.$tablePost1->getTitle().'<br/>';
	echo 'content: '.$tablePost1->getContent().'<br/>';
	echo 'created: '.$tablePost1->getCreated().'<br/>';
	
	echo "<hr>";
	
	echo "<b>Create Table Post 2 (short way):</b><br>";
	$tablePost2 = $table->createPost(array('title' => 'test2', 'content' => 'content 5 (table)'));
	
	echo 'id: '.$tablePost2->getID().'<br/>';
	echo 'title: '.$tablePost2->getTitle().'<br/>';
	echo 'content: '.$tablePost2->getContent().'<br/>';
	echo 'created: '.$tablePost2->getCreated().'<br/>';
	
	
	echo "<hr>";
	
	echo "<b>Delete Table Post 2</b><br>";
	$table->deletePost(5);
	
	echo "<hr>";
	
	echo "<b>Find Posts by id (4):</b><br>";
	$postsById = $table->findPostBy('id',4);
	foreach($postsById as $post){
		echo "id:".$post->getID().'<br/>';	
		echo "title:".$post->getTitle().'<br/>';
		echo "content:".$post->getContent().'<br/>';
	}
	echo '<hr>';
	
	echo "<b>Create another Post with title test2:</b><br>";
	$tablePost3 = $table->createPost(array('title' => 'test2', 'content' => 'content 6 (table)'));
	echo 'id: '.$tablePost3->getID().'<br/>';
	echo 'title: '.$tablePost3->getTitle().'<br/>';
	echo 'content: '.$tablePost3->getContent().'<br/>';
	echo 'created: '.$tablePost3->getCreated().'<br/>';
	
	
	echo "<b>Find Posts by title (test2):</b><br>";
	$postsByTitle = $table->findPostBy('title','test2');
	foreach($postsByTitle as $post){
		echo "id:".$post->getID().'<br/>';
		echo "title:".$post->getTitle().'<br/>';
		echo "content:".$post->getContent().'<br/>';
	}
	echo '<hr>';

 ?> 