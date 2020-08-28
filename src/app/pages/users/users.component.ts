/*
******************************************************************************
******************************************************************************
                              ANGULAR IMPORT
******************************************************************************
******************************************************************************
*/
import {
  Component,
  OnInit,
  OnDestroy,
  ViewChild,
  ChangeDetectorRef,
  TemplateRef,
} from "@angular/core";
import {
  FormBuilder,
  FormGroup,
  Validators,
  NgForm,
  FormGroupDirective,
  FormControl,
} from "@angular/forms";
import { ToastrService } from "ngx-toastr";
import { MatTableDataSource, MatPaginator } from "@angular/material";
import { ErrorStateMatcher } from "@angular/material/core";
import { Observable } from "rxjs";
import { BsModalService, BsModalRef } from "ngx-bootstrap/modal";

/*
******************************************************************************
******************************************************************************
                              ANGULAR SERVICES
******************************************************************************
******************************************************************************
*/
import { GlobalQueriesService } from "./../../services/global-queries.service";
import { UniversityService } from "./../../services/university.service";
import { SettingsService } from "./../../services/settings.service";

/*
******************************************************************************
******************************************************************************
                          ANGULAR STATE MATCH
******************************************************************************
******************************************************************************
*/

export class MyErrorStateMatcher implements ErrorStateMatcher {
  isErrorState(
    control: FormControl | null,
    form: FormGroupDirective | NgForm | null
  ): boolean {
    const invalidCtrl = !!(control && control.invalid && control.parent.dirty);
    const invalidParent = !!(
      control &&
      control.parent &&
      control.parent.invalid &&
      control.parent.dirty
    );

    return control.parent.errors && control.parent.errors["notSame"];
  }
}

@Component({
  selector: "app-users",
  templateUrl: "./users.component.html",
  styleUrls: ["./users.component.scss"],
})
export class UsersComponent implements OnInit, OnDestroy {
  /*
  ******************************************************************************
  ******************************************************************************
                            LIST OF VARIABLES
  ******************************************************************************
  ******************************************************************************
  */
  //ReactiveForm
  user_form: FormGroup;
  update_user_form: FormGroup;
  submitted_form: boolean = false;
  updated_form: boolean = false;
  //Boolean variables view
  listForm: boolean = true;
  registerForm: boolean = false;
  //Class Bootstrap = Active.
  listClass: string;
  registerClass: string;
  //Button form
  button_form: boolean = false;
  //loading effect
  loading: boolean = true;

  //List of services (aux)
  list_users_aux: any;
  //List of services
  list_users: any;
  list_faculties: any;
  list_user_type: any;
  list_user_state: any;

  //Detail data
  detail_user_id: number;
  detail_user_name: string;
  detail_user_lastname: string;
  detail_user_faculty: number;
  detail_user_type: number;
  detail_user_state: number;
  detail_user_email: string;

  //Message
  messageFilterResult: boolean = false;
  messageListUsers: boolean = false;
  messageListFaculties: boolean = false;

  //Paginator
  @ViewChild(MatPaginator) paginator: MatPaginator;
  obs: Observable<any>;
  dataSource: any;

  //Passwords
  @ViewChild("formDirective", { static: false }) private formDirective: NgForm;
  matcher = new MyErrorStateMatcher();
  //Show password
  is_active: boolean = true;
  state_input: string = "Mostrar";

  // Modal settings
  modalRef: BsModalRef;
  config = {
    backdrop: true,
    ignoreBackdropClick: false,
  };

  /*
  ******************************************************************************
  ******************************************************************************
                               CLASS CONSTRUCTOR
  ******************************************************************************
  ******************************************************************************
  */
  constructor(
    private formBuilder: FormBuilder,
    public _globalService: GlobalQueriesService,
    public _universityService: UniversityService,
    public _settingsService: SettingsService,
    private toastr: ToastrService,
    private changeDetectorRef: ChangeDetectorRef,
    private modalService: BsModalService
  ) {
    //Get the user type
    _globalService.getUserType().subscribe((UserType) => {
      this.list_user_type = UserType;
    });

    //Get the user type
    _globalService.getUserState().subscribe((UserState) => {
      this.list_user_state = UserState;
    });

    //Get the faculties
    _universityService.getFaculties().subscribe((Faculties) => {
      this.list_faculties = Faculties;
      this.getFaculties();
    });

    //Get the user list
    this._settingsService.getUsers().subscribe((Users) => {
      const ELEMENT_DATA = Users;
      //Get the elements
      this.list_users_aux = new MatTableDataSource(ELEMENT_DATA);
      this.list_users_aux.paginator = this.paginator;
      this.list_users = this.list_users_aux.connect();
      this.getUsers();
    });
  }

