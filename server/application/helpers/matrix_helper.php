<?php

//抽出数组的某个字段
function matrix_get_column($matrix , $column ){
	$result = array();
	foreach( $matrix as $single )
		$result[] = $single[$column];
	return $result;
}
//抽出数组的某个字段
function matrix_get_column_unique($matrix , $column ){
	$result = array();
	foreach( $matrix as $single )
		$result[] = $single[$column];
	array_unique($result);
	return $result;
}
//抽出数组的某个字段
function matrix_add_column( $matrix ,$oldColumn,$map,$newColumn){
	foreach( $matrix as $key=>$value ){
		$matrix[$key][$newColumn] = $map[$value[$oldColumn]];
	}
	return $matrix;
}
?>