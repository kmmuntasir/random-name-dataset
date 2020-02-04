<?php
	
	function printer($arr, $exit_flag = false, $return_flag=false) { // for debug purpose
        $text  = '';
        $text .= '<pre>';
        $text .= print_r($arr, true);
        $text .= '</pre>';

        // $text = nl2br($text);

        if($return_flag) return $text;
        else echo $text;

        if($exit_flag) exit();
    }
    
	function tabular($arr, $exit_flag=false, $display=true, $style=true, $attr='cellspacing="0" cellpadding="3" style="background-color: #fff; font-size: 10px; font-family: monaco, consolas"') {
	    // if(!$style) $attr = '';
	    $table = '';
	    $css = '';
	    if(is_array($arr) || is_object($arr)) {
	        $first_row_flag=true;
	        $css .= '<style type="text/css">'."\n";
	        $css .= 'tbody > tr > td {border: none; border-right: solid 1px #999;}'."\n";
	        $css .= 'td:first-child {border-left: solid 1px #999;}'."\n";
	        $css .= 'thead > tr {background-color: #fff; color:#000;}'."\n";
	        $css .= 'thead > tr > th {border: solid 1px #999;}'."\n";
	        $css .= 'tr:last-child > td {border-bottom: solid 1px #999;}'."\n";
	        $css .= 'tr {vertical-align: top;}'."\n";
	        $css .= 'table {margin: 10 0; border-collapse: collapse;}'."\n";
	        // $css .= 'th {position: sticky; position: -webkit-sticky; top: 0; z-index: 10;}'."\n";
	        $css .= '</style>'."\n";
	        $table .= "<table $attr>";
	        $color_flag = true;
	        foreach ($arr as $k => $row) {
	            if($first_row_flag) {
	                if(is_array($row) || is_object($row)) {
	                    $table .= '<thead><tr>';
	                    foreach ($row as $key => $val) {
	                        $table .= '<th>'.$key.'</th>';
	                    }
	                    $table .= '</tr></thead><tbody>';
	                    $first_row_flag = false;
	                }
	                else $table .= '<td>'.printer($row, false, true).'</td>';
	            }

	            if(is_array($row) || is_object($row)) {
	                $color = '';
	                if($color_flag && $style) $color = 'style="background-color: #eee;"';
	                $color_flag = !$color_flag;
	                $table .= "<tr $color>";
	                foreach ($row as $key => $val) {
	                    // $table .= '<td>'.$val.'</td>';
	                    $table .= '<td>';
	                    // if(is_array($val) || is_object($val)) {
	                        $table .= printer($val, false, true);
	                    // }
	                    $table .= '</td>';
	                }
	                $table .= '</tr>';
	            }
	            else $table .= '<td>'.printer($row, false, true).'</td>';
	        }
	        $table .= "</tbody></table>";
	    }
	    else $table .= printer($arr, false, true);

	    if($display) {
	        if($style) echo $css;
	        echo $table;
	    }
	    else return $table;

	    if($exit_flag) exit();
	}

?>