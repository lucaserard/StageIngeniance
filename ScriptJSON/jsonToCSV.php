<?php

	class Card{

		private $intitule;
		private $description;
		private $process="";
		private $priorite=0;
		private $liste;
		private $conditions="";
		private $due;
		private $id;
		private $members;

		public function setPriorite(){

			while ( $this->priorite<=3 && (strpos($this->intitule, 'C'.intval($this->priorite)) == false)) {
				$this->priorite++;	
			}
			if ($this->priorite>=4) {
				$this->priorite=0;
			}

			
		}
		

		public function setDue($date){
			$this->due=$date;
		}


		public function setIntitule($title){
			$this->intitule=utf8_encode($title);
		}

		public function setDescription($desc){
			$this->description=utf8_encode($desc);
		}

		public function addProcess($processus){
			if ($this->process!=="") {
				$this->process=$this->process."\n".$processus;
			}else{
				$this->process=$processus;
			}
			$this->process=utf8_encode($this->process);
		}

		public function setConditions($conditions){
			$this->conditions=utf8_encode($conditions);
		}
	
		public function setListe($liste){
			$this->liste=utf8_encode($liste);
		}

		public function getDue(){
			return $this->due;
		}

		public function getIntitule(){
			return $this->intitule;
		}

		public function getDescription(){
			return $this->description;
		}

		public function getProcess(){
			return $this->process;
		}

		public function getPriorite(){
			return $this->priorite;
		}
		public function getConditions(){
			return $this->conditions;
		}

		public function getListe(){
			return $this->liste;
		}

		public function setID($_id){
				$this->id=$_id;
		}
		public function getID(){
			return $this->id;
		}

		public function addMember($_member){
			if($this->members!=="") {
				$this->members=$this->members."\n".$_member;
			}else{
				$this->members=$_member;
			}
			$this->members=utf8_encode($this->members);
		}
		public function getMembers(){
			return $this->members;

		}




	}



	//$jsonPage = file_get_contents('/home/lucas/Documents/Boulot/StageIngeniance/ScriptJSON/trello.json');
	$jsonPage = file_get_contents('/home/lucas/StageIngeniance/ScriptJSON/ERP.json');	
	$trello = json_decode($jsonPage);
	
	$lists = $trello->{'lists'};
	$listsArray=array();
	foreach ($lists as $list) {
		 $listsArray[$list->{'id'}]=$list->{'name'};
	}

	$stories = $trello->{'cards'};

	$exportArray[]=array();
	foreach ($stories as $story) {
		if(!$story->{'closed'}){

			$card=new Card();
			$card->setIntitule($story->{'name'});
			$card->setDescription($story->{'desc'});
			$card->setID($story->{'idShort'});
			foreach ($story->{'labels'} as $label) {
				$card->addProcess($label->{'name'});
			}
			$card->setPriorite();
			$card->setListe($listsArray[$story->{'idList'}]);


			$card->setDue(substr($story->{'due'},0,10));

			// var_dump($story->{'idChecklists'}[0]);
			$card->setConditions(getConditionFromID($story->{'idChecklists'},$trello));

			foreach ($story->{'idMembers'} as $member) {
				$card->addMember(getMemberFromID($member,$trello));
			}
			// $card->addMembers(getMemberFromID($story->{'idMembers'},$trello));
			


			$exportArray[]=array(intval($card->getID()),$card->getIntitule(),$card->getDescription(),$card->getMembers(),$card->getProcess(),intval($card->getPriorite()),$card->getListe(), $card->getConditions(), $card->getDue());
		}

	}

	$fp = fopen('stories.csv', 'w');
	fputs($fp, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
	foreach ($exportArray as $line) {
		$line = array_map("utf8_decode", $line);
		fputcsv($fp, $line,';');
	}

	fclose($fp);
	


	function getConditionFromID($id,$trello){
		$checklists = $trello->{'checklists'};
		$result="";
		if(!empty($id)){
			foreach ($checklists as $list) {
				if ($list->{'id'}==$id[0]) {
					$condList = $list->{'checkItems'};
					$result=""; 
					foreach ($condList as $cond) {
						if ($result!=="") {
							$result=$result."\n".$cond->{'name'};
						}else{
							$result=$cond->{'name'};
						}	
					}
				}
			}
		}	
		return $result;

	}



	function getMemberFromID($id,$trello){
		$members = $trello->{'members'};
		$result="";
		if(!empty($id)){
			foreach ($members as $member) {
				if ($member->{'id'}==$id) { 
					$result=$member->{'fullName'};	
				}
			}
		}	
		return $result;

	}


?>
