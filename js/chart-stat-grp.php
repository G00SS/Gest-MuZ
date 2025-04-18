<?php##########################################################################
# @Name : chart-stat-grp.php
# @Description : Include du script javascript pour les graphiques et tableaux
#         ChartJs et DataTable pour les visites de Groupes
# @Call : stat-grp.php
# @Parameters : 
# @Author : G0osS
# @Create : 31/01/2024
# @Update : 15/04/2025
# @Version : 2.0.0
##############################################################################?>


<script>

// DOUGHNUT EFF PROVENANCE & SCOLAIRE
  // CenterText plugin
  const centerTextEfGPP = {
      id: 'centerTextEfGPP',
      afterDatasetsDraw(chart, args, options) {
          const {ctx, chartArea: {left, right, top, bottom, width, height}} = chart;

          ctx.save();

          var fontSize = (height / 75).toFixed(2);
          ctx.font = "bolder " + fontSize + "em Tahoma";
          ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
          ctx.textBaseline = "middle";
          var text = <?php echo json_encode($Toteff); ?>,
            textX = Math.round((width - ctx.measureText(text).width) / 2),
            textY = height / 2;
          ctx.fillText(text, textX, textY);
          ctx.restore();
      }
  }

  var GraphDoughEfGPP = new Chart('GraphDoughEfGPP', {
    type: 'doughnut',
    data: {
      labels: [<?php echo json_encode('Scolaires '.$resident); ?>, <?php echo json_encode($resident.' Non-scolaires'); ?>, <?php echo json_encode('Scolaires '.$collectivite); ?>, <?php echo json_encode($collectivite.' Non-scolaires'); ?>, 'Extérieurs Scolaires', 'Extérieurs Non-scolaires', <?php echo json_encode($resident); ?>,<?php echo json_encode($collectivite); ?>, 'Extérieurs'],
      datasets: [{
          labels: ['Résidents Scolaires', 'Résidents Non-scolaires', 'Collectivitée Scolaires', 'Collectivitée Non-scolaires', 'Extérieurs Scolaires', 'Extérieurs Non-scolaires'],
          data: <?php echo json_encode($EfGrpDetail1); ?>,
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
          data: <?php echo json_encode($GrpEffTot); ?>,
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
          text: ' Effectifs des groupes / Provenance & Scolaire',
          position: 'bottom',
          font: {
              size: 15,
              family: "'Segoe UI', 'Helvetica Neue', 'Arial'"
          }
        }
      }
    },
    plugins: [centerTextEfGPP,ChartDataLabels]
  });

// DOUGHNUT EFF PROVENANCE & PAYANT
  // CenterText plugin
  const centerTextEfGPF = {
      id: 'centerTextEfGPF',
      afterDatasetsDraw(chart, args, options) {
          const {ctx, chartArea: {left, right, top, bottom, width, height}} = chart;

          ctx.save();

          var fontSize = (height / 75).toFixed(2);
          ctx.font = "bolder " + fontSize + "em Tahoma";
          ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
          ctx.textBaseline = "middle";
          var text = <?php echo json_encode($Toteff); ?>,
            textX = Math.round((width - ctx.measureText(text).width) / 2),
            textY = height / 2;
          ctx.fillText(text, textX, textY);
          ctx.restore();
      }
  }

  var GraphDoughEfGPF = new Chart('GraphDoughEfGPF', {
    type: 'doughnut',
    data: {
      labels: [<?php echo json_encode($resident.' Gratuits'); ?>, <?php echo json_encode($resident.' Payants'); ?>, <?php echo json_encode($collectivite.' Gratuits'); ?>, <?php echo json_encode($collectivite.' Payants'); ?>, 'Extérieurs Gratuits', 'Extérieurs Payants', <?php echo json_encode($resident); ?>,<?php echo json_encode($collectivite); ?>, 'Extérieurs'],
      datasets: [{
          labels: ['Résidents Gratuits', 'Résidents Payants', 'Collectivitée Gratuits', 'Collectivitée Payants', 'Extérieurs Gratuits', 'Extérieurs Payants'],
          data: <?php echo json_encode($EfGrpDetail2); ?>,
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
          data: <?php echo json_encode($GrpEffTot); ?>,
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
          text: 'Visites Payantes en fonction de la Provenance des Groupes',
          position: 'bottom',
          font: {
              size: 15,
              family: "'Segoe UI', 'Helvetica Neue', 'Arial'"
          }
        }
      }
    },
    plugins: [centerTextEfGPF,ChartDataLabels]
  });

