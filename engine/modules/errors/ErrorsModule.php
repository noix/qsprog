<?php

class ErrorsModule extends Module {
	
	function NotfoundViewController() {
		global $_JAM;
		
		$_JAM->title = $this->strings['title'];
	}
	
}

?>