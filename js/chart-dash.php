<?php#############################################################################
# @Name : chart-dash.php
# @Description : Include du script javascript pour les graphiques et tableaux
#         ChartJs et DataTable pour le dashboard
# @Call : dash.php
# @Parameters : 
# @Author : G0osS
# @Create : 31/01/2024
# @Update : 15/04/2025
# @Version : 2.0.0
################################################################################?>


<script>
// DOUGHNUT DES VISITES INDIV-GROUPES/DAY
    // setup
    const dataIGD = {
        labels: <?php echo json_encode($labelVisitesD); ?>,
        datasets: [{
            backgroundColor: [
             '#2a7b9b',
             '#e5cf19',
            ],
            borderColor: '#ffffff',
            data: <?php echo json_encode($valVisitesD); ?>,
        }]
    };

    // CenterText plugin
    const centerTextIGD = {
        id: 'centerTextIGD',
        afterDatasetsDraw(chart, args, options) {
            const {ctx, chartArea: {left, right, top, bottom, width, height}} = chart;

            ctx.save();

            var fontSize = (height / 60).toFixed(2);
            ctx.font = "bolder " + fontSize + "em Tahoma";
            ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
            ctx.textBaseline = "middle";
            var text = <?php echo json_encode($nbVisitesD); ?>,
              textX = Math.round((width - ctx.measureText(text).width) / 2),
              textY = height / 2;
            ctx.fillText(text, textX, textY);
            ctx.restore();

        }
    }

    // config
    const configIGD = {
        type: 'doughnut',
        data: dataIGD,
        options: {
            responsive: true,
            aspectRatio: 1,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                  display: false,
                  position: 'bottom'
                },
                title: {
                  display: true,
                  text: 'Fréquentation',
                  position: 'bottom',
                  font: {
                      size: 15,
                      family: "'Segoe UI', 'Helvetica Neue', 'Arial'"
                  }
                }
            }
        },
        plugins: [centerTextIGD]
    };

    // render init block
    const visitesIGD = new Chart(
        document.getElementById('visitesIGD'),
        configIGD
    );


// DOUGHNUT DES VISITES INDIV-GROUPES/WEEK
    // setup
    const dataIGW = {
        labels: <?php echo json_encode($labelVisitesW); ?>,
        datasets: [{
            backgroundColor: [
             '#2a7b9b',
             '#e5cf19'
            ],
            borderColor: '#ffffff',
            borderWidth: 2,
            datalabels: {
                color: [
                  '#ffffff',
                  '#5e550a'
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
                   '#e5cf19'
                ],
                borderColor: '#ffffff',
                borderRadius: 100,
                borderWidth: 2,
                anchor: 'center'
            },
            data: <?php echo json_encode($valVisitesW); ?>,
        }]
    };

    // CenterText plugin
    const centerTextIGW = {
        id: 'centerTextIGW',
        afterDatasetsDraw(chart, args, options) {
            const {ctx, chartArea: {left, right, top, bottom, width, height}} = chart;

            ctx.save();

            var fontSize = (height / 60).toFixed(2);
            ctx.font = "bolder " + fontSize + "em Tahoma";
            ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
            ctx.textBaseline = "middle";
            var text = <?php echo json_encode($nbVisitesW); ?>,
              textX = Math.round((width - ctx.measureText(text).width) / 2),
              textY = height / 2;
            ctx.fillText(text, textX, textY);
            ctx.restore();

        }
    }

    // config
    const configIGW = {
        type: 'doughnut',
        data: dataIGW,
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
                  text: 'Fréquentation',
                  position: 'bottom',
                  font: {
                      size: 15,
                      family: "'Segoe UI', 'Helvetica Neue', 'Arial'"
                  }
                }
            }
        },
        plugins: [ChartDataLabels, centerTextIGW]
    };

    // render init block
    const visitesIGW = new Chart(
        document.getElementById('visitesIGW'),
        configIGW
    );

