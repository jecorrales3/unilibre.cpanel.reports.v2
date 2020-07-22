/*
******************************************************************************
******************************************************************************
                              ANGULAR IMPORT
******************************************************************************
******************************************************************************
*/
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

/*
******************************************************************************
******************************************************************************
                              ANGULAR SERVICES
******************************************************************************
******************************************************************************
*/
import { Login }  from './../interfaces/login';

interface isLoggedIn
{
  status: boolean;
};

interface logoutStatus
{
  status: boolean;
};


@Injectable({
  providedIn: 'root'
})
export class ConsultAuthService
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
  private api_production = 'backend/production/auth/';

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
  getService()
  {
    //return this.http.get<Login>('backend/production/php/auth/getAuthService.php')
    return this.http.get<Login>(this.api_localhost + 'getAuthentication.php')
  }

  isLoggedIn(): Observable<isLoggedIn>
  {
    //return this.http.get<isLoggedIn>('backend/production/php/auth/logged.php')
    return this.http.get<isLoggedIn>(this.api_localhost + 'getLogged.php')
  }

  logout()
  {
    //return this.http.get<logoutStatus>('backend/production/php/auth/logout.php')
    return this.http.get<logoutStatus>(this.api_localhost + 'logout.php')
  }

}
