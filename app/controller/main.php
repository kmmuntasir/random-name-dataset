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

	function main() {
		$person = get_person_by_name('Aaban');
		printer($person);
	}

	main();

?>
