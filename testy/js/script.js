const start_btn = document.querySelector(".start_btn button");
const info_box = document.querySelector(".info_box");
const exit_btn = info_box.querySelector(".buttons .quit");
const continue_btn = info_box.querySelector(".buttons .restart");
const quiz_box = document.querySelector(".quiz_box");
const result_box = document.querySelector(".result_box");
const option_list = document.querySelector(".option_list");
const time_line = document.querySelector("header .time_line");
const timeText = document.querySelector(".timer .time_left_txt");
const timeCount = document.querySelector(".timer .timer_sec");


var answer;
var questions = [];
var allAnswers = [];

function shuffle(a) {
    var j, x, i;
    for (i = a.length - 1; i > 0; i--) {
        j = Math.floor(Math.random() * (i + 1));
        x = a[i];
        a[i] = a[j];
        a[j] = x;
    }
    return a;
}

var ajax=new XMLHttpRequest();
    var method="GET";
    var test = new URLSearchParams(window.location.search).get('test');
    var url="./js/data.php?test="+test;
    var asynchronous=true;
    ajax.open(method,url,asynchronous);
    ajax.send();
    ajax.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            var data = JSON.parse(this.responseText);
            shuffle(data);
            for (var a = 0; a < data.length; a++) {
                var list = data[a];
                var test_no = list.test_no;
                var otazky = {      
                  numb: a+1,
                  question: list.question,
                  answer: list.spravnaOdpoved,
                  options: [
                    list.opt1,
                    list.opt2,
                    list.opt3,
                    list.opt4
                  ]};
                questions.push(otazky);
                }
        return questions;
        }
    };

// if startQuiz button clicked
start_btn.onclick = ()=>{
    info_box.classList.add("activeInfo"); //show info box
};

// if exitQuiz button clicked
exit_btn.onclick = ()=>{
    info_box.classList.remove("activeInfo"); //hide info box
};

// if continueQuiz button clicked
continue_btn.onclick = ()=>{
    info_box.classList.remove("activeInfo"); //hide info box
    quiz_box.classList.add("activeQuiz"); //show quiz box
    showQuetions(0); //calling showQestions function
    queCounter(1); //passing 1 parameter to queCounter
    startTimer(45); //calling startTimer function
    startTimerLine(0); //calling startTimerLine function
};

let timeValue =  45;
let que_count = 0;
let que_numb = 1;
let userScore = 0;
let counter;
let counterLine;
let widthValue = 0;

const restart_quiz = result_box.querySelector(".buttons .restart");
const quit_quiz = result_box.querySelector(".buttons .quit");

// if restartQuiz button clicked
restart_quiz.onclick = ()=>{
    quiz_box.classList.add("activeQuiz"); //show quiz box
    result_box.classList.remove("activeResult"); //hide result box
    timeValue = 45;
    que_count = 0;
    que_numb = 1;
    userScore = 0;
    widthValue = 0;
    allAnswers = [];
    showQuetions(que_count); //calling showQestions function
    queCounter(que_numb); //passing que_numb value to queCounter
    clearInterval(counter); //clear counter
    clearInterval(counterLine); //clear counterLine
    startTimer(timeValue); //calling startTimer function
    startTimerLine(widthValue); //calling startTimerLine function
    timeText.textContent = "Zostávajúci čas"; //change the text of timeText to Time Left
    next_btn.classList.remove("show"); //hide the next button
};

// if quitQuiz button clicked
quit_quiz.onclick = ()=>{
    window.location.reload(); //reload the current window
};

const next_btn = document.querySelector("footer .next_btn");
const bottom_ques_counter = document.querySelector("footer .total_que");

// if Next Que button clicked
next_btn.onclick = ()=>{
    let userAns = answer.textContent; //getting user selected option
    let correcAns = questions[que_count].answer; //getting correct answer from array
    allAnswers.push(userAns);
    if(userAns == correcAns){ //if user selected option is equal to array's correct answer
        userScore += 1; //upgrading score value with 1
    }
    if(que_count < questions.length -1){ //if question count is less than total question length
        que_count++; //increment the que_count value
        que_numb++; //increment the que_numb value
        showQuetions(que_count); //calling showQestions function
        queCounter(que_numb); //passing que_numb value to queCounter
        clearInterval(counter); //clear counter
        clearInterval(counterLine); //clear counterLine
        startTimer(timeValue); //calling startTimer function
        startTimerLine(widthValue); //calling startTimerLine function
        timeText.textContent = "Zostavajúci čas"; //change the timeText to Time Left
        next_btn.classList.remove("show"); //hide the next button
        }else{
            clearInterval(counter); //clear counter
            clearInterval(counterLine); //clear counterLine
            showResult(); //calling showResult function
           
        }
};

