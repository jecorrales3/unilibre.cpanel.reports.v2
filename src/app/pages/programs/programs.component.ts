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
import { GlobalQueriesService } from './../../services/global-queries.service';


@Component({
  selector: 'app-programs',
  templateUrl: './programs.component.html',
  styleUrls: ['./programs.component.scss']
})
export class ProgramsComponent implements OnInit, OnDestroy
{
  /*
  ******************************************************************************
  ******************************************************************************
                            LIST OF VARIABLES
  ******************************************************************************
  ******************************************************************************
  */
  //ReactiveForm
  program_form: FormGroup;
  update_program_form: FormGroup;
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
  list_programs_aux: any;
  //List of services
  list_programs: any;
  list_cities: any;
  list_faculties: any;

  //Detail data
  detail_program_id:number;
  detail_program_name:string;
  detail_program_faculty:number;

  //Message
  messageFilterResult:boolean  = false;
  messageListPrograms:boolean  = false;
  messageListFaculties:boolean = false;

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
              public  _globalService:GlobalQueriesService,
              private toastr: ToastrService,
              private changeDetectorRef: ChangeDetectorRef)
  {
    //Get the faculties
    _universityService.getFaculties()
    .subscribe(Faculties => {
      this.list_faculties = Faculties;
      this.getFaculties();
    });

    //Get the faculties
    _universityService.getPrograms()
    .subscribe(Programs => {
      const ELEMENT_DATA = Programs;
      //Get the elements
      this.list_programs_aux = new MatTableDataSource(ELEMENT_DATA);
      this.list_programs_aux.paginator = this.paginator;
      this.list_programs = this.list_programs_aux.connect();
      this.getPrograms();
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
    this.program_form = this.formBuilder.group({
            program_name:     ['',  [Validators.required, Validators.maxLength(120), Validators.pattern('^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$')]],
            program_faculty:  ['',  [Validators.required]]
    });

    //Form builder group (Update)
    this.update_program_form = this.formBuilder.group({
            program_name:     ['',  [Validators.required, Validators.maxLength(120), Validators.pattern('^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$')]],
            program_faculty:  ['',  [Validators.required]]
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
    if (this.list_programs_aux)
    {
      this.list_programs_aux.disconnect();
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
    this.list_programs_aux.filter = filterValue.trim().toLowerCase();

    if (this.list_programs_aux.filteredData.length == 0)
    {
      this.messageFilterResult = true;
      this.messageListPrograms  = false;
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

  getPrograms()
  {
    //Loading effect
    this.loading = false;
    //Length data
    if (this.list_programs.length > 0)
    {
      this.messageListPrograms = false;
    }
    else if (this.list_programs.length == 0 && this.messageFilterResult)
    {
      this.messageListPrograms = true;
      this.messageFilterResult = false;
    }
    else if (this.list_programs.length == 0 && !this.messageFilterResult)
    {
      this.messageListPrograms = true;
    }
  };


  /*
  ******************************************************************************
  ******************************************************************************
                              LOAD DETAIL (MODAL WINDOW)
  ******************************************************************************
  ******************************************************************************
  */
  loadDetail(program: { id_programa_facultad: number; nombre_programa_facultad: string; id_facultad: number; })
  {
    this.detail_program_id = program.id_programa_facultad;
    this.detail_program_name = program.nombre_programa_facultad;
    this.detail_program_faculty = program.id_facultad;

    //Set the values
    this.update_program_form.setValue({
        program_name: this.detail_program_name,
        program_faculty: this.detail_program_faculty
    });
  };


  /*
  ******************************************************************************
  ******************************************************************************
                              REGISTER PROGRAM FORM
  ******************************************************************************
  ******************************************************************************
  */
  get rp() { return this.program_form.controls; }

  registerProgram()
  {
  	 //Disabled form
    this.button_form = true;
    //Submitted
    this.submitted_form = true;
    //Invalid value form
    if (this.program_form.invalid)
    {
      //Disabled form
      this.button_form = false;
      //Finish process
      return;
    }

     //Form values
    const program_name    = this.program_form.get('program_name').value;
    const program_faculty = this.program_form.get('program_faculty').value;

    this._universityService.registerProgram(program_name, program_faculty)
    .subscribe(data=>
    {
      if (data.message == 'Programa registrado.')
      {
        //Submitted
        this.submitted_form = false;
        //Show the result of the action
        this.toastr.success(data.message, "OK", {
          timeOut: 2000,
          positionClass: 'toast-bottom-center'
        });

        //Set the values to null
        this.program_form.setValue({
          program_name: null,
          program_faculty: null
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
                              UPDATE MEMBER FORM
  ******************************************************************************
  ******************************************************************************
  */
  get up() { return this.update_program_form.controls; }

  updateProgram()
  {
    //Submitted
    this.updated_form = true;
    //Invalid value form
    if (this.update_program_form.invalid)
    {
      //Finish process
      return;
    }

    //Form values
    const program_id      = this.detail_program_id;
    const program_name    = this.update_program_form.get('program_name').value;
    const program_faculty = this.update_program_form.get('program_faculty').value;

    this._universityService.updateProgram(program_id, program_name, program_faculty)
    .subscribe(data=>
    {
      if (data.message == 'Programa actualizado.')
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
                               DELETE PROGRAM
  ******************************************************************************
  ******************************************************************************
  */
  deleteProgram()
  {
    //Get the id
    const program_id = this.detail_program_id;

    //Method
    this._universityService.deleteProgram(program_id)
    .subscribe(data=>
    {
      if (data.message == 'Programa eliminado.')
      {
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
    //Get the faculties
    this._universityService.getPrograms()
    .subscribe(Programs => {
      const ELEMENT_DATA = Programs;
      //Get the elements
      this.list_programs_aux = new MatTableDataSource(ELEMENT_DATA);
      this.list_programs_aux.paginator = this.paginator;
      this.list_programs = this.list_programs_aux.connect();
      this.getPrograms();
    });
  };

}
