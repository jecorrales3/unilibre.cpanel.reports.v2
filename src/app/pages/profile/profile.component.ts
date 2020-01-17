/*
******************************************************************************
******************************************************************************
                              ANGULAR IMPORT
******************************************************************************
******************************************************************************
*/
import { Component, OnInit, ViewChild }            from '@angular/core';
import { FormBuilder, FormGroup, Validators,
         NgForm, FormGroupDirective, FormControl } from '@angular/forms';
import { ErrorStateMatcher }                       from '@angular/material/core';
import { ToastrService }                           from 'ngx-toastr';
import { Router }                                  from '@angular/router';

/*
******************************************************************************
******************************************************************************
                              ANGULAR SERVICES
******************************************************************************
******************************************************************************
*/
import { GlobalQueriesService }  from './../../services/global-queries.service';
import { UniversityService }     from './../../services/university.service';
import { SettingsService }       from './../../services/settings.service';

/*
******************************************************************************
******************************************************************************
                          ANGULAR STATE MATCH
******************************************************************************
******************************************************************************
*/

export class MyErrorStateMatcher implements ErrorStateMatcher
{
  isErrorState(control: FormControl | null, form: FormGroupDirective | NgForm | null): boolean
  {
    const invalidCtrl   = !!(control && control.invalid && control.parent.dirty);
    const invalidParent = !!(control && control.parent && control.parent.invalid && control.parent.dirty);

    return control.parent.errors && control.parent.errors['notSame'];
  }
}

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.scss']
})
export class ProfileComponent implements OnInit
{
  /*
  ******************************************************************************
  ******************************************************************************
                            LIST OF VARIABLES
  ******************************************************************************
  ******************************************************************************
  */
  //ReactiveForm
  user_form: FormGroup;
  password_form: FormGroup;
  submitted_form:boolean = false;
  updated_form:boolean   = false;
  //Button form
  button_form:boolean = false;
  //List of services
  list_profile: any;
  list_faculties: any;
  list_user_type: any;
  list_user_state: any;

  //Message
  messageListFaculties:boolean = false;

  //Passwords
  @ViewChild('formDirective', {static: false}) private formDirective: NgForm;
  matcher = new MyErrorStateMatcher();
  //Show password
  is_active:boolean  = true;
  state_input:string = 'Mostrar';


