<?php

class HomeModule extends Module {
	
	function DefaultViewController() {
		$this->LoadViewInLayoutVariable('presentation');
	}
	
	function PresentationViewController() {
		$this->view['youTubeURL'] = $this->config['youTubeURL'];
	}
	
}

?>