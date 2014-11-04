<?php
require_once 'CommandResolver.php';
class FileSystemCommandResolver implements CommandResolver {

	public function getCommand(Request $request) {
		if ($request -> issetParameter("command")) {
			switch( $request->getParameter("command") ) {
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
