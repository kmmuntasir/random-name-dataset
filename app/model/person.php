<?php
	function get_all_persons() {

		return get('person', 3);
	}

	function find_duplicate_names() {
		$q = "SELECT 
			`name`, 
			COUNT(`name`) as `count`
		FROM
			`person`
		GROUP BY `name`
		HAVING COUNT(`name`) > 1
		LIMIT 100;";

		return dbresult($q);
	}

	function get_person_by_name($name) {
		$q = "
		SELECT *
		FROM person
		WHERE
			`name` = '$name'
		";

		return dbresult($q);
	}

	function get_unique_names($isFemale=false, $limit=1000, $offset=0) {
		$table = $isFemale ? "female_persons" : "male_persons";
		$q = "
		SELECT `name`
		FROM $table
		GROUP BY `name`
		LIMIT $offset, $limit
		";

		return dbresult($q);
	}

	function insert_batch_names($isFemale=false, $names, $buffer=1000) {
		$table = $isFemale ? "female_unique_names" : "male_unique_names";
		return insert_batch($table, $names, $buffer);

	}

	function get_gender_dataset($isFemale=false) {
		$table = $isFemale ? "female_unique_names" : "male_unique_names";
		return get($table);
	}
//
//CREATE TABLE person_temp
//LIKE person;
//
//-- step 2
//INSERT INTO person_temp
//SELECT *
//FROM person
//GROUP BY `name`;
//
//
//-- step 3
//DROP TABLE person;
//
//ALTER TABLE person_temp
//RENAME TO person;

?>