  /*
  ******************************************************************************
  ******************************************************************************
                               CLASS CONSTRUCTOR
  ******************************************************************************
  ******************************************************************************
  */
  constructor(private formBuilder:FormBuilder,
              public  _globalService: GlobalQueriesService,
              public  _universityService: UniversityService,
              public  _settingsService: SettingsService,
              private toastr: ToastrService,
              private route: Router)
  {
    //Get the user type
    _globalService.getUserType()
    .subscribe(UserType => {
      this.list_user_type = UserType;
    });

    //Get the user type
    _globalService.getUserState()
    .subscribe(UserState => {
      this.list_user_state = UserState;
    });

    //Get the faculties
    _universityService.getFaculties()
    .subscribe(Faculties => {
      this.list_faculties = Faculties;
      this.getFaculties();
    });

    //Service that obtains the list of user role
    _settingsService.getProfile()
    .subscribe(Profile => {
      this.list_profile = Profile;

      //Get the value form
      this.list_profile.forEach(element =>
      {
          this.user_form.setValue({
              //Profile data
              user_name: element.nombre_usuario,
              user_lastname: element.apellido_usuario,
              user_email: element.correo_usuario,
              user_faculty: element.id_facultad,
              user_type: element.id_tipo_usuario,
              user_state: element.id_estado_usuario
          });
      });
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
    //Message
    this.toastr.warning("Al actualizar cualquier información del usuario se procederá a cerrar la sesión actual.", "WARNING", {
      timeOut: 7000,
      positionClass: 'toast-top-right'
    });

    //Form builder group
    this.user_form = this.formBuilder.group({
            user_name:       ['', [Validators.required, Validators.maxLength(25), Validators.pattern('^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$')]],
            user_lastname:   ['', [Validators.required, Validators.maxLength(25), Validators.pattern('^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$')]],
            user_email:      ['', [Validators.required, Validators.email]],
            user_faculty:    ['', [Validators.required]],
            user_type:       [{value: '', disabled: true}],
            user_state:      [{value: '', disabled: true}],
    });

    //Form builder group
    this.password_form = this.formBuilder.group({
            old_password:     ['', [Validators.required, Validators.minLength(5), Validators.maxLength(25)]],
            new_password:     ['', [Validators.required, Validators.minLength(5), Validators.maxLength(25)]],
            confirm_password: [''],
    },
    {
      validator: this.checkPasswords
    });
  };

  checkPasswords(group: FormGroup)
  { // here we have the 'passwords' group
    let pass = group.controls.new_password.value;
    let confirmPass = group.controls.confirm_password.value;

    return pass === confirmPass ? null : { notSame: true }
  };

  changeInput()
  {
    if (this.is_active)
    {
      this.is_active   = false;
      this.state_input = 'Ocultar';
    }
    else
    {
      this.is_active   = true;
      this.state_input = 'Mostrar';
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


  /*
  ******************************************************************************
  ******************************************************************************
                              UPDATE USER FORM
  ******************************************************************************
  ******************************************************************************
  */
  get up() { return this.user_form.controls; }
  //User method
  userForm()
  {
    //Disabled form
    this.button_form = true;
    //Submitted
    this.submitted_form = true;

    //Invalid value form
    if (this.user_form.invalid)
    {
      //Disabled form
      this.button_form = false;
      //Finish process
      return;
    }

    //Form values
    const user_name     = this.user_form.get('user_name').value;
    const user_lastname = this.user_form.get('user_lastname').value;
    const user_email    = this.user_form.get('user_email').value;
    const user_faculty  = this.user_form.get('user_faculty').value;
    //User type value
    const user_type     = this.user_form.get('user_type').value;

    this._settingsService.updateProfile(user_name, user_lastname, user_email, user_faculty)
    .subscribe(data=>
    {
      if (data.message == "Usuario actualizado.")
      {
        //Submitted
        this.submitted_form = false;
        //Show the result of the action
        this.toastr.success(data.message, "OK", {
          timeOut: 2000,
          positionClass: 'toast-bottom-center'
        });

        if (user_type == 1)
        {
          //Route navigation
          this.route.navigate(['administrator/logout']);
        }
        else
        {
          //Route navigation
          this.route.navigate(['generator/logout']);
        }
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
                              UPDATE PASSWORD PROFILE FORM
  ******************************************************************************
  ******************************************************************************
  */
  get upu() { return this.password_form.controls; }
  //User method
  passwordForm()
  {
    //Submitted
    this.updated_form = true;

    //Invalid value form
    if (this.password_form.invalid)
    {
      //Disabled form
      this.button_form = false;
      //Finish process
      return;
    }

    //Form values
    const old_password     = this.password_form.get('old_password').value;
    const new_password     = this.password_form.get('new_password').value;
    const confirm_password = this.password_form.get('confirm_password').value;
    //User type value
    const user_type        = this.user_form.get('user_type').value;

    this._settingsService.updatePasswordProfile(old_password, new_password, confirm_password)
    .subscribe(data=>
    {
      if (data.message == "Contraseña actualizada.")
      {
        //Submitted
        this.updated_form = false;
        //Show the result of the action
        this.toastr.success(data.message, "OK", {
          timeOut: 2000,
          positionClass: 'toast-bottom-center'
        });

        if (user_type == 1)
        {
          //Route navigation
          this.route.navigate(['administrator/logout']);
        }
        else
        {
          //Route navigation
          this.route.navigate(['generator/logout']);
        }
        //Refresh page
        window.location.reload();
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

}
