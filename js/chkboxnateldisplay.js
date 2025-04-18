//##############################################################################
//# @Name : chkboxnateldisplay.js
//# @Description : Script de gestion des checkbox
//# @Call : vis-indiv.php ou vis-grp.php ou edit-indiv.php ou edit-grp.php
//# @Parameters : 
//# @Author : G0osS
//# @Create : 31/01/2024
//# @Update : 15/04/2025
//# @Version : 2.0.0
//##############################################################################


    /* Script gestion des check automatique des checkboxs filles (Parcours complet/Secteurs/Expositions)
    ================================================================================================== */
 
function checkBoxClass(ref, classname) {
  var checkAll = document.getElementById(ref);
  checkAll.addEventListener("change", function() {
    var checked = this.checked;
    var otherCheckboxes = document.querySelectorAll(classname);
    [].forEach.call(otherCheckboxes, function(item) {
       item.checked = checked;
    });
  });
};


    /* Script gestion des check automatique des checkboxs filles (Residents/Membres collectivité)
    =========================================================================================== */

function checkBoxName(ref, name) {
  var form = ref;
  while (form.parentNode && form.nodeName.toLowerCase() != 'form') { form = form.parentNode; }
  var elements = form.getElementsByTagName('input');
  for (var i = 0; i < elements.length; i++) {
    if (elements[i].type == 'checkbox' && elements[i].name == name) {
      elements[i].checked = ref.checked;
    }
  }
}


    /* Script gestion de l'affichage des ateliers en fonction du public
    ================================================================= */

function switchDiv(IDdiv,CLASSEdiv){
  var elements = document.querySelectorAll(CLASSEdiv);
  for (var i = 0; i < elements.length; i++) {
    if (elements[i].id == IDdiv) {
      elements[i].classList.add("d-inline-flex");
      elements[i].classList.remove("d-none");
    } else {
      elements[i].classList.remove("d-inline-flex");
      elements[i].classList.add("d-none");
      var radios = elements[i].querySelectorAll('input[id^=atel][type="radio"]');
      console.log(radios)
      for (var x = 0; x < radios.length; x++) {
        radios[x].checked = false;
      }

    }
  }
}