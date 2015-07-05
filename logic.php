<?php
if (isset($_POST['submit'])) {
		if (empty($_POST["text_form"])) {
	     $nameErr = "Code is required";
	    } 
	    else {
	     $inputCode = $_POST["text_form"];
		}
	}

/*$inputCode = "#include <stdio.h>
 
int main(){
  int array[100], n, c, d, swap;
  printf(\"Enter number of elements\n\");
  scanf(\"%d\", &n); 
  printf(\"Enter %d integers\n\", n);
 
  for (c = 0; c < n; c++){
    scanf(\"%d\", &array[c]);
 }
  for (c = 0 ; c < ( n - 1 ); c++){
    for (d = 0 ; d < n - c - 1; d++){
      if (array[d] > array[d+1]) {
        swap       = array[d];
        array[d]   = array[d+1];
        array[d+1] = swap;
      }
    }
  }
 
  printf(\"Sorted list in ascending order:\n\");
 
  for ( c = 0 ; c < n ; c++ ){
     printf(\"%d\n\", array[c]);
  }
  
 
  return 0;
}";
*/

$codeArray = preg_split( '/(\;|{|})/', $inputCode );
$newCodeArray = array();

for ($i=0; $i < count($codeArray) -1; $i++) { 
	$codeArray[$i] = ltrim($codeArray[$i]);
	//if($codeArray[$i] != ""  ){
		if (substr($codeArray[$i], 0, 3) == "for")  {
			$newCodeArray[] = $codeArray[$i] . " " .$codeArray[$i+1] . " " . $codeArray[$i+2];
			$i += 2; 
		} else {
			$newCodeArray[] = $codeArray[$i];
		}
	//}
}
var_dump($newCodeArray);
$graph = array();

for ($i=0; $i < count($newCodeArray) ; $i++) { 
	$line = $newCodeArray[$i];
	if(!is_array($graph[$i]))
		$graph[$i] = array();
	if(substr($line, 0,2) == "if"){
		$k = getCloseNode($newCodeArray,$i);
		$graph[$i] = array($k);
	}
	elseif (substr($line, 0, 3) == "for") {
		$k = getCloseNode($newCodeArray,$i);
		$graph[$k] = array($i);	
	}
	elseif (substr($line, 0,5) == "while") {
		$k = getCloseNode($newCodeArray,$i);
		$graph[$k] = array($i);
	}

	else {
		if($newCodeArray[$i] == ""){
			print_r($graph[$i]);
			
		}	
		
			
	}
	$graph[$i] = array_merge($graph[$i], array($i+1) );

}

var_dump($graph);
/*	$toDrawGraph = array( 
						array(1,4),
						array(2,8),
						array(7,5),
						array(1,4),
						array(2,8),
						array(4,6),
						array(3,5),
						array(1,2)
					);*/

$toDrawGraph = $graph;
//$output = array();
//(array("nodes"), array("edges")

$nodesArray = array();
$edgesArray = array();

foreach($toDrawGraph as $node => $edges) {
  
	$nodesArray[] = array("data" => array(id => "$node"));
	foreach ($edges as $key => $value) {
		$edgesArray[] = array("data" => array(
										"id" => $node.$value, 
										"weight" => 1,
										"source" => $node, 
										"target" => $value
										));
	}
	


}
$jsonArray = array( 0 => array("nodes" => $nodesArray, "edges" => $edgesArray ) );
$nodesjson = "nodes: [".$nodesjson."]";
$edgesjson = "edges: [".$edgesjson."]";


function getCloseNode($array,$i){
	$stack = array("x");
	while ( count($stack) > 0){
		$i++;
		$line = $array[$i];
		if(substr($line, 0,1) == "if"){
			array_push($stack, "x");
		}
		elseif (substr($line, 0, 3) == "for") {
			array_push($stack, "x");	
		}
		elseif (substr($line, 0,4) == "while") {
			array_push($stack, "x");
		}
		elseif ($line == "") {
			array_pop($stack);
		}
		
	}

	return $i+1;

}
?>