// DOUGHNUT EFF PROVENANCE & GUIDEES
  // CenterText plugin
  const centerTextEfGPG = {
      id: 'centerTextEfGPG',
      afterDatasetsDraw(chart, args, options) {
          const {ctx, chartArea: {left, right, top, bottom, width, height}} = chart;

          ctx.save();

          var fontSize = (height / 75).toFixed(2);
          ctx.font = "bolder " + fontSize + "em Tahoma";
          ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
          ctx.textBaseline = "middle";
          var text = <?php echo json_encode($Toteff); ?>,
            textX = Math.round((width - ctx.measureText(text).width) / 2),
            textY = height / 2;
          ctx.fillText(text, textX, textY);
          ctx.restore();
      }
  }

  var GraphDoughEfGPG = new Chart('GraphDoughEfGPG', {
    type: 'doughnut',
    data: {
      labels: [<?php echo json_encode($resident.' Autonomes'); ?>, <?php echo json_encode($resident.' Guidés'); ?>, <?php echo json_encode($collectivite.' Autonomes'); ?>, <?php echo json_encode($collectivite.' Guidés'); ?>, 'Extérieurs Autonomes', 'Extérieurs Guidés', <?php echo json_encode($resident); ?>,<?php echo json_encode($collectivite); ?>, 'Extérieurs'],
      datasets: [{
          labels: ['Résidents Autonomes', 'Résidents Guidés', 'Collectivitée Autonomes', 'Collectivitée Guidés', 'Extérieurs Autonomes', 'Extérieurs Guidés'],
          data: <?php echo json_encode($EfGrpDetail3); ?>,
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
          data: <?php echo json_encode($GrpEffTot); ?>,
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
          text: 'Visites Guidées en fonction de la Provenance des Groupes',
          position: 'bottom',
          font: {
              size: 15,
              family: "'Segoe UI', 'Helvetica Neue', 'Arial'"
          }
        }
      }
    },
    plugins: [centerTextEfGPG,ChartDataLabels]
  });

// DOUGHNUT GRP PROVENANCE & SCOLAIRE
  // CenterText plugin
  const centerTextGPP = {
      id: 'centerTextGPP',
      afterDatasetsDraw(chart, args, options) {
          const {ctx, chartArea: {left, right, top, bottom, width, height}} = chart;

          ctx.save();

          var fontSize = (height / 75).toFixed(2);
          ctx.font = "bolder " + fontSize + "em Tahoma";
          ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
          ctx.textBaseline = "middle";
          var text = <?php echo json_encode($Totgrp); ?>,
            textX = Math.round((width - ctx.measureText(text).width) / 2),
            textY = height / 2;
          ctx.fillText(text, textX, textY);
          ctx.restore();
      }
  }

  var GraphDoughGPP = new Chart('GraphDoughGPP', {
    type: 'doughnut',
    data: {
      labels: [<?php echo json_encode('Scolaires '.$resident); ?>, <?php echo json_encode($resident.' Non-scolaires'); ?>, <?php echo json_encode('Scolaires '.$collectivite); ?>, <?php echo json_encode($collectivite.' Non-scolaires'); ?>, 'Extérieurs Scolaires', 'Extérieurs Non-scolaires', <?php echo json_encode($resident); ?>,<?php echo json_encode($collectivite); ?>, 'Extérieurs'],
      datasets: [{
          labels: ['Résidents Scolaires', 'Résidents Non-scolaires', 'Collectivitée Scolaires', 'Collectivitée Non-scolaires', 'Extérieurs Scolaires', 'Extérieurs Non-scolaires'],
          data: <?php echo json_encode($GrpDetail1); ?>,
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
          data: <?php echo json_encode($GrpTot); ?>,
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
          display: false,
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
          text: ' Nombre de groupes / Provenance & Scolaire',
          position: 'bottom',
          font: {
              size: 15,
              family: "'Segoe UI', 'Helvetica Neue', 'Arial'"
          }
        }
      }
    },
    plugins: [centerTextGPP,ChartDataLabels]
  });

