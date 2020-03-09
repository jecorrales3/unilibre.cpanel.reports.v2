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
import { Profile }     from './../interfaces/profile';
import { Members }     from './../interfaces/members';
import { Consecutive } from './../interfaces/consecutive';
import { Users }       from './../interfaces/users';

@Injectable({
  providedIn: 'root'
})
export class SettingsService
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
  private api_production = 'backend/production/php/services/settings/';

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
                         FUNCTIONS SERVICE (PROFILE)
  ******************************************************************************
  ******************************************************************************
  */
  //Method return the profile
  public getProfile()
  {
    //Path
    const path = this.api_localhost + 'getProfile.php';
    return this.http.get<Profile[]>(path);
  };

  //Method post that update a user
  updateProfile(user_name:string,
                user_lastname:string,
                user_email:string,
                user_faculty:number)
  {
    return this.http.post<Global>(this.api_localhost + 'updateProfile.php',
    {
      user_name,
      user_lastname,
      user_email,
      user_faculty
    })
  };

  //Method post that update the password
  updatePasswordProfile(old_password:string,
                        new_password:string,
                        confirm_password:string)
  {
    return this.http.post<Global>(this.api_localhost + 'updatePasswordProfile.php',
    {
      old_password,
      new_password,
      confirm_password
    })
  };


  /*
  ******************************************************************************
  ******************************************************************************
                         FUNCTIONS SERVICE (Users)
  ******************************************************************************
  ******************************************************************************
  */
  //Method return the users
  public getUsers()
  {
    //Path
    const path = this.api_localhost + 'getUsers.php';
    return this.http.get<Users[]>(path);
  };

  //Method post that register a user
  registerUser(user_name:string,
               user_lastname:string,
               user_faculty:number,
               user_type:number,
               user_email:string,
               user_password:string,
               user_confirm_password:string)
  {
    return this.http.post<Global>(this.api_localhost + 'registerUser.php',
    {
      user_name,
      user_lastname,
      user_faculty,
      user_type,
      user_email,
      user_password,
      user_confirm_password
    })
  };

  //Method post that update a user
  updateUser(user_id:number,
             user_name:string,
             user_lastname:string,
             user_faculty:number,
             user_type:number,
             user_state:number,
             user_email:string,
             user_password:string,
             user_confirm_password:string)
  {
    return this.http.post<Global>(this.api_localhost + 'updateUser.php',
    {
      user_id,
      user_name,
      user_lastname,
      user_faculty,
      user_type,
      user_state,
      user_email,
      user_password,
      user_confirm_password
    })
  };

  //Method post that delete a user
  deleteUser(user_id:number)
  {
    return this.http.post<Global>(this.api_localhost + 'deleteUser.php',
    {
      user_id
    })
  };


  /*
  ******************************************************************************
  ******************************************************************************
                         FUNCTIONS SERVICE (SIGNATURE)
  ******************************************************************************
  ******************************************************************************
  */
  //Method return the member signature
  public getMemberSignature()
  {
    //Path
    const path = this.api_localhost + 'getMemberSignature.php';
    return this.http.get<Members[]>(path);
  };


  /*
  ******************************************************************************
  ******************************************************************************
                         FUNCTIONS SERVICE (CONSECUTIVE)
  ******************************************************************************
  ******************************************************************************
  */
  //Method return the consecutive
  public getConsecutive()
  {
    //Path
    const path = this.api_localhost + 'getConsecutive.php';
    return this.http.get<Consecutive[]>(path);
  };

  //Method post that register a consecutive
  registerConsecutive(consecutive_current:string,
                      consecutive_faculty:string,
                      consecutive_type:number)
  {
    return this.http.post<Global>(this.api_localhost + 'registerConsecutive.php',
    {
      consecutive_current,
      consecutive_faculty,
      consecutive_type
    })
  };

  //Method post that update a consecutive
  updateConsecutive(consecutive_id:number,
                    consecutive_state:string)
  {
    return this.http.post<Global>(this.api_localhost + 'updateConsecutive.php',
    {
      consecutive_id,
      consecutive_state
    })
  };

}
