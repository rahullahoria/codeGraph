<?php
	if (isset($_POST['submit'])) {
		if (empty($_POST["text_form"])) {
	     $nameErr = "Code is required";
	    } 
	    else {
	     $code_text = $_POST["text_form"];
		}
	}

	echo $code_text;


	$toDrawGraph = array( 
						array(1,4),
						array(2,8),
						array(7,5),
						array(1,4),
						array(2,8),
						array(4,6),
						array(3,5),
						array(1,2)
					);

//$output = array();
//(array("nodes"), array("edges")

$nodesArray = array();
$edgesArray = array();
foreach($toDrawGraph as $node => $edges) {
  
	$nodesArray[] = array("data" => array("id" => $node));
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

echo json_encode($jsonArray) ."\n";

/*echo ($edgesjson) ."\n";




$elements = array($nodesjson,
					$edgesjson
				);

echo json_encode($elements);
*/
/*
elements: {
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
		    },*/
?>

