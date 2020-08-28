/*
******************************************************************************
******************************************************************************
                              ANGULAR IMPORT
******************************************************************************
******************************************************************************
*/
import { Component, OnInit } from "@angular/core";
import { Chart } from "chart.js";
import { environment } from "../../../environments/environment";

/*
******************************************************************************
******************************************************************************
                              ANGULAR SERVICES
******************************************************************************
******************************************************************************
*/
import { DashboardService } from "./../../services/dashboard.service";

@Component({
  selector: "app-dashboard",
  templateUrl: "./dashboard.component.html",
  styleUrls: ["./dashboard.component.scss"],
})
export class DashboardComponent implements OnInit {
  /*
  ******************************************************************************
  ******************************************************************************
                            LIST OF VARIABLES
  ******************************************************************************
  ******************************************************************************
  */
  //URL API for localhost server
  private URL = environment.baseUrl + "file/";

  //Array list
  report_counter: any;
  report_percentage: any;
  report_list: any;
  //Chart array list
  doughnut_data_chart: any = [];
  doughnut_label_chart: any = [];
  doughnut_color_chart: any = [];
  doughnut_footer_chart: any = [];
  //
  doughnut_year_menu: any = [];
  //
  selected_year: number;
  //loading effect
  loading: boolean = true;
  //Message
  messageReportCounters: boolean = false;
  messageReportList: boolean = false;
  messageReportPercentage: boolean = false;
  messageChartDoughnut: boolean = false;

  chart1 = {
    data: {
      labels: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
      datasets: [
        {
          label: "Premium",
          data: [50, 80, 60, 120, 80, 100, 60],
          backgroundColor: "transparent",
          borderColor: "#5b6582",
          borderWidth: 2,
        },
        {
          label: "Free",
          data: [100, 60, 80, 50, 140, 60, 100],
          backgroundColor: "transparent",
          borderColor: "#36a2eb",
          borderWidth: 2,
        },
      ],
    },
    options: {
      scales: {
        yAxes: [
          {
            ticks: {
              fontColor: "rgba(0,0,0,.6)",
              fontStyle: "bold",
              beginAtZero: true,
              maxTicksLimit: 8,
              padding: 10,
            },
          },
        ],
      },
      responsive: true,
      legend: {
        position: "bottom",
        display: false,
      },
    },
  };
  chart2 = {
    data: {
      labels: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
      datasets: [
        {
          label: "Premium",
          data: [50, 80, 60, 120, 80, 100, 60],
          backgroundColor: "#5b6582",
          borderColor: "#5b6582",
          borderWidth: 2,
        },
        {
          label: "Free",
          data: [100, 60, 80, 50, 140, 60, 100],
          backgroundColor: "#36a2eb",
          borderColor: "#36a2eb",
          borderWidth: 2,
        },
      ],
    },
    options: {
      barValueSpacing: 1,
      scales: {
        yAxes: [
          {
            ticks: {
              fontColor: "rgba(0,0,0,.6)",
              fontStyle: "bold",
              beginAtZero: true,
              maxTicksLimit: 8,
              padding: 10,
            },
          },
        ],
        xAxes: [
          {
            barPercentage: 0.4,
          },
        ],
      },
      responsive: true,
      legend: {
        position: "bottom",
        display: false,
      },
    },
  };
  chart3: any;

  /*
  ******************************************************************************
  ******************************************************************************
                               CLASS CONSTRUCTOR
  ******************************************************************************
  ******************************************************************************
  */
  constructor(public _dashboardService: DashboardService) {
    //Get the report counter list
    _dashboardService.getReportCounters().subscribe((ReportCounters) => {
      this.report_counter = ReportCounters;
      this.getReportCounters();
    });

    //Get the report counter list
    _dashboardService.getReportPercentage().subscribe((ReportPercentage) => {
      this.report_percentage = ReportPercentage;
      //Variables list
      let counter = 0;

      //Return the years available
      for (let item_value of this.report_percentage) {
        counter++;
        if (this.doughnut_year_menu.indexOf(item_value.year_report) === -1) {
          this.doughnut_year_menu.push(item_value.year_report);
          if (counter == 1) {
            this.selected_year = item_value.year_report;
          }
        }
      }

      if (this.doughnut_year_menu.length > 0) {
        //Message result
        this.messageChartDoughnut = false;
        //Build the chart
        this.buildChartDoughnut();
      } else {
        this.doughnut_year_menu.push("Sin referencias");
        //Message result
        this.messageChartDoughnut = true;
      }
    });

    //Get the report list (last 5)
    _dashboardService.getReportList().subscribe((ReportList) => {
      this.report_list = ReportList;
      this.getReportList();
    });
  }

  /*
  ******************************************************************************
  ******************************************************************************
                              ANGULAR NGONINIT
  ******************************************************************************
  ******************************************************************************
  */
  ngOnInit() {
    /*
    new Chart('chart-line',
    {
        type: 'line',
        data: this.chart1.data,
        options: this.chart1.options
    });

    new Chart('chart-bar',
    {
        type: 'bar',
        data: this.chart2.data ,
        options: this.chart2.options
    });
    */
  }

  /*
  ******************************************************************************
  ******************************************************************************
                               COMPONENT FUNCTIONS
  ******************************************************************************
  ******************************************************************************
  */

  /*
  ******************************************************************************
  ******************************************************************************
                              METHODS FROM SERVICE RESULT
  ******************************************************************************
  ******************************************************************************
  */
  getReportCounters() {
    //Length data
    if (this.report_counter.length > 0) {
      this.messageReportCounters = false;
    } else {
      this.messageReportCounters = true;
    }
  }

