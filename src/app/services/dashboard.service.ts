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
import { ReportCounters } from "./../interfaces/report_counters";
import { ReportPercentage } from "./../interfaces/report_percentage";
import { ReportList } from "./../interfaces/report_list";

@Injectable({
  providedIn: "root",
})
export class DashboardService {
  /*
  ******************************************************************************
  ******************************************************************************
                            LIST OF VARIABLES
  ******************************************************************************
  ******************************************************************************
  */
  //URL API for localhost server
  private URL = environment.baseUrl + "dashboard/";

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
                         FUNCTIONS SERVICE (GLOBAL QUERIES)
  ******************************************************************************
  ******************************************************************************
  */
  //Method return the report counter list
  public getReportCounters() {
    //Path
    const path = this.URL + "getReportCounters.php";
    return this.http.get<ReportCounters[]>(path);
  }

  //Method return the percentage report
  public getReportPercentage() {
    //Path
    const path = this.URL + "getReportPercentage.php";
    return this.http.get<ReportPercentage[]>(path);
  }

  //Method return the list (last 5 reports)
  public getReportList() {
    //Path
    const path = this.URL + "getReportList.php";
    return this.http.get<ReportList[]>(path);
  }
}
