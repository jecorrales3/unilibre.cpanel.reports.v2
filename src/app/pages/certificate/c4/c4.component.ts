/*
******************************************************************************
******************************************************************************
                              ANGULAR IMPORT
******************************************************************************
******************************************************************************
*/
import { Component, OnInit }                  from '@angular/core';
import { FormBuilder, FormGroup, Validators,
         FormArray, ValidatorFn, FormControl,
       } from '@angular/forms';
import { ToastrService }                      from 'ngx-toastr';
import { of }                                 from 'rxjs';

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
  selector: 'app-c4',
  templateUrl: './c4.component.html',
  styleUrls: ['./c4.component.scss']
})
export class C4Component implements OnInit
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
  list_investigation_groups = [];

  //list of local_storage
  report_settings_c4 = [];
  report_members_c4  = [];

  //List of data structure
  data_settings = [];
  data_students = [];
  data_members  = [];
  ordersData    = [];

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
    //Get the member position
    _globalService.getMemberPosition2()
    .subscribe(MemberPosition => {
      this.list_member_position = MemberPosition;
    });

    //Get the investigation groups
    _globalService.getInvestigationGroups()
    .subscribe(InvestigationGroups => {
      //this.list_investigation_groups = InvestigationGroups;

      // Store JSON data from the service in 'data' variable.
      let data = InvestigationGroups;

      let groupsMap = new Map();

      // Iterate over the data array.
      data.forEach((element) => {

        const groupName = element.nombre_facultad;

        delete element.nombre_facultad;

        let value;

        // If group already exists in the map, get current value.
        if (groupsMap.has(groupName))
        {
          value = groupsMap.get(groupName);
        }
        else
        {
          value = {
             'faculty_name': groupName,
             'investigation_group': []
          };
        }

        // Add current element to the group's investigation_group list.
        value.investigation_group.push(element);

        // Add updated value to the map.
        groupsMap.set(groupName, value);
      });

      groupsMap.forEach((value, key) => {
         this.list_investigation_groups.push(value);
      });
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
            date_report:         ['',  [Validators.required]],
            initial_date_report: ['',  [Validators.required]],
            end_date_report:     ['',  [Validators.required]],
            budget_report:       ['0', [Validators.required]],
            title_report:        ['',  [Validators.required,   Validators.maxLength(300),  Validators.pattern('^[A-Za-zñÑáéíóúÁÉÍÓÚ.,:; ]+$')]]
    });

    //Form builder group (Second)
    this.secondFormGroup = this.formBuilder.group({
            checkArray: this.formBuilder.array([], [Validators.required])
    });

    //Form builder group (Third)
    this.thirdFormGroup = this.formBuilder.group({
            report_member:           ['',  [Validators.required]],
            report_member_position:  ['',  [Validators.required]],
    });



    //Get value of local storage
    if (JSON.parse(localStorage.getItem("report_settings_c4")) != null)
    {
      let header_settings = JSON.parse(localStorage.getItem("report_settings_c4"));

      //Recorremos los objetos del arreglo
      header_settings.forEach(element =>
      {
        //Igualamos los valores de cada objeto
        this.firstFormGroup.setValue({
            //Companys data
            date_report: element.fecha_reporte,
            initial_date_report: element.fecha_inicial_reporte,
            end_date_report: element.fecha_final_reporte,
            budget_report: element.presupuesto_reporte,
            title_report: element.titulo_reporte
        });
      });
    }

    //Get value of local storage
    if (JSON.parse(localStorage.getItem("report_members_c4")) != null)
    {
      //Get the value of local storage
      this.report_members_c4 = JSON.parse(localStorage.getItem("report_members_c4"));
      //Message
      this.messageListMembers = false;
    }
    else
    {
      //Message
      this.messageListMembers = true;
    }
  };

  onCheckboxChange(e: any)
  {
    const checkArray: FormArray = this.secondFormGroup.get('checkArray') as FormArray;

    if (e.target.checked)
    {
      checkArray.push(new FormControl(e.target.value));
    }
    else
    {
      let i: number = 0;
      checkArray.controls.forEach((item: FormControl) => {
        if (item.value == e.target.value) {
          checkArray.removeAt(i);
          return;
        }
        i++;
      });
    }
  }


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
    const date_report         = this.firstFormGroup.get('date_report').value;
    const initial_date_report = this.firstFormGroup.get('initial_date_report').value;
    const end_date_report     = this.firstFormGroup.get('end_date_report').value;
    const budget_report       = this.firstFormGroup.get('budget_report').value;
    const title_report        = this.firstFormGroup.get('title_report').value;

    //Clear LocalStorage
    localStorage.removeItem('report_settings_c4');
    //Clear array
    this.data_settings = [];
    //Add new elements
    this.data_settings.push(
    {
        fecha_reporte:date_report,
        fecha_inicial_reporte:initial_date_report,
        fecha_final_reporte:end_date_report,
        presupuesto_reporte:budget_report,
        titulo_reporte:title_report
    });

    //Set item
    localStorage.setItem("report_settings_c4", JSON.stringify(this.data_settings));
    //Get Item
    this.report_settings_c4 = JSON.parse(localStorage.getItem("report_settings_c4"));

    //Show the result of the action
    this.toastr.success('Datos de configuración del reporte grabados', 'OK', {
      timeOut: 3000,
      positionClass: 'toast-bottom-center',
    });
  };

  /*
  ******************************************************************************
  ******************************************************************************
                       REGISTER INVESTIGATION GROUP FORM
  ******************************************************************************
  ******************************************************************************
  */
  get rsf() { return this.secondFormGroup.controls; }

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
    else if(this.report_members_c4.length == 3)
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
    if(JSON.parse(localStorage.getItem("report_members_c4")) != null)
    {
      //Push the object array
      this.data_members = JSON.parse(localStorage.getItem("report_members_c4"));
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
    localStorage.setItem("report_members_c4", JSON.stringify(this.data_members));
    //Get Item
    this.report_members_c4 = JSON.parse(localStorage.getItem("report_members_c4"));

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
    var members = JSON.parse(localStorage.getItem("report_members_c4"));
    for (var i = 0; i < members.length; i++)
    {
      if(i == id)
      {
        members.splice(i, 1);
        break;  //exit loop since you found the person
      }
    }
    localStorage.setItem("report_members_c4", JSON.stringify(members));
    //Get the results
    this.report_members_c4 = JSON.parse(localStorage.getItem("report_members_c4"));

    //Get value of local storage
    if (this.report_members_c4.length > 0)
    {
      //Message
      this.messageListMembers = false;
    }
    else
    {
      //Message
      this.messageListMembers = true;
      //Clear LocalStorage
      localStorage.removeItem('report_members_c4');
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
    else if (this.secondFormGroup.get('checkArray').value.length == 0)
    {
      //Show the result of the action
      this.toastr.warning('Se necesita registrar al menos un grupo de investigación', 'WARNING', {
        timeOut: 3000,
        positionClass: 'toast-top-right',
      });
      //Finish process
      return;
    }
    else if (this.report_members_c4.length == 0)
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
    let report_settings_c4 = JSON.parse(localStorage.getItem("report_settings_c4"));
    let report_groups_c4   = this.secondFormGroup.get('checkArray').value;
    let report_members_c4  = JSON.parse(localStorage.getItem("report_members_c4"));

    this._controlService.registerReportC4(report_settings_c4, report_groups_c4, report_members_c4)
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
    if(JSON.parse(localStorage.getItem("report_settings_c4")) != null)
    {
      if (confirm("¿Estás seguro de eliminar los datos de la configuración del reporte?"))
      {
        //Clear LocalStorage
        localStorage.removeItem('report_settings_c4');

        //Submitted
        this.submitted_first_form = false;

        //Set the values to null
        this.firstFormGroup.setValue({
          date_report: null,
          initial_date_report: null,
          end_date_report: null,
          budget_report: null,
          title_report: null
        });
      }
    }
  };

  removeMembers()
  {
    //Evaluate if localstorage != null
    if(JSON.parse(localStorage.getItem("report_members_c4")) != null)
    {
      if (confirm("¿Estás seguro de eliminar el listado de integrantes asociados al reporte?"))
      {
        //Clear LocalStorage
        localStorage.removeItem('report_members_c4');
        //Message
        this.messageListMembers = true;
        //Data list
        this.report_members_c4 = [];
      }
    }
  };

  resetForms()
  {
    //Execute the methods
    if (confirm("¿Estás seguro de reiniciar los formularios del reporte?"))
    {
      //Clear LocalStorage
      localStorage.removeItem('report_settings_c4');
      localStorage.removeItem('report_members_c4');

      //Submitted
      this.submitted_first_form = false;

      //Set the values to null
      this.firstFormGroup.setValue({
        date_report: null,
        initial_date_report: null,
        end_date_report: null,
        budget_report: null,
        title_report: null
      });

      //Message
      this.messageListStudents = true;
      this.messageListMembers  = true;

      //Data list
      this.report_members_c4 = [];
    }
  };

  cleanForms()
  {
    //Clear LocalStorage
    localStorage.removeItem('report_settings_c4');
    localStorage.removeItem('report_members_c4');

    //Submitted
    this.submitted_first_form = false;

    //Set the values to null
    this.firstFormGroup.setValue({
      date_report: null,
      initial_date_report: null,
      end_date_report: null,
      budget_report: null,
      title_report: null
    });

    const checkArray: FormArray = this.secondFormGroup.get('checkArray') as FormArray;
    checkArray.clear();

    //Message
    this.messageListStudents = true;
    this.messageListMembers  = true;

    //Data list
    this.report_members_c4 = [];
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
    //C4 Report (Acta de Inicio)
    window.open(this.api_localhost + 'generateReportC4.php?configuration_id=' + configuration_id, '_blank');
  };
}
