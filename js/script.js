// javascript

//Force les champs a ne pas contenir de chiffres
function lettersOnly(input) {
    var regex = /[^a-z]/gi;
    input.value = input.value.replace(regex,"");
}