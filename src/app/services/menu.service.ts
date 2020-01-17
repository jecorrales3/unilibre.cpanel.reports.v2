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
export class MenuService
{
  /*
  ******************************************************************************
  ******************************************************************************
                            LIST OF VARIABLES
  ******************************************************************************
  ******************************************************************************
  */
  menu_list_administrator =
  [
    //DASHBOARD
    {
      header_list: 'Tablero',
      body_list:
      [
        {
          name:  'Dashboard',
          icon:  'far fa-chart-bar',
          route: 'dashboard',
        }
      ]
    },
    //CONTROL PANEL
    {
      header_list: 'Control',
      body_list:
      [
        {
          name:  'Reporte',
          icon:  'far fa-file-pdf',
          route: 'reports',
        },
        {
          name:  'Historial',
          icon:  'fas fa-history',
          route: 'history-reports',
        }
      ]
    },
    //UNIVERSITY
    {
      header_list: 'Universidad',
      body_list:
      [
        {
          name:  'Facultades',
          icon:  'fas fa-university',
          route: 'faculties',
        },
        {
          name:  'Programas',
          icon:  'fas fa-file-signature',
          route: 'programs',
        },
        {
          name:  'Estudiantes',
          icon:  'fas fa-user-graduate',
          route: 'students',
        },
        {
          name:  'Integrantes',
          icon:  'fas fa-chalkboard-teacher',
          route: 'members',
        }
      ]
    },
    //SETTINGS
    {
      header_list: 'Configuración',
      body_list:
      [
        {
          name:  'Perfil',
          icon:  'fas fa-user-alt',
          route: 'profile',
        },
        {
          name:  'Usuarios',
          icon:  'fas fa-user-cog',
          route: 'users',
        }
      ]
    },
  ];

  menu_list_generator =
  [
    //DASHBOARD
    {
      header_list: 'Tablero',
      body_list:
      [
        {
          name:  'Dashboard',
          icon:  'far fa-chart-bar',
          route: 'dashboard',
        }
      ]
    },
    //CONTROL PANEL
    {
      header_list: 'Control',
      body_list:
      [
        {
          name:  'Reporte',
          icon:  'far fa-file-pdf',
          route: 'reports',
        },
        {
          name:  'Historial',
          icon:  'fas fa-history',
          route: 'history-reports',
        }
      ]
    },
    //UNIVERSITY
    {
      header_list: 'Universidad',
      body_list:
      [
        {
          name:  'Estudiantes',
          icon:  'fas fa-user-graduate',
          route: 'students',
        },
        {
          name:  'Integrantes',
          icon:  'fas fa-chalkboard-teacher',
          route: 'members',
        }
      ]
    },
    //SETTINGS
    {
      header_list: 'Configuración',
      body_list:
      [
        {
          name:  'Perfil',
          icon:  'fas fa-user-alt',
          route: 'profile',
        }
      ]
    },
  ];

  //Menu reports list
  menu_reports =
  [
    {
      name: 'Acta de Sustentación',
      icon: 'fas fa-hands-helping',
      route: '../certificate/c1',
    },
    {
      name: 'Homologación Auxiliar',
      icon: 'fas fa-user-edit',
      route: '../certificate/c2',
    },
    {
      name: 'Acta de Aprobación',
      icon: 'fas fa-clipboard-check',
      route: '../certificate/c3',
    },
    {
      name: 'Paz y Salvo',
      icon: 'fas fa-file-signature',
      route: '../certificate/c4',
    },
    {
      name: 'Acta de Inicio',
      icon: 'fas fa-file-alt',
      route: '../certificate/c5',
    },
  ];
  /*
  ******************************************************************************
  ******************************************************************************
                               CLASS CONSTRUCTOR
  ******************************************************************************
  ******************************************************************************
  */
  constructor()
  {

  };


  /*
  ******************************************************************************
  ******************************************************************************
                         FUNCTIONS SERVICE (MENU)
  ******************************************************************************
  ******************************************************************************
  */
  getMenuListAdministrator()
  {
    return this.menu_list_administrator;
  };

  getMenuListGenerator()
  {
    return this.menu_list_generator;
  };

  getMenuListReports()
  {
    return this.menu_reports;
  };


}