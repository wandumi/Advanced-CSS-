var profile = {
   name: 'wandumi',
   age: 35,
   country: 'Malawian',
   selftaught: true,
   skills: ['Php','Javascript','html','css','jquery','ajax']
};

function print( message ){
  var printout = document.getElementById('output');
  printout.innerHTML = message;
}

for (var key in profile) {
  console.log(key,':', profile[key]);
  if (profile.hasOwnProperty(key)) {

  }
}

var html = "My name is " + profile.name + " age " + profile.age + " and am a "+
profile.country +  " . Am a self taught Programmer in "+ profile.skills.length+" Skills, which are "+
profile.skills.join(',' );

print(html);