// DOUGHNUT GRP PROVENANCE & PAYANT
  // CenterText plugin
  const centerTextGPF = {
      id: 'centerTextGPF',
      afterDatasetsDraw(chart, args, options) {
          const {ctx, chartArea: {left, right, top, bottom, width, height}} = chart;

          ctx.save();

          var fontSize = (height / 75).toFixed(2);
          ctx.font = "bolder " + fontSize + "em Tahoma";
          ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
          ctx.textBaseline = "middle";
          var text = <?php echo json_encode($Totgrp); ?>,
            textX = Math.round((width - ctx.measureText(text).width) / 2),
            textY = height / 2;
          ctx.fillText(text, textX, textY);
          ctx.restore();
      }
  }

  var GraphDoughGPF = new Chart('GraphDoughGPF', {
    type: 'doughnut',
    data: {
      labels: [<?php echo json_encode($resident.' Gratuits'); ?>, <?php echo json_encode($resident.' Payants'); ?>, <?php echo json_encode($collectivite.' Gratuits'); ?>, <?php echo json_encode($collectivite.' Payants'); ?>, 'Extérieurs Gratuits', 'Extérieurs Payants', <?php echo json_encode($resident); ?>,<?php echo json_encode($collectivite); ?>, 'Extérieurs'],
      datasets: [{
          labels: ['Résidents Gratuits', 'Résidents Payants', 'Collectivitée Gratuits', 'Collectivitée Payants', 'Extérieurs Gratuits', 'Extérieurs Payants'],
          data: <?php echo json_encode($GrpDetail2); ?>,
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
          data: <?php echo json_encode($GrpTot); ?>,
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
          display: false,
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
          text: 'Nombre de Groupes Payants en fonction de la Provenance',
          position: 'bottom',
          font: {
              size: 15,
              family: "'Segoe UI', 'Helvetica Neue', 'Arial'"
          }
        }
      }
    },
    plugins: [centerTextGPF,ChartDataLabels]
  });

// DOUGHNUT GRP PROVENANCE & GUIDEES
  // CenterText plugin
  const centerTextGPG = {
      id: 'centerTextGPG',
      afterDatasetsDraw(chart, args, options) {
          const {ctx, chartArea: {left, right, top, bottom, width, height}} = chart;

          ctx.save();

          var fontSize = (height / 75).toFixed(2);
          ctx.font = "bolder " + fontSize + "em Tahoma";
          ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
          ctx.textBaseline = "middle";
          var text = <?php echo json_encode($Totgrp); ?>,
            textX = Math.round((width - ctx.measureText(text).width) / 2),
            textY = height / 2;
          ctx.fillText(text, textX, textY);
          ctx.restore();
      }
  }

  var GraphDoughGPG = new Chart('GraphDoughGPG', {
    type: 'doughnut',
    data: {
      labels: [<?php echo json_encode($resident.' Autonomes'); ?>, <?php echo json_encode($resident.' Guidés'); ?>, <?php echo json_encode($collectivite.' Autonomes'); ?>, <?php echo json_encode($collectivite.' Guidés'); ?>, 'Extérieurs Autonomes', 'Extérieurs Guidés', <?php echo json_encode($resident); ?>,<?php echo json_encode($collectivite); ?>, 'Extérieurs'],
      datasets: [{
          labels: ['Résidents Autonomes', 'Résidents Guidés', 'Collectivitée Autonomes', 'Collectivitée Guidés', 'Extérieurs Autonomes', 'Extérieurs Guidés'],
          data: <?php echo json_encode($GrpDetail3); ?>,
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
          data: <?php echo json_encode($GrpTot); ?>,
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
          display: false,
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
          text: 'Nombre de Groupes Guidés en fonction de la Provenance',
          position: 'bottom',
          font: {
              size: 15,
              family: "'Segoe UI', 'Helvetica Neue', 'Arial'"
          }
        }
      }
    },
    plugins: [centerTextGPG,ChartDataLabels]
  });


