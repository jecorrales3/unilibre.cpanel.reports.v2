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
import { Reports }     from './../interfaces/reports';
import { Certificate } from './../interfaces/certificate';
import { Profile }     from './../interfaces/profile';
import { Global }      from './../interfaces/global';

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
  private api_production = 'backend/production/control/';

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
                         FUNCTIONS SERVICE (REPORTS)
  ******************************************************************************
  ******************************************************************************
  */
  //Method return the reports
  public getReports()
  {
    //Path
    const path = this.api_localhost + 'getReports.php';
    return this.http.get<Reports[]>(path);
  };

  //Method return the members
  public searchReports(type_report: any, year_report: any, month_report: any)
  {
    //Path
    const path = this.api_localhost + 'getDetailReports.php';
    return this.http.get<Reports[]>(path, {
          params: {
            type_report: type_report,
            year_report: year_report,
            month_report: month_report
          }
        });
  };

  //Method post that update a report state
  updateReport(configuration_id: number,
               report_state: number)
  {
    return this.http.post<Global>(this.api_localhost + 'updateReport.php',
    {
      configuration_id,
      report_state
    })
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
                   report_groups_c1: any,
                   report_members_c1: any)
  {
    return this.http.post<Certificate>(this.api_localhost + 'registerReportC1.php',
    {
      report_settings_c1,
      report_groups_c1,
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

  /*
  ******************************************************************************
  ******************************************************************************
                         FUNCTIONS SERVICE (CERTIFICATE 4)
  ******************************************************************************
  ******************************************************************************
  */
  //Method post that register a report (C4)
  registerReportC4(report_settings_c4: any,
                   report_students_c4: any,
                   report_members_c4: any)
  {
    return this.http.post<Certificate>(this.api_localhost + 'registerReportC4.php',
    {
      report_settings_c4,
      report_students_c4,
      report_members_c4
    })
  };

  /*
  ******************************************************************************
  ******************************************************************************
                         FUNCTIONS SERVICE (CERTIFICATE 5)
  ******************************************************************************
  ******************************************************************************
  */
  //Method post that register a report (C5)
  registerReportC5(report_settings_c5: any,
                   report_students_c5: any,
                   report_members_c5: any)
  {
    return this.http.post<Certificate>(this.api_localhost + 'registerReportC5.php',
    {
      report_settings_c5,
      report_students_c5,
      report_members_c5
    })
  };

  /*
  ******************************************************************************
  ******************************************************************************
                         FUNCTIONS SERVICE (CERTIFICATE 6)
  ******************************************************************************
  ******************************************************************************
                                DISABLED REPORT
  ******************************************************************************
  ******************************************************************************
  */
  //Method post that register a report (C6)
  registerReportC6(report_settings_c6: any,
                   report_students_c6: any,
                   report_members_c6: any)
  {
    return this.http.post<Certificate>(this.api_localhost + 'registerReportC6.php',
    {
      report_settings_c6,
      report_students_c6,
      report_members_c6
    })
  };

}
