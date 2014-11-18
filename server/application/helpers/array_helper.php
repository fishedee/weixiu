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
//设置数组的某个字段
function matrix_set_column( $matrix ,$column,$value){
	foreach( $matrix as $key=>$value ){
		$matrix[$key][$column] = $value;
	}
	return $matrix;
}
//删除数组的某个字段
function matrix_del_column( $matrix ,$column){
	$result = array();
	foreach( $matrix as $key=>$value ){
		unset($value[$column]);
		$result[$key] = $value;
	}
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