// STACKED BARGRAPH DES VISITES PAR PROVENANCE/WEEK
    // setup
    const dataGraphIW = {
        labels: ['Individuels', 'Groupes'],
        datasets: [{
          label: <?php echo json_encode($resident); ?>,
          data: <?php echo json_encode($resiW); ?>,
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
            backgroundColor: '#2a7b9b',
            color: '#ffffff',
            borderColor: '#ffffff',
            borderRadius: 100,
            borderWidth: 2,
            anchor: 'center'
          }
        },{
          label: <?php echo json_encode($collectivite); ?>,
          data: <?php echo json_encode($colW); ?>,
          backgroundColor: [
            '#e5cf19'
          ],
          borderColor: [
            '#ffffff'
          ],
          borderWidth: 2,
          datalabels: {
            labels: {
                title: {
                    font: {
                        weight: 'bold'
                    }
                }
            },
            backgroundColor: '#e5cf19',
            color: '#5e550a',
            borderColor: '#ffffff',
            borderRadius: 100,
            borderWidth: 2,
            anchor: 'center'
          }
        },{
          label: 'Extérieurs',
          data: <?php echo json_encode($OtherW); ?>,
          backgroundColor: [
            '#d30530'
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
            backgroundColor: '#d30530',
            color: '#ffffff',
            borderColor: '#ffffff',
            borderRadius: 100,
            borderWidth: 2,
            anchor: 'center'
          }
        }]
    };

    // config
    const configGraphIW = {
        type: 'bar',
        data: dataGraphIW,
        options: {
          responsive: true,
          aspectRatio: 1,
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
              position: 'top'
            },
            datalabels: {
              font: {
                weight: 'bold',
                size: 16
              }
            },
            title: {
              display: true,
              text: 'Provenance des Visiteurs',
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
    const GraphIW = new Chart(
        document.getElementById('GraphIW'),
        configGraphIW
    );

// FREQUENTATION SCOLAIRE/WEEK
    // setup
    const dataGraphSW = { 
        labels: ["Fréquentation des groupes"],
        datasets: [
          {
            label: 'Scolaires',
            data: [<?php echo json_encode($valFreqSW[1]); ?>],
            backgroundColor: [
              '#4f7a28'
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
            backgroundColor: '#4f7a28',
            color: '#ffffff',
            borderColor: '#ffffff',
            borderRadius: 100,
            borderWidth: 2,
            anchor: 'center'
            }
          },
          {
            label: 'Non Scolaires',
            data: [<?php echo json_encode($valFreqSW[0]); ?>],
            backgroundColor: [
              '#77bb41'
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
            backgroundColor: '#77bb41',
            color: '#ffffff',
            borderColor: '#ffffff',
            borderRadius: 100,
            borderWidth: 2,
            anchor: 'center'
            }
          }
        ]
      };

    // config
    const configGraphSW = {
        type: 'bar',
        data: dataGraphSW,
        options: {
          responsive: true,
          aspectRatio: 1,
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
                display: false
            },
            datalabels: {
              font: {
                weight: 'bold',
                size: 16
              }
            },
            title: {
              display: true,
              text: 'Les Scolaires',
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
    const GraphSW = new Chart(
        document.getElementById('GraphSW'),
        configGraphSW
    );

// DOUGHNUT DES GROUPES PAR ATELIER/WEEK
    // setup
    const dataAW = {
        labels: <?php echo json_encode($labelAtelierW); ?>,
      datasets: [{
        label: 'Fréquentation',
        data: <?php echo json_encode($valFreqW); ?>,
        borderWidth: 1,
        datalabels: {
            color: '#ffffff',
            labels: {
                title: {
                    font: {
                        weight: 'bold'
                    }
                }
            },
            borderColor: '#ffffff',
            borderRadius: 100,
            borderWidth: 2,
            anchor: 'center'
        },
      }]
    };

    // CenterText plugin
    const centerTextAW = {
        id: 'centerTextAW',
        afterDatasetsDraw(chart, args, options) {
            const {ctx, chartArea: {left, right, top, bottom, width, height}} = chart;

            ctx.save();

            var fontSize = (height / 60).toFixed(2);
            ctx.font = "bolder " + fontSize + "em Tahoma";
            ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
            ctx.textBaseline = "middle";
            var text = <?php echo json_encode($TotEffW); ?>,
              textX = Math.round((width - ctx.measureText(text).width) / 2),
              textY = height / 2;
            ctx.fillText(text, textX, textY);
            ctx.restore();

        }
    }

    // config
    const configAW = {
        type: 'doughnut',
        data: dataAW,
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
                  text: 'Fréquentation / Ateliers',
                  position: 'bottom',
                  font: {
                      size: 15,
                      family: "'Segoe UI', 'Helvetica Neue', 'Arial'"
                  }
                },
                colorschemes: {
                    scheme: 'tableau.ClassicColorBlind10',
                    override: true
                }
            }
        },
        plugins : [ChartDataLabels, centerTextAW]
    };

    // render init block
    const GraphAW = new Chart(
        document.getElementById('GraphAW'),
        configAW
    );


// DOUGHNUT DES VISITES INDIV-GROUPES/MONTH
    // setup
    const dataIGM = {
        labels: <?php echo json_encode($labelVisitesM); ?>,
        datasets: [{
            backgroundColor: [
             '#2a7b9b',
             '#e5cf19',
            ],
            borderColor: '#ffffff',
            borderWidth: 2,
            datalabels: {
                color: [
                  '#ffffff',
                  '#5e550a'
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
                   '#e5cf19'
                ],
                borderColor: '#ffffff',
                borderRadius: 100,
                borderWidth: 2,
                anchor: 'center'
            },
            data: <?php echo json_encode($valVisitesM); ?>,
        }]
    };

    // CenterText plugin
    const centerTextIGM = {
        id: 'centerTextIGM',
        afterDatasetsDraw(chart, args, options) {
            const {ctx, chartArea: {left, right, top, bottom, width, height}} = chart;

            ctx.save();

            var fontSize = (height / 65).toFixed(2);
            ctx.font = "bolder " + fontSize + "em Tahoma";
            ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
            ctx.textBaseline = "middle";
            var text = <?php echo json_encode($nbVisitesM); ?>,
              textX = Math.round((width - ctx.measureText(text).width) / 2),
              textY = height / 2;
            ctx.fillText(text, textX, textY);
            ctx.restore();

        }
    }

    // config
    const configIGM = {
        type: 'doughnut',
        data: dataIGM,
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
                  text: 'Fréquentation',
                  position: 'bottom',
                  font: {
                      size: 15,
                      family: "'Segoe UI', 'Helvetica Neue', 'Arial'"
                  }
                }
            }
        },
        plugins: [ChartDataLabels, centerTextIGM]
    };

    // render init block
    const visitesIGM = new Chart(
        document.getElementById('visitesIGM'),
        configIGM
    );

