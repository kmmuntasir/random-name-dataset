<?php

	// Loading Models
	model('name');
	model('person');

	function importFromCSV() {
		ini_set('max_execution_time', 0); // 0 = Unlimited

		$male_persons = 0;
		$female_persons = 0;

		for ($year = 2015; $year < 2019; ++$year) {
			$csv_filename = "names/yob".$year.".txt";
			$all_persons = array();

			$csv_file = fopen($csv_filename,"r");

			$counter = 0;
			while(!feof($csv_file)) {
				$person = fgetcsv($csv_file);

				if(!is_array($person)) continue;

				$person['name'] = $person[0];
				$person['gender'] = $person[1];

				unset($person[0]);
				unset($person[1]);
				unset($person[2]);

				++$counter;

				if($person['gender'] == 'M') $male_persons++;
				else $female_persons++;

				$all_persons[] = $person;

				if(count($all_persons) > 1000) {
					insert_batch('person', $all_persons);
					$all_persons = array();
				}
			}

			if(count($all_persons) > 0) {
					insert_batch('person', $all_persons);
			}

			printer($year . ' - '. $counter . ' Persons');

			fclose($csv_file);
		}

		printer("Total ". $male_persons." Male Persons");
		printer("Total ". $female_persons." Female Persons");
//		tabular($male_persons);
//		tabular($female_persons);
	}

	function checkDuplicates() {
		$result = find_duplicate_names();
		printer($result);
	}

	function unique_name_filter() {
		$isFemale = isset($_GET['isfemale']) ? $_GET['isfemale'] : 0;
		$persons = get_unique_names($isFemale, 10000, 50000);
//		tabular($persons);
		printer("Total: ".count($persons));
		$result = insert_batch_names($isFemale, $persons);
		printer($result);
	}

	function generate_unique_name($dataset) {
		$total = count($dataset);

		$flag = rand(0, 1);

		$a = $c = 0;
		$b = $d = $total-1;

		$a = 0;
		$b = $total/2;
		$c = $b+1;
		$d = $total-1;

		if($flag) {
			$c = $a;
			$d = $b;
			$a = $d+1;
			$b = $total-1;
		}
		$x = rand($a, $b);
		do {$y = rand($c, $d);} while($y==$x);
		$firstname = $dataset[$x]['name'];
		$lastname = $dataset[$y]['name'];

		$fullname = $firstname.' '.$lastname;
		return $fullname;
	}

	function main() {
		$isFemale = isset($_GET['isfemale']) ? $_GET['isfemale'] : 0;
		$dataset = get_gender_dataset($isFemale);
		$name = generate_unique_name($dataset);

		printer($name);
		printer("Dataset Size: ".count($dataset));
//		tabular($dataset);
	}

	main();

?>
