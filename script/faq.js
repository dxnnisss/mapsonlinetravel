function active() {
    let length = document.getElementsByClassName('answer').length;
    for (i = 0; i < length; i++) {
        var element = document.getElementsByClassName('question')[i];
        var answer = document.getElementsByClassName('answer')[i];
        if (element.className == 'question') {
            element.className += ' questionActive';
            answer.style.maxHeight = 'none';
            answer.style.padding = '30px';
        }
        else {
            element.className = 'question';
            answer.style.maxHeight = '0';
            answer.style.padding = '0 30px 0 30px';
        }
    }
}

function active(no) {
    var element = document.getElementsByClassName('question')[no];
    var answer = document.getElementsByClassName('answer')[no];
    if (element.className == 'question') {
        element.className += ' questionActive';
        answer.style.maxHeight = 'none';
        answer.style.padding = '30px';
    }
    else {
        element.className = 'question';
        answer.style.maxHeight = '0';
        answer.style.padding = '0 30px 0 30px';
    }
}