// STACKED BARGRAPH DES VISITES PAR PROVENANCE/MONTH
    // setup
    const dataGraphIM = {
        labels: ['Individuels', 'Groupes'],
        datasets: [{
          label: <?php echo json_encode($resident); ?>,
          data: <?php echo json_encode($resiM); ?>,
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
            backgroundColor: '#2a7b9b',
            color: '#ffffff',
            borderColor: '#ffffff',
            borderRadius: 100,
            borderWidth: 2,
            anchor: 'center'
          }
        },{
          label: <?php echo json_encode($collectivite); ?>,
          data: <?php echo json_encode($colM); ?>,
          backgroundColor: [
            '#e5cf19'
          ],
          borderColor: [
            '#ffffff'
          ],
          borderWidth: 2,
          datalabels: {
            labels: {
                title: {
                    font: {
                        weight: 'bold'
                    }
                }
            },
            backgroundColor: '#e5cf19',
            color: '#5e550a',
            borderColor: '#ffffff',
            borderRadius: 100,
            borderWidth: 2,
            anchor: 'center'
          }
        },{
          label: 'Extérieurs',
          data: <?php echo json_encode($OtherM); ?>,
          backgroundColor: [
            '#d30530'
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
            backgroundColor: '#d30530',
            color: '#ffffff',
            borderColor: '#ffffff',
            borderRadius: 100,
            borderWidth: 2,
            anchor: 'center'
          }
        }]
    };

    // config
    const configGraphIM = {
        type: 'bar',
        data: dataGraphIM,
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
              position: 'top'
            },
            datalabels: {
              font: {
                weight: 'bold',
                size: 16
              }
            },
            title: {
              display: true,
              text: 'Provenance des Visiteurs',
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
    const GraphIM = new Chart(
        document.getElementById('GraphIM'),
        configGraphIM
    );

// FREQUENTATION SCOLAIRE/MONTH
    // setup
    const dataGraphSM = { 
        labels: ["Effectifs des groupes"],
        datasets: [
          {
            label: 'Scolaires',
            data: [<?php echo json_encode($valEffSM[1]); ?>],
            backgroundColor: [
              '#4f7a28'
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
            backgroundColor: '#4f7a28',
            color: '#ffffff',
            borderColor: '#ffffff',
            borderRadius: 100,
            borderWidth: 2,
            anchor: 'center'
            }
          },
          {
            label: 'Non Scolaires',
            data: [<?php echo json_encode($valEffSM[0]); ?>],
            backgroundColor: [
              '#77bb41'
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
            backgroundColor: '#77bb41',
            color: '#ffffff',
            borderColor: '#ffffff',
            borderRadius: 100,
            borderWidth: 2,
            anchor: 'center'
            }
          }
        ]
      };

    // config
    const configGraphSM = {
        type: 'bar',
        data: dataGraphSM,
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
                display: false
            },
            datalabels: {
              font: {
                weight: 'bold',
                size: 16
              }
            },
            title: {
              display: true,
              text: 'Les Scolaires',
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
    const GraphSM = new Chart(
        document.getElementById('GraphSM'),
        configGraphSM
    );

// BARGRAPH REPARTITION PAR CLASSES D'AGES/MONTH
    // setup
    const dataGraphECM = {
      labels: <?php echo json_encode($ages); ?>,
      datasets: [{
        label: 'Individuels',
        data: <?php echo json_encode($effIndECM); ?>,
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
      },{
        label: 'Groupes',
        data: <?php echo json_encode($effGrpECM); ?>,
        backgroundColor: [
          '#e5cf19'
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
          color: '#5e550a'
        }
      }]
    };

    // config
    const configGraphECM = {
        type: 'bar',
        data: dataGraphECM,
        options: {
            responsive: true,
            aspectRatio: 2,
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
              display: true,
              position: 'top'
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
    const GraphECM = new Chart(
        document.getElementById('GraphECM'),
        configGraphECM
    );

// DOUGHNUT DES GROUPES PAR ATELIER/MONTH
    // setup
    const dataAM = {
        labels: <?php echo json_encode($labelAtelierM); ?>,
      datasets: [{
        label: 'Fréquentation',
        data: <?php echo json_encode($valEffM); ?>,
        borderWidth: 1,
        datalabels: {
            color: '#ffffff',
            labels: {
                title: {
                    font: {
                        weight: 'bold'
                    }
                }
            },
            borderColor: '#ffffff',
            borderRadius: 100,
            borderWidth: 2,
            anchor: 'center',
            offset: 10
        },
      }]
    };

    // CenterText plugin
    const centerTextAM = {
        id: 'centerTextAM',
        afterDatasetsDraw(chart, args, options) {
            const {ctx, chartArea: {left, right, top, bottom, width, height}} = chart;

            ctx.save();

            var fontSize = (height / 60).toFixed(2);
            ctx.font = "bolder " + fontSize + "em Tahoma";
            ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
            ctx.textBaseline = "middle";
            var text = <?php echo json_encode($TotEffM); ?>,
              textX = Math.round((width - ctx.measureText(text).width) / 2),
              textY = height / 2;
            ctx.fillText(text, textX, textY);
            ctx.restore();

        }
    }

    // config
    const configAM = {
        type: 'doughnut',
        data: dataAM,
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
                  text: 'Effectifs / Ateliers',
                  position: 'bottom',
                  font: {
                      size: 15,
                      family: "'Segoe UI', 'Helvetica Neue', 'Arial'"
                  }
                },
                colorschemes: {
                    scheme: 'tableau.ClassicColorBlind10',
                    override: true
                }
            }
        },
        plugins : [ChartDataLabels, centerTextAM]
    };

    // render init block
    const GraphAM = new Chart(
        document.getElementById('GraphAM'),
        configAM
    );

// BARGRAPH FREQUENTATION JOURNALIERE/MONTH
    // setup
    const dataGraphDM = {
      labels: <?php echo json_encode($days); ?>,
      datasets: [{
        label: 'Individuels',
        data: <?php echo json_encode($freqIndDM); ?>,
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
      },{
        label: 'Groupes',
        data: <?php echo json_encode($freqGrpDM); ?>,
        backgroundColor: [
          '#e5cf19'
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
          color: '#5e550a'
        }
      }]
    };

    // config
    const configGraphDM = {
        type: 'bar',
        data: dataGraphDM,
        options: {
            responsive: true,
            aspectRatio: 2,
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
              text: "Fréquentation moyenne journalière",
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
    const GraphDM = new Chart(
        document.getElementById('GraphDM'),
        configGraphDM
    );

// BARGRAPH FREQUENTATION HORAIRES/MONTH
    // setup
    const dataGraphHM = {
      labels: <?php echo json_encode($hours); ?>,
      datasets: [{
        label: 'Individuels',
        data: <?php echo json_encode($freqIndHM); ?>,
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
      },{
        label: 'Groupes',
        data: <?php echo json_encode($freqGrpHM); ?>,
        backgroundColor: [
          '#e5cf19'
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
          color: '#5e550a'
        }
      }]
    };

    // config
    const configGraphHM = {
        type: 'bar',
        data: dataGraphHM,
        options: {
            responsive: true,
            aspectRatio: 2,
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
    const GraphHM = new Chart(
        document.getElementById('GraphHM'),
        configGraphHM
    );


// DOUGHNUT DES VISITES INDIV-GROUPES/YEAR
    // setup
    const dataIGY = {
        labels: <?php echo json_encode($labelVisitesY); ?>,
        datasets: [{
            backgroundColor: [
             '#2a7b9b',
             '#e5cf19',
            ],
            borderColor: '#ffffff',
            borderWidth: 2,
            datalabels: {
                color: [
                  '#ffffff',
                  '#5e550a'
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
                   '#e5cf19'
                ],
                borderColor: '#ffffff',
                borderRadius: 100,
                borderWidth: 2,
                anchor: 'center'
            },
            data: <?php echo json_encode($valVisitesY); ?>,
        }]
    };

    // CenterText plugin
    const centerTextIGY = {
        id: 'centerTextIGY',
        afterDatasetsDraw(chart, args, options) {
            const {ctx, chartArea: {left, right, top, bottom, width, height}} = chart;

            ctx.save();

            var fontSize = (height / 75).toFixed(2);
            ctx.font = "bolder " + fontSize + "em Tahoma";
            ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
            ctx.textBaseline = "middle";
            var text = <?php echo json_encode($nbVisitesY); ?>,
              textX = Math.round((width - ctx.measureText(text).width) / 2),
              textY = height / 2;
            ctx.fillText(text, textX, textY);
            ctx.restore();

        }
    }

    // config
    const configIGY = {
        type: 'doughnut',
        data: dataIGY,
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
                  text: 'Fréquentation',
                  position: 'bottom',
                  font: {
                      size: 15,
                      family: "'Segoe UI', 'Helvetica Neue', 'Arial'"
                  }
                }
            }
        },
        plugins: [ChartDataLabels,centerTextIGY]
    };

    // render init block
    const visitesIGY = new Chart(
        document.getElementById('visitesIGY'),
        configIGY
    );

// STACKED BARGRAPH DES VISITES PAR PROVENANCE/YEAR
    // setup
    const dataGraphIY = {
        labels: ['Individuels', 'Groupes'],
        datasets: [{
          label: <?php echo json_encode($resident); ?>,
          data: <?php echo json_encode($resiY); ?>,
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
            backgroundColor: '#2a7b9b',
            color: '#ffffff',
            borderColor: '#ffffff',
            borderRadius: 100,
            borderWidth: 2,
            anchor: 'center'
          }
        },{
          label: <?php echo json_encode($collectivite); ?>,
          data: <?php echo json_encode($colY); ?>,
          backgroundColor: [
            '#e5cf19'
          ],
          borderColor: [
            '#ffffff'
          ],
          borderWidth: 2,
          datalabels: {
            labels: {
                title: {
                    font: {
                        weight: 'bold'
                    }
                }
            },
            backgroundColor: '#e5cf19',
            color: '#5e550a',
            borderColor: '#ffffff',
            borderRadius: 100,
            borderWidth: 2,
            anchor: 'center'
          }
        },{
          label: 'Extérieurs',
          data: <?php echo json_encode($OtherY); ?>,
          backgroundColor: [
            '#d30530'
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
            backgroundColor: '#d30530',
            color: '#ffffff',
            borderColor: '#ffffff',
            borderRadius: 100,
            borderWidth: 2,
            anchor: 'center'
          }
        }]
    };

    // config
    const configGraphIY = {
        type: 'bar',
        data: dataGraphIY,
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
              position: 'top'
            },
            datalabels: {
              font: {
                weight: 'bold',
                size: 16
              }
            },
            title: {
              display: true,
              text: 'Provenance des Visiteurs',
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
    const GraphIY = new Chart(
        document.getElementById('GraphIY'),
        configGraphIY
    );

// FREQUENTATION SCOLAIRE/YEAR
    // setup
    const dataGraphSY = { 
        labels: ["Effectifs des Groupes"],
        datasets: [
          {
            label: 'Scolaires',
            data: [<?php echo json_encode($valEffSY[1]); ?>],
            backgroundColor: [
              '#4f7a28'
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
            backgroundColor: '#4f7a28',
            color: '#ffffff',
            borderColor: '#ffffff',
            borderRadius: 100,
            borderWidth: 2,
            anchor: 'center'
            }
          },
          {
            label: 'Non Scolaires',
            data: [<?php echo json_encode($valEffSY[0]); ?>],
            backgroundColor: [
              '#77bb41'
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
            backgroundColor: '#77bb41',
            color: '#ffffff',
            borderColor: '#ffffff',
            borderRadius: 100,
            borderWidth: 2,
            anchor: 'center'
            }
          }
        ]
      };

    // config
    const configGraphSY = {
        type: 'bar',
        data: dataGraphSY,
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
                display: false
            },
            datalabels: {
              font: {
                weight: 'bold',
                size: 16
              }
            },
            title: {
              display: true,
              text: 'Les Scolaires',
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
    const GraphSY = new Chart(
        document.getElementById('GraphSY'),
        configGraphSY
    );

// BARGRAPH REPARTITION PAR CLASSES D'AGES/YEAR
    // setup
    const dataGraphECY = {
      labels: <?php echo json_encode($ages); ?>,
      datasets: [{
        label: 'Individuels',
        data: <?php echo json_encode($effIndECY); ?>,
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
      },{
        label: 'Nb Groupes',
        data: <?php echo json_encode($NbGrpECY); ?>,
        backgroundColor: [
          '#e5cf19'
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
          color: '#5e550a'
        }
      }]
    };

    // config
    const configGraphECY = {
        type: 'bar',
        data: dataGraphECY,
        options: {
            responsive: true,
            aspectRatio: 2,
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
                  display: true,
                  position: 'top'
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
    const GraphECY = new Chart(
        document.getElementById('GraphECY'),
        configGraphECY
    );

// DOUGHNUT DES GROUPES PAR ATELIER/YEAR
    // setup
    const dataAY = {
        labels: <?php echo json_encode($labelAtelierY); ?>,
      datasets: [{
        label: 'Fréquentation',
        data: <?php echo json_encode($valEffY); ?>,
        borderWidth: 1,
        datalabels: {
            color: '#ffffff',
            backgroundColor : chart => {
                console.log(chart.dataset.backgroundColor[chart.dataIndex])
                return chart.dataset.backgroundColor[chart.dataIndex];
            },
            labels: {
                title: {
                    font: {
                        weight: 'bold'
                    }
                }
            },
            borderColor: '#ffffff',
            borderRadius: 100,
            borderWidth: 2,
            anchor: 'end',
            offset: 10
        },
      }]
    };

    // CenterText plugin
    const centerTextAY = {
        id: 'centerTextAY',
        afterDatasetsDraw(chart, args, options) {
            const {ctx, chartArea: {left, right, top, bottom, width, height}} = chart;

            ctx.save();

            var fontSize = (height / 60).toFixed(2);
            ctx.font = "bolder " + fontSize + "em Tahoma";
            ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
            ctx.textBaseline = "middle";
            var text = <?php echo json_encode($TotEffY); ?>,
              textX = Math.round((width - ctx.measureText(text).width) / 2),
              textY = height / 2;
            ctx.fillText(text, textX, textY);
            ctx.restore();

        }
    }

    // config
    const configAY = {
        type: 'doughnut',
        data: dataAY,
        options: {
            responsive: true,
            aspectRatio: 1,
            maintainAspectRatio: false,
            layout: {
                padding: {
                    top: 10,
                    bottom: 10
                }
            },
            plugins: {
                legend: {
                  display: true,
                  position: 'bottom',
                  labels: {
                    padding: 10
                  }
                },
                title: {
                  display: true,
                  text: 'Effectifs / Ateliers',
                  position: 'bottom',
                  font: {
                      size: 15,
                      family: "'Segoe UI', 'Helvetica Neue', 'Arial'"
                  }
                },
                colorschemes: {
                    scheme: 'tableau.ClassicColorBlind10',
                    override: true
                }
            }
        },
        plugins : [ChartDataLabels, centerTextAY]
    };

    // render init block
    const GraphAY = new Chart(
        document.getElementById('GraphAY'),
        configAY
    );

// BARGRAPH FREQUENTATION JOURNALIERE/YEAR
    // setup
    const dataGraphDY = {
      labels: <?php echo json_encode($days); ?>,
      datasets: [{
        label: 'Individuels',
        data: <?php echo json_encode($freqIndDY); ?>,
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
      },{
        label: 'Groupes',
        data: <?php echo json_encode($freqGrpDY); ?>,
        backgroundColor: [
          '#e5cf19'
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
          color: '#5e550a'
        }
      }]
    };

    // config
    const configGraphDY = {
        type: 'bar',
        data: dataGraphDY,
        options: {
            responsive: true,
            aspectRatio: 2,
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
              text: "Fréquentation moyenne journalière",
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
    const GraphDY = new Chart(
        document.getElementById('GraphDY'),
        configGraphDY
    );

// BARGRAPH FREQUENTATION HORAIRES/YEAR
    // setup
    const dataGraphHY = {
      labels: <?php echo json_encode($hours); ?>,
      datasets: [{
        label: 'Individuels',
        data: <?php echo json_encode($freqIndHY); ?>,
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
      },{
        label: 'Groupes',
        data: <?php echo json_encode($freqGrpHY); ?>,
        backgroundColor: [
          '#e5cf19'
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
          color: '#5e550a'
        }
      }]
    };

    // config
    const configGraphHY = {
        type: 'bar',
        data: dataGraphHY,
        options: {
            responsive: true,
            aspectRatio: 2,
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
    const GraphHY = new Chart(
        document.getElementById('GraphHY'),
        configGraphHY
    );

// BARGRAPH FREQUENTATIONS/SECTEUR
    // setup
    const dataGraphSECTY = {
      labels: <?php echo json_encode($LabelSECT); ?>,
      datasets: [{
        label: 'Individuels Habitués',
        data: <?php echo json_encode($effISECT); ?>,
        stack: 'Stack 0',
        backgroundColor: [
          '#2a7b9b'
        ],
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 1,
        borderRadius: {
          topLeft: 10,
          bottomLeft: 10
        },
        borderSkipped: false,
        datalabels: {
          color: 'white'
        }
      },{
        label: 'Individuels Primo-Visiteurs',
        data: <?php echo json_encode($effISECTP); ?>,
        stack: 'Stack 0',
        backgroundColor: [
          '#369cc4'
        ],
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 1,
        borderRadius: {
          topRight: 10,
          bottomRight: 10
        },
        borderSkipped: false,
        datalabels: {
          color: 'white'
        }
      },{
        label: 'Groupes Scolaires',
        data: <?php echo json_encode($effGSECTP); ?>,
        stack: 'Stack 1',
        backgroundColor: [
          '#e5cf19'
        ],
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 1,
        borderRadius: {
          topLeft: 10,
          bottomLeft: 10
        },
        borderSkipped: false,
        datalabels: {
          color: '#5e550a'
        }
      },{
        label: 'Groupes Non Scolaires',
        data: <?php echo json_encode($effGSECT); ?>,
        stack: 'Stack 1',
        backgroundColor: [
          '#ecdc50'
        ],
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 1,
        borderRadius: {
          topRight: 10,
          bottomRight: 10
        },
        borderSkipped: false,
        datalabels: {
          color: '#5e550a'
        }
      }]
    };

    // config
    const configGraphSECTY = {
        type: 'bar',
        data: dataGraphSECTY,
        options: {
          responsive: true,
          aspectRatio: 1,
          maintainAspectRatio: true,
          indexAxis: 'y',
          scales: {
            x: {
              stacked: true,
              display: false,
              beginAtZero: true
            },
            y: {
              stacked: true,
              display: true,
              border: {
                diplay: false
              },
              grid: {
                display: false
              }
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
              text: "Effectifs par Secteur",
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
    const GraphSECTY = new Chart(
        document.getElementById('GraphSECTY'),
        configGraphSECTY
    );

// BARGRAPH FREQUENTATIONS/EXPO
    // setup
    const dataGraphEXPOY = {
      labels: <?php echo json_encode($LabelEXPO); ?>,
      datasets: [{
        label: 'Individuels Habitués',
        data: <?php echo json_encode($effIEXPO); ?>,
        stack: 'Stack 0',
        backgroundColor: [
          '#2a7b9b'
        ],
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 1,
        borderRadius: {
          topLeft: 10,
          bottomLeft: 10
        },
        borderSkipped: false,
        datalabels: {
          color: 'white'
        }
      },{
        label: 'Individuels Primo-Visiteurs',
        data: <?php echo json_encode($effIEXPOP); ?>,
        stack: 'Stack 0',
        backgroundColor: [
          '#369cc4'
        ],
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 1,
        borderRadius: {
          topRight: 10,
          bottomRight: 10
        },
        borderSkipped: false,
        datalabels: {
          color: 'white'
        }
      },{
        label: 'Groupes Scolaires',
        data: <?php echo json_encode($effGEXPOP); ?>,
        stack: 'Stack 1',
        backgroundColor: [
          '#e5cf19'
        ],
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 1,
        borderRadius: {
          topLeft: 10,
          bottomLeft: 10
        },
        borderSkipped: false,
        datalabels: {
          color: '#5e550a'
        }
      },{
        label: 'Groupes Non Scolaires',
        data: <?php echo json_encode($effGEXPO); ?>,
        stack: 'Stack 1',
        backgroundColor: [
          '#ecdc50'
        ],
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 1,
        borderRadius: {
          topRight: 10,
          bottomRight: 10
        },
        borderSkipped: false,
        datalabels: {
          color: '#5e550a'
        }
      }]
    };

    // config
    const configGraphEXPOY = {
        type: 'bar',
        data: dataGraphEXPOY,
        options: {
          responsive: true,
          aspectRatio: 1,
          maintainAspectRatio: true,
          indexAxis: 'y',
          scales: {
            x: {
              stacked: true,
              display: false,
              beginAtZero: true
            },
            y: {
              stacked: true,
              display: true,
              border: {
                diplay: false
              },
              grid: {
                display: false
              }
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
              text: "Effectifs par Exposition",
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
    const GraphEXPOY = new Chart(
        document.getElementById('GraphEXPOY'),
        configGraphEXPOY
    );

// BARGRAPH FREQUENTATIONS/EVTS
    // setup
    const dataGraphEVTY = {
      labels: <?php echo json_encode($LabelEVT); ?>,
      datasets: [{
        label: 'Individuels Habitués',
        data: <?php echo json_encode($effIEVT); ?>,
        stack: 'Stack 0',
        backgroundColor: [
          '#2a7b9b'
        ],
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 1,
        borderRadius: {
          topLeft: 10,
          bottomLeft: 10
        },
        borderSkipped: false,
        datalabels: {
          color: 'white'
        }
      },{
        label: 'Individuels Primo-Visiteurs',
        data: <?php echo json_encode($effIEVTP); ?>,
        stack: 'Stack 0',
        backgroundColor: [
          '#369cc4'
        ],
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 1,
        borderRadius: {
          topRight: 10,
          bottomRight: 10
        },
        borderSkipped: false,
        datalabels: {
          color: 'white'
        }
      },{
        label: 'Groupes Scolaires',
        data: <?php echo json_encode($effGEVTP); ?>,
        stack: 'Stack 1',
        backgroundColor: [
          '#e5cf19'
        ],
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 1,
        borderRadius: {
          topLeft: 10,
          bottomLeft: 10
        },
        borderSkipped: false,
        datalabels: {
          color: '#5e550a'
        }
      },{
        label: 'Groupes Non Scolaires',
        data: <?php echo json_encode($effGEVT); ?>,
        stack: 'Stack 1',
        backgroundColor: [
          '#ecdc50'
        ],
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 1,
        borderRadius: {
          topRight: 10,
          bottomRight: 10
        },
        borderSkipped: false,
        datalabels: {
          color: '#5e550a'
        }
      }]
    };

    // config
    const configGraphEVTY = {
        type: 'bar',
        data: dataGraphEVTY,
        options: {
          responsive: true,
          aspectRatio: 1,
          maintainAspectRatio: true,
          indexAxis: 'y',
          scales: {
            x: {
              stacked: true,
              display: false,
              beginAtZero: true
            },
            y: {
              stacked: true,
              display: true,
              border: {
                diplay: false
              },
              grid: {
                display: false
              }
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
              text: "Effectifs par Evenement",
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
    const GraphEVTY = new Chart(
        document.getElementById('GraphEVTY'),
        configGraphEVTY
    );

</script>
