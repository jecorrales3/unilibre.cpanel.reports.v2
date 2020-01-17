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
import { Global }      from './../interfaces/global';
import { Cities }      from './../interfaces/cities';
import { MemberType }  from './../interfaces/member_type';
import { UserType }    from './../interfaces/user_type';
import { UserState }   from './../interfaces/user_state';

@Injectable({
  providedIn: 'root'
})
export class GlobalQueriesService
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
  private api_production = 'backend/production/php/services/university/';

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
                         FUNCTIONS SERVICE (GLOBAL QUERIES)
  ******************************************************************************
  ******************************************************************************
  */
  //Method return the cities
  public getCities()
  {
    //Path
    const path = this.api_localhost + 'getCities.php';
    return this.http.get<Cities[]>(path);
  };

  //Method return the member type
  public getMemberType()
  {
    //Path
    const path = this.api_localhost + 'getMemberType.php';
    return this.http.get<MemberType[]>(path);
  };

  //Method return the user type
  public getUserType()
  {
    //Path
    const path = this.api_localhost + 'getUserType.php';
    return this.http.get<UserType[]>(path);
  };

  //Method return the user type
  public getUserState()
  {
    //Path
    const path = this.api_localhost + 'getUserState.php';
    return this.http.get<UserState[]>(path);
  };

}