//answers dropdown list toggle
function showAnswers() {
    document.querySelector(".answersList").classList.add("show");
    document.querySelector('.popup').innerHTML = `<h2>Odpovede <i class="fas fa-times" onclick="hideAnswers()"></i></h2>`;
    for (let i = 0; i < questions.length; i++) {
        var x = document.createElement('div');
        x.classList.add("question");
        var question = questions[i];
        var userAnswer = allAnswers[i];
        //var indexOfCorrectAns = question['options'].indexOf(question['answer']);
        var isCorrectAnswer = userAnswer === question['answer'];
        var score = isCorrectAnswer ? 1 : 0;
        x.innerHTML = `<h4>`+question['question']+`<span> Body: `+score+`/1</span></h4>
                        <p class="${userAnswer === question['options'][0] ? 'selectedAns ' : ''} ${userAnswer && userAnswer !== question['answer'] && userAnswer === question['options'][0] ? 'wrongAns showTimes ' : ''} ${isCorrectAnswer && userAnswer === question['options'][0] ? 'correctAns showTick ' : ''}">`+question['options'][0]+`<i class="fas fa-check"></i><i class="fas fa-times"></i></p>
                        <p class="${userAnswer === question['options'][1] ? 'selectedAns ' : ''} ${userAnswer && userAnswer !== question['answer'] && userAnswer === question['options'][1] ? 'wrongAns showTimes ' : ''} ${isCorrectAnswer && userAnswer === question['options'][1] ? 'correctAns showTick ' : ''}">`+question['options'][1]+`<i class="fas fa-check"></i><i class="fas fa-times"></i></p>
                        <p class="${userAnswer === question['options'][2] ? 'selectedAns ' : ''} ${userAnswer && userAnswer !== question['answer'] && userAnswer === question['options'][2] ? 'wrongAns showTimes ' : ''} ${isCorrectAnswer && userAnswer === question['options'][2] ? 'correctAns showTick ' : ''}">`+question['options'][2]+`<i class="fas fa-check"></i><i class="fas fa-times"></i></p>
                        <p class="${userAnswer === question['options'][3] ? 'selectedAns ' : ''} ${userAnswer && userAnswer !== question['answer'] && userAnswer === question['options'][3] ? 'wrongAns showTimes ' : ''} ${isCorrectAnswer && userAnswer === question['options'][3] ? 'correctAns showTick ' : ''}">`+question['options'][3]+`<i class="fas fa-check"></i><i class="fas fa-times"></i></p>
                        <hr>`;
        document.querySelector(".popup").appendChild(x);        
    }
}

function hideAnswers() {
    document.querySelector(".answersList").classList.remove("show");
}

// getting questions and options from array
function showQuetions(index){
    const que_text = document.querySelector(".que_text");
    //creating a new span and div tag for question and option and passing the value using array index
    let que_tag = '<span>'+ questions[index].numb + ". " + questions[index].question +'</span>';
    shuffle(questions[index].options);
    let option_tag = '<div class="option"><span>'+ questions[index].options[0] +'</span></div>'
    + '<div class="option"><span>'+ questions[index].options[1] +'</span></div>'
    + '<div class="option"><span>'+ questions[index].options[2] +'</span></div>'
    + '<div class="option"><span>'+ questions[index].options[3] +'</span></div>';
    que_text.innerHTML = que_tag; //adding new span tag inside que_tag
    option_list.innerHTML = option_tag; //adding new div tag inside option_tag
    
    const option = option_list.querySelectorAll(".option");

    // set onclick attribute to all available options
    for(i=0; i < option.length; i++){
        option[i].setAttribute("onclick", "optionSelected(this)");
    }
}
// creating the new div tags which for icons
let tickIconTag = '<div class="icon tick"><i class="fas fa-check"></i></div>';
let crossIconTag = '<div class="icon cross"><i class="fas fa-times"></i></div>';

//if user clicked on option
function optionSelected(ans){
    answer = ans;
    let selectedInputs = document.querySelector('.option_list .selected');
    if(selectedInputs !== null) {
        selectedInputs.classList.remove("selected");
    }
    answer.classList.add("selected"); //adding class selected
    next_btn.classList.add("show"); //show the next button if user selected any option
}

