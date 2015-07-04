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
    },

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
