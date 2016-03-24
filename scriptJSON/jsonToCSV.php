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
		$card->intitule=utf8_encode($story->{'name'});
		$card->description=utf8_encode($story->{'desc'});
		foreach ($story->{'labels'} as $label) {
			$card->process=$card->process.", ".$label->{'name'};
		}
		$card->setPriorite();

		$card->liste=$listsArray[$story->{'idList'}];

		// var_dump($card);


		$exportArray[]=array($card->intitule,$card->description,$card->process,intval($card->priorite),$card->liste);

		$fp = fopen('stories.csv', 'w');
		fputs($fp, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
		foreach ($exportArray as $line) {
			$line = array_map("utf8_decode", $line);
    		fputcsv($fp, $line);
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