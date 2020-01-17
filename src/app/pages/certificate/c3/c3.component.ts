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
  selector: 'app-c3',
  templateUrl: './c3.component.html',
  styleUrls: ['./c3.component.scss']
})
export class C3Component implements OnInit
{
  /*
  ******************************************************************************
  ******************************************************************************
                            LIST OF VARIABLES
  ******************************************************************************
  ******************************************************************************
  */
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
  list_advisors: any;
  list_juries: any;

  //list of local_storage
  report_settings = [];
  report_students = [];
  report_juries   = [];

  //List of data structure
  data_settings = [];
  data_students = [];
  data_juries   = [];

  //Message
  messageListPrograms:boolean  = false;
  messageListAdvisors:boolean  = false;
  messageListStudents:boolean  = false;
  messageListJuries:boolean    = false;


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
    _universityService.getPrograms()
    .subscribe(Programs => {
      this.list_programs = Programs;
      this.getPrograms();
    });

    //Get the members (advisers)
    _controlService.getAdvisors()
    .subscribe(Members => {
      this.list_advisors = Members;
      this.list_juries   = Members;
      this.getAdvisors();
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
            adviser_report:  ['',  [Validators.required]],
            title_report:    ['',  [Validators.required,   Validators.maxLength(300),  Validators.pattern('^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$')]]
    });

    //Form builder group (Second)
    this.secondFormGroup = this.formBuilder.group({
            student_name:      ['',  [Validators.required, Validators.maxLength(40), Validators.pattern('^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$')]],
            student_lastname:  ['',  [Validators.required, Validators.maxLength(40), Validators.pattern('^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$')]],
            student_document:  ['',  [Validators.required, Validators.minLength(8),   Validators.maxLength(12), Validators.pattern('^[0-9]+$')]]
    });

    //Form builder group (Third)
    this.thirdFormGroup = this.formBuilder.group({
            report_jury:  ['',  [Validators.required]]
    });

    //Get value of local storage
    if (JSON.parse(localStorage.getItem("report_settings")) != null)
    {
      let header_settings = JSON.parse(localStorage.getItem("report_settings"));

      //Recorremos los objetos del arreglo
      header_settings.forEach(element =>
      {
        //Igualamos los valores de cada objeto
        this.firstFormGroup.setValue({
            //Companys data
            program_report: element.programa_reporte,
            adviser_report: element.asesor_reporte,
            title_report: element.titulo_reporte
        });
      });
    }

    //Get value of local storage
    if (JSON.parse(localStorage.getItem("report_students")) != null)
    {
      //Get the value of local storage
      this.report_students = JSON.parse(localStorage.getItem("report_students"));
      //Message
      this.messageListStudents = false;
    }
    else
    {
      //Message
      this.messageListStudents = true;
    }

