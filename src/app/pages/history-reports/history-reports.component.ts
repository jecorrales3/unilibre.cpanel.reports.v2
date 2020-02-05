/*
******************************************************************************
******************************************************************************
                              ANGULAR IMPORT
******************************************************************************
******************************************************************************
*/
import { Component, OnInit, OnDestroy,
         ViewChild, ChangeDetectorRef }       from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ToastrService }                      from 'ngx-toastr';
import { Observable }                         from 'rxjs';
import { MatTableDataSource, MatPaginator }   from '@angular/material';

/*
******************************************************************************
******************************************************************************
                              ANGULAR SERVICES
******************************************************************************
******************************************************************************
*/
import { ControlService }    from './../../services/control.service';

@Component({
  selector: 'app-history-reports',
  templateUrl: './history-reports.component.html',
  styleUrls: ['./history-reports.component.scss']
})
export class HistoryReportsComponent implements OnInit
{
  /*
  ******************************************************************************
  ******************************************************************************
                            LIST OF VARIABLES
  ******************************************************************************
  ******************************************************************************
  */
  //URL API for localhost server
  private api_localhost  = 'auth/';
  //URL API for production server
  private api_production = 'backend/production/php/services/file/';

  //Boolean variables view
  listForm:boolean     = true;
  registerForm:boolean = false;
  //Class Bootstrap = Active.
  listClass:string;
  registerClass:string;
  //loading effect
  loading:boolean       = true;
  loading_modal:boolean = true;

  //List of services (aux)
  list_reports_aux: any;
  //List of services
  list_reports: any;

  //Detail data
  detail_configuration_id:number;
  detail_configuration_title:string;
  detail_configuration_date:string;
  detail_configuration_lift_date:string;
  detail_configuration_hour:string;
  detail_configuration_code:string;
  detail_configuration_acronym:string;
  detail_configuration_faculty:string;
  detail_configuration_program:string;
  detail_configuration_result:string;
  detail_configuration_user_name:string;
  detail_configuration_user_lastname:string;
  detail_configuration_user_email:string;
  detail_configuration_year:number;
  detail_configuration_type_id:number;
  detail_configuration_type:string;
  detail_configuration_state:string;

  //Message
  messageFilterResult:boolean  = false;
  messageListReports:boolean   = false;

  //Paginator
  @ViewChild(MatPaginator) paginator: MatPaginator;
  obs: Observable<any>;
  dataSource: any;

  //Expansion panel
  step = 0;

  setStep(index: number)
  {
    this.step = index;
  };


  /*
  ******************************************************************************
  ******************************************************************************
                               CLASS CONSTRUCTOR
  ******************************************************************************
  ******************************************************************************
  */
  constructor(private formBuilder:FormBuilder,
  			      private _controlService:ControlService,
              private toastr: ToastrService,
              private changeDetectorRef: ChangeDetectorRef)
  {
    //Get the reports
    _controlService.getReports()
    .subscribe(Reports => {
      const ELEMENT_DATA = Reports;
      //Get the elements
      this.list_reports_aux = new MatTableDataSource(ELEMENT_DATA);
      this.list_reports_aux.paginator = this.paginator;
      this.list_reports = this.list_reports_aux.connect();
      this.getReports();
    });
  };

  /*
  ******************************************************************************
  ******************************************************************************
                              ANGULAR NGONINIT
  ******************************************************************************
  ******************************************************************************
  */
  ngOnInit()
  {
    //Class Bootstrap = Active.
    this.listClass = 'active';

    this.changeDetectorRef.detectChanges();

    //Label elements
    this.paginator._intl.itemsPerPageLabel = 'Ítems por página:';
    this.paginator._intl.firstPageLabel    = 'Primer página ';
    this.paginator._intl.previousPageLabel = 'Anterior';
    this.paginator._intl.nextPageLabel     = 'Siguiente';
    this.paginator._intl.lastPageLabel     = 'Última página';
  };

  ngOnDestroy()
  {
    if (this.list_reports_aux)
    {
      this.list_reports_aux.disconnect();
    }
  };

  /*
  ******************************************************************************
  ******************************************************************************
                               COMPONENT FUNCTIONS
  ******************************************************************************
  ******************************************************************************
  */
  listSection()
  {
    //Variable form
    this.listForm      = true;
    this.registerForm  = false;
    //Class Bootstrap = Active.
    this.listClass     = 'active';
    this.registerClass = '';
  };

  registerSection()
  {
    //Variable form
    this.listForm      = false;
    this.registerForm  = true;
    //Class Bootstrap = Active.
    this.listClass     = '';
    this.registerClass = 'active';
  };



