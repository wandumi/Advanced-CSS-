const myHeading = document.getElementById("program");
const myButton = document.getElementById('myButton');

const myTextOne = document.getElementById('myOne');
const myTextInput = document.getElementById('myInput');

myButton.addEventListener ( 'click', () => {
    myHeading.style.color = myTextInput.value;
});

const myList = document.getElementsByTagName('li');

for (var i = 0; i < myList.length; i++) {
  // mylist[i].style.color = myOne.value;
  myList[i].style.color = 'blue';
}

const myClass = document.getElementsByClassName('unique');

for (var i = 0; i < myClass.length; i++) {
  // myClass[i].style.color = myTextInput.value;
  myClass[i].style.color = 'red';
}
