/*
******************************************************************************
******************************************************************************
                              ANGULAR IMPORT
******************************************************************************
******************************************************************************
*/
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

/*
******************************************************************************
******************************************************************************
                              ANGULAR INTERFACE
******************************************************************************
******************************************************************************
*/
import { Global }  from './../interfaces/global';

@Injectable({
  providedIn: 'root'
})
export class AuthService
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
  private api_production = 'backend/production/php/services/auth/';
  //Status
  private loggedInStatus = false;

  /*
  ******************************************************************************
  ******************************************************************************
                                 CLASS CONSTRUCTOR
  ******************************************************************************
  ******************************************************************************
  */

  constructor(private http: HttpClient)
  {

  };


  /*
  ******************************************************************************
  ******************************************************************************
                                FUNCTIONS SERVICE
  ******************************************************************************
  ******************************************************************************
  */

  setLoggedIn(value: boolean)
  {
    this.loggedInStatus = value;
    localStorage.setItem('loggedIn', 'true');
  };

  get isLoggedIn()
  {
    return this.loggedInStatus;
  };

  getAuthentication(user_email:string, user_password:string)
  {
    //Metodo POST
    return this.http.post<Global>(this.api_localhost + 'login.php',
    //return this.http.post<Global>('backend/production/php/auth/authentication.php'
    {
      user_email,
      user_password
    })
  };

}