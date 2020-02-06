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
import { Cities }              from './../interfaces/cities';
import { MemberType }          from './../interfaces/member_type';
import { UserType }            from './../interfaces/user_type';
import { UserState }           from './../interfaces/user_state';
import { MemberPosition }      from './../interfaces/member_position';
import { InvestigationGroups } from './../interfaces/investigation_groups';
import { CertificateTypes }    from './../interfaces/certificate_types';
import { ConsecutiveTypes }    from './../interfaces/consecutive_types';

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

  //Method return the member position (for C1 y C3)
  public getMemberPosition()
  {
    //Path
    const path = this.api_localhost + 'getMemberPosition.php';
    return this.http.get<MemberPosition[]>(path);
  };

  //Method return the member position (for C2)
  public getMemberPosition2()
  {
    //Path
    const path = this.api_localhost + 'getMemberPosition2.php';
    return this.http.get<MemberPosition[]>(path);
  };

  //Method return the investigation groups
  public getInvestigationGroups()
  {
    //Path
    const path = this.api_localhost + 'getInvestigationGroups.php';
    return this.http.get<InvestigationGroups[]>(path);
  };

  //Method return the certificate types
  public getCertificateTypes()
  {
    //Path
    const path = this.api_localhost + 'getCertificateTypes.php';
    return this.http.get<CertificateTypes[]>(path);
  };

  //Method return the consecutive types
  public getConsecutiveTypes()
  {
    //Path
    const path = this.api_localhost + 'getConsecutiveTypes.php';
    return this.http.get<ConsecutiveTypes[]>(path);
  };


}
