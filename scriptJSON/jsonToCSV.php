<?php

	class Card{

		public $intitule;
		public $description;
		public $process="";
		public $priorite=0;
		public $liste;

		public function setPriorite(){

			while ( $this->priorite<=3 && (strpos($this->intitule, 'C'.intval($this->priorite)) == false)) {
				$this->priorite++;	
			}
			
		}
		
		public function setIntitule($title){
			$this->intitule=utf8_encode($title);
		}

		public function setDescription($desc){
			$this->description=utf8_encode($desc);
		}

		public function addProcess($processus){
			if ($this->process!=="") {
				$this->process=$this->process.", ".$processus;
			}else{
				$this->process=$processus;
			}
			$this->process=utf8_encode($this->process);
		}


		public function setListe($liste){
			$this->liste=utf8_encode($liste);
		}

	}	

	$jsonPage = file_get_contents('/home/lucas/Documents/Boulot/Test JSON/trello.json');
	$trello = json_decode($jsonPage);
	
	$lists = $trello->{'lists'};
	$listsArray=array();
	foreach ($lists as $list) {
		 $listsArray[$list->{'id'}]=$list->{'name'};
	}

	$stories = $trello->{'cards'};

	$exportArray[]=array();
	foreach ($stories as $story) {
		$card=new Card();
		$card->setIntitule($story->{'name'});
		$card->setDescription($story->{'desc'});
		foreach ($story->{'labels'} as $label) {
			$card->addProcess($label->{'name'});
		}
		$card->setPriorite();
		$card->setListe($listsArray[$story->{'idList'}]);

		// $card->intitule=utf8_encode($story->{'name'});
		// $card->description=utf8_encode($story->{'desc'});
		// foreach ($story->{'labels'} as $label) {
			// $card->process=$card->process.", ".$label->{'name'};
		// }
		// $card->process=utf8_encode($card->process);
		// $card->liste=utf8_encode($listsArray[$story->{'idList'}]);

		// var_dump($card);


		$exportArray[]=array($card->intitule,$card->description,$card->process,intval($card->priorite),$card->liste);

		$fp = fopen('stories.csv', 'w');
		fputs($fp, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
		foreach ($exportArray as $line) {
			$line = array_map("utf8_decode", $line);
    		fputcsv($fp, $line,';');
		}

		fclose($fp);
		// var_dump($exportArray);



	}

	// var_dump($stories);
	// foreach ($trello as $key => $value){
		// echo "key :".$key."\n";
	// }	
	// 	// echo "key :".$key.", "."value :".$value."\n";		
	// // 	$i++;
	// // 	foreach ($stuff as $key => $value) {
	// // 		// echo "key :".$key.", "."value :".$value."\n";
	// // 		echo "key :".$key."\n";
	// // 	}

	// // 	echo "i : ".intval($i);

		
?>