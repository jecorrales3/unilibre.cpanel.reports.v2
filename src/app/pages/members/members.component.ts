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
  selector: 'app-members',
  templateUrl: './members.component.html',
  styleUrls: ['./members.component.scss']
})
export class MembersComponent implements OnInit, OnDestroy
{
  /*
  ******************************************************************************
  ******************************************************************************
                            LIST OF VARIABLES
  ******************************************************************************
  ******************************************************************************
  */
  //ReactiveForm
  member_form: FormGroup;
  update_member_form: FormGroup;
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
  list_members_aux: any;
  //List of services
  list_members: any;
  list_member_type: any;
  list_faculties: any;

  //Detail data
  detail_member_id:number;
  detail_member_name:string;
  detail_member_lastname:string;
  detail_member_email:string;
  detail_member_document:string;
  detail_member_faculty:number;
  detail_member_type:number;

  //Message
  messageFilterResult:boolean  = false;
  messageListMembers:boolean   = false;
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
    //Get the member type
    _globalService.getMemberType()
    .subscribe(MemberType => {
      this.list_member_type = MemberType;
    });

    //Get the faculties
    _universityService.getFaculties()
    .subscribe(Faculties => {
      this.list_faculties = Faculties;
      this.getFaculties();
    });

    //Get the members list
    _universityService.getMembers()
    .subscribe(Members => {
      const ELEMENT_DATA = Members;
      //Get the elements
      this.list_members_aux = new MatTableDataSource(ELEMENT_DATA);
      this.list_members_aux.paginator = this.paginator;
      this.list_members = this.list_members_aux.connect();
      this.getMembers();
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
    this.member_form = this.formBuilder.group({
            member_name:     ['',  [Validators.required, Validators.maxLength(40), Validators.pattern('^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$')]],
            member_lastname: ['',  [Validators.required, Validators.maxLength(40), Validators.pattern('^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$')]],
            member_email:    ['',  [Validators.email,    Validators.maxLength(70)]],
            member_document: ['',  [Validators.required, Validators.minLength(8),  Validators.maxLength(15), Validators.pattern('^[0-9-]+$')]],
            member_faculty:  ['',  [Validators.required]],
            member_type:     ['1', [Validators.required]]
    });

    //Form builder group (Update)
    this.update_member_form = this.formBuilder.group({
            member_name:     ['',  [Validators.required, Validators.maxLength(40), Validators.pattern('^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$')]],
            member_lastname: ['',  [Validators.required, Validators.maxLength(40), Validators.pattern('^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$')]],
            member_email:    ['',  [Validators.email,    Validators.maxLength(70)]],
            member_document: ['',  [Validators.required, Validators.minLength(8),  Validators.maxLength(15), Validators.pattern('^[0-9-]+$')]],
            member_faculty:  ['',  [Validators.required]],
            member_type:     ['',  [Validators.required]]
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
    if (this.list_members_aux)
    {
      this.list_members_aux.disconnect();
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
    this.list_members_aux.filter = filterValue.trim().toLowerCase();

    if (this.list_members_aux.filteredData.length == 0)
    {
      this.messageFilterResult = true;
      this.messageListMembers  = false;
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

  getMembers()
  {
    //Loading effect
    this.loading = false;
    //Length data
    if (this.list_members_aux.filteredData.length > 0)
    {
      this.messageListMembers = false;
    }
    else
    {
      this.messageListMembers = true;
    }
  };

  /*
  ******************************************************************************
  ******************************************************************************
                              LOAD DETAIL (MODAL WINDOW)
  ******************************************************************************
  ******************************************************************************
  */
  loadDetail(member: { id_integrante: number; nombre_integrante: string; apellido_integrante: string; correo_integrante: string; cedula_integrante: string; id_facultad: number; id_tipo_integrante: number; })
  {
    this.detail_member_id       = member.id_integrante;
    this.detail_member_name     = member.nombre_integrante;
    this.detail_member_lastname = member.apellido_integrante;
    this.detail_member_email    = member.correo_integrante;
    this.detail_member_document = member.cedula_integrante;
    this.detail_member_faculty  = member.id_facultad;
    this.detail_member_type     = member.id_tipo_integrante;

    //Set the values
    this.update_member_form.setValue({
        member_name: this.detail_member_name,
        member_lastname: this.detail_member_lastname,
        member_email: this.detail_member_email,
        member_document: this.detail_member_document,
        member_faculty: this.detail_member_faculty,
        member_type: this.detail_member_type
    });
  };



  /*
  ******************************************************************************
  ******************************************************************************
                              REGISTER MEMBER FORM
  ******************************************************************************
  ******************************************************************************
  */
  get rm() { return this.member_form.controls; }

  registerMember()
  {
  	 //Disabled form
    this.button_form = true;
    //Submitted
    this.submitted_form = true;
    //Invalid value form
    if (this.member_form.invalid)
    {
      //Disabled form
      this.button_form = false;
      //Finish process
      return;
    }

     //Form values
    const member_name     = this.member_form.get('member_name').value;
    const member_lastname = this.member_form.get('member_lastname').value;
    const member_email    = this.member_form.get('member_email').value;
    const member_document = this.member_form.get('member_document').value;
    const member_faculty  = this.member_form.get('member_faculty').value;
    const member_type     = this.member_form.get('member_type').value;

    this._universityService.registerMember(member_name,     member_lastname, member_email,
                                           member_document, member_faculty,  member_type)
    .subscribe(data=>
    {
      if (data.message == 'Integrante registrado.')
      {
        //Submitted
        this.submitted_form = false;
        //Show the result of the action
        this.toastr.success(data.message, "OK", {
          timeOut: 2000,
          positionClass: 'toast-bottom-center'
        });

        //Set the values to null
        this.member_form.setValue({
          member_name: null,
          member_lastname: null,
          member_email: null,
          member_document: null,
          member_faculty: null,
          member_type: null
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
  get um() { return this.update_member_form.controls; }

  updateMember()
  {
    //Submitted
    this.updated_form = true;
    //Invalid value form
    if (this.update_member_form.invalid)
    {
      //Finish process
      return;
    }

    //Form values
    const member_id       = this.detail_member_id;
    const member_name     = this.update_member_form.get('member_name').value;
    const member_lastname = this.update_member_form.get('member_lastname').value;
    const member_email    = this.update_member_form.get('member_email').value;
    const member_document = this.update_member_form.get('member_document').value;
    const member_faculty  = this.update_member_form.get('member_faculty').value;
    const member_type     = this.update_member_form.get('member_type').value;

    this._universityService.updateMember(member_id,    member_name,     member_lastname,
                                         member_email, member_document, member_faculty,
                                         member_type)
    .subscribe(data=>
    {
      if (data.message == 'Integrante actualizado.')
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
                               DELETE MEMBER
  ******************************************************************************
  ******************************************************************************
  */
  deleteMember()
  {
    //Get the id
    const member_id = this.detail_member_id;

    //Method
    this._universityService.deleteMember(member_id)
    .subscribe(data=>
    {
      if (data.message == 'Integrante eliminado.')
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
    //Get the members list
    this._universityService.getMembers()
    .subscribe(Members => {
      const ELEMENT_DATA = Members;
      //Get the elements
      this.list_members_aux = new MatTableDataSource(ELEMENT_DATA);
      this.list_members_aux.paginator = this.paginator;
      this.list_members = this.list_members_aux.connect();
      this.getMembers();
    });
  };

}
