<?php
class BlogEntryListView extends View {
	
	public function __construct($title){
		parent::__construct($title);
	}
	
	public function renderSub(Request $request, Response $response){
		$body="<a href='index.php?command=create'><span class='glyphicon glyphicon-plus'></span> Create Entry</a><br/>";
		$body.="<h2>Blog Entries</h2>";

		$blogEntries = $this->get("blogEntryFiles");
		foreach ($blogEntries as $blogEntry){
			$body.="<div class='well'>";
			$body.="<h2>" . $blogEntry->getTitle() . " <small>" . $blogEntry->getUsername() . " - " . $blogEntry->getCreateDate() . "</small></h2>"; 
			$body.="<p>" . $blogEntry->getContentForHTML() . "</p>";
			$body.="<a href='index.php?page=update&blogFile=" . $blogEntry->getFilename() ."'><span class='glyphicon glyphicon-pencil'></span> edit</a>";
			$body.="&nbsp;&nbsp;";
			$body.="<a href='index.php?page=delete&blogFile=" . $blogEntry->getFilename() . "'><span class='glyphicon glyphicon-trash'></span> delete</a>";			
			$body.="</div>";
		}
		
		return $body;
	}	
	
}
?>