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
import { SettingsService }      from './../../services/settings.service';
import { UniversityService }    from './../../services/university.service';
import { GlobalQueriesService } from './../../services/global-queries.service';


@Component({
  selector: 'app-consecutive',
  templateUrl: './consecutive.component.html',
  styleUrls: ['./consecutive.component.scss']
})
export class ConsecutiveComponent implements OnInit , OnDestroy
{
  /*
  ******************************************************************************
  ******************************************************************************
                            LIST OF VARIABLES
  ******************************************************************************
  ******************************************************************************
  */
  //ReactiveForm
  consecutive_form: FormGroup;
  update_faculty_form: FormGroup;
  submitted_form:boolean = false;
  updated_form:boolean   = false;
  //Boolean variables view
  listForm:boolean     = true;
  registerForm:boolean = false;
  //Class Bootstrap = Active.
  listClass:string;
  registerClass:string;
  //Button form
  button_form:boolean = false;
  //loading effect
  loading:boolean = true;

  //List of services (aux)
  list_consecutive_aux: any;
  //List of services
  list_cities: any;
  list_consecutive: any;
  list_consecutive_types:any;
  list_faculties: any;

  //Detail data
  detail_faculty_id:number;
  detail_faculty_name:string;
  detail_faculty_acronym:string;
  detail_faculty_city:string;

  //Message
  messageFilterResult:boolean    = false;
  messageListConsecutive:boolean = false;
  messageListMembers:boolean     = false;
  messageListFaculties:boolean   = false;

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
  			      private _settingsService:SettingsService,
              public  _globalService:GlobalQueriesService,
              private toastr: ToastrService,
              private changeDetectorRef: ChangeDetectorRef)
  {
    //Get the consecutive list
    _globalService.getConsecutiveTypes()
    .subscribe(ConsecutiveTypes => {
      this.list_consecutive_types = ConsecutiveTypes;
    });

    //Get the faculties
    _universityService.getFaculties()
    .subscribe(Faculties => {
      this.list_faculties = Faculties;
      this.getFaculties();
    });

    //Get the faculties
    _settingsService.getConsecutive()
    .subscribe(Faculties => {
      const ELEMENT_DATA = Faculties;
      //Get the elements
      this.list_consecutive_aux = new MatTableDataSource(ELEMENT_DATA);
      this.list_consecutive_aux.paginator = this.paginator;
      this.list_consecutive = this.list_consecutive_aux.connect();

      this.getConsecutive();
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

    //Form builder group (Register)
    this.consecutive_form = this.formBuilder.group({
            consecutive_current:  ['',  [Validators.required, Validators.maxLength(130), Validators.pattern('^[0-9-]+$')]],
            consecutive_faculty:  ['',  [Validators.required]],
            consecutive_type:     ['1', [Validators.required]]
    });

    //Form builder group (Update)
    this.update_faculty_form = this.formBuilder.group({
            faculty_name:     ['',  [Validators.required, Validators.maxLength(130), Validators.pattern('^[A-Za-zñÑáéíóúÁÉÍÓÚ,. ]+$')]],
            faculty_acronym:  ['',  [Validators.required, Validators.maxLength(10),  Validators.pattern('^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$')]],
            faculty_city:     [{value: '', disabled: true}]
    });

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
    if (this.list_consecutive_aux)
    {
      this.list_consecutive_aux.disconnect();
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
    this.list_consecutive_aux.filter = filterValue.trim().toLowerCase();

    if (this.list_consecutive_aux.filteredData.length == 0)
    {
      this.messageFilterResult  = true;
      this.messageListConsecutive = false;
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
  getFaculties()
  {
    //Evaluamos si contiene datos
    if (this.list_faculties.length > 0)
    {
      this.messageListFaculties = false;
    }
    else
    {
      this.messageListFaculties = true;
    }
  };

  getConsecutive()
  {
    //Loading effect
    this.loading = false;
    //Length data
    if (this.list_consecutive.length > 0)
    {
      this.messageListConsecutive = false;
    }
    else if (this.list_consecutive.length == 0 && this.messageFilterResult)
    {
      this.messageListConsecutive = true;
      this.messageFilterResult = false;
    }
    else if (this.list_consecutive.length == 0 && !this.messageFilterResult)
    {
      this.messageListConsecutive = true;
    }
  };

  /*
  ******************************************************************************
  ******************************************************************************
                              LOAD DETAIL (MODAL WINDOW)
  ******************************************************************************
  ******************************************************************************
  */
  loadDetail()
  {

  };


}
