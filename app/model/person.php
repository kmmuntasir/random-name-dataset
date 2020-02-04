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

		return extractRows(query($q));
	}

	function get_person_by_name($name) {
		$q = "
		SELECT *
		FROM person
		WHERE
			`name` = '$name'
		";

		return extractRows(query($q));
	}
?>
