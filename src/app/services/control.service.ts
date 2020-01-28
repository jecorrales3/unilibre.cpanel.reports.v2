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
import { Certificate } from './../interfaces/certificate';
import { Profile }     from './../interfaces/profile';

@Injectable({
  providedIn: 'root'
})
export class ControlService
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
  private api_production = 'backend/production/php/services/control/';

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
                         FUNCTIONS SERVICE (ADVISORS)
  ******************************************************************************
  ******************************************************************************
  */
  //Method return the members (Advisors)
  public getAdvisors()
  {
    //Path
    const path = this.api_localhost + 'getAdvisors.php';
    return this.http.get<Profile[]>(path);
  };

  /*
  ******************************************************************************
  ******************************************************************************
                         FUNCTIONS SERVICE (CERTIFICATE 1)
  ******************************************************************************
  ******************************************************************************
  */
  //Method post that register a report (C1)
  registerReportC1(report_settings_c1: any,
                   report_students_c1: any,
                   report_members_c1: any)
  {
    return this.http.post<Certificate>(this.api_localhost + 'registerReportC1.php',
    {
      report_settings_c1,
      report_students_c1,
      report_members_c1
    })
  };

  /*
  ******************************************************************************
  ******************************************************************************
                         FUNCTIONS SERVICE (CERTIFICATE 2)
  ******************************************************************************
  ******************************************************************************
  */
  //Method post that register a report (C2)
  registerReportC2(report_settings_c2: any,
                   report_students_c2: any,
                   report_members_c2: any)
  {
    return this.http.post<Certificate>(this.api_localhost + 'registerReportC2.php',
    {
      report_settings_c2,
      report_students_c2,
      report_members_c2
    })
  };

  /*
  ******************************************************************************
  ******************************************************************************
                         FUNCTIONS SERVICE (CERTIFICATE 3)
  ******************************************************************************
  ******************************************************************************
  */
  //Method post that register a report (C3)
  registerReportC3(report_settings_c3: any,
                   report_students_c3: any,
                   report_members_c3: any)
  {
    return this.http.post<Certificate>(this.api_localhost + 'registerReportC3.php',
    {
      report_settings_c3,
      report_students_c3,
      report_members_c3
    })
  };

}
