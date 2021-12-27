let destination = ['Batu Caves', 'George Town', 'Ipoh', 'Langkawi', 'Melaka', 'Semporna', 'Cameron Highlands', 'Sekinchan'];

for (i = 0; i < 8; i++) {
    var element = destination[i].toLowerCase().replace(' ', '');
    document.getElementById(element).style.backgroundImage = "url(images/destination/" + element + ".jpg)";
}


// change greetings in motd
// const today initialized in master.js
var time = today.getHours();
var quote = ['Good Morning!', 'Good Afternoon!', 'Good Evening!', 'Good Night!'];

if (6 <= time && time < 12) {
    document.getElementById("motdGreeting").innerHTML = quote[0];
}
else if (12 <= time && time < 17) {
    document.getElementById("motdGreeting").innerHTML = quote[1];
}
else if (17 <= time && time < 22) {
    document.getElementById("motdGreeting").innerHTML = quote[2];
}
else {
    document.getElementById("motdGreeting").innerHTML = quote[3];
}

// Random Integer Generator
// Math.random always returns value < 1
// parameter max is excluded
function randint(min, max) {
    return Math.floor(Math.random() * (max - min)) + min;
}

// generate random quotes and picture in motd
let quoteList = [
    '“A journey of a thousand miles begins with a single step.” – Lao Tzu', 
    '“Do not follow where the path may lead but go where there is no path and leave a trail.” – Ralph Waldo Emerson',
    '“Man cannot discover new oceans unless he has the courage to lose sight of the shore.” – Andre Gide',
    '“Traveling – it leaves you speechless, then turns you into a storyteller.” – Ibn Battuta',
    '“Oh the places you’ll go.” – Dr. Seuss',
    '“Wherever you go becomes a part of you somehow.” – Anita Desai', 
    '“Take only memories, leave only footprints.” – Chief Seattle', 
    '“Traveling allows you to become so many different versions of yourself.” – Unknown'];

function ranMOTD() {
    var i = randint(0, 8)
    var photoName = destination[i].toLocaleLowerCase().replace(' ', '');
    document.getElementById('motdCover').style.backgroundImage = 'url(images/destination/' + photoName +'.jpg';
    document.getElementById('motdMsg').innerHTML = quoteList[i];
}

document.onload = ranMOTD();

// when a function name is written with parenthesis --> (), its actually calling the function to run
setInterval(ranMOTD, 10000);
