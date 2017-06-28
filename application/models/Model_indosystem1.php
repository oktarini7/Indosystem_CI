<?php

class Model_indosystem1 extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function checkInput($n){
		if ($n > 0 && $n <26){
			return true;
		} else {
			return false;
		}
	}

	public function getResult($n){
		$i=1; //$i is row pointer
		$output= "<table>"; //neater display using table
		while ($i<($n+1)){
			$output.= "<tr>";
			$j=1; //$j is column pointer
			$interval=$i;
			while ($j<($n+1)){
				$output.='<td>'.$interval.'</td>';
				$interval=$i+$interval;
				$j++;
			}
			$output.='<tr/>';
			$i++;
		}
		$output.= "</table>";
		return $output;
	}
}
?>