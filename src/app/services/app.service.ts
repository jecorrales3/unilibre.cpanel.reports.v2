/*
******************************************************************************
******************************************************************************
                              ANGULAR IMPORT
******************************************************************************
******************************************************************************
*/
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class AppService
{
  /*
  ******************************************************************************
  ******************************************************************************
                            LIST OF VARIABLES
  ******************************************************************************
  ******************************************************************************
  */
  isSidebarPinned:boolean   = false;
  isSidebarToggeled:boolean = false;

  /*
  ******************************************************************************
  ******************************************************************************
                                 CLASS CONSTRUCTOR
  ******************************************************************************
  ******************************************************************************
  */
  constructor()
  {

  }

  /*
  ******************************************************************************
  ******************************************************************************
                                FUNCTIONS SERVICE
  ******************************************************************************
  ******************************************************************************
  */
  toggleSidebar()
  {
    this.isSidebarToggeled = ! this.isSidebarToggeled;
  }

  toggleSidebarPin()
  {
    this.isSidebarPinned = ! this.isSidebarPinned;
  }

  getSidebarStat()
  {
    return {
      isSidebarPinned: this.isSidebarPinned,
      isSidebarToggeled: this.isSidebarToggeled
    }
  }

}
