<?php
class BlogEntryList implements Command {
	
	public function execute(Request $request, Response $response) {
		$view = new BlogEntryListView('List');
		
		$blogEntryFiles=scandir(BlogEntry::UPLOAD_DIR);
		$blogEntries=array();
		foreach ($blogEntryFiles as $blogEntryFile){
			if(preg_match("/^" . BlogEntry::FILE_PREFIX . "/", $blogEntryFile)){
				$blogEntries[] = BlogEntry::createFromFile($blogEntryFile);
			}
		}
		$view->assign("blogEntryFiles", $blogEntries);
		
		$view->render($request, $response);
		
	}
	
}
?>