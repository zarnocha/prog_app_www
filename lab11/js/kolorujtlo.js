var computed = false;
var decimal = 0;

function convert(entryform, from, to) {
    convertfrom = from.selectedIndex;
    convertto = to.selectedIndex;
    entryform.display.value = (entryform.input.value * from[convertfrom].value / to[convertto].value);
}

function addChar(input, character) {
    if ((character=='.' && decimal=="0") || character !='.') {
        (input.value == "" || input.value == "0") ? input.value = character : input.value += character
        convert(input.form.input.form.measure1, input.form.measure2)
        computed = true;
        if (character=='.') {
            decimal = 1;
        }
    }

}

function wyczysc_inputy(form) {
    inputs = form;
    for (let i = 0; i < inputs.length; ++i) {
        inputs[i].value = '';
    }
}


function openVothcom() {
    var left = (screen.width/2) - 100;
    var top = (screen.height/2) - 300;
    var new_window = window.open("", "Display window", "toolbar=no,directories=no,menubar=no,width=100,height=300,top=" + top + ",left=" + left);
    new_window.document.write("<center><h1>Autor:</h1><br><h2>Artur Żarnoch</h2><br><h3>Nr indeksu: 162686</center>");
}


function changeBackground() {
    var color1 = Math.floor(Math.random() * 100);
    var color2 = Math.floor(Math.random() * 100);
    var color3 = Math.floor(Math.random() * 100);

    document.body.style.background = 'rgba(' + color1 + ',' + color2 + ', ' + color3 + ')';
}