  getReportList() {
    //Loading effect
    this.loading = false;
    //Length data
    if (this.report_list.length > 0) {
      this.messageReportList = false;
    } else {
      this.messageReportList = true;
    }
  }

  /*
  ******************************************************************************
  ******************************************************************************
                            METHODS THAT BUILD THE CHARTS
  ******************************************************************************
  ******************************************************************************
  */
  selectYear(year: any) {
    //Get the new value
    this.selected_year = year;
    //Clean the arrays
    this.doughnut_data_chart = [];
    this.doughnut_label_chart = [];
    //Build the chart
    this.buildChartDoughnut();
  }

  buildChartDoughnut() {
    //Variables list
    let max_value = 0,
      result = 0,
      amount = 0;

    //Get the maximum value (amount)
    for (let item_amount of this.report_percentage) {
      if (item_amount.year_report == this.selected_year) {
        //Get the maximum value
        max_value += Number(item_amount.counter_report);
      }
    }

    //Get the percentage result
    for (let item_report of this.report_percentage) {
      if (item_report.year_report == this.selected_year) {
        //Group the C5 report list
        if (item_report.id_tipo_reporte >= 5) {
          amount += Number(item_report.counter_report);
        } else {
          //Calculate percentage
          result = (item_report.counter_report / max_value) * 100;
          //Push the value
          this.doughnut_data_chart.push(result.toFixed(2));

          this.doughnut_label_chart.push(item_report.nombre_tipo_reporte);

          switch (Number(item_report.id_tipo_reporte)) {
            case 1:
              this.doughnut_color_chart.push("#5b6582");
              this.doughnut_footer_chart.push({
                color_report: "#5b6582",
                title_report: "Acta de Inicio",
              });
              break;
            case 2:
              this.doughnut_color_chart.push("#98a4c7");
              this.doughnut_footer_chart.push({
                color_report: "#98a4c7",
                title_report: "Nombramiento de Asesor",
              });
              break;
            case 3:
              this.doughnut_color_chart.push("#36a2eb");
              this.doughnut_footer_chart.push({
                color_report: "#36a2eb",
                title_report: "Acta de Aprobación (Posgrados)",
              });
              break;
            case 4:
              this.doughnut_color_chart.push("#254399");
              this.doughnut_footer_chart.push({
                color_report: "#254399",
                title_report: "Acta de Sustentación",
              });
              break;

            default:
              break;
          }
        }
      }
    }

    //Calculate percentage
    result = (amount / max_value) * 100;
    //Push the value result
    this.doughnut_data_chart.push(result.toFixed(2));
    this.doughnut_label_chart.push("Paz y Salvo");
    this.doughnut_color_chart.push("#62cbff");
    this.doughnut_footer_chart.push({
      color_report: "#62cbff",
      title_report: "Paz y Salvo",
    });

    this.chart3 = {
      data: {
        datasets: [
          {
            data: this.doughnut_data_chart,
            backgroundColor: this.doughnut_color_chart,
          },
        ],
        labels: this.doughnut_label_chart,
      },
      options: {
        legend: {
          position: "bottom",
          display: false,
        },
        tooltips: {
          enabled: true,
          mode: "label",
          callbacks: {
            label: function (tooltipItem, data) {
              var indice = tooltipItem.index;
              return (
                data.labels[indice] + ": " + data.datasets[0].data[indice] + "%"
              );
            },
          },
        },
        cutoutPercentage: 80,
      },
    };

    new Chart("chart-doughnut", {
      type: "doughnut",
      data: this.chart3.data,
      options: this.chart3.options,
    });
  }

  /*
  ******************************************************************************
  ******************************************************************************
                          SHOW THE REPORT IN PDF
  ******************************************************************************
  ******************************************************************************
  */
  showReport(report: { id_configuracion_reporte: any; id_tipo_reporte: any }) {
    //Detail report
    const configuration_id = report.id_configuracion_reporte;
    const type_report = report.id_tipo_reporte;

    switch (Number(type_report)) {
      //C1 Report (Acta de Inicio)
      case 1:
        window.open(
          this.URL +
            "generateReportC1.php?configuration_id=" +
            configuration_id,
          "_blank"
        );
        break;

      //C2 Report (Nombramiento de Asesor)
      case 2:
        window.open(
          this.URL +
            "generateReportC2.php?configuration_id=" +
            configuration_id,
          "_blank"
        );
        break;

      //C3 Report (Acta de Aprobacion de Posgrados)
      case 3:
        window.open(
          this.URL +
            "generateReportC3.php?configuration_id=" +
            configuration_id,
          "_blank"
        );
        break;

      //C4 Report (Acta de Sustentacion)
      case 4:
        window.open(
          this.URL +
            "generateReportC4.php?configuration_id=" +
            configuration_id,
          "_blank"
        );
        break;

      //C5 Reports (Paz y Salvo)
      case 5:
        window.open(
          this.URL +
            "generateReportC5.php?configuration_id=" +
            configuration_id,
          "_blank"
        );
        break;
      case 6:
        window.open(
          this.URL +
            "generateReportC5.php?configuration_id=" +
            configuration_id,
          "_blank"
        );
        break;
      case 7:
        window.open(
          this.URL +
            "generateReportC5.php?configuration_id=" +
            configuration_id,
          "_blank"
        );
        break;
      case 8:
        window.open(
          this.URL +
            "generateReportC5.php?configuration_id=" +
            configuration_id,
          "_blank"
        );
        break;

      default:
        alert("El reporte seleccionado presenta un error en su configuración.");
        break;
    }
  }
}
