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
import { UniversityService }    from './../../services/university.service';


@Component({
  selector: 'app-students',
  templateUrl: './students.component.html',
  styleUrls: ['./students.component.scss']
})
export class StudentsComponent implements OnInit
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
  list_students_aux: any;
  //List of services
  list_students: any;
  list_reports = [];

  //Detail data
  detail_student_name:string;
  detail_student_lastname:string;
  detail_student_document:number;

  //Message
  messageFilterResult:boolean  = false;
  messageListStudents:boolean  = false;
  messageListReports:boolean   = false;

  //Paginator
  @ViewChild(MatPaginator) paginator: MatPaginator;
  obs: Observable<any>;
  dataSource: any;


  /*
  ******************************************************************************
  ******************************************************************************
                               CLASS CONSTRUCTOR
  ******************************************************************************
  ******************************************************************************
  */
  constructor(private formBuilder:FormBuilder,
  			      private _universityService:UniversityService,
              private toastr: ToastrService,
              private changeDetectorRef: ChangeDetectorRef)
  {
    //Get the faculties
    _universityService.getStudents()
    .subscribe(Students => {
      const ELEMENT_DATA = Students;
      //Get the elements
      this.list_students_aux = new MatTableDataSource(ELEMENT_DATA);
      this.list_students_aux.paginator = this.paginator;
      this.list_students = this.list_students_aux.connect();
      this.getStudents();
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
    if (this.list_students_aux)
    {
      this.list_students_aux.disconnect();
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
    this.list_students_aux.filter = filterValue.trim().toLowerCase();

    if (this.list_students_aux.filteredData.length == 0)
    {
      this.messageFilterResult = true;
      this.messageListStudents = false;
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

  getStudents()
  {
    //Loading effect
    this.loading = false;
    //Length data
    if (this.list_students.length > 0)
    {
      this.messageListStudents = false;
    }
    else if (this.list_students.length == 0 && this.messageFilterResult)
    {
      this.messageListStudents = true;
      this.messageFilterResult = false;
    }
    else if (this.list_students.length == 0 && !this.messageFilterResult)
    {
      this.messageListStudents = true;
    }
  };

  /*
  ******************************************************************************
  ******************************************************************************
                              LOAD DETAIL (MODAL WINDOW)
  ******************************************************************************
  ******************************************************************************
  */
  loadDetail(student: { nombre_estudiante_reporte: string; apellido_estudiante_reporte: string; documento_estudiante_reporte: any; })
  {
    //Loading effect
    this.loading_modal = true;

    //Detail student
    this.detail_student_name     = student.nombre_estudiante_reporte;
    this.detail_student_lastname = student.apellido_estudiante_reporte;

    //Get the value
    let student_document = student.documento_estudiante_reporte;

    //Clean array
    this.list_reports = [];

    //Get the member list of the faculty
    this._universityService.getDetailReportList(student_document)
    .subscribe(Report => {

       //Loading effect
       this.loading_modal = false;

       if (Report.length > 0)
       {

         // Store JSON data from the service in 'data' variable.
         let data = Report;

         let groupsMap = new Map();

         // Iterate over the data array.
         data.forEach((element) => {

           const groupName = element.nombre_programa_facultad_reporte;

           delete element.nombre_programa_facultad_reporte;

           let value;

           // If group already exists in the map, get current value.
           if (groupsMap.has(groupName))
           {
             value = groupsMap.get(groupName);
           }
           else
           {
             value = {
                'report_type': groupName,
                'report_list': []
             };
           }

           // Add current element to the group's member_list list.
           value.report_list.push(element);

           // Add updated value to the map.
           groupsMap.set(groupName, value);
         });

         groupsMap.forEach((value, key) => {
            this.list_reports.push(value);
          });

          this.messageListReports = false;

       }
       else
       {
         //Show the message
         this.messageListReports = true;
       }
    });

  };


  /*
  ******************************************************************************
  ******************************************************************************
                          SHOW THE REPORT IN PDF
  ******************************************************************************
  ******************************************************************************
  */
  showReport(config: { id_configuracion_reporte: any; id_tipo_reporte: any; })
  {
    //Detail report
    const configuration_id = config.id_configuracion_reporte;
    const type_report      = config.id_tipo_reporte;

    switch (type_report)
    {
      //C1 Report (Acta de Sustentacion)
      case '1':
        window.open(this.api_localhost + 'generateReportC1.php?configuration_id=' + configuration_id, '_blank');
        break;

      //C2 Report (Homologacion Auxiliar)
      case '2':
        window.open(this.api_localhost + 'generateReportC2.php?configuration_id=' + configuration_id, '_blank');
        break;

      //C3 Report (Acta de Aprobacion)
      case '3':
        window.open(this.api_localhost + 'generateReportC3.php?configuration_id=' + configuration_id, '_blank');
        break;

      //C4 Report (Acta de Inicio)
      case '4':
        window.open(this.api_localhost + 'generateReportC4.php?configuration_id=' + configuration_id, '_blank');
        break;

      //C5 Reports (Paz y Salvo)
      case '5':
        window.open(this.api_localhost + 'generateReportC5.php?configuration_id=' + configuration_id, '_blank');
        break;
      case '6':
        window.open(this.api_localhost + 'generateReportC5.php?configuration_id=' + configuration_id, '_blank');
        break;
      case '7':
        window.open(this.api_localhost + 'generateReportC5.php?configuration_id=' + configuration_id, '_blank');
        break;

      default:
        alert("El reporte seleccionado presenta un error en su configuración.");
        break;
    }
  };
}
