var names = ["DR. Jay", "Dr Jhay", "DR. Kja"];
var charToRemove1 = ["DR. ", "Dr ", "DR. "];

for (let i = 0; i < charToRemove1.length - 1; i++) {
names = names.map(name => name.replace(charToRemove1[i],""));
    
}


console.log(names);