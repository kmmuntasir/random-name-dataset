<?php

	function query($q) {
		return mysqli_query($_SESSION['dbcon'], $q);
	}

	function extractRows($result) {
		$final_array = array();

		while($row = mysqli_fetch_array($result)) {
			foreach ($row as $key => $value)
				if (is_int($key)) unset($row[$key]);
			array_push($final_array, $row);
		}
		return $final_array;
	}

	function get($table, $limit=null) {
		$q = "SELECT * FROM `$table`";
		if($limit) $q .= " limit $limit";
		$result = query($q);
		return extractRows($result);
	}

	function insert($table, $arr) {
		$q = "INSERT INTO `$table` (";
		$delimiter = '';
		$keys = $values = "";
		foreach ($arr as $key => $value) {
			$keys .= $delimiter."`$key`";

			if(is_string($value)) $values .= $delimiter."'$value'";
			else $values .= $delimiter.$value;

			$delimiter = ', ';
		}
		$q .= "$keys) VALUES ($values)";

		return query($q);
	}

	function insert_batch($table, $arr) {
		$q = "INSERT INTO `$table` (";
		$delimiter = '';
		$keys = $values = "";
		foreach ($arr[0] as $key => $v) {
			$keys .= $delimiter."`$key`";
			$delimiter = ', ';
		}
		$delimiter = '';
		foreach ($arr as $key => $single_row) {
			$single_values_row = "";
			$d = '';
			foreach ($single_row as $k => $value) {
				if(is_string($value)) $single_values_row .= $d."'$value'";
				else $single_values_row .= $d.$value;

				$d = ', ';
			}
			$values .= $delimiter."(".$single_values_row.")";
			$delimiter = ', ';

		}
		$q .= "$keys) VALUES $values";

		return query($q);

//		printer($q);
	}

	function update($arr, $table) {

	}

	function delete($fieldname, $value, $table) {

	}

?>
