<?php

class ErrorsModule extends Module {
	
	function NotfoundViewController() {
		global $_JAM;
		
		$_JAM->title = $this->strings['title'];
		$layoutVariables = array(
			'enteteTitre' => $this->strings['title'],
			'intro' => $this->strings['text']
		);
		$this->layout->AddVariables($layoutVariables);
	}
	
}

?>