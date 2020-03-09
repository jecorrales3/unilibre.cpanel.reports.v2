/*
******************************************************************************
******************************************************************************
                              ANGULAR IMPORT
******************************************************************************
******************************************************************************
*/
import { Component, OnInit }                  from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ToastrService }                      from 'ngx-toastr';

/*
******************************************************************************
******************************************************************************
                              ANGULAR SERVICES
******************************************************************************
******************************************************************************
*/
import { UniversityService }    from './../../../services/university.service';
import { ControlService }       from './../../../services/control.service';
import { GlobalQueriesService } from './../../../services/global-queries.service';


@Component({
  selector: 'app-c6',
  templateUrl: './c6.component.html',
  styleUrls: ['./c6.component.scss']
})
export class C6Component implements OnInit
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

  //ReactiveForm
  firstFormGroup:  FormGroup;
  secondFormGroup: FormGroup;
  thirdFormGroup:  FormGroup;

  //Linear form
  isLinear:boolean = false;
  submitted_first_form:boolean  = false;
  submitted_second_form:boolean = false;
  submitted_third_form:boolean  = false;

  //List of services
  list_programs: any;
  list_member_position: any;
  list_members: any;

  //list of local_storage
  report_settings_c6 = [];
  report_students_c6 = [];
  report_members_c6  = [];

  //List of data structure
  data_settings = [];
  data_students = [];
  data_members  = [];

  //Message
  messageListMembers:boolean     = false;
  messageListMembersForm:boolean = false;
  messageListPrograms:boolean    = false;
  messageListStudents:boolean    = false;


  /*
  ******************************************************************************
  ******************************************************************************
                               CLASS CONSTRUCTOR
  ******************************************************************************
  ******************************************************************************
  */
  constructor(private formBuilder:FormBuilder,
  			      private _universityService:UniversityService,
              private _controlService:ControlService,
              public  _globalService:GlobalQueriesService,
              private toastr: ToastrService)
  {
    //Get the programs
    _globalService.getMemberPosition2()
    .subscribe(MemberPosition => {
      this.list_member_position = MemberPosition;
    });

    //Get the programs
    _universityService.getPrograms()
    .subscribe(Programs => {
      this.list_programs = Programs;
      this.getPrograms();
    });

    //Get the members (members)
    _universityService.getMembers()
    .subscribe(Members => {
      this.list_members = Members;
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
    //Form builder group (First)
    this.firstFormGroup = this.formBuilder.group({
            program_report:  ['',  [Validators.required]],
            date_report:     ['',  [Validators.required]],
            time_report:     ['',  [Validators.required]],
            title_report:    ['',  [Validators.required,   Validators.maxLength(300),  Validators.pattern('^[A-Za-zñÑáéíóúÁÉÍÓÚ0-9().,:; ]+$')]]
    });

    //Form builder group (Second)
    this.secondFormGroup = this.formBuilder.group({
            student_name:      ['',  [Validators.required, Validators.maxLength(40), Validators.pattern('^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$')]],
            student_lastname:  ['',  [Validators.required, Validators.maxLength(40), Validators.pattern('^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$')]],
            student_document:  ['',  [Validators.required, Validators.minLength(8),  Validators.maxLength(12), Validators.pattern('^[0-9]+$')]]
    });

    //Form builder group (Third)
    this.thirdFormGroup = this.formBuilder.group({
            report_member:           ['',  [Validators.required]],
            report_member_position:  ['',  [Validators.required]],
    });

    //Get value of local storage
    if (JSON.parse(localStorage.getItem("report_settings_c6")) != null)
    {
      let header_settings = JSON.parse(localStorage.getItem("report_settings_c6"));

      //Recorremos los objetos del arreglo
      header_settings.forEach(element =>
      {
        //Igualamos los valores de cada objeto
        this.firstFormGroup.setValue({
            //Companys data
            program_report: element.programa_reporte,
            date_report: element.fecha_reporte,
            time_report: element.hora_reporte,
            title_report: element.titulo_reporte
        });
      });
    }

    //Get value of local storage
    if (JSON.parse(localStorage.getItem("report_students_c6")) != null)
    {
      //Get the value of local storage
      this.report_students_c6 = JSON.parse(localStorage.getItem("report_students_c6"));
      //Message
      this.messageListStudents = false;
    }
    else
    {
      //Message
      this.messageListStudents = true;
    }

    //Get value of local storage
    if (JSON.parse(localStorage.getItem("report_members_c6")) != null)
    {
      //Get the value of local storage
      this.report_members_c6 = JSON.parse(localStorage.getItem("report_members_c6"));
      //Message
      this.messageListMembers = false;
    }
    else
    {
      //Message
      this.messageListMembers = true;
    }
  };


  /*
  ******************************************************************************
  ******************************************************************************
                              METHODS FROM SERVICE RESULT
  ******************************************************************************
  ******************************************************************************
  */
  getPrograms()
  {
    //Length data
    if (this.list_programs.length > 0)
    {
      this.messageListPrograms = false;
    }
    else
    {
      this.messageListPrograms = true;
    }
  };

  getMembers()
  {
    //Length data
    if (this.list_members.length > 0)
    {
      this.messageListMembersForm = false;
    }
    else
    {
      this.messageListMembersForm = true;
    }
  };

  /*
  ******************************************************************************
  ******************************************************************************
                              REGISTER SETTING FORM
  ******************************************************************************
  ******************************************************************************
  */
  get rff() { return this.firstFormGroup.controls; }

  registerSetting()
  {
    //Submitted
    this.submitted_first_form = true;
    //Invalid value form
    if (this.firstFormGroup.invalid)
    {
      //Finish process
      return;
    }

     //Form values
    const program_report = this.firstFormGroup.get('program_report').value;
    const date_report    = this.firstFormGroup.get('date_report').value;
    const time_report    = this.firstFormGroup.get('time_report').value;
    const title_report   = this.firstFormGroup.get('title_report').value;

    //Clear LocalStorage
    localStorage.removeItem('report_settings_c6');
    //Clear array
    this.data_settings = [];
    //Add new elements
    this.data_settings.push(
    {
        programa_reporte:program_report,
        fecha_reporte:date_report,
        hora_reporte:time_report,
        titulo_reporte:title_report
    });

    //Set item
    localStorage.setItem("report_settings_c6", JSON.stringify(this.data_settings));
    //Get Item
    this.report_settings_c6 = JSON.parse(localStorage.getItem("report_settings_c6"));

    //Show the result of the action
    this.toastr.success('Datos de configuración del reporte grabados', 'OK', {
      timeOut: 3000,
      positionClass: 'toast-bottom-center',
    });
  };

  /*
  ******************************************************************************
  ******************************************************************************
                              REGISTER STUDENT FORM
  ******************************************************************************
  ******************************************************************************
  */
  get rsf() { return this.secondFormGroup.controls; }

  registerStudent()
  {
    //Submitted
    this.submitted_second_form = true;
    //Invalid value form
    if (this.secondFormGroup.invalid)
    {
      //Finish process
      return;
    }

     //Form values
    const student_name     = this.secondFormGroup.get('student_name').value;
    const student_lastname = this.secondFormGroup.get('student_lastname').value;
    const student_document = this.secondFormGroup.get('student_document').value;

    //Clear array
    this.data_students = [];

    //Evaluate if localstorage != null
    if(JSON.parse(localStorage.getItem("report_students_c6")) != null)
    {
      //Push the object array
      this.data_students = JSON.parse(localStorage.getItem("report_students_c6"));
    }

    //Add new elements
    this.data_students.push(
    {
        nombre_estudiante:student_name,
        apellido_estudiante:student_lastname,
        documento_estudiante:student_document
    });

    //Message
    this.messageListStudents = false;

    //Set item
    localStorage.setItem("report_students_c6", JSON.stringify(this.data_students));
    //Get Item
    this.report_students_c6 = JSON.parse(localStorage.getItem("report_students_c6"));

    //Submitted
    this.submitted_second_form = false;

    //Set the values to null
    this.secondFormGroup.setValue({
      student_name: null,
      student_lastname: null,
      student_document: null
    });

    //Show the result of the action
    this.toastr.success('Datos del estudiante grabados', 'OK', {
      timeOut: 3000,
      positionClass: 'toast-bottom-center',
    });
  };

  deleteStudent(id)
  {
    var students = JSON.parse(localStorage.getItem("report_students_c6"));
    for (var i = 0; i < students.length; i++)
    {
      if(i == id)
      {
        students.splice(i, 1);
        break;  //exit loop since you found the person
      }
    }
    localStorage.setItem("report_students_c6", JSON.stringify(students));
    //Get the results
    this.report_students_c6 = JSON.parse(localStorage.getItem("report_students_c6"));

    //Get value of local storage
    if (this.report_students_c6.length > 0)
    {
      //Message
      this.messageListStudents = false;
    }
    else
    {
      //Message
      this.messageListStudents = true;
      //Clear LocalStorage
      localStorage.removeItem('report_students_c6');
    }
  };

  /*
  ******************************************************************************
  ******************************************************************************
                              REGISTER MEMBER FORM
  ******************************************************************************
  ******************************************************************************
  */
  get rmf() { return this.thirdFormGroup.controls; }

  registerMember()
  {
    //Submitted
    this.submitted_third_form = true;
    //Invalid value form
    if (this.thirdFormGroup.invalid)
    {
      //Finish process
      return;
    }
    else if(this.report_members_c6.length == 3)
    {
      //Show the result of the action
      this.toastr.warning('Sólo se permite hasta tres integrantes para este reporte', 'WARNING', {
        timeOut: 3000,
        positionClass: 'toast-top-right',
      });

      //Finish process
      return;
    }

     //Form values
    const report_member          = this.thirdFormGroup.get('report_member').value;
    const report_member_position = this.thirdFormGroup.get('report_member_position').value;

    //Clear array
    this.data_members = [];

    //Evaluate if localstorage != null
    if(JSON.parse(localStorage.getItem("report_members_c6")) != null)
    {
      //Push the object array
      this.data_members = JSON.parse(localStorage.getItem("report_members_c6"));
    }

    //Add new elements
    this.data_members.push(
    {
        nombre_integrante: report_member.nombre_integrante,
        apellido_integrante: report_member.apellido_integrante,
        correo_integrante: report_member.correo_integrante,
        cedula_integrante: report_member.cedula_integrante,
        id_tipo_integrante: report_member.id_tipo_integrante,
        nombre_tipo_integrante: report_member.nombre_tipo_integrante,
        id_tipo_cargo_integrante: report_member_position.id_tipo_cargo_reporte,
        nombre_tipo_cargo_reporte: report_member_position.nombre_tipo_cargo_reporte
    });

    //Message
    this.messageListMembers = false;

    //Set item
    localStorage.setItem("report_members_c6", JSON.stringify(this.data_members));
    //Get Item
    this.report_members_c6 = JSON.parse(localStorage.getItem("report_members_c6"));

    //Submitted
    this.submitted_third_form = false;

    //Set the values to null
    this.thirdFormGroup.setValue({
      report_member: null,
      report_member_position: null
    });

    //Show the result of the action
    this.toastr.success('Datos del integrante grabados', 'OK', {
      timeOut: 3000,
      positionClass: 'toast-bottom-center',
    });
  };

  deleteMember(id)
  {
    var members = JSON.parse(localStorage.getItem("report_members_c6"));
    for (var i = 0; i < members.length; i++)
    {
      if(i == id)
      {
        members.splice(i, 1);
        break;  //exit loop since you found the person
      }
    }
    localStorage.setItem("report_members_c6", JSON.stringify(members));
    //Get the results
    this.report_members_c6 = JSON.parse(localStorage.getItem("report_members_c6"));

    //Get value of local storage
    if (this.report_members_c6.length > 0)
    {
      //Message
      this.messageListMembers = false;
    }
    else
    {
      //Message
      this.messageListMembers = true;
      //Clear LocalStorage
      localStorage.removeItem('report_members_c6');
    }
  };

  /*
  ******************************************************************************
  ******************************************************************************
                                GENERATE REPORT
  ******************************************************************************
  ******************************************************************************
  */
  generateReport()
  {
    //Invalid value form
    if (this.firstFormGroup.invalid)
    {
      //Show the result of the action
      this.toastr.warning('La configuración del reporte es necesaria', 'WARNING', {
        timeOut: 3000,
        positionClass: 'toast-top-right',
      });
      //Finish process
      return;
    }
    else if (this.report_students_c6.length == 0)
    {
      //Show the result of the action
      this.toastr.warning('Se necesita registrar al menos un estudiante', 'WARNING', {
        timeOut: 3000,
        positionClass: 'toast-top-right',
      });
      //Finish process
      return;
    }
    else if (this.report_members_c6.length == 0)
    {
      //Show the result of the action
      this.toastr.warning('Se necesita registrar al menos un integrante', 'WARNING', {
        timeOut: 3000,
        positionClass: 'toast-top-right',
      });
      //Finish process
      return;
    }

    //Get values
    let report_settings_c6 = JSON.parse(localStorage.getItem("report_settings_c6"));
    let report_students_c6 = JSON.parse(localStorage.getItem("report_students_c6"));
    let report_members_c6  = JSON.parse(localStorage.getItem("report_members_c6"));

    this._controlService.registerReportC6(report_settings_c6, report_students_c6, report_members_c6)
    .subscribe(data=>
    {
      if (data.message == 'Reporte generado.')
      {
        //Show the result of the action
        this.toastr.success(data.message, "OK", {
          timeOut: 2000,
          positionClass: 'toast-bottom-center'
        });
        //GET ID
        const configuration_id = data.configuration_id;
        //Show PDF
        this.showReport(configuration_id);
        this.cleanForms();
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
                          REMOVE LOCAL STORAGE DATA
  ******************************************************************************
  ******************************************************************************
  */
  removeSettings()
  {
    //Evaluate if localstorage != null
    if(JSON.parse(localStorage.getItem("report_settings_c6")) != null)
    {
      if (confirm("¿Estás seguro de eliminar los datos de la configuración del reporte?"))
      {
        //Clear LocalStorage
        localStorage.removeItem('report_settings_c6');

        //Submitted
        this.submitted_first_form = false;

        //Set the values to null
        this.firstFormGroup.setValue({
          program_report: null,
          date_report: null,
          time_report: null,
          title_report: null
        });
      }
    }
  };

  removeStudents()
  {
    //Evaluate if localstorage != null
    if(JSON.parse(localStorage.getItem("report_students_c6")) != null)
    {
      if (confirm("¿Estás seguro de eliminar el listado de estudiantes asociados al reporte?"))
      {
        //Clear LocalStorage
        localStorage.removeItem('report_students_c6');
        //Message
        this.messageListStudents = true;
        //Data list
        this.report_students_c6 = [];
      }
    }
  };

  removeMembers()
  {
    //Evaluate if localstorage != null
    if(JSON.parse(localStorage.getItem("report_members_c6")) != null)
    {
      if (confirm("¿Estás seguro de eliminar el listado de integrantes asociados al reporte?"))
      {
        //Clear LocalStorage
        localStorage.removeItem('report_members_c6');
        //Message
        this.messageListMembers = true;
        //Data list
        this.report_members_c6 = [];
      }
    }
  };

  resetForms()
  {
    //Execute the methods
    if (confirm("¿Estás seguro de reiniciar los formularios del reporte?"))
    {
      //Clear LocalStorage
      localStorage.removeItem('report_settings_c6');
      localStorage.removeItem('report_students_c6');
      localStorage.removeItem('report_members_c6');

      //Submitted
      this.submitted_first_form = false;

      //Set the values to null
      this.firstFormGroup.setValue({
        program_report: null,
        date_report: null,
        time_report: null,
        title_report: null
      });

      //Message
      this.messageListStudents = true;
      this.messageListMembers  = true;

      //Data list
      this.report_students_c6 = [];
      this.report_members_c6  = [];
    }
  };

  cleanForms()
  {
    //Clear LocalStorage
    localStorage.removeItem('report_settings_c6');
    localStorage.removeItem('report_students_c6');
    localStorage.removeItem('report_members_c6');

    //Submitted
    this.submitted_first_form = false;

    //Set the values to null
    this.firstFormGroup.setValue({
      program_report: null,
      date_report: null,
      time_report: null,
      title_report: null
    });

    //Message
    this.messageListStudents = true;
    this.messageListMembers  = true;

    //Data list
    this.report_students_c6 = [];
    this.report_members_c6  = [];
  };

  /*
  ******************************************************************************
  ******************************************************************************
                          SHOW THE REPORT IN PDF
  ******************************************************************************
  ******************************************************************************
  */
  showReport(configuration_id: string | number)
  {
    //C6 Report (Homologacion Auxiliar)
    window.open(this.api_localhost + 'generateReportC6.php?configuration_id=' + configuration_id, '_blank');
  };
}