function showResult(){
    info_box.classList.remove("activeInfo"); //hide info box
    quiz_box.classList.remove("activeQuiz"); //hide quiz box
    result_box.classList.add("activeResult"); //show result box
    const scoreText = result_box.querySelector(".score_text");
    const scoreTextPER = result_box.querySelector(".score_textPER");
    let per = Math.round((userScore/que_numb)*100,1);

    if (userScore>12 && userScore ==15){ // ak je tvoje skore medzi 12-15 -1
        let scoreTag = '<span>Vidno že sa učíš, máš <strong> &ensp;'+ userScore +'&ensp; </strong> bodov z <strong> &ensp;'+ questions.length +'&ensp; </strong> bodov </span>';
        scoreText.innerHTML = scoreTag;
        let percenta = '<span>Z testu si dosiahol <strong> &ensp;'+ per +'&ensp; </strong>%</span>';
        scoreTextPER.innerHTML = percenta;
    }
    else if (userScore>8 && userScore <=12){// ak je tvoje skore medzi 9-12 -2

        let scoreTag = '<span>Je tam priestor na zlepšenie, máš <strong> &ensp;'+ userScore +'&ensp; </strong> bodov z <strong> &ensp;'+ questions.length +'&ensp; </strong> bodov </span>';
        scoreText.innerHTML = scoreTag;
        let percenta = '<span>Z testu si dosiahol <strong> &ensp;'+ per +'&ensp; </strong>%</span>';
        scoreTextPER.innerHTML = percenta;
    }
    else if (userScore>5 && userScore <=8){// ak je tvoje skore medzi 5-8 -3

        let scoreTag = '<span>Musíš ešte zabrať na tom, máš <strong> &ensp;'+ userScore +'&ensp; </strong> bodov z <strong> &ensp;'+ questions.length +'&ensp; </strong> bodov </span>';
        scoreText.innerHTML = scoreTag;
        let percenta = '<span>Z testu si dosiahol <strong> &ensp;'+ per +'&ensp; </strong>%</span>';
        scoreTextPER.innerHTML = percenta;
    }
    else if (userScore>3 && userScore <=5){// ak je tvoje skore medzi 3-5 -4

        let scoreTag = '<span>Treba dávať pozor na hodinách, máš <strong>  &ensp;'+ userScore +'&ensp;  </strong> bodov z <strong> &ensp;'+ questions.length +'&ensp; </strong> bodov </span>';
        scoreText.innerHTML = scoreTag;
        let percenta = '<span>Z testu si dosiahol <strong> &ensp;'+ per +'&ensp; </strong>%</span>';
        scoreTextPER.innerHTML = percenta;
    }
    else if (userScore<=3){// ak je tvoje skore medzi 0-3 -5
        
        let scoreTag = '<span>Si vôbec slovák? máš <strong> &ensp;'+ userScore +'&ensp; </strong> bodov z <strong> &ensp;'+ questions.length +'&ensp; </strong> bodov </span>';
        scoreText.innerHTML = scoreTag;
        let percenta = '<span>Z testu si dosiahol <strong> &ensp;'+ per +'&ensp; </strong>%</span>';
        scoreTextPER.innerHTML = percenta;
    } 
    // var percento = {};
    // percento.asd = per; 
    // percento.test = new URLSearchParams(window.location.search).get('test');
    // $.ajax({
    //     url:"percenta.php?test="+test,
    //     method: "get",
    //     data: percento,
    //     success: function(data) {
    //         return data; 
    //     }
    // })    
};



function startTimer(time){
    counter = setInterval(timer, 1000);
    function timer(){
        timeCount.textContent = time; //changing the value of timeCount with time value
        time--; //decrement the time value
        if(time < 9){ //if timer is less than 9
            let addZero = timeCount.textContent; 
            timeCount.textContent = "0" + addZero; //add a 0 before time value
        }
        if(time < 0){ //if timer is less than 0
            clearInterval(counter); //clear counter
            timeText.textContent = "Čas skončil!"; //change the time text to time off
            const allOptions = option_list.children.length; //getting all option items
            let correcAns = questions[que_count].answer; //getting correct answer from array
            for(i=0; i < allOptions; i++){
                if(option_list.children[i].textContent == correcAns){ //if there is an option which is matched to an array answer
                    option_list.children[i].setAttribute("class", "option correct"); //adding green color to matched option
                    option_list.children[i].insertAdjacentHTML("beforeend", tickIconTag); //adding tick icon to matched option
                    console.log("Time Off: Auto selected correct answer.");
                }
            }
            for(i=0; i < allOptions; i++){
                option_list.children[i].classList.add("disabled"); //once user select an option then disabled all options
            }
            next_btn.classList.add("show"); //show the next button if user selected any option
        }
    }
}

function startTimerLine(time){
    counterLine = setInterval(timer, 29);
    function timer(){
        time += 1; //upgrading time value with 1
        if(time > 549){ //if time value is greater than 549
            clearInterval(counterLine); //clear counterLine
        }
    }
}

function queCounter(index){
    //creating a new span tag and passing the question number and total question
    let totalQueCounTag = '<span><p>'+ index +'</p> z <p>'+ questions.length +'</p> otázok</span>';
    bottom_ques_counter.innerHTML = totalQueCounTag;  //adding new span tag inside bottom_ques_counter
}