    //Get value of local storage
    if (JSON.parse(localStorage.getItem("report_juries")) != null)
    {
      //Get the value of local storage
      this.report_juries = JSON.parse(localStorage.getItem("report_juries"));
      //Message
      this.messageListJuries = false;
    }
    else
    {
      //Message
      this.messageListJuries = true;
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

  getAdvisors()
  {
    //Length data
    if (this.list_advisors.length > 0)
    {
      this.messageListAdvisors = false;
    }
    else
    {
      this.messageListAdvisors = true;
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
    const adviser_report = this.firstFormGroup.get('adviser_report').value;
    const title_report   = this.firstFormGroup.get('title_report').value;

    //Clear LocalStorage
    localStorage.removeItem('report_settings');
    //Clear array
    this.data_settings = [];
    //Add new elements
    this.data_settings.push(
    {
        programa_reporte:program_report,
        asesor_reporte:adviser_report,
        titulo_reporte:title_report
    });

    //Set item
    localStorage.setItem("report_settings", JSON.stringify(this.data_settings));
    //Get Item
    this.report_settings = JSON.parse(localStorage.getItem("report_settings"));

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
    if(JSON.parse(localStorage.getItem("report_students")) != null)
    {
      //Push the object array
      this.data_students = JSON.parse(localStorage.getItem("report_students"));
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
    localStorage.setItem("report_students", JSON.stringify(this.data_students));
    //Get Item
    this.report_students = JSON.parse(localStorage.getItem("report_students"));

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
    var students = JSON.parse(localStorage.getItem("report_students"));
    for (var i = 0; i < students.length; i++)
    {
      if(i == id)
      {
        students.splice(i, 1);
        break;  //exit loop since you found the person
      }
    }
    localStorage.setItem("report_students", JSON.stringify(students));
    //Get the results
    this.report_students = JSON.parse(localStorage.getItem("report_students"));

    //Get value of local storage
    if (this.report_students.length > 0)
    {
      //Message
      this.messageListStudents = false;
    }
    else
    {
      //Message
      this.messageListStudents = true;
      //Clear LocalStorage
      localStorage.removeItem('report_students');
    }
  };

  /*
  ******************************************************************************
  ******************************************************************************
                              REGISTER JURY FORM
  ******************************************************************************
  ******************************************************************************
  */
  get rjf() { return this.thirdFormGroup.controls; }

  registerJury()
  {
    //Submitted
    this.submitted_third_form = true;
    //Invalid value form
    if (this.thirdFormGroup.invalid)
    {
      //Finish process
      return;
    }

     //Form values
    const report_jury     = this.thirdFormGroup.get('report_jury').value;

    //Clear array
    this.data_juries = [];

    //Evaluate if localstorage != null
    if(JSON.parse(localStorage.getItem("report_juries")) != null)
    {
      //Push the object array
      this.data_juries = JSON.parse(localStorage.getItem("report_juries"));
    }

    //Add new elements
    this.data_juries.push(
    {
        id_integrante:report_jury.id_integrante,
        nombre_integrante: report_jury.nombre_integrante,
        apellido_integrante: report_jury.apellido_integrante,
        correo_integrante: report_jury.correo_integrante,
        cedula_integrante: report_jury.cedula_integrante,
        id_tipo_integrante: report_jury.id_tipo_integrante,
        nombre_tipo_integrante: report_jury.nombre_tipo_integrante,
        id_facultad: report_jury.id_facultad,
        nombre_facultad: report_jury.nombre_facultad,
    });

    //Message
    this.messageListJuries = false;

    //Set item
    localStorage.setItem("report_juries", JSON.stringify(this.data_juries));
    //Get Item
    this.report_juries = JSON.parse(localStorage.getItem("report_juries"));

    //Submitted
    this.submitted_third_form = false;

    //Set the values to null
    this.thirdFormGroup.setValue({
      report_jury: null
    });

    //Show the result of the action
    this.toastr.success('Datos del jurado grabados', 'OK', {
      timeOut: 3000,
      positionClass: 'toast-bottom-center',
    });
  };

  deleteJury(id)
  {
    var students = JSON.parse(localStorage.getItem("report_juries"));
    for (var i = 0; i < students.length; i++)
    {
      if(i == id)
      {
        students.splice(i, 1);
        break;  //exit loop since you found the person
      }
    }
    localStorage.setItem("report_juries", JSON.stringify(students));
    //Get the results
    this.report_juries = JSON.parse(localStorage.getItem("report_juries"));

    //Get value of local storage
    if (this.report_juries.length > 0)
    {
      //Message
      this.messageListJuries = false;
    }
    else
    {
      //Message
      this.messageListJuries = true;
      //Clear LocalStorage
      localStorage.removeItem('report_juries');
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
    else if (this.report_students.length == 0)
    {
      //Show the result of the action
      this.toastr.warning('Se necesita registrar al menos un estudiante', 'WARNING', {
        timeOut: 3000,
        positionClass: 'toast-top-right',
      });
      //Finish process
      return;
    }
    else if (this.report_juries.length == 0)
    {
      //Show the result of the action
      this.toastr.warning('Se necesita registrar al menos un jurado', 'WARNING', {
        timeOut: 3000,
        positionClass: 'toast-top-right',
      });
      //Finish process
      return;
    }

    //Get values
    let report_settings = JSON.parse(localStorage.getItem("report_settings"));
    let report_students = JSON.parse(localStorage.getItem("report_students"));
    let report_juries   = JSON.parse(localStorage.getItem("report_juries"));

    this._controlService.generateReportC3(report_settings, report_students, report_juries)
    .subscribe(data=>
    {
      console.log("Data: ", data);
      if (data.message == 'Reporte generado.')
      {
        //Show the result of the action
        this.toastr.success(data.message, "OK", {
          timeOut: 2000,
          positionClass: 'toast-bottom-center'
        });
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
    if(JSON.parse(localStorage.getItem("report_settings")) != null)
    {
      if (confirm("¿Estás seguro de eliminar los datos de la configuración del reporte?"))
      {
        //Clear LocalStorage
        localStorage.removeItem('report_settings');

        //Submitted
        this.submitted_first_form = false;

        //Set the values to null
        this.firstFormGroup.setValue({
          program_report: null,
          adviser_report: null,
          title_report: null
        });
      }
    }
  };

  removeStudents()
  {
    //Evaluate if localstorage != null
    if(JSON.parse(localStorage.getItem("report_students")) != null)
    {
      if (confirm("¿Estás seguro de eliminar el listado de estudiantes asociados al reporte?"))
      {
        //Clear LocalStorage
        localStorage.removeItem('report_students');
        //Message
        this.messageListStudents = true;
        //Data list
        this.report_students = [];
      }
    }
  };

  removeJuries()
  {
    //Evaluate if localstorage != null
    if(JSON.parse(localStorage.getItem("report_juries")) != null)
    {
      if (confirm("¿Estás seguro de eliminar el listado de jurados asociados al reporte?"))
      {
        //Clear LocalStorage
        localStorage.removeItem('report_juries');
        //Message
        this.messageListJuries = true;
        //Data list
        this.report_juries = [];
      }
    }
  };

  resetForms()
  {
    //Execute the methods
    if (confirm("¿Estás seguro de reiniciar los formularios del reporte?"))
    {
      //Clear LocalStorage
      localStorage.removeItem('report_settings');
      localStorage.removeItem('report_students');
      localStorage.removeItem('report_juries');

      //Submitted
      this.submitted_first_form = false;

      //Set the values to null
      this.firstFormGroup.setValue({
        program_report: null,
        adviser_report: null,
        title_report: null
      });

      //Message
      this.messageListStudents = true;
      this.messageListJuries   = true;

      //Data list
      this.report_students = [];
      this.report_juries   = [];
    }
  };


}
