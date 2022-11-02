var date_type = 'numeric';

function change_date_type() {
    date_type = (date_type == 'numeric') ? 'verbal' : 'numeric';
    gettheDate();
}

function gettheDate() {
    if (date_type === 'numeric') {
        Todays = new Date();
        TheDate = "" + Todays.getDate() + "." + (Todays.getMonth() + 1) + "." + (Todays.getFullYear());
        document.getElementById("data").innerHTML = TheDate;
    }
    else {
        Todays = new Date();
        Todays = Todays.toDateString().split(' ');
        TheDate = Todays[2] + ' ' + Todays[1] + ' ' + Todays[3];
        document.getElementById("data").innerHTML = TheDate;
    }
}

var timerID = null;
var timerRunning = false;

function stopclock() {
    if(timerRunning) {
        clearTimeout(timerID);
    }
    timerRunning = false;
}

function startclock() {
    stopclock();
    gettheDate();
    showtime();
}

var time_type = 24;

function change_time_type() {
    time_type = (time_type == 12) ? 24 : 12;
    showtime();
}


function showtime() {
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var seconds = now.getSeconds();

    if (time_type == 12) {
        var timeValue = "" + ((hours > 12) ? hours - 12 : hours);
        timeValue += ((minutes < 10) ? ":0" : ":") + minutes;
        timeValue += ((seconds < 10) ? ":0" : ":") + seconds;
        timeValue += (hours >= 12) ? " PM" : " AM";
    }
    else {
        var timeValue = "" + hours;
        timeValue += ((minutes < 10) ? ":0" : ":") + minutes;
        timeValue += ((seconds < 10) ? ":0" : ":") + seconds;
    }

    document.getElementById("zegarek").innerHTML = timeValue;
    timerID = setTimeout("showtime()", 1000);
    timerRunning = true;
}