// BARGRAPH FREQUENTATION JOURNALIERE
    // setup
    const dataGraphGD = {
      labels: <?php echo json_encode($days); ?>,
      datasets: [{
        label: 'Nombre de Groupes',
        data: <?php echo json_encode($freqGrpD); ?>,
        backgroundColor: [
          '#f2e78a'
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
      },{
        label: 'Effectifs',
        data: <?php echo json_encode($freqEffGrpD); ?>,
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
    const configGraphGD = {
        type: 'bar',
        data: dataGraphGD,
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
    const GraphGD = new Chart(
        document.getElementById('GraphGD'),
        configGraphGD
    );

// BARGRAPH FREQUENTATION HORAIRES
    // setup
    const dataGraphGH = {
      labels: <?php echo json_encode($hours); ?>,
      datasets: [{
        label: 'Nombre de Groupes',
        data: <?php echo json_encode($frequGrpH); ?>,
        backgroundColor: [
          '#f2e78a'
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
      },{
        label: 'Effectif',
        data: <?php echo json_encode($frequEffGrpH); ?>,
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
    const configGraphGH = {
        type: 'bar',
        data: dataGraphGH,
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
    const GraphGH = new Chart(
        document.getElementById('GraphGH'),
        configGraphGH
    );


// BARGRAPH REPARTITION PAR SECTEUR
    // setup
    const dataGraphSECT = {
      labels: <?php echo json_encode($LabelSECT); ?>,
      datasets: [{
        label: 'Scolaires',
        data: <?php echo json_encode($effSECTP); ?>,
        backgroundColor: [
          '#e5cf19'
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
        color: '#5e550a',
        anchor: 'center'
        }
      },{
        label: 'Non-Scolaires',
        data: <?php echo json_encode($effSECT); ?>,
        backgroundColor: [
          '#f2e78a'
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
        color: '#5e550a',
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
        label: 'Scolaires',
        data: <?php echo json_encode($effEXPOP); ?>,
        backgroundColor: [
          '#e5cf19'
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
        color: '#5e550a',
        anchor: 'center'
        }
      },{
        label: 'Non-Scolaires',
        data: <?php echo json_encode($effEXPO); ?>,
        backgroundColor: [
          '#f2e78a'
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
        color: '#5e550a',
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
        label: 'Scolaires',
        data: <?php echo json_encode($effEVTP); ?>,
        backgroundColor: [
          '#e5cf19'
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
        color: '#5e550a',
        anchor: 'center'
        }
      },{
        label: 'Non-Scolaires',
        data: <?php echo json_encode($effEVT); ?>,
        backgroundColor: [
          '#f2e78a'
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
        color: '#5e550a',
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

// TABLEAU RECAP GROUPES ATELIERS
  $(document).ready( function () {
      var table = $('#grpAP').DataTable( {
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
        "dom": "Bfrtlip",
        lengthMenu: [
            [ 5, 10, 25, 50, -1 ],
            [ '5 lignes', '10 lignes', '25 lignes', '50 lignes', 'Tout afficher' ]
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
                "visible": false,
                "orderable": false,
                "searchable": false
            },
            {
                "targets": [ 1,2 ],
                "orderable": true,
                "searchable": true,
                "className": 'dt-left'
            },
            {
                "targets": [ 3,4,5,6,7,8 ],
                "orderable": true,
                "searchable": false,
                "className": 'dt-center'
            }
        ]
      } );
      table.buttons().container()
          .appendTo( '#grpAP_wrapper .col-md-6:eq(0)' );
  } );

// TABLEAU RECAP EFFECTIFS GROUPES ATELIERS
  $(document).ready( function () {
      var table = $('#grpAE').DataTable( {
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
        "dom": "Bfrtlip",
        lengthMenu: [
            [ 5, 10, 25, 50, -1 ],
            [ '5 lignes', '10 lignes', '25 lignes', '50 lignes', 'Tout afficher' ]
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
                "visible": false,
                "orderable": false,
                "searchable": false
            },
            {
                "targets": [ 1,2 ],
                "orderable": true,
                "searchable": true,
                "className": 'dt-left'
            },
            {
                "targets": [ 3,4,5,6,7,8 ],
                "orderable": true,
                "searchable": false,
                "className": 'dt-center'
            }
        ]
      } );
      table.buttons().container()
          .appendTo( '#grpAE_wrapper .col-md-6:eq(0)' );
  } );


// BARGRAPH REPARTITION PAR TYPE DE GROUPES
    // setup
    const dataGraphG = {
      labels: <?php echo json_encode($type); ?>,
      datasets: [{
        label: 'Nombre de Groupes',
        data: <?php echo json_encode($nbGrpT); ?>,
        backgroundColor: <?php echo json_encode($GrpTScol); ?>,
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 1,
        borderRadius: 10,
        borderSkipped: false,
        datalabels: {
          color: '#5e550a'
        },
        xAxisID: 'x',
      },{
        label: 'Effectif',
        data: <?php echo json_encode($effGrpT); ?>,
        backgroundColor: <?php echo json_encode($GrpTScol); ?>,
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 2,
        borderRadius: 10,
        borderSkipped: false,
        datalabels: {
        labels: {
            title: {
                font: {
                    weight: 'bold'
                }
            }
        },
        color: '#5e550a',
        anchor: 'center'
        },
        xAxisID: 'x1',
      }]
    };

    // config
    const configGraphG = {
        type: 'bar',
        data: dataGraphG,
        options: {
          responsive: true,
          aspectRatio: 1,
          maintainAspectRatio: true,
          indexAxis: "y",
          scales: {
            x: {
              display: false,
              stacked: false,
              border: {
                diplay: false
              },
              grid: {
                display: false
              }
            },
            x1: {
              display: false,
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
              display: true,
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
              text: "Effectifs par Type de Groupe",
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
    const GraphG = new Chart(
        document.getElementById('GraphG'),
        configGraphG
    );

// BARGRAPH REPARTITION PAR PUBLIC
    // setup
    const dataGraphP = {
      labels: <?php echo json_encode($public); ?>,
      datasets: [{
        label: 'Effectif',
        data: <?php echo json_encode($effGrpP); ?>,
        backgroundColor: <?php echo json_encode($GrpScol); ?>,
        borderColor: [
          '#ffffff'
        ],
        borderWidth: 2,
        borderRadius: 10,
        borderSkipped: false,
        datalabels: {
        labels: {
            title: {
                font: {
                    weight: 'bold'
                }
            }
        },
        color: '#5e550a',
        anchor: 'center'
        }
      }]
    };

    // config
    const configGraphP = {
        type: 'bar',
        data: dataGraphP,
        options: {
          responsive: true,
          aspectRatio: 1,
          maintainAspectRatio: true,
          indexAxis: 'y',
          scales: {
            x: {
              stacked: false,
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
              text: "Effectifs par Public",
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
    const GraphP = new Chart(
        document.getElementById('GraphP'),
        configGraphP
    );

// BARGRAPH REPARTITION PAR CLASSES D'AGES
    // setup
    const dataGraphAS = {
      labels: <?php echo json_encode($ages); ?>,
      datasets: [{
        label: 'Scolaires',
        data: <?php echo json_encode($effGrpAS); ?>,
        backgroundColor: [
          '#e5cf19'
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
        color: '#5e550a',
        anchor: 'center'
        }
      },{
        label: 'Non-Scolaires',
        data: <?php echo json_encode($effGrpA); ?>,
        backgroundColor: [
          '#f2e78a'
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
        color: '#5e550a',
        anchor: 'center'
        }
      }]
    };


    // config
    const configGraphAS = {
        type: 'bar',
        data: dataGraphAS,
        options: {
          responsive: true,
          aspectRatio: 1,
          maintainAspectRatio: true,
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
    const GraphAS = new Chart(
        document.getElementById('GraphAS'),
        configGraphAS
    );

// FREQUENTATION FRANCAIS
    // setup
    const dataGraphFR = { 
        labels: ["Fréquentation Français"],
        datasets: [
          {
            label: 'Scolaires',
            data: [<?php echo json_encode($EffFrScol[0]); ?>],
            backgroundColor: [
              '#e5cf19'
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
            color: '#5e550a',
            anchor: 'center'
            }
          },
          {
            label: 'Non-Scolaires',
            data: [<?php echo json_encode($EffFrScol[1]); ?>],
            backgroundColor: [
              '#f2e78a'
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
            color: '#5e550a',
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
              '#369cc4',
              '#6bb9d7',
              '#ecdc50',
              '#f2e78a',
              '#fa1a49',
              '#fc708e'
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
                  '#369cc4',
                  '#6bb9d7',
                  '#ecdc50',
                  '#f2e78a',
                  '#fa1a49',
                  '#fc708e'
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
        label: 'Scolaires',
        data: <?php echo json_encode($effDEP); ?>,
        backgroundColor: [
          '#e5cf19'
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
        color: '#5e550a',
        anchor: 'center'
        }
      },{
        label: 'Non-Scolaires',
        data: <?php echo json_encode($effDEPP); ?>,
        backgroundColor: [
          '#f2e78a'
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
        color: '#5e550a',
        anchor: 'center'
        }
      }]
    };

    // config
    const configGraphDEP = {
        type: 'bar',
        data: dataGraphDEP,
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
        label: 'Scolaires',
        data: <?php echo json_encode($effIPI); ?>,
        backgroundColor: [
          '#e5cf19'
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
        color: '#5e550a',
        anchor: 'center'
        }
      },{
        label: 'Non-Scolaires',
        data: <?php echo json_encode($effIPIP); ?>,
        backgroundColor: [
          '#f2e78a'
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
        color: '#5e550a',
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
          label: 'Scolaires',
          data: <?php echo json_encode($effIGR); ?>,
          backgroundColor: [
            '#e5cf19'
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
          color: '#5e550a',
          anchor: 'center'
          }
        },{
          label: 'Non-Scolaires',
          data: <?php echo json_encode($effIGRP); ?>,
          backgroundColor: [
            '#f2e78a'
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
          color: '#5e550a',
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