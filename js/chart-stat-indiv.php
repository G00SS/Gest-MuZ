<?php############################################################################
# @Name : chart-stat-indiv.php
# @Description : Include du script javascript pour les graphiques et tableaux
#         ChartJs et DataTable pour les visites Individuelles
# @Call : stat-indiv.php
# @Parameters : 
# @Author : G0osS
# @Create : 31/01/2024
# @Update : 15/04/2025
# @Version : 2.0.0
################################################################################?>


<script>

// DOUGHNUT PROVENANCE & PRIMO-VISITEUR
  // CenterText plugin
  const centerTextIPP = {
      id: 'centerTextIPP',
      afterDatasetsDraw(chart, args, options) {
          const {ctx, chartArea: {left, right, top, bottom, width, height}} = chart;

          ctx.save();

          var fontSize = (height / 75).toFixed(2);
          ctx.font = "bolder " + fontSize + "em Tahoma";
          ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
          ctx.textBaseline = "middle";
          var text = <?php echo json_encode($Tot); ?>,
            textX = Math.round((width - ctx.measureText(text).width) / 2),
            textY = height / 2;
          ctx.fillText(text, textX, textY);
          ctx.restore();
      }
  }

  var GraphDoughIPP = new Chart('GraphDoughIPP', {
    type: 'doughnut',
    data: {
      labels: [<?php echo json_encode('Primo-visiteurs '.$resident); ?>, <?php echo json_encode($resident.' Habitués'); ?>, <?php echo json_encode('Primo-visiteurs '.$collectivite); ?>, <?php echo json_encode($collectivite.' Habitués'); ?>, 'Extérieurs Primo-visiteurs', 'Extérieurs Habitués', <?php echo json_encode($resident); ?>,<?php echo json_encode($collectivite); ?>, 'Extérieurs'],
      datasets: [{
          labels: ['Résidents Primo-visiteurs', 'Résidents Habitués', 'Collectivitée Primo-visiteurs', 'Collectivitée Habitués', 'Extérieurs Primo-visiteurs', 'Extérieurs Habitués'],
          data: <?php echo json_encode($IndivDetail1); ?>,
          backgroundColor: [
              '#6bb9d7',
              '#369cc4',
              '#f2e78a',
              '#ecdc50',
              '#fc708e',
              '#fa1a49'
            ],
            datalabels: {
                color: [
                  '#ffffff',
                  '#ffffff',
                  '#5e550a',
                  '#5e550a',
                  '#ffffff',
                  '#ffffff'
                  ],
                labels: {
                    title: {
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                backgroundColor: [
                  '#6bb9d7',
                  '#369cc4',
                  '#f2e78a',
                  '#ecdc50',
                  '#fc708e',
                  '#fa1a49'
                ],
                borderColor: '#ffffff',
                borderRadius: 100,
                borderWidth: 2,
                anchor: 'center'
            },
        },
        {
          labels: ['Résidents', 'Collectivitée', 'Extérieurs'],
          data: <?php echo json_encode($IndivTot); ?>,
          backgroundColor: [
            '#2a7b9b',
            '#e5cf19',
            '#d30530'
          ],
            datalabels: {
                color: [
                  '#ffffff',
                  '#5e550a',
                  '#ffffff'
                  ],
                labels: {
                    title: {
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                backgroundColor: [
                  '#2a7b9b',
                  '#e5cf19',
                  '#d30530'
                ],
                borderColor: '#ffffff',
                borderRadius: 100,
                borderWidth: 2,
                anchor: 'center'
            },
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      //aspectRatio : 2,
      plugins: {
        legend: {
          display: true,
          position: 'bottom',
          labels: {
            generateLabels: function(chart) {
              // Get the default label list
              const original = Chart.overrides.pie.plugins.legend.labels.generateLabels;
              const labelsOriginal = original.call(this, chart);

              // Build an array of colors used in the datasets of the chart
              let datasetColors = chart.data.datasets.map(function(e) {
                return e.backgroundColor;
              });
              datasetColors = datasetColors.flat();

              // Modify the color and hide state of each label
              labelsOriginal.forEach(label => {
                // There are twice as many labels as there are datasets. This converts the label index into the corresponding dataset index
                //label.datasetIndex = (label.index - label.index % 2) / 2;

                // The hidden state must match the dataset's hidden state
                //label.hidden = !chart.isDatasetVisible(label.datasetIndex);

                // Change the color to match the dataset
                label.fillStyle = datasetColors[label.index];
              });

              return labelsOriginal;
            }
          },
          onClick: function(mouseEvent, legendItem, legend) {
            // toggle the visibility of the dataset from what it currently is
            legend.chart.getDatasetMeta(
              legendItem.datasetIndex
            ).hidden = legend.chart.isDatasetVisible(legendItem.datasetIndex);
            legend.chart.update();
          }
        },
        tooltip: {
          callbacks: {
            title: function(context) {
              //const labelIndex = (context[0].datasetIndex * 2) + context[0].dataIndex;
              if (context[0].datasetIndex == 0) {
              var labelIndex = context[0].dataIndex;
              } else {
              var labelIndex = context[0].dataIndex + 6;
              }
              return context[0].chart.data.labels[labelIndex] + ': ' + context[0].formattedValue;
              
            }
          }
        },
        title: {
          display: true,
          text: 'Provenance & Expérience des Visiteurs',
          position: 'bottom',
          font: {
              size: 15,
              family: "'Segoe UI', 'Helvetica Neue', 'Arial'"
          }
        }
      }
    },
    plugins: [centerTextIPP,ChartDataLabels]
  });

// DOUGHNUT PROVENANCE & PAYANT
  // CenterText plugin
  const centerTextIPF = {
      id: 'centerTextIPF',
      afterDatasetsDraw(chart, args, options) {
          const {ctx, chartArea: {left, right, top, bottom, width, height}} = chart;

          ctx.save();

          var fontSize = (height / 75).toFixed(2);
          ctx.font = "bolder " + fontSize + "em Tahoma";
          ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
          ctx.textBaseline = "middle";
          var text = <?php echo json_encode($Tot); ?>,
            textX = Math.round((width - ctx.measureText(text).width) / 2),
            textY = height / 2;
          ctx.fillText(text, textX, textY);
          ctx.restore();
      }
  }

  var GraphDoughIPF = new Chart('GraphDoughIPF', {
    type: 'doughnut',
    data: {
      labels: [<?php echo json_encode($resident.' Gratuits'); ?>, <?php echo json_encode($resident.' Payants'); ?>, <?php echo json_encode($collectivite.' Gratuits'); ?>, <?php echo json_encode($collectivite.' Payants'); ?>, 'Extérieurs Gratuits', 'Extérieurs Payants', <?php echo json_encode($resident); ?>,<?php echo json_encode($collectivite); ?>, 'Extérieurs'],
      datasets: [{
          labels: ['Résidents Gratuits', 'Résidents Payants', 'Collectivitée Gratuits', 'Collectivitée Payants', 'Extérieurs Gratuits', 'Extérieurs Payants'],
          data: <?php echo json_encode($IndivDetail2); ?>,
          backgroundColor: [
              '#6bb9d7',
              '#369cc4',
              '#f2e78a',
              '#ecdc50',
              '#fc708e',
              '#fa1a49'
            ],
            datalabels: {
                color: [
                  '#ffffff',
                  '#ffffff',
                  '#5e550a',
                  '#5e550a',
                  '#ffffff',
                  '#ffffff'
                  ],
                labels: {
                    title: {
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                backgroundColor: [
                  '#6bb9d7',
                  '#369cc4',
                  '#f2e78a',
                  '#ecdc50',
                  '#fc708e',
                  '#fa1a49'
                ],
                borderColor: '#ffffff',
                borderRadius: 100,
                borderWidth: 2,
                anchor: 'center'
            },
        },
        {
          labels: ['Résidents', 'Collectivitée', 'Extérieurs'],
          data: <?php echo json_encode($IndivTot); ?>,
          backgroundColor: [
            '#2a7b9b',
            '#e5cf19',
            '#d30530'
          ],
            datalabels: {
                color: [
                  '#ffffff',
                  '#5e550a',
                  '#ffffff'
                  ],
                labels: {
                    title: {
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                backgroundColor: [
                  '#2a7b9b',
                  '#e5cf19',
                  '#d30530'
                ],
                borderColor: '#ffffff',
                borderRadius: 100,
                borderWidth: 2,
                anchor: 'center'
            },
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      //aspectRatio : 2,
      plugins: {
        legend: {
          display: true,
          position: 'bottom',
          labels: {
            generateLabels: function(chart) {
              // Get the default label list
              const original = Chart.overrides.pie.plugins.legend.labels.generateLabels;
              const labelsOriginal = original.call(this, chart);

              // Build an array of colors used in the datasets of the chart
              let datasetColors = chart.data.datasets.map(function(e) {
                return e.backgroundColor;
              });
              datasetColors = datasetColors.flat();

              // Modify the color and hide state of each label
              labelsOriginal.forEach(label => {
                // There are twice as many labels as there are datasets. This converts the label index into the corresponding dataset index
                //label.datasetIndex = (label.index - label.index % 2) / 2;

                // The hidden state must match the dataset's hidden state
                //label.hidden = !chart.isDatasetVisible(label.datasetIndex);

                // Change the color to match the dataset
                label.fillStyle = datasetColors[label.index];
              });

              return labelsOriginal;
            }
          },
          onClick: function(mouseEvent, legendItem, legend) {
            // toggle the visibility of the dataset from what it currently is
            legend.chart.getDatasetMeta(
              legendItem.datasetIndex
            ).hidden = legend.chart.isDatasetVisible(legendItem.datasetIndex);
            legend.chart.update();
          }
        },
        tooltip: {
          callbacks: {
            title: function(context) {
              //const labelIndex = (context[0].datasetIndex * 2) + context[0].dataIndex;
              if (context[0].datasetIndex == 0) {
              var labelIndex = context[0].dataIndex;
              } else {
              var labelIndex = context[0].dataIndex + 6;
              }
              return context[0].chart.data.labels[labelIndex] + ': ' + context[0].formattedValue;
              
            }
          }
        },
        title: {
          display: true,
          text: 'Visites Payantes en fonction de la Provenance des Visiteurs',
          position: 'bottom',
          font: {
              size: 15,
              family: "'Segoe UI', 'Helvetica Neue', 'Arial'"
          }
        }
      }
    },
    plugins: [centerTextIPF,ChartDataLabels]
  });

// DOUGHNUT PROVENANCE & GUIDEES
  // CenterText plugin
  const centerTextIPG = {
      id: 'centerTextIPG',
      afterDatasetsDraw(chart, args, options) {
          const {ctx, chartArea: {left, right, top, bottom, width, height}} = chart;

          ctx.save();

          var fontSize = (height / 75).toFixed(2);
          ctx.font = "bolder " + fontSize + "em Tahoma";
          ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
          ctx.textBaseline = "middle";
          var text = <?php echo json_encode($Tot); ?>,
            textX = Math.round((width - ctx.measureText(text).width) / 2),
            textY = height / 2;
          ctx.fillText(text, textX, textY);
          ctx.restore();
      }
  }

  var GraphDoughIPG = new Chart('GraphDoughIPG', {
    type: 'doughnut',
    data: {
      labels: [<?php echo json_encode($resident.' Autonomes'); ?>, <?php echo json_encode($resident.' Guidés'); ?>, <?php echo json_encode($collectivite.' Autonomes'); ?>, <?php echo json_encode($collectivite.' Guidés'); ?>, 'Extérieurs Autonomes', 'Extérieurs Guidés', <?php echo json_encode($resident); ?>,<?php echo json_encode($collectivite); ?>, 'Extérieurs'],
      datasets: [{
          labels: ['Résidents Autonomes', 'Résidents Guidés', 'Collectivitée Autonomes', 'Collectivitée Guidés', 'Extérieurs Autonomes', 'Extérieurs Guidés'],
          data: <?php echo json_encode($IndivDetail3); ?>,
          backgroundColor: [
              '#6bb9d7',
              '#369cc4',
              '#f2e78a',
              '#ecdc50',
              '#fc708e',
              '#fa1a49'
            ],
            datalabels: {
                color: [
                  '#ffffff',
                  '#ffffff',
                  '#5e550a',
                  '#5e550a',
                  '#ffffff',
                  '#ffffff'
                  ],
                labels: {
                    title: {
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                backgroundColor: [
                  '#6bb9d7',
                  '#369cc4',
                  '#f2e78a',
                  '#ecdc50',
                  '#fc708e',
                  '#fa1a49'
                ],
                borderColor: '#ffffff',
                borderRadius: 100,
                borderWidth: 2,
                anchor: 'center'
            },
        },
        {
          labels: ['Résidents', 'Collectivitée', 'Extérieurs'],
          data: <?php echo json_encode($IndivTot); ?>,
          backgroundColor: [
            '#2a7b9b',
            '#e5cf19',
            '#d30530'
          ],
            datalabels: {
                color: [
                  '#ffffff',
                  '#5e550a',
                  '#ffffff'
                  ],
                labels: {
                    title: {
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                backgroundColor: [
                  '#2a7b9b',
                  '#e5cf19',
                  '#d30530'
                ],
                borderColor: '#ffffff',
                borderRadius: 100,
                borderWidth: 2,
                anchor: 'center'
            },
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      //aspectRatio : 2,
      plugins: {
        legend: {
          display: true,
          position: 'bottom',
          labels: {
            generateLabels: function(chart) {
              // Get the default label list
              const original = Chart.overrides.pie.plugins.legend.labels.generateLabels;
              const labelsOriginal = original.call(this, chart);

              // Build an array of colors used in the datasets of the chart
              let datasetColors = chart.data.datasets.map(function(e) {
                return e.backgroundColor;
              });
              datasetColors = datasetColors.flat();

              // Modify the color and hide state of each label
              labelsOriginal.forEach(label => {
                // There are twice as many labels as there are datasets. This converts the label index into the corresponding dataset index
                //label.datasetIndex = (label.index - label.index % 2) / 2;

                // The hidden state must match the dataset's hidden state
                //label.hidden = !chart.isDatasetVisible(label.datasetIndex);

                // Change the color to match the dataset
                label.fillStyle = datasetColors[label.index];
              });

              return labelsOriginal;
            }
          },
          onClick: function(mouseEvent, legendItem, legend) {
            // toggle the visibility of the dataset from what it currently is
            legend.chart.getDatasetMeta(
              legendItem.datasetIndex
            ).hidden = legend.chart.isDatasetVisible(legendItem.datasetIndex);
            legend.chart.update();
          }
        },
        tooltip: {
          callbacks: {
            title: function(context) {
              //const labelIndex = (context[0].datasetIndex * 2) + context[0].dataIndex;
              if (context[0].datasetIndex == 0) {
              var labelIndex = context[0].dataIndex;
              } else {
              var labelIndex = context[0].dataIndex + 6;
              }
              return context[0].chart.data.labels[labelIndex] + ': ' + context[0].formattedValue;
              
            }
          }
        },
        title: {
          display: true,
          text: 'Visites Guidées en fonction de la Provenance des Visiteurs',
          position: 'bottom',
          font: {
              size: 15,
              family: "'Segoe UI', 'Helvetica Neue', 'Arial'"
          }
        }
      }
    },
    plugins: [centerTextIPG,ChartDataLabels]
  });

// TABLEAU RECAP PROVENANCE PRIMO GUIDEE PAYANT
  $(document).ready( function () {
      var table = $('#indivPGP').DataTable( {
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
          "dom": "Brt", //to hide default searchbox but search feature is not disabled hence customised searchbox can be made.
          lengthMenu: [
              [ 10, 25, 50, -1 ],
              [ '10 lignes', '25 lignes', '50 lignes', 'Tout afficher' ]
          ],
          buttons: [
              {
                extend: 'collection',
                text: 'Exporter  ',
                className: 'btn btn-secondary',
                buttons:[ 'print', 'excel', 'csv', 'pdf' ]
              }
          ],
          order: [],
          "columnDefs": [
              {
                  "targets": [ 0 ],
                  "orderable": false,
                  "searchable": false
              },
              {
                  "targets": [ 1,2,3,4,5,6,7 ],
                  "orderable": true,
                  "searchable": false
              }
          ]
      } );
      table.buttons().container()
          .appendTo( '#indivPGP_wrapper .col-md-6:eq(0)' );
  } );


// BARGRAPH FREQUENTATION JOURNALIERE
    // setup
    const dataGraphID = {
      labels: <?php echo json_encode($days); ?>,
      datasets: [{
        label: 'Individuels',
        data: <?php echo json_encode($freqIndD); ?>,
        backgroundColor: [
          '#2a7b9b'
        ],
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 1,
        borderRadius: {
          topLeft: 10,
          topRight: 10
        },
        borderSkipped: false,
        datalabels: {
          color: 'white'
        }
      }]
    };

    // config
    const configGraphID = {
        type: 'bar',
        data: dataGraphID,
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            x: {
              stacked: false,
              border: {
                diplay: false
              },
              grid: {
                display: false
              }
            },
            y: {
              stacked: false,
              display: false,
              beginAtZero: true
            }
          },
          plugins: {
            legend: {
              display: false,
              position: 'bottom'
            },
            datalabels: {
              font: {
                weight: 'bold',
                size: 16
              }
            },
            title: {
              display: true,
              text: "Fréquentation moyenne journalière par jour",
              position: 'bottom',
              font: {
                  size: 15,
                  family: "'Segoe UI', 'Helvetica Neue', 'Arial'"
              }
            }
          }
        },
        plugins : [ChartDataLabels]
    };

    // render init block
    const GraphID = new Chart(
        document.getElementById('GraphID'),
        configGraphID
    );

// BARGRAPH FREQUENTATION HORAIRES
    // setup
    const dataGraphIH = {
      labels: <?php echo json_encode($hours); ?>,
      datasets: [{
        label: 'Individuels',
        data: <?php echo json_encode($freqIndH); ?>,
        backgroundColor: [
          '#2a7b9b'
        ],
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 1,
        borderRadius: {
          topLeft: 10,
          topRight: 10
        },
        borderSkipped: false,
        datalabels: {
          color: 'white'
        }
      }]
    };

    // config
    const configGraphIH = {
        type: 'bar',
        data: dataGraphIH,
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            x: {
              stacked: false,
              border: {
                diplay: false
              },
              grid: {
                display: false
              }
            },
            y: {
              stacked: false,
              display: false,
              beginAtZero: true
            }
          },
          plugins: {
            legend: {
              display: false,
              position: 'bottom'
            },
            datalabels: {
              font: {
                weight: 'bold',
                size: 16
              }
            },
            title: {
              display: true,
              text: "Fréquentation horaire moyenne",
              position: 'bottom',
              font: {
                  size: 15,
                  family: "'Segoe UI', 'Helvetica Neue', 'Arial'"
              }
            }
          }
        },
        plugins : [ChartDataLabels]
    };

    // render init block
    const GraphIH = new Chart(
        document.getElementById('GraphIH'),
        configGraphIH
    );


// BARGRAPH REPARTITION PAR SECTEUR
    // setup
    const dataGraphSECT = {
      labels: <?php echo json_encode($LabelSECT); ?>,
      datasets: [{
        label: 'Habitués',
        data: <?php echo json_encode($effSECT); ?>,
        backgroundColor: [
          '#2a7b9b'
        ],
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 2,
        borderRadius: {
          topLeft: 10,
          bottomLeft: 10
        },
        borderSkipped: false,
        datalabels: {
        labels: {
            title: {
                font: {
                    weight: 'bold'
                }
            }
        },
        color: '#ffffff',
        anchor: 'center'
        }
      },{
        label: 'Primo-visiteurs',
        data: <?php echo json_encode($effSECTP); ?>,
        backgroundColor: [
          '#369cc4'
        ],
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 2,
        borderRadius: {
          topRight: 10,
          bottomRight: 10
        },
        borderSkipped: false,
        datalabels: {
        labels: {
            title: {
                font: {
                    weight: 'bold'
                }
            }
        },
        color: '#ffffff',
        anchor: 'center'
        }
      }]
    };

    // config
    const configGraphSECT = {
        type: 'bar',
        data: dataGraphSECT,
        options: {
          responsive: true,
          aspectRatio: 2,
          maintainAspectRatio: false,
          indexAxis: 'y',
          scales: {
            x: {
              stacked: true,
              display: false,
              border: {
                diplay: false
              },
              grid: {
                display: false
              }
            },
            y: {
              stacked: true,
              display: true,
              beginAtZero: true
            }
          },
          plugins: {
            legend: {
              display: true,
              position: 'bottom'
            },
            datalabels: {
              font: {
                weight: 'bold',
                size: 16
              }
            },
            title: {
              display: true,
              text: <?php echo json_encode("Fréquentation des Secteurs du ".$structure);?>,
              position: 'bottom',
              font: {
                  size: 15,
                  family: "'Segoe UI', 'Helvetica Neue', 'Arial'"
              }
            }
          }
        },
        plugins : [ChartDataLabels]
    };

    // render init block
    const GraphSECT = new Chart(
        document.getElementById('GraphSECT'),
        configGraphSECT
    );

// BARGRAPH REPARTITION PAR EXPOSITION
    // setup
    const dataGraphEXPO = {
      labels: <?php echo json_encode($LabelEXPO); ?>,
      datasets: [{
        label: 'Habitués',
        data: <?php echo json_encode($effEXPO); ?>,
        backgroundColor: [
          '#2a7b9b'
        ],
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 2,
        borderRadius: {
          topLeft: 10,
          bottomLeft: 10
        },
        borderSkipped: false,
        datalabels: {
        labels: {
            title: {
                font: {
                    weight: 'bold'
                }
            }
        },
        color: '#ffffff',
        anchor: 'center'
        }
      },{
        label: 'Primo-visiteurs',
        data: <?php echo json_encode($effEXPOP); ?>,
        backgroundColor: [
          '#369cc4'
        ],
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 2,
        borderRadius: {
          topRight: 10,
          bottomRight: 10
        },
        borderSkipped: false,
        datalabels: {
        labels: {
            title: {
                font: {
                    weight: 'bold'
                }
            }
        },
        color: '#ffffff',
        anchor: 'center'
        }
      }]
    };

    // config
    const configGraphEXPO = {
        type: 'bar',
        data: dataGraphEXPO,
        options: {
          responsive: true,
          aspectRatio: 1,
          maintainAspectRatio: true,
          indexAxis: 'y',
          scales: {
            x: {
              stacked: true,
              display: false,
              border: {
                diplay: false
              },
              grid: {
                display: false
              }
            },
            y: {
              stacked: true,
              display: true,
              beginAtZero: true
            }
          },
          plugins: {
            legend: {
              display: true,
              position: 'bottom'
            },
            datalabels: {
              font: {
                weight: 'bold',
                size: 16
              }
            },
            title: {
              display: true,
              text: <?php echo json_encode("Fréquentation des Expositions du ".$structure);?>,
              position: 'bottom',
              font: {
                  size: 15,
                  family: "'Segoe UI', 'Helvetica Neue', 'Arial'"
              }
            }
          }
        },
        plugins : [ChartDataLabels]
    };

    // render init block
    const GraphEXPO = new Chart(
        document.getElementById('GraphEXPO'),
        configGraphEXPO
    );

// BARGRAPH REPARTITION PAR EVENEMENT
    // setup
    const dataGraphEVT = {
      labels: <?php echo json_encode($LabelEVT); ?>,
      datasets: [{
        label: 'Habitués',
        data: <?php echo json_encode($effEVT); ?>,
        backgroundColor: [
          '#2a7b9b'
        ],
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 2,
        borderRadius: {
          topLeft: 10,
          bottomLeft: 10
        },
        borderSkipped: false,
        datalabels: {
        labels: {
            title: {
                font: {
                    weight: 'bold'
                }
            }
        },
        color: '#ffffff',
        anchor: 'center'
        }
      },{
        label: 'Primo-visiteurs',
        data: <?php echo json_encode($effEVTP); ?>,
        backgroundColor: [
          '#369cc4'
        ],
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 2,
        borderRadius: {
          topRight: 10,
          bottomRight: 10
        },
        borderSkipped: false,
        datalabels: {
        labels: {
            title: {
                font: {
                    weight: 'bold'
                }
            }
        },
        color: '#ffffff',
        anchor: 'center'
        }
      }]
    };

    // config
    const configGraphEVT = {
        type: 'bar',
        data: dataGraphEVT,
        options: {
          responsive: true,
          aspectRatio: 2,
          maintainAspectRatio: false,
          indexAxis: 'y',
          scales: {
            x: {
              stacked: true,
              display: false,
              border: {
                diplay: false
              },
              grid: {
                display: false
              }
            },
            y: {
              stacked: true,
              display: true,
              beginAtZero: true
            }
          },
          plugins: {
            legend: {
              display: true,
              position: 'bottom'
            },
            datalabels: {
              font: {
                weight: 'bold',
                size: 16
              }
            },
            title: {
              display: true,
              text: <?php echo json_encode("Fréquentation des Evènements du ".$structure);?>,
              position: 'bottom',
              font: {
                  size: 15,
                  family: "'Segoe UI', 'Helvetica Neue', 'Arial'"
              }
            }
          }
        },
        plugins : [ChartDataLabels]
    };

    // render init block
    const GraphEVT = new Chart(
        document.getElementById('GraphEVT'),
        configGraphEVT
    );


// BARGRAPH REPARTITION PAR MOTIVATION
    // setup
    const dataGraphM = {
      labels: <?php echo json_encode($motiv); ?>,
      datasets: [{
        label: 'Habitués',
        data: <?php echo json_encode($effIndM); ?>,
        backgroundColor: [
          '#2a7b9b'
        ],
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 2,
        borderRadius: {
          topLeft: 10,
          bottomLeft: 10
        },
        borderSkipped: false,
        datalabels: {
        labels: {
            title: {
                font: {
                    weight: 'bold'
                }
            }
        },
        color: '#ffffff',
        anchor: 'center'
        }
      },{
        label: 'Primo-visiteurs',
        data: <?php echo json_encode($effIndMP); ?>,
        backgroundColor: [
          '#369cc4'
        ],
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 2,
        borderRadius: {
          topRight: 10,
          bottomRight: 10
        },
        borderSkipped: false,
        datalabels: {
        labels: {
            title: {
                font: {
                    weight: 'bold'
                }
            }
        },
        color: '#ffffff',
        anchor: 'center'
        }
      }]
    };

    // config
    const configGraphM = {
        type: 'bar',
        data: dataGraphM,
        options: {
          responsive: true,
          aspectRatio: 2,
          maintainAspectRatio: false,
          indexAxis: 'y',
          scales: {
            x: {
              stacked: true,
              display: false,
              border: {
                diplay: false
              },
              grid: {
                display: false
              }
            },
            y: {
              stacked: true,
              display: true,
              beginAtZero: true
            }
          },
          plugins: {
            legend: {
              display: true,
              position: 'bottom'
            },
            datalabels: {
              font: {
                weight: 'bold',
                size: 16
              }
            },
            title: {
              display: true,
              text: "Effectifs par motivation",
              position: 'bottom',
              font: {
                  size: 15,
                  family: "'Segoe UI', 'Helvetica Neue', 'Arial'"
              }
            }
          }
        },
        plugins : [ChartDataLabels]
    };

    // render init block
    const GraphM = new Chart(
        document.getElementById('GraphM'),
        configGraphM
    );

// BARGRAPH REPARTITION PAR CLASSES D'AGES
    // setup
    const dataGraphEC = {
      labels: <?php echo json_encode($ages); ?>,
      datasets: [{
        label: 'Habitués',
        data: <?php echo json_encode($effIndEC); ?>,
        backgroundColor: [
          '#2a7b9b'
        ],
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 2,
        borderRadius: {
          bottomLeft: 10,
          bottomRight: 10
        },
        borderSkipped: false,
        datalabels: {
        labels: {
            title: {
                font: {
                    weight: 'bold'
                }
            }
        },
        color: '#ffffff',
        anchor: 'center'
        }
      },{
        label: 'Primo-visiteurs',
        data: <?php echo json_encode($effIndECP); ?>,
        backgroundColor: [
          '#369cc4'
        ],
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 2,
        borderRadius: {
          topLeft: 10,
          topRight: 10
        },
        borderSkipped: false,
        datalabels: {
        labels: {
            title: {
                font: {
                    weight: 'bold'
                }
            }
        },
        color: '#ffffff',
        anchor: 'center'
        }
      }]
    };


    // config
    const configGraphEC = {
        type: 'bar',
        data: dataGraphEC,
        options: {
          responsive: true,
          aspectRatio: 2,
          maintainAspectRatio: false,
          scales: {
            x: {
              stacked: true,
              border: {
                diplay: false
              },
              grid: {
                display: false
              }
            },
            y: {
              stacked: true,
              display: false,
              beginAtZero: true
            }
          },
          plugins: {
            legend: {
              display: true,
              position: 'bottom'
            },
            datalabels: {
              font: {
                weight: 'bold',
                size: 16
              }
            },
            title: {
              display: true,
              text: "Effectifs par classe d'âges",
              position: 'bottom',
              font: {
                  size: 15,
                  family: "'Segoe UI', 'Helvetica Neue', 'Arial'"
              }
            }
          }
        },
        plugins : [ChartDataLabels]
    };

    // render init block
    const GraphEC = new Chart(
        document.getElementById('GraphEC'),
        configGraphEC
    );

// DOUGHNUT VISITES FAMILIALES
    // setup
    const dataFAM = {
        labels: <?php echo json_encode($labelFamille); ?>,
        datasets: [{
            backgroundColor: [
             '#2a7b9b',
             '#369cc4',
            ],
            borderColor: '#ffffff',
            borderWidth: 2,
            datalabels: {
                color: [
                  '#ffffff',
                  '#ffffff'
                  ],
                labels: {
                    title: {
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                backgroundColor: [
                   '#2a7b9b',
                   '#369cc4'
                ],
                borderColor: '#ffffff',
                borderRadius: 100,
                borderWidth: 2,
                anchor: 'center'
            },
            data: <?php echo json_encode($effFam); ?>,
        }]
    };

    // CenterText plugin
    const centerTextFAM = {
        id: 'centerTextFAM',
        afterDatasetsDraw(chart, args, options) {
            const {ctx, chartArea: {left, right, top, bottom, width, height}} = chart;

            ctx.save();

            var fontSize = (height / 75).toFixed(2);
            ctx.font = "bolder " + fontSize + "em Tahoma";
            ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
            ctx.textBaseline = "middle";
            var text = <?php echo json_encode($nbVisites); ?>,
              textX = Math.round((width - ctx.measureText(text).width) / 2),
              textY = height / 2;
            ctx.fillText(text, textX, textY);
            ctx.restore();

        }
    }

    // config
    const configFAM = {
        type: 'doughnut',
        data: dataFAM,
        options: {
          responsive: true,
          aspectRatio: 1,
          maintainAspectRatio: false,
            plugins: {
                legend: {
                  display: true,
                  position: 'bottom'
                },
                title: {
                  display: true,
                  text: 'Proportion des Visites Familiales',
                  position: 'bottom',
                  font: {
                      size: 15,
                      family: "'Segoe UI', 'Helvetica Neue', 'Arial'"
                  }
                }
            }
        },
        plugins: [ChartDataLabels, centerTextFAM]
    };

    // render init block
    const visitesFAM = new Chart(
        document.getElementById('visitesFAM'),
        configFAM
    );

// FREQUENTATION FRANCAIS
    // setup
    const dataGraphFR = { 
        labels: ["Fréquentation Français"],
        datasets: [
          {
            label: 'Habitués',
            data: [<?php echo json_encode($effFR[0]); ?>],
            backgroundColor: [
              '#2a7b9b'
            ],
            borderColor: [
              '#ffffff'
            ],
            borderWidth: 2,
            borderRadius: {
              bottomLeft: 10,
              bottomRight: 10
            },
            borderSkipped: false,
            datalabels: {
            labels: {
                title: {
                    font: {
                        weight: 'bold'
                    }
                }
            },
            color: '#ffffff',
            anchor: 'center'
            }
          },
          {
            label: 'Primo-Visiteurs',
            data: [<?php echo json_encode($effFR[1]); ?>],
            backgroundColor: [
              '#369cc4'
            ],
            borderColor: [
              '#ffffff'
            ],
            borderWidth: 2,
            borderRadius: {
              topLeft: 10,
              topRight: 10
            },
            borderSkipped: false,
            datalabels: {
            labels: {
                title: {
                    font: {
                        weight: 'bold'
                    }
                }
            },
            color: '#ffffff',
            anchor: 'center'
            }
          }
        ]
      };

    // config
    const configGraphFR = {
        type: 'bar',
        data: dataGraphFR,
        options: {
          responsive: true,
          aspectRatio: 2,
          maintainAspectRatio: false,
          scales: {
            x: {
              stacked: true,
              ticks: {
                display: false
              },
              border: {
                diplay: false
              },
              grid: {
                display: false
              }
            },
            y: {
              stacked: true,
              display: false,
              beginAtZero: true
            }
          },
          plugins: {
            legend: {
                display: true,
                position: 'bottom'
            },
            datalabels: {
              font: {
                weight: 'bold',
                size: 16
              }
            },
            title: {
              display: true,
              text: 'Effectif des Français',
              position: 'bottom',
              font: {
                  size: 15,
                  family: "'Segoe UI', 'Helvetica Neue', 'Arial'"
              }
            }
          }
        },
        plugins : [ChartDataLabels]
    };

    // render init block
    const GraphFR = new Chart(
        document.getElementById('GraphFR'),
        configGraphFR
    );

// DOUGHNUT REPARTITION PAR DEPARTEMENT DANS LA REGION
  // CenterText plugin
  const centerTextREG = {
      id: 'centerTextREG',
      afterDatasetsDraw(chart, args, options) {
          const {ctx, chartArea: {left, right, top, bottom, width, height}} = chart;

          ctx.save();

          var fontSize = (height / 75).toFixed(2);
          ctx.font = "bolder " + fontSize + "em Tahoma";
          ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
          ctx.textBaseline = "middle";
          var text = <?php echo json_encode($REGT); ?>,
            textX = Math.round((width - ctx.measureText(text).width) / 2),
            textY = height / 2;
          ctx.fillText(text, textX, textY);
          ctx.restore();
      }
  }

  var GraphDoughREG = new Chart('GraphDoughREG', {
    type: 'doughnut',
    data: {
      labels: <?php echo json_encode($LabelREGTP); ?>,
      datasets: [{
          labels: <?php echo json_encode($LabelREGP); ?>,
          data: <?php echo json_encode($effREGTP); ?>,
          backgroundColor: [
              '#6bb9d7',
              '#369cc4',
              '#f2e78a',
              '#ecdc50',
              '#fc708e',
              '#fa1a49'
            ],
            datalabels: {
                color: [
                  '#ffffff',
                  '#ffffff',
                  '#5e550a',
                  '#5e550a',
                  '#ffffff',
                  '#ffffff'
                  ],
                labels: {
                    title: {
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                backgroundColor: [
                  '#6bb9d7',
                  '#369cc4',
                  '#f2e78a',
                  '#ecdc50',
                  '#fc708e',
                  '#fa1a49'
                ],
                borderColor: '#ffffff',
                borderRadius: 100,
                borderWidth: 2,
                anchor: 'center'
            },
        },
        {
          labels: <?php echo json_encode($LabelREG); ?>,
          data: <?php echo json_encode($effREGT); ?>,
          backgroundColor: [
            '#2a7b9b',
            '#e5cf19',
            '#d30530'
          ],
            datalabels: {
                color: [
                  '#ffffff',
                  '#5e550a',
                  '#ffffff'
                  ],
                labels: {
                    title: {
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                backgroundColor: [
                  '#2a7b9b',
                  '#e5cf19',
                  '#d30530'
                ],
                borderColor: '#ffffff',
                borderRadius: 100,
                borderWidth: 2,
                anchor: 'center'
            },
        }
      ]
    },
    options: {
      responsive: true,
      aspectRatio: 1,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: true,
          position: 'bottom',
          labels: {
            generateLabels: function(chart) {
              // Get the default label list
              const original = Chart.overrides.pie.plugins.legend.labels.generateLabels;
              const labelsOriginal = original.call(this, chart);

              // Build an array of colors used in the datasets of the chart
              let datasetColors = chart.data.datasets.map(function(e) {
                return e.backgroundColor;
              });
              datasetColors = datasetColors.flat();

              // Modify the color and hide state of each label
              labelsOriginal.forEach(label => {
                // There are twice as many labels as there are datasets. This converts the label index into the corresponding dataset index
                //label.datasetIndex = (label.index - label.index % 2) / 2;

                // The hidden state must match the dataset's hidden state
                //label.hidden = !chart.isDatasetVisible(label.datasetIndex);

                // Change the color to match the dataset
                label.fillStyle = datasetColors[label.index];
              });

              return labelsOriginal;
            }
          },
          onClick: function(mouseEvent, legendItem, legend) {
            // toggle the visibility of the dataset from what it currently is
            legend.chart.getDatasetMeta(
              legendItem.datasetIndex
            ).hidden = legend.chart.isDatasetVisible(legendItem.datasetIndex);
            legend.chart.update();
          }
        },
        tooltip: {
          callbacks: {
            title: function(context) {
              //const labelIndex = (context[0].datasetIndex * 2) + context[0].dataIndex;
              if (context[0].datasetIndex == 0) {
              var labelIndex = context[0].dataIndex;
              } else {
              var labelIndex = context[0].dataIndex + <?php echo json_encode(count($LabelREGP)); ?>;
              }
              return context[0].chart.data.labels[labelIndex] + ': ' + context[0].formattedValue;
              
            }
          }
        },
        title: {
          display: true,
          text: <?php echo json_encode("Région : ".$default_regname);?>,
          position: 'bottom',
          font: {
              size: 15,
              family: "'Segoe UI', 'Helvetica Neue', 'Arial'"
          }
        }
      }
    },
    plugins: [centerTextREG,ChartDataLabels]
  });

// BARGRAPH REPARTITION PAR DEPARTEMENT
    // setup
    const dataGraphDEP = {
      labels: <?php echo json_encode($LabelDEP); ?>,
      datasets: [{
        label: 'Habitués',
        data: <?php echo json_encode($effDEP); ?>,
        backgroundColor: [
          '#2a7b9b'
        ],
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 2,
        borderRadius: {
          topLeft: 10,
          bottomLeft: 10
        },
        borderSkipped: false,
        datalabels: {
        labels: {
            title: {
                font: {
                    weight: 'bold'
                }
            }
        },
        color: '#1f343d',
        anchor: 'center'
        }
      },{
        label: 'Primo-visiteurs',
        data: <?php echo json_encode($effDEPP); ?>,
        backgroundColor: [
          '#369cc4'
        ],
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 2,
        borderRadius: {
          topRight: 10,
          bottomRight: 10
        },
        borderSkipped: false,
        datalabels: {
        labels: {
            title: {
                font: {
                    weight: 'bold'
                }
            }
        },
        color: '#1f343d',
        anchor: 'center'
        }
      }]
    };

    // config
    const configGraphDEP = {
        type: 'bar',
        data: dataGraphDEP,
        options: {
          responsive: false,
          aspectRatio: 0.5,
          maintainAspectRatio: false,
          indexAxis: 'y',
          scales: {
            x: {
              stacked: true,
              display: false,
              border: {
                diplay: false
              },
              grid: {
                display: false
              }
            },
            y: {
              stacked: true,
              display: true,
              beginAtZero: true
            }
          },
          plugins: {
            legend: {
              display: true,
              position: 'bottom'
            },
            datalabels: {
              font: {
                weight: 'bold',
                size: 16
              }
            },
            title: {
              display: true,
              text: <?php echo json_encode("Effectifs par Département (hors ".$default_regname.")");?>,
              position: 'bottom',
              font: {
                  size: 15,
                  family: "'Segoe UI', 'Helvetica Neue', 'Arial'"
              }
            }
          }
        },
        plugins : [ChartDataLabels]
    };

    // render init block
    const GraphDEP = new Chart(
        document.getElementById('GraphDEP'),
        configGraphDEP
    );

// BARGRAPH REPARTITION PAR PAYS
    // setup
    const dataGraphIPI = {
      labels: <?php echo json_encode($LabelPIP); ?>,
      datasets: [{
        label: 'Habitués',
        data: <?php echo json_encode($effIPI); ?>,
        backgroundColor: [
          '#2a7b9b'
        ],
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 2,
        borderRadius: {
          topLeft: 10,
          bottomLeft: 10
        },
        borderSkipped: false,
        datalabels: {
        labels: {
            title: {
                font: {
                    weight: 'bold'
                }
            }
        },
        color: '#ffffff',
        anchor: 'center'
        }
      },{
        label: 'Primo-visiteurs',
        data: <?php echo json_encode($effIPIP); ?>,
        backgroundColor: [
          '#369cc4'
        ],
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 2,
        borderRadius: {
          topRight: 10,
          bottomRight: 10
        },
        borderSkipped: false,
        datalabels: {
        labels: {
            title: {
                font: {
                    weight: 'bold'
                }
            }
        },
        color: '#ffffff',
        anchor: 'center'
        }
      }]
    };

    // config
    const configGraphIPI = {
        type: 'bar',
        data: dataGraphIPI,
        options: {
          responsive: true,
          maintainAspectRatio: false,
          indexAxis: 'y',
          scales: {
            x: {
              stacked: true,
              display: false,
              border: {
                diplay: false
              },
              grid: {
                display: false
              }
            },
            y: {
              stacked: true,
              display: true,
              beginAtZero: true
            }
          },
          plugins: {
            legend: {
              display: true,
              position: 'bottom'
            },
            datalabels: {
              font: {
                weight: 'bold',
                size: 16
              }
            },
            title: {
              display: true,
              text: "Effectifs par Pays (hors France)",
              position: 'bottom',
              font: {
                  size: 15,
                  family: "'Segoe UI', 'Helvetica Neue', 'Arial'"
              }
            }
          }
        },
        plugins : [ChartDataLabels]
    };

    // render init block
    const GraphIPI = new Chart(
        document.getElementById('GraphIPI'),
        configGraphIPI
    );

// BARGRAPH REPARTITION PAR REGION DU GLOBE
    // setup
    const dataGraphIRG = {
      labels: <?php echo json_encode($LabelGRP); ?>,
      datasets: [{
          label: 'Habitués',
          data: <?php echo json_encode($effIGR); ?>,
          backgroundColor: [
            '#2a7b9b'
          ],
          borderColor: [
            '#ffffff'
          ],
          borderWidth: 2,
          borderRadius: {
            topLeft: 10,
            bottomLeft: 10
          },
          borderSkipped: false,
          datalabels: {
          labels: {
              title: {
                  font: {
                      weight: 'bold'
                  }
              }
          },
          color: '#ffffff',
          anchor: 'center'
          }
        },{
          label: 'Primo-visiteurs',
          data: <?php echo json_encode($effIGRP); ?>,
          backgroundColor: [
            '#369cc4'
          ],
          borderColor: [
            '#ffffff'
          ],
          borderWidth: 2,
          borderRadius: {
            topRight: 10,
            bottomRight: 10
          },
          borderSkipped: false,
          datalabels: {
          labels: {
              title: {
                  font: {
                      weight: 'bold'
                  }
              }
          },
          color: '#ffffff',
          anchor: 'center'
          }
      }]
    };

    // config
    const configGraphIRG = {
        type: 'bar',
        data: dataGraphIRG,
        options: {
          responsive: true,
          aspectRatio: 2,
          maintainAspectRatio: false,
          indexAxis: 'y',
          scales: {
            x: {
              stacked: true,
              display: false,
              border: {
                diplay: false
              },
              grid: {
                display: false
              }
            },
            y: {
              stacked: true,
              display: true,
              beginAtZero: true
            }
          },
          plugins: {
            legend: {
              display: true,
              position: 'bottom'
            },
            datalabels: {
              font: {
                weight: 'bold',
                size: 16
              }
            },
            title: {
              display: true,
              text: "Effectifs par Région du Globe (hors français)",
              position: 'bottom',
              font: {
                  size: 15,
                  family: "'Segoe UI', 'Helvetica Neue', 'Arial'"
              }
            }
          }
        },
        plugins : [ChartDataLabels]
    };

    // render init block
    const GraphIRG = new Chart(
        document.getElementById('GraphIRG'),
        configGraphIRG
    );

</script>
