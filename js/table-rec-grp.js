//##############################################################################
//# @Name : table-rec-grp.js
//# @Description : Tableau DataTable
//# @Call : rec-grp.php
//# @Parameters : 
//# @Author : G0osS
//# @Create : 31/01/2024
//# @Update : 15/04/2025
//# @Version : 2.0.0
//##############################################################################


$(document).ready(function() {
    $('#myCustomSearchBox').keyup(function() {
        table.search($(this).val()).draw(); // this  is for customized searchbox with datatable search feature.
    });
    var table = $('#grp-table').DataTable( {
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
            "search":         "Chercher:",
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
        "dom": "Brtip", //to hide default searchbox but search feature is not disabled hence customised searchbox can be made.
        lengthMenu: [
            [ 30, 60, 120, -1 ],
            [ '30 lignes', '60 lignes', '120 lignes', 'Tout afficher' ]
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
        //"paging": false,
        "scrollX": true,
        "responsive": true,
        "order": [[ 0, "desc" ]],
        "columnDefs": [{
            "className": "dt-center",
            "targets": "_all",
            },
            {
                "targets": [ 0 ],
                "visible": false,
                "orderable": false,
                "searchable": false
            },
            {
                "targets": [ 1 ],
                "orderable": true,
                "searchable": true
            },
            {
                "targets": [ 2 ],
                "orderable": true,
                "searchable": false
            },
            {
                "targets": [ 3, 4 ],
                "orderable": false
            },
            {
                "targets": [ 5 ],
                "orderable": true,
                "searchable": true
            },
            {
                "targets": [ 6, 7 ],
                "orderable": true,
                "searchable": false
            },
            {
                "targets": [ 8, 9, 10, 11 ],
                "orderable": true,
                "searchable": true
            },
            {
                "targets": [ 12 ],
                "orderable": false,
                "searchable": false
            }
        ],
    } );
} )

