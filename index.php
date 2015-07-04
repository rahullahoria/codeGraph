<?php
$inputCode = "#include <stdio.h>
 
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

$graph = array();

for ($i=0; $i < count($newCodeArray) ; $i++) { 
	$line = $newCodeArray[$i];
	if(!is_array($graph[$i]))
		$graph[$i] = array();
	
	if(substr($line, 0,1) == "if"){
		$k=$i;
		while ($newCodeArray[$k] == "")
			$k++;
		$graph[$k] = array($i+1);
	}
	elseif (substr($line, 0, 3) == "for") {
		$k=$i;
		while ($newCodeArray[$k] == "")
			$k++;
		$graph[$k] = array($i+1);	
	}
	elseif (substr($line, 0,4) == "while") {
		$k=$i;
		while ($newCodeArray[$k] == "")
			$k++;
		$graph[$k] = array($i+1);
	}

	else {
		if($newCodeArray[$i] == ""){
			print_r($graph[$i]);
			
		}	
		
			
	}
	$graph[$i] = array_merge($graph[$i], array($i+1) );

}

var_dump($graph);

?>
<!DOCTYPE html>
<html>
<head>
<link href="style.css" rel="stylesheet" />
<meta charset=utf-8 />
<title>Animated BFS</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="http://cytoscape.github.io/cytoscape.js/api/cytoscape.js-latest/cytoscape.min.js"></script>
<script src="code.js"></script>
</head>
<body>
<div id="cy"></div>
</body>
</html>