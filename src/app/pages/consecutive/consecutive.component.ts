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
  update_consecutive_form: FormGroup;
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
  list_consecutive_state:any;
  list_faculties: any;

  //Detail data
  detail_faculty_id:number;
  detail_faculty_name:string;
  detail_faculty_acronym:string;
  detail_faculty_city:string;
  detail_consecutive_id:number;
  detail_consecutive_valid_since:string;
  detail_consecutive_valid_until:string;
  detail_consecutive_year:number;
  detail_consecutive_since:number;
  detail_consecutive_current:number;
  detail_consecutive_until:number;
  detail_consecutive_remaining:number;
  detail_consecutive_state_id:number;
  detail_consecutive_state:string;
  detail_consecutive_type:string;
  detail_consecutive_faculty:string;

  //Message
  messageFilterResult:boolean      = false;
  messageListConsecutive:boolean   = false;
  messageListMembers:boolean       = false;
  messageListFaculties:boolean     = false;
  messageConsecutiveNumber:boolean = false;
  messageConsecutiveYear:boolean   = false;
  messageConsecutive:boolean       = false;
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
    //Get the consecutive state
    _globalService.getConsecutiveState()
    .subscribe(ConsecutiveState => {
      this.list_consecutive_state = ConsecutiveState;
    });

    //Get the consecutive types
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

    //Get the consecutives
    _settingsService.getConsecutive()
    .subscribe(Consecutive => {
      const ELEMENT_DATA = Consecutive;
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
            consecutive_type:     ['',  [Validators.required]]
    });

    //Form builder group (Update)
    this.update_consecutive_form = this.formBuilder.group({
            consecutive_state:    ['',  [Validators.required]]
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
      this.messageFilterResult    = true;
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
    if (this.list_consecutive_aux.filteredData.length > 0)
    {
      this.messageListConsecutive = false;
    }
    else
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
  loadDetail(consecutive)
  {
    this.detail_consecutive_id          = consecutive.id_consecutivo_reporte;
    this.detail_consecutive_valid_since = consecutive.vigencia_desde_consecutivo_reporte;
    this.detail_consecutive_valid_until = consecutive.vigencia_hasta_consecutivo_reporte;
    this.detail_consecutive_year        = consecutive.year_consecutivo_reporte;
    this.detail_consecutive_since       = consecutive.consecutivo_desde_reporte;
    this.detail_consecutive_current     = consecutive.consecutivo_actual_reporte;
    this.detail_consecutive_until       = consecutive.consecutivo_hasta_reporte;
    this.detail_consecutive_remaining   = consecutive.consecutivo_restante_reporte;
    this.detail_consecutive_state_id    = consecutive.id_estado_consecutivo_reporte;
    this.detail_consecutive_state       = consecutive.nombre_estado_consecutivo_reporte;
    this.detail_consecutive_type        = consecutive.nombre_tipo_consecutivo_reporte;
    this.detail_consecutive_faculty     = consecutive.siglas_facultad;

    //Set the values to null
    this.update_consecutive_form.setValue({
      consecutive_state: this.detail_consecutive_state_id
    });

    //const today = ;
    const year  = new Date().getFullYear();
    if (consecutive.year_consecutivo_reporte == year)
    {
      if (Number(consecutive.consecutivo_actual_reporte) <= Number(consecutive.consecutivo_hasta_reporte))
      {
        this.messageConsecutive = false;
      }
      else
      {
        this.messageConsecutive = true;
      }
    }
    else
    {
      this.messageConsecutive = true;
    }

  };


  /*
  ******************************************************************************
  ******************************************************************************
                              REGISTER CONSECUTIVE FORM
  ******************************************************************************
  ******************************************************************************
  */
  get rc() { return this.consecutive_form.controls; }

  registerConsecutive()
  {
  	 //Disabled form
    this.button_form = true;
    //Submitted
    this.submitted_form = true;
    //Invalid value form
    if (this.consecutive_form.invalid)
    {
      //Disabled form
      this.button_form = false;
      //Finish process
      return;
    }

     //Form values
    const consecutive_current = this.consecutive_form.get('consecutive_current').value;
    const consecutive_faculty = this.consecutive_form.get('consecutive_faculty').value;
    const consecutive_type    = this.consecutive_form.get('consecutive_type').value;

    this._settingsService.registerConsecutive(consecutive_current, consecutive_faculty, consecutive_type)
    .subscribe(data=>
    {
      if (data.message == 'Consecutivo registrado.')
      {
        //Submitted
        this.submitted_form = false;
        //Show the result of the action
        this.toastr.success(data.message, "OK", {
          timeOut: 2000,
          positionClass: 'toast-bottom-center'
        });

        //Set the values to null
        this.consecutive_form.setValue({
          consecutive_current: null,
          consecutive_faculty: null,
          consecutive_type: null
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
      //Disabled form
      this.button_form = false;
    });
  };



  /*
  ******************************************************************************
  ******************************************************************************
                              UPDATE CONSECUTIVE FORM
  ******************************************************************************
  ******************************************************************************
  */
  get uc() { return this.update_consecutive_form.controls; }

  updateConsecutive()
  {
    //Submitted
    this.updated_form = true;
    //Invalid value form
    if (this.update_consecutive_form.invalid)
    {
      //Finish process
      return;
    }

    //Form values
    const consecutive_id       = this.detail_consecutive_id;
    const consecutive_state    = this.update_consecutive_form.get('consecutive_state').value;

    this._settingsService.updateConsecutive(consecutive_id, consecutive_state)
    .subscribe(data=>
    {
      if (data.message == 'Consecutivo actualizado.')
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
    //Get the consecutives
    this._settingsService.getConsecutive()
    .subscribe(Consecutive => {
      const ELEMENT_DATA = Consecutive;
      //Get the elements
      this.list_consecutive_aux = new MatTableDataSource(ELEMENT_DATA);
      this.list_consecutive_aux.paginator = this.paginator;
      this.list_consecutive = this.list_consecutive_aux.connect();
      this.getConsecutive();
    });
  };


}
