/*
******************************************************************************
******************************************************************************
                              ANGULAR IMPORT
******************************************************************************
******************************************************************************
*/
import { Injectable } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { environment } from "../../environments/environment";

/*
******************************************************************************
******************************************************************************
                              ANGULAR INTERFACE
******************************************************************************
******************************************************************************
*/
import { Global } from "./../interfaces/global";

@Injectable({
  providedIn: "root",
})
export class AuthService {
  /*
  ******************************************************************************
  ******************************************************************************
                            LIST OF VARIABLES
  ******************************************************************************
  ******************************************************************************
  */
  //URL
  private URL = environment.baseUrl + "auth/";
  //Status
  private loggedInStatus = false;

  /*
  ******************************************************************************
  ******************************************************************************
                                 CLASS CONSTRUCTOR
  ******************************************************************************
  ******************************************************************************
  */

  constructor(private http: HttpClient) {}

  /*
  ******************************************************************************
  ******************************************************************************
                                FUNCTIONS SERVICE
  ******************************************************************************
  ******************************************************************************
  */

  setLoggedIn(value: boolean) {
    this.loggedInStatus = value;
    localStorage.setItem("loggedIn", "true");
  }

  get isLoggedIn() {
    return this.loggedInStatus;
  }

  getAuthentication(user_email: string, user_password: string) {
    //Metodo POST
    return this.http.post<Global>(this.URL + "login.php", {
      user_email,
      user_password,
    });
  }
}
