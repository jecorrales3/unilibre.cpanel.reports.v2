/*
******************************************************************************
******************************************************************************
                              ANGULAR IMPORT
******************************************************************************
******************************************************************************
*/
import { Component, OnInit } from "@angular/core";
import { FormBuilder, FormGroup, Validators } from "@angular/forms";
import { ActivatedRoute, Router } from "@angular/router";
import { ToastrService } from "ngx-toastr";

/*
******************************************************************************
******************************************************************************
                              ANGULAR SERVICES
******************************************************************************
******************************************************************************
*/
import { AuthService } from "./../../services/auth.service";
import { ConsultAuthService } from "./../../services/consult-auth.service";

@Component({
  selector: "app-login",
  templateUrl: "./login.component.html",
  styleUrls: ["./login.component.scss"],
})
export class LoginComponent implements OnInit {
  /*
  ******************************************************************************
  ******************************************************************************
                            LIST OF VARIABLES
  ******************************************************************************
  ******************************************************************************
  */
  //ReactiveForm
  login_form: FormGroup;
  submitted_login: boolean = false;
  evaluated_login: boolean = false;
  //Button form
  button_form: boolean = false;
  //loading effect
  loading: boolean;

  /*
  ******************************************************************************
  ******************************************************************************
                               CLASS CONSTRUCTOR
  ******************************************************************************
  ******************************************************************************
  */
  constructor(
    private formBuilder: FormBuilder,
    private _serviceConsultAuth: ConsultAuthService,
    private Auth: AuthService,
    private route: Router,
    private toastr: ToastrService
  ) {}

  /*
  ******************************************************************************
  ******************************************************************************
                              ANGULAR NGONINIT
  ******************************************************************************
  ******************************************************************************
  */
  ngOnInit() {
    //Method for authentication service
    this._serviceConsultAuth.getService().subscribe((data) => {
      //Verify session status
      if (!data.status) {
        localStorage.removeItem("loggedIn");
      } else {
        this.route.navigate(["administrator/dashboard"]);
      }
    });

    //Form state
    this.evaluated_login = true;
    //Form builder group
    this.login_form = this.formBuilder.group({
      user_email: ["", [Validators.required, Validators.email]],
      user_password: [
        "",
        [
          Validators.required,
          Validators.minLength(5),
          Validators.maxLength(25),
        ],
      ],
    });
  }

  /*
  ******************************************************************************
  ******************************************************************************
                               COMPONENT FUNCTIONS
  ******************************************************************************
  ******************************************************************************
  */

  /*
  ******************************************************************************
  ******************************************************************************
                            ANGULAR CONSULT FORM
  ******************************************************************************
  ******************************************************************************
  */

  get ri() {
    return this.login_form.controls;
  }
  //Login method
  loginForm() {
    //Disabled form
    this.button_form = true;
    //Submitted
    this.submitted_login = true;
    //Show loading effect
    this.loading = true;
    //Invalid value form
    if (this.login_form.invalid) {
      //Dismiss loading effect
      this.loading = false;
      //Disabled form
      this.button_form = false;
      //Finish process
      return;
    }

    //Form values
    const user_email = this.login_form.get("user_email").value;
    const user_password = this.login_form.get("user_password").value;

    this.Auth.getAuthentication(user_email, user_password).subscribe((data) => {
      if (data.status) {
        //Show the result of the action
        this.toastr.success(data.message, "OK", {
          timeOut: 2000,
          positionClass: "toast-bottom-center",
        });

        //Seteamos la autenticacion como valor true
        this.Auth.setLoggedIn(true);

        if (data.usertype == 1) {
          //Route navigation
          this.route.navigate(["administrator"]);
        } else {
          //Route navigation
          this.route.navigate(["generator"]);
        }
      } else {
        //Show the result of the action
        this.toastr.error(data.message, "ERROR", {
          timeOut: 2000,
          positionClass: "toast-bottom-center",
        });
        //Seteamos la autenticacion como valor true
        this.Auth.setLoggedIn(false);
      }
      //Dismiss loading effect
      this.loading = false;
      //Disabled form
      this.button_form = false;
    });
  }
}
