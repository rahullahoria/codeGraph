<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Graph Splitter | Regression Testing</title>


	<!--STYLESHEET-->
	<!--=================================================-->

	<!--Bootstrap Stylesheet [ REQUIRED ]-->
	<link href="v2.2/css/bootstrap.min.css" rel="stylesheet">


	<!--Nifty Stylesheet [ REQUIRED ]-->
	<link href="v2.2/css/nifty.min.css" rel="stylesheet">

	<!--Demo [ DEMONSTRATION ]-->
	<link href="v2.2/css/demo/nifty-demo.min.css" rel="stylesheet">


	<!--SCRIPT-->
	<!--=================================================-->

	<!--Page Load Progress Bar [ OPTIONAL ]-->
	<link href="v2.2/plugins/pace/pace.min.css" rel="stylesheet">
	<script src="v2.2/plugins/pace/pace.min.js"></script>


	
	<!--

	REQUIRED
	You must include this in your project.

	RECOMMENDED
	This category must be included but you may modify which plugins or components which should be included in your project.

	OPTIONAL
	Optional plugins. You may choose whether to include it in your project or not.

	DEMONSTRATION
	This is to be removed, used for demonstration purposes only. This category must not be included in your project.

	SAMPLE
	Some script samples which explain how to initialize plugins or components. This category should not be included in your project.


	Detailed information and more samples can be found in the document.

	-->
		

</head>

<!--TIPS-->
<!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->

<body>
	<div id="container" class="effect mainnav-lg">
		
		<!--NAVBAR-->
		<!--===================================================-->
		<header id="navbar">
			<div id="navbar-container">

				<!--Brand logo & name-->
				<!--================================-->
				<div class="navbar-header">
					<a href="#" class="navbar-brand">
						
						<div class="brand-title">
							<span class="brand-text">Graph Splitter</span>
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

		<div class="boxed">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div id="">
				
				<!--Page Title-->
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<div id="page-title">
					<h1 class="page-header text-overflow">Write down code</h1>

				</div>
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<!--End page title-->

				<!--Page content-->
				<!--===================================================-->
				
					
					<div class="row">
						<div class="col-lg-5 col-md-5 col-lg-offset-1 col-md-offset-1">
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Code Text Area</h3>
								</div>
					
								<!--No Label Form-->
								<!--===================================================-->
								<form class="form-horizontal" method="POST">
									<div class="panel-body">
										
										<textarea placeholder="Enter your code" name = "text_form" rows="22" class="form-control">
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
							<div class="panel" style="min-height: 555px;">
								<div class="panel-heading">
									<h3 class="panel-title">Formed Graph</h3>
								</div>
								<div class="panel-body">
				
									
								</div>
							</div>
						</div>
					</div>

				<!--===================================================-->
				<!--End page content-->


			</div>
			<!--===================================================-->
			<!--END CONTENT CONTAINER-->

		</div>

		

		<!-- FOOTER -->
		


		<!-- SCROLL TOP BUTTON -->
		<!--===================================================-->
		<button id="scroll-top" class="btn"><i class="fa fa-chevron-up"></i></button>
		<!--===================================================-->



	</div>
	<!--===================================================-->
	<!-- END OF CONTAINER -->

	
	<!--JAVASCRIPT-->
	<!--=================================================-->

	<!--jQuery [ REQUIRED ]-->
	<script src="v2.2/js/jquery-2.1.1.min.js"></script>


	<!--BootstrapJS [ RECOMMENDED ]-->
	<script src="v2.2/js/bootstrap.min.js"></script>

	
	<!--Nifty Admin [ RECOMMENDED ]-->
	<script src="v2.2/js/nifty.min.js"></script>


	<!--Demo script [ DEMONSTRATION ]-->
	<script src="v2.2/js/demo/nifty-demo.min.js"></script>


	<!--Form Component [ SAMPLE ]-->
	<script src="v2.2/js/demo/form-component.js"></script>

	
	<!--

	REQUIRED
	You must include this in your project.

	RECOMMENDED
	This category must be included but you may modify which plugins or components which should be included in your project.

	OPTIONAL
	Optional plugins. You may choose whether to include it in your project or not.

	DEMONSTRATION
	This is to be removed, used for demonstration purposes only. This category must not be included in your project.

	SAMPLE
	Some script samples which explain how to initialize plugins or components. This category should not be included in your project.


	Detailed information and more samples can be found in the document.

	-->
		
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