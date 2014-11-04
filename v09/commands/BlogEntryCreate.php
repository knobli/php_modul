<?php
class BlogEntryCreate implements Command {
	
	public function execute(Request $request, Response $response) {
		$view = new HtmlTemplateView('HelloWorld');
		if ($request->issetParameter('Name')) {
			$view->assign('Name', $request->getParameter('Name'));
		}
		$view->render($request, $response);
		//TODO create
	}
	
}
?>