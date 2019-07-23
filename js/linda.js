var myStyles = [
  {
    width: 80,
    color: "yellow"
  },
  {
    width: 250,
    color: "green"
  },
  {
    width: 180,
    color: "black"
  },
  {
    width: 200,
    color: "blue"
  }
];

var work = d3.selectAll(".item")
  .data(myStyles)
  .styles({
    'color':'white',
    // loop through the data passed above
    'background': function(d){
      return d.color;
    },
    width: function(d){
      return d.width + 'px';
    }
  });
