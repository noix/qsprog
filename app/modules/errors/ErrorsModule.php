<?php

class ErrorsModule extends Module {
	
	function NotfoundViewController() {
		global $_JAM;
		
		$_JAM->title = $this->strings['title'];
		$templateVariables = array(
			'enteteTitre' => $this->strings['title'],
			'intro' => $this->strings['text']
		);
	}
	
}

?>