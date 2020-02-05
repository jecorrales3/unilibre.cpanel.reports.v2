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
import { Faculties }   from './../interfaces/faculties';
import { Members }     from './../interfaces/members';
import { Students }    from './../interfaces/students';
import { Report }      from './../interfaces/report';
//import { University }  from './../interfaces/university';

@Injectable({
  providedIn: 'root'
})
export class UniversityService
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
                         FUNCTIONS SERVICE (FACULTIES)
  ******************************************************************************
  ******************************************************************************
  */
  //Method return the faculties
  public getFaculties()
  {
    //Path
    const path = this.api_localhost + 'getFaculties.php';
    return this.http.get<Faculties[]>(path);
  };

  //Method post that register a faculty
  registerFaculty(faculty_name:string,
                  faculty_acronym:string,
                  faculty_city:number)
  {
    return this.http.post<Global>(this.api_localhost + 'registerFaculty.php',
    {
      faculty_name,
      faculty_acronym,
      faculty_city
    })
  };

  //Method post that update a faculty
  updateFaculty(faculty_id:number,
                faculty_name:string,
                faculty_acronym:string,
                faculty_city:string)
  {
    return this.http.post<Global>(this.api_localhost + 'updateFaculty.php',
    {
      faculty_id,
      faculty_name,
      faculty_acronym,
      faculty_city
    })
  };

  //Method post that delete a faculty
  deleteFaculty(faculty_id:number)
  {
    return this.http.post<Global>(this.api_localhost + 'deleteFaculty.php',
    {
      faculty_id
    })
  };



  /*
  ******************************************************************************
  ******************************************************************************
                         FUNCTIONS SERVICE (PROGRAM)
  ******************************************************************************
  ******************************************************************************
  */
  //Method return the program
  public getPrograms()
  {
    //Path
    const path = this.api_localhost + 'getPrograms.php';
    return this.http.get<Members[]>(path);
  };

  //Method post that register a program
  registerProgram(program_name:string,
                  program_title_name:string,
                  program_faculty:string)
  {
    return this.http.post<Global>(this.api_localhost + 'registerProgram.php',
    {
      program_name,
      program_title_name,
      program_faculty
    })
  };

  //Method post that update a program
  updateProgram(program_id:number,
                program_name:string,
                program_title_name:string,
                program_faculty:string)
  {
    return this.http.post<Global>(this.api_localhost + 'updateProgram.php',
    {
      program_id,
      program_name,
      program_title_name,
      program_faculty
    })
  };

  //Method post that delete a program
  deleteProgram(program_id:number)
  {
    return this.http.post<Global>(this.api_localhost + 'deleteProgram.php',
    {
      program_id
    })
  };


  /*
  ******************************************************************************
  ******************************************************************************
                         FUNCTIONS SERVICE (MEMBERS)
  ******************************************************************************
  ******************************************************************************
  */
  //Method return the members
  public getMembers()
  {
    //Path
    const path = this.api_localhost + 'getMembers.php';
    return this.http.get<Members[]>(path);
  };

  //Method return the members
  public getDetailMemberList(faculty_id: string | string[])
  {
    //Path
    const path = this.api_localhost + 'getDetailMemberList.php';
    return this.http.get<Members[]>(path, {
          params: {
            faculty_id: faculty_id
          }
        });
  };

  //Method post that register a member
  registerMember(member_name:string,
                 member_lastname:string,
                 member_email:string,
                 member_document:number,
                 member_faculty:number,
                 member_type:number)
  {
    return this.http.post<Global>(this.api_localhost + 'registerMember.php',
    {
      member_name,
      member_lastname,
      member_email,
      member_document,
      member_faculty,
      member_type
    })
  };

  //Method post that update a member
  updateMember(member_id:number,
               member_name:string,
               member_lastname:string,
               member_email:string,
               member_document:number,
               member_faculty:number,
               member_type:number)
  {
    return this.http.post<Global>(this.api_localhost + 'updateMember.php',
    {
      member_id,
      member_name,
      member_lastname,
      member_email,
      member_document,
      member_faculty,
      member_type
    })
  };

  //Method post that delete a member
  deleteMember(member_id:number)
  {
    return this.http.post<Global>(this.api_localhost + 'deleteMember.php',
    {
      member_id
    })
  };



  /*
  ******************************************************************************
  ******************************************************************************
                         FUNCTIONS SERVICE (STUDENTS)
  ******************************************************************************
  ******************************************************************************
  */
  //Method return the students
  public getStudents()
  {
    //Path
    const path = this.api_localhost + 'getStudents.php';
    return this.http.get<Students[]>(path);
  };

  //Method return the report list
  public getDetailReportList(student_document: string | string[])
  {
    //Path
    const path = this.api_localhost + 'getDetailReportList.php';
    return this.http.get<Report[]>(path, {
          params: {
            student_document: student_document
          }
        });
  };

}
