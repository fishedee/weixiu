<?php

//��������ĳ���ֶ�
function matrix_get_column($matrix , $column ){
	$result = array();
	foreach( $matrix as $single )
		$result[] = $single[$column];
	return $result;
}
//��������ĳ���ֶ�
function matrix_get_column_unique($matrix , $column ){
	$result = array();
	foreach( $matrix as $single )
		$result[] = $single[$column];
	array_unique($result);
	return $result;
}
//��������ĳ���ֶ�
function matrix_add_column( $matrix ,$oldColumn,$map,$newColumn){
	foreach( $matrix as $key=>$value ){
		$matrix[$key][$newColumn] = $map[$value[$oldColumn]];
	}
	return $matrix;
}
?>