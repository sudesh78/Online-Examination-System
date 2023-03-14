

const questionNumber = document.querySelector(".question-number");
const questionText = document.querySelector(".question-text");
const optionContainer = document.querySelector(".option-container");
const answersIndicatorContainer = document.querySelector(".answers-indicator");
const homeBox = document.querySelector(".home-box");
const quizBox = document.querySelector(".quiz-box");
const resultBox = document.querySelector(".result-box");


let questionCounter = 0;
let currentQuestion;
let availableQuestions = [];
let availableQuestions1 = [];
let availableOptions = [];
let questionorder =[];
var selected = {};
var select = Array();
// var selected = Array();
let correctAnswers = 0;
let attempt = 0;
let quesindex;

function selectData(eid,stid){
    
    $.ajax({
        url: "viewExamServer.php",
        method: "POST",
        async: false,
        data: {
            'eid': eid,
            'stid':stid,
            action: 'selectdata'
        },
        success: function(data) {
            if(data == "blank"){
                console.log(select);
            }
            else{
                select = JSON.parse(data);
            }
        }
    })
}


function setAvailableQuestions(){
    const totalQuestion = quiz.length;
    for(let i=0;i<totalQuestion;i++)
    {
        console.log(select);
      
        if(select[i+1] != undefined){
            selected[i+1] = select[i+1];
        }else{
            selected[i+1] = 0;
        }
        
        availableQuestions.push(quiz[i]);
        availableQuestions1.push(quiz[i]);
    }
}

function setQuestionOrder(){
    for(let i=0 ; i< quiz.length ; i++){
        const questionIndex1 = availableQuestions1[Math.floor(Math.random() * availableQuestions1.length)];
        const index1 = availableQuestions1.indexOf(questionIndex1);
        questionorder.push(questionIndex1.questionno);
        availableQuestions1.splice(index1,1);
    }
    

}


function getNewQuestion(quesno){
    questionNumber.innerHTML = "Question" + (questionorder.indexOf(quesno) + 1) + "of" + quiz.length;
    currentQuestion = quesno;
    questionText.innerHTML = quiz[currentQuestion-1].question;

    if(quiz[currentQuestion-1].hasOwnProperty("img")){
       const  img = document.createElement("img");
       img.src = quiz[currentQuestion-1].img;
       questionText.appendChild(img);
    
    }

    const optionLen = 4;
    optionContainer.innerHTML= '';
    let animationDelay = 0.15;

    for(let i=0;i<optionLen;i++){ 
        const option = document.createElement("div");
        if(i == 0){
            option.innerHTML = quiz[currentQuestion-1].option1;
        }
        if(i == 1){
            option.innerHTML = quiz[currentQuestion-1].option2;
        }
        if(i == 2){
            option.innerHTML = quiz[currentQuestion-1].option3;
        }
        if(i == 3){
            option.innerHTML = quiz[currentQuestion-1].option4;
        }
        
        option.id = i+1;
        if(selected[currentQuestion] == i+1)
        {
            option.className = "option select";
        }else{
            option.className = "option";
        }
        option.style.animationDelay = animationDelay + 's';
        animationDelay = animationDelay + 0.15;
        
        optionContainer.appendChild(option);
        option.setAttribute("onclick","getResult(this)");
    }
}

// get the result of current attempt question

function getResult(element){
    const id = parseInt(element.id);
    var ss = quiz.length;
    // get the answer by comparing the id of clicked option
    if(selected[currentQuestion] == id){
        document.getElementById(selected[currentQuestion]).classList.remove("select");
        selected[currentQuestion] = 0;
        updateAnswersIndicator("notselected");
        attempt--;
    }
    else
    if(selected[currentQuestion] != 0){
        document.getElementById(selected[currentQuestion]).classList.remove("select");
        selected[currentQuestion] = id;
        element.classList.add("select");
        updateAnswersIndicator("select");
        insertData(eid,stid,quiz.length,currentQuestion,id);
        attempt++;
    }
    else{
        insertData(eid,stid,quiz.length,currentQuestion,id);
        selected[currentQuestion] = id;
        element.classList.add("select");
        updateAnswersIndicator("select");
        attempt++;
    }    
}
// make all the options unclickable

function answersIndicator(){
    answersIndicatorContainer.innerHTML = '';
    const totalQuestion = quiz.length;
    for(let i=0 ; i<totalQuestion;i++){
        const indicator = document.createElement("div");
        indicator.setAttribute("id",i+1);
        indicator.innerHTML = i+1;
        answersIndicatorContainer.appendChild(indicator);
        if(selected[questionorder[i]] != 0){
            answersIndicatorContainer.children[i].classList.add("select");
        }
        indicator.setAttribute("onclick","randques(this)");
    }
}

function updateAnswersIndicator(metadata){
    if(metadata === "select"){
        answersIndicatorContainer.children[questionorder.indexOf(currentQuestion)].classList.add("select");
    }
    else if(metadata === "notselected"){
        answersIndicatorContainer.children[questionorder.indexOf(currentQuestion)].classList.remove("select");
    }
}

function next()
{   
    console.log(" da",examtime);
    let nxtval = questionorder.indexOf(currentQuestion);
    let sum = nxtval+1;
    if((sum+1) == quiz.length+1){
        getNewQuestion(questionorder[0]);
    }
    else{
        getNewQuestion(questionorder[sum]);
    }
}

function previous(){
    let nxtval = questionorder.indexOf(currentQuestion);
    let sum = nxtval-1;
    if((sum) == -1){
        getNewQuestion(questionorder[quiz.length-1]);
    }
    else{
        getNewQuestion(questionorder[sum]);
    }
}

function randques(element){
    const id = parseInt(element.id);
    // get the answer by comparing the id of clicked option
    getNewQuestion(questionorder[id-1]);
}

function submit(){
    quizOver();
}

function quizOver()
{
    window.location = "./student.php?p=0";
}

 
// window.onload = function()
function startQuiz()
{
        selectData(eid,stid);
        
        homeBox.classList.add("hide");
        quizBox.classList.remove("hide");
        // first we set all questions in availableQuestion array
        setAvailableQuestions();

        setQuestionOrder();
        
        // Second we will call NewQuestion
        getNewQuestion(questionorder[0]);
        insertSelect(eid,stid,totalq);
        // to create indicator of answers
        answersIndicator();
}

window.onload = function(){
    homeBox.querySelector(".total-question").innerHTML = quiz.length;
}
