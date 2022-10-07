let datos = {};

let tuPartida = {
  nrespuestas: 0,
  respuestas: []
}

function jugar() {
  document.getElementById("navbar").style.display = "block";
  document.getElementById("count").style.display = "block";
  document.getElementById("form").style.display = "none";
  document.getElementById("titul").style.display = "block";

  let nPreguntas = parseInt(document.getElementById("pregunta").value); 
  
  fetch('../Back/getPreguntes.php?np='+nPreguntas)
        .then(response => response.json())
        .then(data => pregunta(data,nPreguntas));  
 }

function pregunta(data, nPreguntas) {
  datos = data;
  console.log(datos);
  let htmlStr = `<div class="container">`;
  for (let index = 0; index < nPreguntas; index++) {
    htmlStr += `<form class="quiz-form">  <div class="quiz-form__quiz"> <p id="quiz-form__question">${index + 1 + ". " + datos.questions[index].question}</p></div>`
    for (let j = 0; j < 4; j++) {
      htmlStr += `<label id="answerbutton" class="quiz-form__ans" onclick="selection(${index}, ${j}, ${nPreguntas})" > <span type="button" class="text" >${datos.questions[index].answers[j]}</span></label>`
    }
    htmlStr += `</form>`
  }
  htmlStr += `</div>`
  document.getElementById("listadoPreguntas").innerHTML = htmlStr;
}

function selection(pregunta, respuesta, nPreguntas) {
  if (tuPartida.respuestas[pregunta] == undefined) {
    tuPartida.nrespuestas++;
  }
  tuPartida.respuestas[pregunta] = respuesta;
  renderEstado(nPreguntas);
}

function checkanswer() {
  let formData = new FormData();
  formData.append('dades', JSON.stringify(tuPartida));
  
    fetch("../Back/valid.php", {
            method: "post",
            body: formData,  
        })
        .then((response) => response.json())
        .then((data) => mostrar(data));
}
function mostrar(data) {
  document.getElementById("listadoPreguntas").style.display = "none";
  document.getElementById("total").style.display = "block";
  document.getElementById("total").innerHTML=`<p>Has encertat: `+data +" / "+ tuPartida.nrespuestas+`</p>`;
}
function renderEstado(nPreguntas) {
  htmlCount = `<button class="submit1">${tuPartida.nrespuestas} / ${nPreguntas}</button>`;
  htmlStr = `<strong>Has Seleccionat</strong><br> <ul>`;
  for (let i = 0; i < tuPartida.respuestas.length; i++) {
    if (tuPartida.respuestas[i] != undefined) {
      htmlStr += `<p style="font-size: 16px; color:black">   ${i + 1}. ${datos.questions[i].question} --> <b> ${datos.questions[i].answers[tuPartida.respuestas[i]]} </b></p>`;
    }
  }
  htmlStr += "</ul>";

  if (tuPartida.nrespuestas == nPreguntas) {
    htmlStr += `<input class="submit" type="submit" value="Enviar" onclick="checkanswer()"/>`;
    
  }
  document.getElementById("navbar").innerHTML = htmlStr;
  document.getElementById("count").innerHTML = htmlCount;
}