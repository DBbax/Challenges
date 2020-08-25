
// function reverseString(string)
// {
//     var reversed = "";
//     for(i = string.length-1; i >= 0; i--) {
//         reversed += string.charAt(i);
//     }
//     return reversed;
// }

function reverseNumberBinary(number)
{
    var binary = Number(number).toString(2); // cast "number" to work with numeric strings too
    var reversedBinary = binary.split('').reverse().join(''); // or use reverseString(binary); instead
    return parseInt(reversedBinary, 2);
}

var reversed = reverseNumberBinary(13);
console.log(reversed);


// to see the output run in terminal: "node reverse_binary.js"
