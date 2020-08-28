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
import { Cities } from "./../interfaces/cities";
import { MemberType } from "./../interfaces/member_type";
import { UserType } from "./../interfaces/user_type";
import { UserState } from "./../interfaces/user_state";
import { MemberPosition } from "./../interfaces/member_position";
import { InvestigationGroups } from "./../interfaces/investigation_groups";
import { CertificateTypes } from "./../interfaces/certificate_types";
import { ConsecutiveTypes } from "./../interfaces/consecutive_types";
import { ConsecutiveState } from "./../interfaces/consecutive_state";
import { ConsecutiveYears } from "./../interfaces/consecutive_years";
import { ReportState } from "./../interfaces/report_state";
import { ReportTypes } from "./../interfaces/report_types";
import { ConvocatoryTypes } from "./../interfaces/convocatory_types";

@Injectable({
  providedIn: "root",
})
export class GlobalQueriesService {
  /*
  ******************************************************************************
  ******************************************************************************
                            LIST OF VARIABLES
  ******************************************************************************
  ******************************************************************************
  */
  //URL API for localhost server
  private URL = environment.baseUrl + "global/";

  //Array list
  list_months = [
    {
      id_month: "1",
      month_name: "Enero",
    },
    {
      id_month: "2",
      month_name: "Febrero",
    },
    {
      id_month: "3",
      month_name: "Marzo",
    },
    {
      id_month: "4",
      month_name: "Abril",
    },
    {
      id_month: "5",
      month_name: "Mayo",
    },
    {
      id_month: "6",
      month_name: "Junio",
    },
    {
      id_month: "7",
      month_name: "Julio",
    },
    {
      id_month: "8",
      month_name: "Agosto",
    },
    {
      id_month: "9",
      month_name: "Septiembre",
    },
    {
      id_month: "10",
      month_name: "Octubre",
    },
    {
      id_month: "11",
      month_name: "Noviembre",
    },
    {
      id_month: "12",
      month_name: "Diciembre",
    },
  ];

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
                         FUNCTIONS SERVICE (GLOBAL ARRAY)
  ******************************************************************************
  ******************************************************************************
  */

  getMonthList() {
    return this.list_months;
  }

  /*
  ******************************************************************************
  ******************************************************************************
                         FUNCTIONS SERVICE (GLOBAL QUERIES)
  ******************************************************************************
  ******************************************************************************
  */
  //Method return the cities
  public getCities() {
    //Path
    const path = this.URL + "getCities.php";
    return this.http.get<Cities[]>(path);
  }

  //Method return the member type
  public getMemberType() {
    //Path
    const path = this.URL + "getMemberType.php";
    return this.http.get<MemberType[]>(path);
  }

  //Method return the user type
  public getUserType() {
    //Path
    const path = this.URL + "getUserType.php";
    return this.http.get<UserType[]>(path);
  }

  //Method return the user type
  public getUserState() {
    //Path
    const path = this.URL + "getUserState.php";
    return this.http.get<UserState[]>(path);
  }

  //Method return the member position (for C1 y C3)
  public getMemberPosition() {
    //Path
    const path = this.URL + "getMemberPosition.php";
    return this.http.get<MemberPosition[]>(path);
  }

  //Method return the member position (for C2)
  public getMemberPosition2() {
    //Path
    const path = this.URL + "getMemberPosition2.php";
    return this.http.get<MemberPosition[]>(path);
  }

  //Method return the investigation groups
  public getInvestigationGroups() {
    //Path
    const path = this.URL + "getInvestigationGroups.php";
    return this.http.get<InvestigationGroups[]>(path);
  }

  //Method return the certificate types
  public getCertificateTypes() {
    //Path
    const path = this.URL + "getCertificateTypes.php";
    return this.http.get<CertificateTypes[]>(path);
  }

  //Method return the consecutive types
  public getConsecutiveTypes() {
    //Path
    const path = this.URL + "getConsecutiveTypes.php";
    return this.http.get<ConsecutiveTypes[]>(path);
  }

  //Method return the consecutive state
  public getConsecutiveState() {
    //Path
    const path = this.URL + "getConsecutiveState.php";
    return this.http.get<ConsecutiveState[]>(path);
  }

  //Method return the report status
  public getReportState() {
    //Path
    const path = this.URL + "getReportState.php";
    return this.http.get<ReportState[]>(path);
  }

  //Method return the report types
  public getReportTypes() {
    //Path
    const path = this.URL + "getReportTypes.php";
    return this.http.get<ReportTypes[]>(path);
  }

  //Method return the consecutive year (list)
  public getConsecutiveYears() {
    //Path
    const path = this.URL + "getConsecutiveYears.php";
    return this.http.get<ConsecutiveYears[]>(path);
  }

  //Method return the convocatory types
  public getConvocatoryTypes() {
    //Path
    const path = this.URL + "getConvocatoryTypes.php";
    return this.http.get<ConvocatoryTypes[]>(path);
  }
}