  /*
  ******************************************************************************
  ******************************************************************************
                              ANGULAR NGONINIT
  ******************************************************************************
  ******************************************************************************
  */
  ngOnInit() {
    //Class Bootstrap = Active.
    this.listClass = "active";

    //Form builder group (Register)
    this.user_form = this.formBuilder.group(
      {
        user_name: [
          "",
          [
            Validators.required,
            Validators.maxLength(40),
            Validators.pattern("^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$"),
          ],
        ],
        user_lastname: [
          "",
          [
            Validators.required,
            Validators.maxLength(40),
            Validators.pattern("^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$"),
          ],
        ],
        user_faculty: ["", [Validators.required]],
        user_type: ["1", [Validators.required]],
        user_email: [
          "",
          [Validators.required, Validators.email, Validators.maxLength(70)],
        ],
        user_password: [
          "",
          [
            Validators.required,
            Validators.minLength(5),
            Validators.maxLength(30),
          ],
        ],
        user_confirm_password: [""],
      },
      {
        validator: this.checkPasswords,
      }
    );

    //Form builder group (Update)
    this.update_user_form = this.formBuilder.group(
      {
        user_name: [
          "",
          [
            Validators.required,
            Validators.maxLength(40),
            Validators.pattern("^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$"),
          ],
        ],
        user_lastname: [
          "",
          [
            Validators.required,
            Validators.maxLength(40),
            Validators.pattern("^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$"),
          ],
        ],
        user_faculty: ["", [Validators.required]],
        user_type: ["", [Validators.required]],
        user_state: ["", [Validators.required]],
        user_email: ["", [Validators.email, Validators.maxLength(70)]],
        user_password: [
          "",
          [Validators.minLength(5), Validators.maxLength(30)],
        ],
        user_confirm_password: [""],
      },
      {
        validator: this.checkPasswords,
      }
    );

    this.changeDetectorRef.detectChanges();

    //Label elements
    this.paginator._intl.itemsPerPageLabel = "Ítems por página:";
    this.paginator._intl.firstPageLabel = "Primer página ";
    this.paginator._intl.previousPageLabel = "Anterior";
    this.paginator._intl.nextPageLabel = "Siguiente";
    this.paginator._intl.lastPageLabel = "Última página";
  }

  checkPasswords(group: FormGroup) {
    // here we have the 'passwords' group
    let pass = group.controls.user_password.value;
    let confirmPass = group.controls.user_confirm_password.value;

    return pass === confirmPass ? null : { notSame: true };
  }

  changeInput() {
    if (this.is_active) {
      this.is_active = false;
      this.state_input = "Ocultar";
    } else {
      this.is_active = true;
      this.state_input = "Mostrar";
    }
  }

  ngOnDestroy() {
    if (this.list_users_aux) {
      this.list_users_aux.disconnect();
    }
  }

  /*
  ******************************************************************************
  ******************************************************************************
                               COMPONENT FUNCTIONS
  ******************************************************************************
  ******************************************************************************
  */
  listSection() {
    //Variable form
    this.listForm = true;
    this.registerForm = false;
    //Class Bootstrap = Active.
    this.listClass = "active";
    this.registerClass = "";
  }

  registerSection() {
    //Variable form
    this.listForm = false;
    this.registerForm = true;
    //Class Bootstrap = Active.
    this.listClass = "";
    this.registerClass = "active";
  }

  openDetailModal(detailTemplate: TemplateRef<any>) {
    this.modalRef = this.modalService.show(detailTemplate, this.config);
  }

  openDeleteModal(deleteTemplate: TemplateRef<any>) {
    this.modalRef = this.modalService.show(deleteTemplate, this.config);
  }

  /*
   ******************************************************************************
   ******************************************************************************
   ******************************    SEARCH DATA   ******************************
   ******************************************************************************
   ******************************************************************************
   */

  applyFilter(filterValue: string) {
    this.list_users_aux.filter = filterValue.trim().toLowerCase();

    if (this.list_users_aux.filteredData.length == 0) {
      this.messageFilterResult = true;
      this.messageListUsers = false;
    } else {
      this.messageFilterResult = false;
    }
  }

  /*
  ******************************************************************************
  ******************************************************************************
                              METHODS FROM SERVICE RESULT
  ******************************************************************************
  ******************************************************************************
  */
  getFaculties() {
    //Evaluamos si contiene datos
    if (this.list_faculties.length > 0) {
      this.messageListFaculties = false;
    } else {
      this.messageListFaculties = true;
    }
  }

  getUsers() {
    //Loading effect
    this.loading = false;
    //Length data
    if (this.list_users_aux.filteredData.length > 0) {
      this.messageListUsers = false;
    } else {
      this.messageListUsers = true;
    }
  }

  /*
  ******************************************************************************
  ******************************************************************************
                              LOAD DETAIL (MODAL WINDOW)
  ******************************************************************************
  ******************************************************************************
  */
  loadDetail(user) {
    this.detail_user_id = user.id_usuario;
    this.detail_user_name = user.nombre_usuario;
    this.detail_user_lastname = user.apellido_usuario;
    this.detail_user_faculty = user.id_facultad;
    this.detail_user_type = user.id_tipo_usuario;
    this.detail_user_state = user.id_estado_usuario;
    this.detail_user_email = user.correo_usuario;

    //Set the values
    this.update_user_form.setValue({
      user_name: this.detail_user_name,
      user_lastname: this.detail_user_lastname,
      user_faculty: this.detail_user_faculty,
      user_type: this.detail_user_type,
      user_state: this.detail_user_state,
      user_email: this.detail_user_email,
      user_password: null,
      user_confirm_password: null,
    });
  }

