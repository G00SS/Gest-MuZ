//##############################################################################
//# @Name : table-param-users.js
//# @Description : Tableau DataTable
//# @Call : param-users.php
//# @Parameters : 
//# @Author : G0osS
//# @Create : 31/01/2024
//# @Update : 15/04/2025
//# @Version : 2.0.0
//##############################################################################


$(document).ready( function () {
    $('#myCustomSearchBox').keyup(function() {
        table.search($(this).val()).draw(); // this  is for customized searchbox with datatable search feature.
    });
    var table = $('#users').DataTable( {
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
            "search":         "Cherhcer:",
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
        "dom": "rtip", //to hide default searchbox but search feature is not disabled hence customised searchbox can be made.
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
        "order": [[ 1, "desc" ]],
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
                "orderable": false,
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
                "searchable": true
            }
        ]
    } );
    table.buttons().container()
        .appendTo( '#users_wrapper .col-md-6:eq(0)' );
} );
