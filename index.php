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
		echo "=============== $k ===============";
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
	$edgesArray[] = array("data" => array(
										"id" => $edges[0].$edges[1], 
										"weight" => 1,
										"source" => $edges[0], 
										"target" => $edges[1]
										));


}
$jsonArray = array( array("nodes" => $nodesArray, "edges" => $edgesArray ) );
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
<!DOCTYPE html>
<html>
<head>
<link href="style.css" rel="stylesheet" />
<meta charset=utf-8 />
<title>Animated BFS</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="http://cytoscape.github.io/cytoscape.js/api/cytoscape.js-latest/cytoscape.min.js"></script>

</head>
<body>
<div class="row">
						<div class="col-lg-5 col-md-5 col-lg-offset-1 col-md-offset-1">
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Code Text Area</h3>
								</div>
					
								<!--No Label Form-->
								<!--===================================================-->
								<form class="" method="POST">
									<div class="panel-body">
										
										<textarea placeholder="Enter your code" name = "text_form" rows="13" class="">
										</textarea>
									</div>
									<div class="panel-footer text-right">
										<input type = "submit" class="btn btn-primary" name ="submit" value="Submit" />
									</div>
								</form>
								<!--===================================================-->
								<!--End No Label Form-->
					
							</div>

						</div>
						<div class="col-lg-5 col-md-5">
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Formed Graph</h3>
								</div>
								<div class="panel-body">
				
					<div id="cy"></div>								
									</div>
							</div>
						</div>
					</div>




<script type="text/javascript">
	$(function(){ // on dom ready

		$('#cy').cytoscape({
		  style: cytoscape.stylesheet()
		    .selector('node')
		      .css({
		        'content': 'data(id)'
		      })
		    .selector('edge')
		      .css({
		        'target-arrow-shape': 'triangle',
		        'width': 4,
		        'line-color': '#ddd',
		        'target-arrow-color': '#ddd'
		      })
		    .selector('.highlighted')
		      .css({
		        'background-color': '#61bffc',
		        'line-color': '#61bffc',
		        'target-arrow-color': '#61bffc',
		        'transition-property': 'background-color, line-color, target-arrow-color',
		        'transition-duration': '0.5s'
		      }),

		  elements: <?= json_encode($jsonArray) ?>,

		  layout: {
		    name: 'breadthfirst',
		    directed: true,
		    roots: '#a',
		    padding: 5
		  },

		  ready: function(){
		    window.cy = this;

		    var dijkstra = cy.elements().dijkstra('#f',function(){
		      return this.data('weight');
		    },false);

		    var bfs = dijkstra.pathTo( cy.$('#i') );
		    var x=0;
		    var highlightNextEle = function(){
		     var el=bfs[x];
		      el.addClass('highlighted');
		      if(x<bfs.length){
		        x++;
		        setTimeout(highlightNextEle, 500);
		      }
		       };
		    highlightNextEle();
		  }
		});

		});	
</script>

</body>
</html>
