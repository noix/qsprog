<?php

class ContributionsModule extends Module {
	
	var $missingMember;
	var $participants = array();
	
	function GetPath() {
		if ($this->item['phase'] == 1) {
			$themesModule = Module::GetNewModule('themes', $this->item['theme']);
			$pathPrefix = $themesModule->item['path'];
		} else {
			$pathPrefix = 'contributions';
		}
		if ($path = $pathPrefix .'/'. String::PrepareForURL($this->item['titre'])) {
			return $path;
		} else {
			trigger_error("Couldn't get path for item", E_USER_ERROR);
			return false;
		}
	}
	
	function ValidateData() {
		global $_JAM;
		
		if ($_JAM->rootModuleName != 'admin') {
			// Valider les participants
			for ($i = 1; $i < 99; $i++) {
				if ($_POST['membre'. $i] || $_POST['prenom'. $i] || $_POST['nom'. $i]) {
					// S'assurer que toutes les informations sont là
					$this->postData['membre'. $i] = $_POST['membre'. $i];
					$this->postData['nom'. $i] = $_POST['nom'. $i];
					$this->postData['prenom'. $i] = $_POST['prenom'. $i];
					if (!$_POST['nom'. $i]) {
						$this->missingData[] = 'nom'. $i;
					}
					if (!$_POST['prenom'. $i]) {
						$this->missingData[] = 'prenom'. $i;
					}
					if (!$this->missingData) {
						$this->participants[$i] = array(
							'nom' => $_POST['nom'. $i],
							'prenom' => $_POST['prenom'. $i],
							'membre' => $_POST['membre'. $i]
						);
					}
				}
			}
			
			/*
			// S'assurer qu'il y a au moins 3 membres
			$count = count($this->participants);
			if (!$this->participants || $count < 3) {
				$this->missingData[] = 'missingParticipants';
				for ($i = 1; $i < 4; $i++) {
					if (!$this->participants[$i]) {
						$this->missingData[] = 'prenom'. $i;
						$this->missingData[] = 'nom'. $i;
					}
				}
			}
			*/

			// S'assurer qu'il y a au moins un membre de QS
			if ($this->participants) {
				foreach ($this->participants as $participant) {
					if ($participant['membre']) {
						$hasMember = true;
						continue;
					}
				}
			}
			if (!$hasMember) {
				$this->missingMember = true;
				$this->missingData[] = 'hasMember';
			}
			
		}
		
		parent::ValidateData();

		if ($this->postData['typeModification'] == 4) {
			// Si c'est un commentaire général, ne pas inscrire de perspective dans la DB
			$this->postData['perspective'] = 0;
		}
	}

	function PostProcessData($id) {
		foreach ($this->participants as $participant) {
			$params = $participant;
			$params['contribution'] = $id;
			if (!Database::Insert('participants', $params)) {
				trigger_error("Couldn't insert data for child module", E_USER_ERROR);
				return false;
			}
		}
	}
	
	function DefaultViewController() {
		$queryParams = array(
			'fields' => array('titre', 'phase', 'cercle', 'perspective', 'typeModification'),
			'where' => array(
				'publier = TRUE',
				'phase = 2',
				'typeModification != 4'
			),
			'orderby' => 'perspective ASC, contributions.modified DESC'
		);
		$this->FetchItems($queryParams);
		$layoutVariables = array(
			'surtitre' => 'S’informer',
			'titre' => 'Contributions',
			'intro' => "Les contributions comme celles ci-dessous ont été rédigées par des cercles citoyens. Elles vous sont suggérées comme lecture afin d'alimenter votre réflexion sur les enjeux et vous montrer la diversité des opinions, des théories et des tendances des membres de Québec solidaire. Vous pouvez utiliser ces textes comme point de départ et y réagir, ou alors écrire votre contribution en partant d'ailleurs.",
			'titreCorps' => 'Toutes les contributions',
			'afficherEtape' => true,
			'etape' => 1
		);
		$this->layout->AddVariables($layoutVariables);
		$this->view['commentaires'] = Module::GetNewModule('contributions');
	}
	
	function ItemViewController() {
		if (!$this->item['publier']) {
			$this->LoadView('private');
			return false;
		}
		$layoutVariables = array(
			'surtitre' => 'S’informer',
			'titre' => 'Contribution',
			'intro' => "Les contributions comme celle ci-dessous ont été rédigées par des cercles citoyens. Elles vous sont suggérées comme lecture afin d'alimenter votre réflexion sur les enjeux et vous montrer la diversité des opinions, des théories et des tendances des membres de Québec solidaire. Vous pouvez utiliser ces textes comme point de départ et y réagir, ou alors écrire votre contribution en partant d'ailleurs.",
			'titreCorps' => $this->item['titre'],
			'afficherTheme' => $this->item['phase'] == 1,
			'theme' => $this->item['theme'],
			'afficherEtape' => true,
			'etape' => 1
		);
		
		$autresContributions = Module::GetNewModule('contributions');
		$queryParams = array(
			'fields' => array('titre', 'cercle'),
			'where' => array(
				'perspective = '. $this->item['perspective'],
				'contributions.id != '. $this->item['id']
			),
			'orderby' => 'contributions.modified DESC'
		);
		$this->view['autresContributions'] = $autresContributions->FetchItems($queryParams);
		$this->layout->AddVariables($layoutVariables);
	}
	
	function PagesViewController() {
		if ($_GET['m'] == 'updated') {
			HTTP::RedirectLocal('merci');
			return false;
		}
		
		$this->view['form'] = $this->GetForm();
		
		// Add perspective specified as GET variable to form values
		$this->view['form']->LoadValue('perspective', $_GET['perspective']);
		
		$perspectives = Module::GetNewModule('perspectives');
		$queryParams = array(
			'fields' => 'numero'
		);
		$perspectives->FetchItems($queryParams);

		$this->view['perspectives'] = $perspectives->items;
	}
	
	function ThemesViewController() {
		$queryParams = array(
			'fields' => array('titre', 'cercle'),
			'where' => array(
				'theme = '. $this->parentModule->itemID,
				'publier = TRUE'
			),
			'orderby' => 'modified DESC'
		);
		$this->FetchItems($queryParams);
	}

	function HomeViewController() {
		$queryParams = array(
			'fields' => array('titre', 'cercle', 'typeModification', 'perspective'),
			'where' => array(
				'publier = TRUE'
			),
			'limit' => 4,
			'orderby' => 'contributions.modified DESC'
		);
		$this->FetchItems($queryParams);
	}

	function PrivateViewController() {
		$layoutVariables = array(
			'surtitre' => 'Réfléchir',
			'titre' => 'Non-disponible',
			'intro' => "La contribution à cette adresse n'est pas offerte en consultation publique.",
			'afficherEtape' => true,
			'etape' => 1
		);
		$this->layout->AddVariables($layoutVariables);
	}
	
	function CommentairesViewController() {
		$queryParams = array(
			'fields' => array('titre', 'cercle'),
			'where' => array(
				'publier = TRUE',
				'phase = 2',
				'typeModification = 4'
			),
			'orderby' => 'contributions.modified DESC'
		);
		$this->FetchItems($queryParams);
	}
}

?>