/*
******************************************************************************
******************************************************************************
                              ANGULAR IMPORT
******************************************************************************
******************************************************************************
*/
import { Component, OnInit } from '@angular/core';

/*
******************************************************************************
******************************************************************************
                              ANGULAR SERVICES
******************************************************************************
******************************************************************************
*/
import { MenuService }        from './../../services/menu.service';
import { ConsultAuthService } from './../../services/consult-auth.service';

@Component({
  selector: 'app-sidebar',
  templateUrl: './sidebar.component.html',
  styleUrls: ['./sidebar.component.scss']
})
export class SidebarComponent implements OnInit
{
  /*
  ******************************************************************************
  ******************************************************************************
                            LIST OF VARIABLES
  ******************************************************************************
  ******************************************************************************
  */
  //Session variables
  username:String = "Loading...";
  usertype:String = "Loading...";
  //List array
  menu:any = [];
  //Loading data
  loading:boolean = true;


  /*
  ******************************************************************************
  ******************************************************************************
                               CLASS CONSTRUCTOR
  ******************************************************************************
  ******************************************************************************
  */
  constructor(public  _menuService:MenuService,
              private _serviceConsultAuth:ConsultAuthService)
  {
    //Method for authentication service
    this._serviceConsultAuth.getService()
    .subscribe(data => {
      this.username = data.username;

      //Service return data
      setTimeout(() => {
          //Loading data
          this.loading = false;
          //Service return data
          if (data.type == 1)
          {
            this.usertype = 'Administrador';
            this.menu = _menuService.getMenuListAdministrator();
          }
          else
          {
            this.usertype = 'Generador';
            this.menu = _menuService.getMenuListGenerator();
          }
      }, 1000);

      //Verify session status
      if (!data.status)
      {
        alert("Session was closed!");
        localStorage.removeItem('loggedIn');
      }
    });
  };

  /*
  ******************************************************************************
  ******************************************************************************
                              ANGULAR NGONINIT
  ******************************************************************************
  ******************************************************************************
  */
  ngOnInit()
  {

  };

}
