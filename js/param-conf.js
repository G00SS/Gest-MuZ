//##########################################################################
//# @Name : param-conf.js
//# @Description : Création des Formulaire Modaux de modification des champs des
//#                tables principales ainsi que les tableaux DataTable
//# @Call : param-conf.php
//# @Parameters : 
//# @Author : G0osS
//# @Create : 31/01/2024
//# @Update : 15/04/2025
//# @Version : 2.0.0
//##############################################################################


// SECTEURS
// Script pour le tableau des "Secteurs"
$(document).ready( function () {
    var table = $('#secteurs').DataTable( {
        "dom": "rt", //to hide default searchbox but search feature is not disabled hence customised searchbox can be made.
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 lignes', '25 lignes', '50 lignes', 'Tout afficher' ]
        ],
        buttons: [
            {
            extend: 'pageLength',
            text: 'Afficher ',
            className: 'btn btn-secondary',
            },
            {
              extend: 'collection',
              text: 'Exporter  ',
              className: 'btn btn-secondary',
              buttons:[ 'print', 'excel', 'csv', 'pdf' ]
            }
        ],
        "order": [[ 1, "asc" ]],
        "columnDefs": [
            {
                "targets": [ 0 ],
                "orderable": false,
                "searchable": false
            },
            {
                "targets": [ 1 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 2 ],
                "orderable": true,
                "searchable": true
            },
            {
                "targets": [ 3 ],
                "visible": false,
                "searchable": false
            }
        ]
    } )
} );

// Script pour l'affichage des détails du "Secteur" séléctionné dans un modal
$(document).on("click", ".detail-secteur", function () {
     var sectId = $(this).data('id');
     $.ajax({
       url:'./inc/get_details.php',
       type: 'post',
       data: {sectId:sectId},
       dataType:'text',
       success: function(response) {
              $(".secteurdetail").html(response);
            },
       error: function (request, status, error) {
        $(".secteurdetail").html(request.responseText);
        }
    });
});


// MOTIVATIONS
// Script pour le tableau des "Motivations"
$(document).ready( function () {
    var table = $('#motiv').DataTable( {
        "dom": "rt", //to hide default searchbox but search feature is not disabled hence customised searchbox can be made.
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 lignes', '25 lignes', '50 lignes', 'Tout afficher' ]
        ],
        buttons: [
            {
            extend: 'pageLength',
            text: 'Afficher ',
            className: 'btn btn-secondary',
            },
            {
              extend: 'collection',
              text: 'Exporter  ',
              className: 'btn btn-secondary',
              buttons:[ 'print', 'excel', 'csv', 'pdf' ]
            }
        ],
        "order": [[ 1, "asc" ]],
        "columnDefs": [
            {
                "targets": [ 0 ],
                "orderable": false,
                "searchable": false
            },
            {
                "targets": [ 1 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 2 ],
                "orderable": true,
                "searchable": true
            }
        ]
    } )
} );

// Script pour l'affichage des détails de la "Motivation" séléctionnée dans un modal
$(document).on("click", ".detail-motiv", function () {
     var motivId = $(this).data('id');
     $.ajax({
       url:'./inc/get_details.php',
       type: 'post',
       data: {motivId:motivId},
       dataType:'text',
       success: function(response) {
              $(".motivdetail").html(response);
            },
       error: function (request, status, error) {
        $(".motivdetail").html(request.responseText);
        }
    });
});


// TYPES DE GROUPES
// Script pour le tableau des "Types de Groupes"
$(document).ready( function () {
    var table = $('#grp').DataTable( {
        "language": {
            "decimal":        "",
            "emptyTable":     "... Aucune donnée à afficher... :(",
            "info":           "Affichage de _START_ à _END_ sur _TOTAL_ lignes",
            "infoEmpty":      "Affichage de 0 à 0 sur 0 lignes",
            "infoFiltered":   "(filtrées depuis _MAX_ lignes)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Afficher _MENU_ lignes",
            "loadingRecords": "Chargement...",
            "processing":     "",
            "search":         "Chercher :",
            "zeroRecords":    "Aucun résultat trouvé",
            "paginate": {
                "first":      "Premier",
                "last":       "Dernier",
                "next":       "Suivant",
                "previous":   "Précédent"
            },
            "aria": {
                "sortAscending":  ": Trier par ordre croissant",
                "sortDescending": ": Trier par ordre décroissant"
            }
        },
        "dom": "rftip", //to hide default searchbox but search feature is not disabled hence customised searchbox can be made.
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 lignes', '25 lignes', '50 lignes', 'Tout afficher' ]
        ],
        "order": [[ 1, "asc" ]],
        "columnDefs": [
            {
                "targets": [ 0 ],
                "orderable": false,
                "searchable": false
            },
            {
                "targets": [ 1 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 2 ],
                "orderable": true,
                "searchable": true
            },
            {
                "targets": [ 3 ],
                "orderable": true,
                "searchable": true
            }
        ]
    } )
} );

