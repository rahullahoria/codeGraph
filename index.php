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
//var_dump($newCodeArray);
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
	elseif (substr($line, 0, 7) == "foreach") {
		$k = getCloseNode($newCodeArray,$i);
		$graph[$k] = array($i);	
	}
	elseif (substr($line, 0,5) == "while") {
		$k = getCloseNode($newCodeArray,$i);
		$graph[$k] = array($i);
	}

	else {
		if($newCodeArray[$i] == ""){
			
		}	
		
			
	}
	$graph[$i] = array_merge($graph[$i], array($i+1) );

}

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

global $allPaths;
$allPaths = array();

getPaths($graph, 0, count($newCodeArray)-1, array());

function getPaths($graph, $current, $end, $currentPath){

	
	if($end == $current){
		global $allPaths;
		$allPaths[] = $currentPath;
		return;  
	}
		
	
	foreach ($graph[$current] as $key => $value) {
		if(checkNodePresentMoreThen2( $currentPath, $value)){
			$currentPath[] = $value;
			getPaths($graph,$value, $end, $currentPath);
		}
	}
	return;


}

//echo "------------Graphs----------<br/>";
var_dump($graph);

$subGraphs = getSubGraphs($graph);
//echo "------------subGraphs----------<br/>";
var_dump($subGraphs);
function getSubGraphs($graph){
	
	$subGraphs = array();
	$wasFor = false;

	foreach ($graph as $key => $value) {
		if(count($value) >= 2){
			
			foreach ($value as $k => $v) {
				$max = 0;
				if($max < $v)
					$max = $v;
				if ($key > $v  ) {
					$subGraphs[] = array($v,$key);
					$wasFor = true; 
				}
			}

			if(!$wasFor){
				
				$subGraphs[] = array($key,$max);
				$wasFor = false;


			}
		}
	}

	return $subGraphs;

}

$setOfDivition = getSet($subGraphs);

function getSet($graph){
	$set = array();
	foreach ($graph as $key => $value) {
		foreach ($value as $k => $v) {
			$set[] = $v; 
		}
	}

	return array_unique($set);

}
//echo "------------------setOfDivition----------------";
//var_dump($setOfDivition);

$divideGraph = getDivideGraph($graph,$setOfDivition);

function getDivideGraph($graph,$setOfDivition){
	$divideGraph = array();
	$i=0;
	foreach ($graph as $key => $value) {
		if(in_array($key, $setOfDivition)){
			$divideGraph[$i] = array();
			$i++;


		}
		$divideGraph[$i] = $value;
		$i++;
	}
	return $divideGraph;
}

//echo "-----------divide Graph----------------<br/>";

//var_dump($divideGraph);

function checkNodePresentMoreThen2($arr,$node){
	$count=0;
	foreach ($arr as $key => $value) {
		if($value == $node)
			$count++;
	}
	if($count >= 2)
		return false;
	return true;
}
//var_dump($allPaths);
$nodeComplaxity = 0;
foreach ($allPaths as $key => $value) {
	$nodeComplaxity += count($value);
}
$toDrawGraph = $graph;
//$output = array();
//(array("nodes"), array("edges")
/*
nodes: [
        { data: { id: 'a' } },
        { data: { id: 'b' } },
        { data: { id: 'c' } },
        { data: { id: 'd' } },
        { data: { id: 'e' } },
        { data: { id: 'f' } },
        { data: { id: 'g' } },
        { data: { id: 'h' } },
        { data: { id: 'i' } }
      ], 

      edges: [
        { data: { id: 'ab', weight: 1, source: 'a', target: 'b' } },
	{ data: { id: 'ca', weight: 2, source: 'c', target: 'a' } },
        { data: { id: 'ac', weight: 2, source: 'a', target: 'c' } },
	{ data: { id: 'ca', weight: 2, source: 'c', target: 'a' } },
        { data: { id: 'bd', weight: 3, source: 'b', target: 'd' } },
        { data: { id: 'be', weight: 4, source: 'b', target: 'e' } },
        { data: { id: 'cf', weight: 5, source: 'c', target: 'f' } },
        { data: { id: 'cg', weight: 6, source: 'c', target: 'g' } },
        { data: { id: 'ah', weight: 7, source: 'a', target: 'h' } },
        { data: { id: 'hi', weight: 8, source: 'h', target: 'i' } },
	{ data: { id: 'ci', weight: 18, source: 'c', target: 'i' } }  
      ]

*/
$notedStr = "{ nodes: [\n";
$edgeStr =  "edges: [\n";
foreach($toDrawGraph as $node => $edges) {
  
  	$notedStr .=  "{ data: { id: '".$node."', name: '".trim(preg_replace('/\s\s+/', ' ', addslashes($newCodeArray[$node]) ))."' } },\n";
	
	foreach ($edges as $key => $value) {
		$edgeStr .= "{ data: { id: 'a".$node.$value."', weight: $node, source: '".$node."', target: '".$value."' } },\n"; 
		
	}
	


}
$jsonEcho = $notedStr." ], ". $edgeStr . " ]}\n";

