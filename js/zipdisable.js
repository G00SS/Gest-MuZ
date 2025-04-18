//##############################################################################
//# @Name : zipdisable.js
//# @Description : Désactivation des champs textuels si un code postal est entré
//# @Call : vis-indiv.php ou vis-grp.php ou edit-indiv.php ou edit-grp.php
//# @Parameters : 
//# @Author : G0osS
//# @Create : 31/01/2024
//# @Update : 15/04/2025
//# @Version : 2.0.0
//##############################################################################


const form = document.querySelector('form');

function disableInputs(exception) {
  for (const input of form.elements) {
    if (input !== exception) {
      if ((input.name === 'pays') || (input.name === 'dept')) {
        input.disabled = true;
      }
    }
  }
}

function enableInputs() {
  for (const input of form.elements) {
    input.disabled = false;
  }
}

form.addEventListener('input', event => {
  const { target } = event;

  if (
    (target.type === 'number' && target.name === "zip" && target.value !== '')
  ) {
    disableInputs(target);
  } else {
    enableInputs();
  }
});