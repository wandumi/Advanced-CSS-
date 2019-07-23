var malawi = [
   { question:'how many districts does Malawi have?',answer:36},
   { question:'How many Cities Does the country has?',answer:4},
   { question:'How many District surrounds Lake Malawi?',answer: 7}
];

var correctAnswer = 0;
var question;
var answer;
var response;
var correct = [];
var wrong = [];

function print( message ){
  var printout = document.getElementById('output');
  printout.innerHTML = message;
}

function buildLIST ( arr ){
  var listHTML = '<ol>';
  for (var i = 0; i < arr.length; i++) {
    listHTML += '<li>' + arr[i] + '</li>';
  }
  listHTML += '</ol>';
  return listHTML;
}

for (var i = 0; i < malawi.length; i++) {
     question = malawi[i].question;
     answer = malawi[i].answer;
     response = parseInt(prompt(question));

     if ( response === answer ) {
        correctAnswer += 1;
        correct.push(question);
     }else{
        wrong.push(question);
     }
}

// html = "You have got " + correctAnswer + " questions corrently";
html = "You have the following Questions Correct";
html += buildLIST(correct);
html += "You have the following Questions Wrong";
html += buildLIST(wrong);

print(html);
