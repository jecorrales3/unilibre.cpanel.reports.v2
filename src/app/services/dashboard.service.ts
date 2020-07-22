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
import { ReportCounters }      from './../interfaces/report_counters';
import { ReportPercentage }    from './../interfaces/report_percentage';
import { ReportList }          from './../interfaces/report_list';

@Injectable({
  providedIn: 'root'
})
export class DashboardService
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
  private api_production = 'backend/production/dashboard/';

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
  //Method return the report counter list
  public getReportCounters()
  {
    //Path
    const path = this.api_localhost + 'getReportCounters.php';
    return this.http.get<ReportCounters[]>(path);
  };

  //Method return the percentage report
  public getReportPercentage()
  {
    //Path
    const path = this.api_localhost + 'getReportPercentage.php';
    return this.http.get<ReportPercentage[]>(path);
  };

  //Method return the list (last 5 reports)
  public getReportList()
  {
    //Path
    const path = this.api_localhost + 'getReportList.php';
    return this.http.get<ReportList[]>(path);
  };
}