  /*
  ******************************************************************************
  ******************************************************************************
                              REGISTER MEMBER FORM
  ******************************************************************************
  ******************************************************************************
  */
  get ru() {
    return this.user_form.controls;
  }

  registerUser() {
    //Disabled form
    this.button_form = true;
    //Submitted
    this.submitted_form = true;
    //Invalid value form
    if (this.user_form.invalid) {
      //Disabled form
      this.button_form = false;
      //Finish process
      return;
    }

    //Form values
    const user_name = this.user_form.get("user_name").value;
    const user_lastname = this.user_form.get("user_lastname").value;
    const user_faculty = this.user_form.get("user_faculty").value;
    const user_type = this.user_form.get("user_type").value;
    const user_email = this.user_form.get("user_email").value;
    const user_password = this.user_form.get("user_password").value;
    const user_confirm_password = this.user_form.get("user_confirm_password")
      .value;

    this._settingsService
      .registerUser(
        user_name,
        user_lastname,
        user_faculty,
        user_type,
        user_email,
        user_password,
        user_confirm_password
      )
      .subscribe((data) => {
        if (data.message == "Usuario registrado.") {
          //Submitted
          this.submitted_form = false;
          //Show the result of the action
          this.toastr.success(data.message, "OK", {
            timeOut: 2000,
            positionClass: "toast-bottom-center",
          });

          //Set the values to null
          this.user_form.setValue({
            user_name: null,
            user_lastname: null,
            user_faculty: null,
            user_type: null,
            user_email: null,
            user_password: null,
            user_confirm_password: null,
          });

          this.refreshData();
        } else {
          //Show the result of the action
          this.toastr.error(data.message, "ERROR", {
            timeOut: 2000,
            positionClass: "toast-bottom-center",
          });
        }
        //Disabled form
        this.button_form = false;
      });
  }

  /*
  ******************************************************************************
  ******************************************************************************
                              UPDATE MEMBER FORM
  ******************************************************************************
  ******************************************************************************
  */
  get uu() {
    return this.update_user_form.controls;
  }

  updateUser() {
    //Submitted
    this.updated_form = true;
    //Invalid value form
    if (this.update_user_form.invalid) {
      //Finish process
      return;
    }

    //Form values
    const user_id = this.detail_user_id;
    const user_name = this.update_user_form.get("user_name").value;
    const user_lastname = this.update_user_form.get("user_lastname").value;
    const user_faculty = this.update_user_form.get("user_faculty").value;
    const user_type = this.update_user_form.get("user_type").value;
    const user_state = this.update_user_form.get("user_state").value;
    const user_email = this.update_user_form.get("user_email").value;
    const user_password = this.update_user_form.get("user_password").value;
    const user_confirm_password = this.update_user_form.get(
      "user_confirm_password"
    ).value;

    this._settingsService
      .updateUser(
        user_id,
        user_name,
        user_lastname,
        user_faculty,
        user_type,
        user_state,
        user_email,
        user_password,
        user_confirm_password
      )
      .subscribe((data) => {
        if (data.message == "Usuario actualizado.") {
          //Submitted
          this.updated_form = false;
          //Show the result of the action
          this.toastr.success(data.message, "OK", {
            timeOut: 2000,
            positionClass: "toast-bottom-center",
          });

          //Set the values
          this.update_user_form.setValue({
            user_name: user_name,
            user_lastname: user_lastname,
            user_faculty: user_faculty,
            user_type: user_type,
            user_state: user_state,
            user_email: user_email,
            user_password: null,
            user_confirm_password: null,
          });

          this.refreshData();
        } else {
          //Show the result of the action
          this.toastr.error(data.message, "ERROR", {
            timeOut: 2000,
            positionClass: "toast-bottom-center",
          });
        }
      });
  }

  /*
  ******************************************************************************
  ******************************************************************************
                               DELETE MEMBER
  ******************************************************************************
  ******************************************************************************
  */
  deleteUser() {
    //Get the id
    const user_id = this.detail_user_id;

    //Method
    this._settingsService.deleteUser(user_id).subscribe((data) => {
      if (data.message == "Usuario eliminado.") {
        //Show the result of the action
        this.toastr.success(data.message, "OK", {
          timeOut: 2000,
          positionClass: "toast-bottom-center",
        });

        this.refreshData();
      } else {
        //Show the result of the action
        this.toastr.error(data.message, "ERROR", {
          timeOut: 2000,
          positionClass: "toast-bottom-center",
        });
      }
    });
  }

  /*
  ******************************************************************************
  ******************************************************************************
                              REFRESH DATA METHOD
  ******************************************************************************
  ******************************************************************************
  */
  refreshData() {
    //Get the user list
    this._settingsService.getUsers().subscribe((Users) => {
      const ELEMENT_DATA = Users;
      //Get the elements
      this.list_users_aux = new MatTableDataSource(ELEMENT_DATA);
      this.list_users_aux.paginator = this.paginator;
      this.list_users = this.list_users_aux.connect();
      this.getUsers();
    });
  }
}
