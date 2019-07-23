function getRandomNumber( lower, upper){
    if ( isNaN(lower) || isNaN(upper)) {
       throw new Error('Both Arguments should be numbers');
    }

    return Math.floor(Math.random() * (upper - lower + 1) ) + lower;
}



function colorPicker(v){
  if( v <= 20){
    return "#D1D7E8";
  }else if (v > 20 && v <= 45) {
    return "#ff0033";
  }else if(v > 45 && v <= 60){
    return "#E6CAF1";
  }else if(v > 60 && v <= 120){
    return "#FFFFE6";
  }else if(v > 120 && v <= 200){
    return "#FFFFE6";
  }
}

console.log(getRandomNumber(1,5));
// console.log(getRandomNumber('none','1'));
console.log(colorPicker(30));
console.log(colorPicker(70));
console.log(colorPicker(130));
console.log(colorPicker(50));