$subnotedStr = "{ nodes: [\n";
$subedgeStr =  "edges: [\n";
foreach($divideGraph as $node => $edges) {
  
  	$subnotedStr .=  "{ data: { id: '".$node."', name: '".trim(preg_replace('/\s\s+/', ' ', addslashes($newCodeArray[$node]) ))."' } },\n";
	
	foreach ($edges as $key => $value) {
		$subedgeStr .= "{ data: { id: 'a".$node.$value."', weight: $node, source: '".$node."', target: '".$value."' } },\n"; 
		
	}
	


}
$subjsonEcho = $subnotedStr." ], ". $subedgeStr . " ]}\n";


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
		elseif (substr($line, 0, 7) == "foreach") {
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
<title>Code Graph | Generate Flow Graph</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="http://cytoscape.github.io/cytoscape.js/api/cytoscape.js-latest/cytoscape.min.js"></script>




	<!--Bootstrap Stylesheet [ REQUIRED ]-->
	<link href="v2.2/css/bootstrap.min.css" rel="stylesheet">


	<!--Nifty Stylesheet [ REQUIRED ]-->
	<link href="v2.2/css/nifty.min.css" rel="stylesheet">


	<script src="testCodes.js"></script>	

</head>
<body>



	<!--NAVBAR-->
		<!--===================================================-->
		<header id="navbar">
			<div id="navbar-container">

				<!--Brand logo & name-->
				<!--================================-->
				<div class="navbar-header">
					<a href="#" class="navbar-brand">
						
						<div class="brand-title">
							<span class="brand-text">Code Graph</span>
						</div>
					</a>
				</div>
				<!--================================-->
				<!--End brand logo & name-->


				<!--Navbar Dropdown-->
				<!--================================-->
				<div class="navbar-content clearfix">
					<ul class="nav navbar-top-links pull-left">
						
						
					</ul>
					<ul class="nav navbar-top-links pull-right">

						
					</ul>
				</div>
				<!--================================-->
				<!--End Navbar Dropdown-->


			</div>
		</header>
		<!--===================================================-->
		<!--END NAVBAR-->



					<div class="row" style="margin-top : 65px;">
						<div class="col-lg-8 col-md-8 col-lg-offset-1 col-md-offset-1">
							<div class="panel">
								<div class="panel-heading panel panel-dark panel-colorful">
									<h3 class="panel-title">Code Text Area</h3>
								</div>
					
								<!--No Label Form-->
								<!--===================================================-->
								<form class="" method="POST" id="codeForm">
									<div class="panel-body">
										
										<textarea placeholder="Enter your code" name = "text_form" id="codeTA" rows="22" class="form-control">
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

						<div class="col-lg-2 col-md-2">

							<div class="panel">
								<div class="panel-heading panel panel-dark panel-colorful">
									<h4 class="panel-title">Sample Codes</h4>
								</div>
								<div class="panel-body" style="padding-left: 0px; padding-right: 0px;">

									<div class="panel panel-success panel-colorful" onclick="insertCode('quick_sort');" style="margin-bottom: 0px;">
										<div class="pad-all media">
											<div class="media-left">
												<span class="icon-wrap icon-wrap-xs">
													<i class="fa fa-users fa-2x"></i>
												</span>
											</div>
											<div class="media-body">
												<p class="h4 text-thin media-heading">Quick Sort</p>
											</div>
										</div>
											
									</div>

									<div class="panel panel-primary panel-colorful" onclick="insertCode('merge_sort');" style="margin-bottom: 0px;">
										<div class="pad-all media">
											<div class="media-left">
												<span class="icon-wrap icon-wrap-xs">
													<i class="fa fa-users fa-2x"></i>
												</span>
											</div>
											<div class="media-body">
												<p class="h4 text-thin media-heading">Merge Sort</p>
											</div>
										</div>
											
									</div>

									<div class="panel panel-pink panel-colorful" onclick="insertCode('bubble_sort');" style="margin-bottom: 0px;">
										<div class="pad-all media">
											<div class="media-left">
												<span class="icon-wrap icon-wrap-xs">
													<i class="fa fa-users fa-2x"></i>
												</span>
											</div>
											<div class="media-body">
												<p class="h4 text-thin media-heading">Bubble Sort</p>
											</div>
										</div>
											
									</div>

									<div class="panel panel-warning panel-colorful" onclick="insertCode('heap_sort');" style="margin-bottom: 0px;">
										<div class="pad-all media">
											<div class="media-left">
												<span class="icon-wrap icon-wrap-xs">
													<i class="fa fa-users fa-2x"></i>
												</span>
											</div>
											<div class="media-body">
												<p class="h4 text-thin media-heading">Heap Sort</p>
											</div>
										</div>
											
									</div>

									<div class="panel panel-danger panel-colorful" onclick="insertCode('selection_sort');" style="margin-bottom: 0px;">
										<div class="pad-all media">
											<div class="media-left">
												<span class="icon-wrap icon-wrap-xs">
													<i class="fa fa-users fa-2x"></i>
												</span>
											</div>
											<div class="media-body">
												<p class="h4 text-thin media-heading">Selection Sort</p>
											</div>
										</div>
											
									</div>

									<div class="panel panel-mint panel-colorful" onclick="insertCode('binary_search');" style="margin-bottom: 0px;">
										<div class="pad-all media">
											<div class="media-left">
												<span class="icon-wrap icon-wrap-xs">
													<i class="fa fa-users fa-2x"></i>
												</span>
											</div>
											<div class="media-body">
												<p class="h4 text-thin media-heading">Binary Search</p>
											</div>
										</div>
											
									</div>

									<div class="panel panel-warning panel-colorful" onclick="insertCode('linear_search');" style="margin-bottom: 0px;">
										<div class="pad-all media">
											<div class="media-left">
												<span class="icon-wrap icon-wrap-xs">
													<i class="fa fa-users fa-2x"></i>
												</span>
											</div>
											<div class="media-body">
												<p class="h4 text-thin media-heading">Linear Search</p>
											</div>
										</div>
									</div>


									<div class="panel panel-purple panel-colorful" onclick="insertCode('generate_iterative_code');" style="margin-bottom: 0px;">
										<div class="pad-all media">
											<div class="media-left">
												<span class="icon-wrap icon-wrap-xs">
													<i class="fa fa-users fa-2x"></i>
												</span>
											</div>
											<div class="media-body">
												<p class="h4 text-thin media-heading">Generate Iterative Code</p>
											</div>
										</div>
											
									</div>

								</div>
							</div>

						</div>
					</div>

					<div class="row" style="margin-top : 65px;">
						<div class="col-lg-4 col-md-4 ">
							<div class="panel">
								<div class="panel-heading panel-heading panel panel-dark panel-colorful">
									<h3 class="panel-title">Graph Nodes</h3>
								</div>
								<div class="panel-body">
				
									<?php 

										foreach ($newCodeArray as $key => $value) {
											echo $key. " : ". $value. "<br/>";
										}
									?>
								</div>
							</div>
						</div>

						<div class="col-lg-8 col-md-8 ">

							<div class="panel">
								<div class="panel-heading panel-heading panel panel-dark panel-colorful">
									<h3 class="panel-title">Formed Graph</h3>
									<h4 class="panel-title panel-success panel-colorful">Node Complaxity by standard approch: <?= $nodeComplaxity ?></h4>
								</div>
								<div class="panel-body">
				
									<div id="cy"></div>								
								</div>
							</div>
						</div>
					</div>

					<div class="row" style="margin-top : 65px;">
						<div class="col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1">

							<div class="panel">
								<div class="panel-heading panel panel-dark panel-colorful">
									<h3 class="panel-title">Formed Subgraph</h3>
									<h4 class="panel-title panel-success panel-colorful" >Node Complaxity by standard approch: <?= $nodeComplaxity ?></h4>
								</div>
								<div class="panel-body">
				
									<div id="subGraphs"></div>								
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
		  

		  elements: <?= $jsonEcho    ?>,

		  layout: {
		    name: 'breadthfirst',
		    directed: true,
		    roots: '#0',
		    padding: 5
		  },

		  ready: function(){
		    window.cy = this;

		    var dijkstra = cy.elements().dijkstra('#0',function(){
		      return this.data('weight');
		    },false);

		    var bfs = dijkstra.pathTo( cy.$('#22') );
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

		$(function(){ // on dom ready

		$('#subGraphs').cytoscape({
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
		  

		  elements: <?= $subjsonEcho    ?>,

		  layout: {
		    name: 'breadthfirst',
		    directed: true,
		    roots: '#0',
		    padding: 5
		  },

		  ready: function(){
		    window.cy = this;

		    var dijkstra = cy.elements().dijkstra('#0',function(){
		      return this.data('weight');
		    },false);

		    var bfs = dijkstra.pathTo( cy.$('#22') );
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