  /*
  ******************************************************************************
  ******************************************************************************
  ******************************    SEARCH DATA   ******************************
  ******************************************************************************
  ******************************************************************************
  */

  applyFilter(filterValue: string)
  {
    this.list_reports_aux.filter = filterValue.trim().toLowerCase();

    if (this.list_reports_aux.filteredData.length == 0)
    {
      this.messageFilterResult = true;
      this.messageListReports  = false;
    }
    else
    {
      this.messageFilterResult = false;
    }
  };


  /*
  ******************************************************************************
  ******************************************************************************
                              METHODS FROM SERVICE RESULT
  ******************************************************************************
  ******************************************************************************
  */

  getReports()
  {
    //Loading effect
    this.loading = false;
    //Length data
    if (this.list_reports.length > 0)
    {
      this.messageListReports = false;
    }
    else if (this.list_reports.length == 0 && this.messageFilterResult)
    {
      this.messageListReports  = true;
      this.messageFilterResult = false;
    }
    else if (this.list_reports.length == 0 && !this.messageFilterResult)
    {
      this.messageListReports = true;
    }
  };

  /*
  ******************************************************************************
  ******************************************************************************
                              LOAD DETAIL (MODAL WINDOW)
  ******************************************************************************
  ******************************************************************************
  */
  loadDetail(report)
  {
    //Detail report
    this.detail_configuration_id            = report.id_configuracion_reporte;
    this.detail_configuration_title         = report.titulo_configuracion_reporte;
    this.detail_configuration_date          = report.fecha_generacion_configuracion_reporte;
    this.detail_configuration_lift_date     = report.fecha_sustentacion_configuracion_reporte != undefined ? report.fecha_sustentacion_configuracion_reporte : "N/A";
    this.detail_configuration_hour          = report.hora_sustentacion_reporte != undefined ? report.hora_sustentacion_reporte : "N/A";
    this.detail_configuration_acronym       = report.siglas_facultad;
    this.detail_configuration_faculty       = report.nombre_facultad_reporte;
    this.detail_configuration_program       = report.nombre_programa_facultad_reporte;
    this.detail_configuration_result        = report.nombre_resultado_reporte;
    this.detail_configuration_user_name     = report.nombre_usuario;
    this.detail_configuration_user_lastname = report.apellido_usuario;
    this.detail_configuration_user_email    = report.correo_usuario;
    this.detail_configuration_type_id       = report.id_tipo_reporte;
    this.detail_configuration_type          = report.nombre_tipo_reporte;
    this.detail_configuration_state         = report.nombre_funcionalidad;

    //Consecutive
    if (report.codigo_configuracion_reporte != undefined)
    {
      const code_report = report.codigo_configuracion_reporte.length > 1 ? report.codigo_configuracion_reporte : "0" + report.codigo_configuracion_reporte;
      this.detail_configuration_code          = code_report  != undefined ? code_report + "-" + report.year_consecutivo_reporte : "";
    }
    else
    {
      this.detail_configuration_code = "";
    }

  };


  /*
  ******************************************************************************
  ******************************************************************************
                          SHOW THE REPORT IN PDF
  ******************************************************************************
  ******************************************************************************
  */
  showReport()
  {
    //Detail report
    const configuration_id = this.detail_configuration_id;
    const type_report      = this.detail_configuration_type_id;

    console.log("Type: ", type_report);

    switch (Number(type_report))
    {
      //C1 Report (Acta de Sustentacion)
      case 1:
        window.open(this.api_localhost + 'generateReportC1.php?configuration_id=' + configuration_id, '_blank');
        break;

      //C2 Report (Homologacion Auxiliar)
      case 2:
        window.open(this.api_localhost + 'generateReportC2.php?configuration_id=' + configuration_id, '_blank');
        break;

      //C3 Report (Acta de Aprobacion)
      case 3:
        window.open(this.api_localhost + 'generateReportC3.php?configuration_id=' + configuration_id, '_blank');
        break;

      //C4 Report (Acta de Inicio)
      case 4:
        window.open(this.api_localhost + 'generateReportC4.php?configuration_id=' + configuration_id, '_blank');
        break;

      //C5 Reports (Paz y Salvo)
      case 5:
        window.open(this.api_localhost + 'generateReportC5.php?configuration_id=' + configuration_id, '_blank');
        break;
      case 6:
        window.open(this.api_localhost + 'generateReportC5.php?configuration_id=' + configuration_id, '_blank');
        break;
      case 7:
        window.open(this.api_localhost + 'generateReportC5.php?configuration_id=' + configuration_id, '_blank');
        break;

      default:
        alert("El reporte seleccionado presenta un error en su configuración.");
        break;
    }
  };

}
