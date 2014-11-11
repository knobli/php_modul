<?php
require_once 'CommandResolver.php';
class FileSystemCommandResolver implements CommandResolver {

	public function getCommand(Request $request) {
		if ($request -> issetParameter("page")) {
			switch( $request->getParameter("page") ) {
				case 'create' :
					return new BlogEntryCreate();
				case 'delete' :
					return new BlogEntryDelete();
				case 'update' :
					return new BlogEntryUpdate();
				default :
					return new BlogEntryList();
			}
		} else {
			return new BlogEntryList();
		}
	}

}
