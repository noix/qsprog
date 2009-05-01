<?php

class HomeModule extends Module {
	
	function DefaultViewController() {
		$this->LoadViewInTemplateVariable('presentation');
	}
	
	function PresentationViewController() {
		$this->view['youTubeURL'] = $this->config['youTubeURL'];
	}
	
}

?>