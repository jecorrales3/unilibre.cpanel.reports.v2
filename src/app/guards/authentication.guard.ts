/*
******************************************************************************
******************************************************************************
                                IMPORTACION                                
                                    DE                                    
                                OPERACIONES                                
******************************************************************************
******************************************************************************
*/
import { Injectable } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { Observable } from 'rxjs';
import { Router }     from '@angular/router';
import { map }        from 'rxjs/operators';
//Importacion de servicios
import { AuthService }        from './../services/auth.service';
import { ConsultAuthService } from './../services/consult-auth.service';

@Injectable({
  providedIn: 'root'
})

export class AuthenticationGuard implements CanActivate
{
  /*
  ******************************************************************************
  ******************************************************************************
                                   VARIABLES     
                                      DEL       
                                     GUARD       
  ******************************************************************************
  ******************************************************************************
  */
  //Declaracion de mensaje de retorno
  message:string;
  /*
  ******************************************************************************
  ******************************************************************************
                                   CONSTRUCTOR                                 
                                      DE LA                                 
                                      CLASE                                    
  ******************************************************************************
  ******************************************************************************
  */
  constructor(private Auth: AuthService,
              private rout: Router,
              private consultService: ConsultAuthService)
  {

  };

  /*
  ******************************************************************************
  ******************************************************************************
                                   FUNCIONES      
  ******************************************************************************
  ******************************************************************************
  */

  canActivate(
    _next: ActivatedRouteSnapshot,
    _state: RouterStateSnapshot): Observable<boolean> | Promise<boolean> | boolean
    {
      //debugger
      if (this.Auth.isLoggedIn)
      {
          return true
      }
      //return this.Auth.isLoggedIn;
      return this.consultService.isLoggedIn()
      .pipe(map(res =>
      {
        if (res.status)
        {
          this.Auth.setLoggedIn(true);
          return true;
        }
        else
        {
          this.rout.navigate(['login']);
          return false;
        }
      }));
    }
}
