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

	function dbresult($q) {
		return extractRows(query($q));
	}

	function get($table, $limit=null) {
		$q = "SELECT * FROM `$table`";
		if($limit) $q .= " limit $limit";
		return dbresult($q);
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

	function insert_batch($table, $arr, $buffer=1000) {
		$total = count($arr);
		$beg = 0;
		$end = $buffer-1;
		$done= 0;
		while($end < $total) {
			$done += insert_batch_fragment($table, $arr, $beg, $end);
			$beg += $buffer;
			$end += $buffer;
		}
		if($beg < $total) {
			$end = $total-1;
			$done += insert_batch_fragment($table, $arr, $beg, $end);
		}
		return $done;
	}

	function insert_batch_fragment($table, $arr, $beg, $end) {
		$q = "INSERT INTO `$table` (";
		$delimiter = '';
		$keys = $values = "";
		foreach ($arr[$beg] as $key => $v) {
			$keys .= $delimiter."`$key`";
			$delimiter = ', ';
		}
		$delimiter = '';
		for($i=$beg; $i<=$end; ++$i) {
			$single_values_row = "";
			$d = '';
			foreach ($arr[$i] as $k => $value) {
				if(is_string($value)) $single_values_row .= $d."'$value'";
				else $single_values_row .= $d.$value;

				$d = ', ';
			}
			$values .= $delimiter."(".$single_values_row.")";
			$delimiter = ', ';
		}
		$q .= "$keys) VALUES $values";

		query($q);
//		printer("Beg: $beg, End: $end");
//		printer($q);

		return $end - $beg + 1;
	}

	function update($arr, $table) {

	}

	function delete($fieldname, $value, $table) {

	}

?>
