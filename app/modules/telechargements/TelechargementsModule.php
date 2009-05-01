<?php

class TelechargementsModule extends Module {
	
	function DefaultViewController() {
		$queryParams = array(
			'fields' => array('titre', 'fichier'),
			'orderby' => 'titre ASC'
		);
		$this->FetchItems($queryParams);
	}
	
}

?>