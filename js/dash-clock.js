//##############################################################################
//# @Name : dash-clock.js
//# @Description : Script javascript pour l'horloge du dashboard
//# @Call : dash.php
//# @Parameters : 
//# @Author : G0osS
//# @Create : 31/01/2024
//# @Update : 15/04/2025
//# @Version : 2.0.0
//##############################################################################


"use strict";

let textElem = document.getElementById("clocktext");
const targetWidth = 0.9;  // Proportion of full screen width
let curFontSize = 20;  // Do not change

function updateClock() {
  const d = new Date();
  let s = "";
  s += (10 > d.getHours  () ? "0" : "") + d.getHours  () + ":";
  s += (10 > d.getMinutes() ? "0" : "") + d.getMinutes();
  textElem.textContent = s;
  setTimeout(updateClock, 60000 - d.getTime() % 60000 + 100);
}

function updateTextSize() {
  for (let i = 0; 3 > i; i++) {  // Iterate for better better convergence
    curFontSize *= targetWidth / (textElem.offsetWidth / textElem.parentNode.offsetWidth);
    textElem.style.fontSize = curFontSize + "pt";
  }
}

updateClock();
updateTextSize();
window.addEventListener("resize", updateTextSize);