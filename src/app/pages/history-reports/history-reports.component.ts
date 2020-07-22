/*
******************************************************************************
******************************************************************************
                              ANGULAR IMPORT
******************************************************************************
******************************************************************************
*/
import { Component, OnInit, OnDestroy, ViewChild,
         ChangeDetectorRef, ViewChildren }    from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ToastrService }                      from 'ngx-toastr';
import { Observable }                         from 'rxjs';
import { MatTableDataSource, MatPaginator }   from '@angular/material';
import { environment }                        from '../../../environments/environment';

/*
******************************************************************************
******************************************************************************
                              ANGULAR SERVICES
******************************************************************************
******************************************************************************
*/
import { GlobalQueriesService }  from './../../services/global-queries.service';
import { UniversityService }     from './../../services/university.service';
import { ControlService }        from './../../services/control.service';

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
  private URL  = environment.baseUrl + 'file/';
  

  //ReactiveForm
  search_form: FormGroup;
  update_report_form: FormGroup;
  submitted_form:boolean = false;
  updated_form:boolean   = false;
  //Boolean variables view
  listForm:boolean   = true;
  filterForm:boolean = false;
  //Class Bootstrap = Active.
  listClass:string;
  filterClass:string;
  //loading effect
  loading:boolean        = true;
  loading_search:boolean = false;

  //List of services (aux)
  list_reports_aux: any;
  //List of services
  list_reports: any;
  list_search_report: any;
  list_report_state: any;
  list_report_types: any;
  list_months: any;
  list_years: any;

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
  detail_configuration_state_id:number;
  detail_configuration_state:string;

  //Message
  messageFilter:boolean        = true;
  messageFilterResult:boolean  = false;
  messageListReports:boolean   = false;
  messageListSearch:boolean    = false;

  //Paginator
  @ViewChild('paginator')  paginator: MatPaginator;
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
  			      private _globalService:GlobalQueriesService,
              private _universityService:UniversityService,
  			      private _controlService:ControlService,
              private toastr: ToastrService,
              private changeDetectorRef: ChangeDetectorRef)
  {
    //Get the month list
    this.list_months = _globalService.getMonthList();

    //Get the consecutive years
    _globalService.getConsecutiveYears()
    .subscribe(ConsecutiveYears => {
      this.list_years = ConsecutiveYears;
    });

    //Get the report state
    _globalService.getReportState()
    .subscribe(ReportState => {
      this.list_report_state = ReportState;
    });

    //Get the report types
    _globalService.getReportTypes()
    .subscribe(ReportType => {
      this.list_report_types = ReportType;
    });

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

    //Form builder group (Search)
    this.search_form = this.formBuilder.group({
            type_report:     ['',  [Validators.required]],
            year_report:     ['',  [Validators.required]],
            month_report:    ['',  [Validators.required]],
    });

    //Form builder group (Update)
    this.update_report_form = this.formBuilder.group({
            report_state:    ['',  [Validators.required]]
    });

    this.changeDetectorRef.detectChanges();
    //Label elements
    this.paginator._intl.itemsPerPageLabel = 'Ítems por página:';
    this.paginator._intl.firstPageLabel    = 'Primer página ';
    this.paginator._intl.previousPageLabel = 'Anterior';
    this.paginator._intl.nextPageLabel     = 'Siguiente';
    this.paginator._intl.lastPageLabel     = 'Última página';
  };

  ngAfterViewInit()
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
    this.listForm    = true;
    this.filterForm  = false;
    //Class Bootstrap = Active.
    this.listClass   = 'active';
    this.filterClass = '';
  };

  filterSection()
  {
    //Variable form
    this.listForm    = false;
    this.filterForm  = true;
    //Class Bootstrap = Active.
    this.listClass   = '';
    this.filterClass = 'active';
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
    if (this.list_reports_aux.filteredData.length > 0)
    {
      this.messageListReports = false;
    }
    else
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
      this.detail_configuration_code = code_report  != undefined ? code_report + "-" + report.year_consecutivo_reporte : "";
    }
    else
    {
      this.detail_configuration_code = "";
    }

  };

  loadDetailAnulate(report)
  {
    //Detail report
    this.detail_configuration_id            = report.id_configuracion_reporte;
    this.detail_configuration_title         = report.titulo_configuracion_reporte;
    this.detail_configuration_state_id      = report.id_funcionalidad;

    //Set the values to null
    this.update_report_form.setValue({
      report_state: this.detail_configuration_state_id
    });
  };

  /*
  ******************************************************************************
  ******************************************************************************
                              SEARCH REPORT FORM
  ******************************************************************************
  ******************************************************************************
  */
  get sr() { return this.search_form.controls; }

  searchReports()
  {
    //Submitted
    this.submitted_form = true;
    //Invalid value form
    if (this.search_form.invalid)
    {
      //Finish process
      return;
    }

    //Loading effect
    this.loading_search = true;
    //Message
    this.messageFilter  = false;
    //Clean array
    this.list_search_report = [];

    //Form values
    const type_report  = this.search_form.get('type_report').value;
    const year_report  = this.search_form.get('year_report').value;
    const month_report = this.search_form.get('month_report').value;

    this._controlService.searchReports(type_report, year_report, month_report)
    .subscribe(data=>
    {
      //Loading effect
      this.loading_search = false;

      if (data.length > 0)
      {
        //Data result
        this.list_search_report = data;
        //Message result
        this.messageListSearch  = false;
      }
      else
      {
        //Message result
        this.messageListSearch = true;
      }
    });
  };

  /*
  ******************************************************************************
  ******************************************************************************
                              UPDATE REPORT FORM
  ******************************************************************************
  ******************************************************************************
  */
  get ur() { return this.update_report_form.controls; }

  updateReport()
  {
    //Submitted
    this.updated_form = true;
    //Invalid value form
    if (this.update_report_form.invalid)
    {
      //Finish process
      return;
    }

    //Form values
    const configuration_id = this.detail_configuration_id;
    const report_state     = this.update_report_form.get('report_state').value;

    this._controlService.updateReport(configuration_id, report_state)
    .subscribe(data=>
    {
      if (data.message == 'Reporte actualizado.')
      {
        //Submitted
        this.updated_form = false;
        //Show the result of the action
        this.toastr.success(data.message, "OK", {
          timeOut: 2000,
          positionClass: 'toast-bottom-center'
        });

        this.refreshData();
      }
      else
      {
        //Show the result of the action
        this.toastr.error(data.message, "ERROR", {
          timeOut: 2000,
          positionClass: 'toast-bottom-center'
        });
      }
    });
  };


  /*
  ******************************************************************************
  ******************************************************************************
                              REFRESH DATA METHOD
  ******************************************************************************
  ******************************************************************************
  */
  refreshData()
  {
    //Get the reports
    this._controlService.getReports()
    .subscribe(Reports => {
      const ELEMENT_DATA = Reports;
      //Get the elements
      this.list_reports_aux = new MatTableDataSource(ELEMENT_DATA);
      this.list_reports_aux.paginator = this.paginator;
      this.list_reports = this.list_reports_aux.connect();
      this.getReports();
    });


    //Invalid value form
    if (this.search_form.valid)
    {
      //Message
      this.messageFilter      = true;
      //Clean array
      this.list_search_report = [];
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

    switch (Number(type_report))
    {
      //C1 Report (Acta de Inicio)
      case 1:
        window.open(this.URL + 'generateReportC1.php?configuration_id=' + configuration_id, '_blank');
        break;

      //C2 Report (Nombramiento de Asesor)
      case 2:
        window.open(this.URL + 'generateReportC2.php?configuration_id=' + configuration_id, '_blank');
        break;

      //C3 Report (Acta de Aprobacion de Posgrados)
      case 3:
        window.open(this.URL + 'generateReportC3.php?configuration_id=' + configuration_id, '_blank');
        break;

      //C4 Report (Acta de Sustentacion)
      case 4:
        window.open(this.URL + 'generateReportC4.php?configuration_id=' + configuration_id, '_blank');
        break;

      //C5 Reports (Paz y Salvo)
      case 5:
        window.open(this.URL + 'generateReportC5.php?configuration_id=' + configuration_id, '_blank');
        break;
      case 6:
        window.open(this.URL + 'generateReportC5.php?configuration_id=' + configuration_id, '_blank');
        break;
      case 7:
        window.open(this.URL + 'generateReportC5.php?configuration_id=' + configuration_id, '_blank');
        break;
      case 8:
        window.open(this.URL + 'generateReportC5.php?configuration_id=' + configuration_id, '_blank');
        break;

      default:
        alert("El reporte seleccionado presenta un error en su configuración.");
        break;
    }
  };

}