// Script pour l'affichage des détails du "Type de Groupe" séléctionné dans un modal
$(document).on("click", ".detail-grp", function () {
     var grpId = $(this).data('id');
     $.ajax({
       url:'./inc/get_details.php',
       type: 'post',
       data: {grpId:grpId},
       dataType:'text',
       success: function(response) {
              $(".grpdetail").html(response);
            },
       error: function (request, status, error) {
        $(".grpdetail").html(request.responseText);
        }
    });
});


// CLASSES D'AGES
// Script pour le tableau des "Classes d'âges"
$(document).ready( function () {
    var table = $('#soci_ages').DataTable( {
        "dom": "rt", //to hide default searchbox but search feature is not disabled hence customised searchbox can be made.
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 lignes', '25 lignes', '50 lignes', 'Tout afficher' ]
        ],
        buttons: [
            {
            extend: 'pageLength',
            text: 'Afficher ',
            className: 'btn btn-secondary',
            },
            {
              extend: 'collection',
              text: 'Exporter  ',
              className: 'btn btn-secondary',
              buttons:[ 'print', 'excel', 'csv', 'pdf' ]
            }
        ],
        "order": [[ 1, "asc" ]],
        "columnDefs": [
            {
                "targets": [ 0 ],
                "orderable": false,
                "searchable": false
            },
            {
                "targets": [ 1 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 2 ],
                "orderable": true,
                "searchable": true
            },
            {
                "targets": [ 3 ],
                "orderable": true,
                "searchable": true
            }
        ]
    } )
} );

// Script pour l'affichage des détails d'une "Classe d'âges" séléctionnée dans un modal
$(document).on("click", ".detail-sociage", function () {
     var sociageId = $(this).data('id');
     $.ajax({
       url:'./inc/get_details.php',
       type: 'post',
       data: {sociageId:sociageId},
       dataType:'text',
       success: function(response) {
              $(".sociagedetail").html(response);
            },
       error: function (request, status, error) {
        $(".sociagedetail").html(request.responseText);
        }
    });
});


// PUBLICS DES ATELIERS
// Script pour le tableau des "Publics des Ateliers"
$(document).ready( function () {
    var table = $('#publics').DataTable( {
        "dom": "rt", //to hide default searchbox but search feature is not disabled hence customised searchbox can be made.
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 lignes', '25 lignes', '50 lignes', 'Tout afficher' ]
        ],
        buttons: [
            {
            extend: 'pageLength',
            text: 'Afficher ',
            className: 'btn btn-secondary',
            },
            {
              extend: 'collection',
              text: 'Exporter  ',
              className: 'btn btn-secondary',
              buttons:[ 'print', 'excel', 'csv', 'pdf' ]
            }
        ],
        "order": [[ 1, "asc" ]],
        "columnDefs": [
            {
                "targets": [ 0 ],
                "orderable": false,
                "searchable": false
            },
            {
                "targets": [ 1 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 2 ],
                "orderable": true,
                "searchable": true
            },
            {
                "targets": [ 3 ],
                "orderable": true,
                "searchable": true
            },
            {
                "targets": [ 4 ],
                "orderable": true,
                "searchable": false
            }
        ]
    } )
} );

// Script pour l'affichage des détails du "Public des Ateliers" séléctionné dans un modal
$(document).on("click", ".detail-public", function () {
     var publicId = $(this).data('id');
     $.ajax({
       url:'./inc/get_details.php',
       type: 'post',
       data: {publicId:publicId},
       dataType:'text',
       success: function(response) {
              $(".publicdetail").html(response);
            },
       error: function (request, status, error) {
        $(".publicdetail").html(request.responseText);
        }
    });
});