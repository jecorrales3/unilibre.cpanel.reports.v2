//Angular import
import { NgModule }                 from '@angular/core';
import { Routes, RouterModule }     from '@angular/router';

//Angular elements
import { DashboardComponent }       from './pages/dashboard/dashboard.component';
import { TablesComponent }          from './pages/tables/tables.component';
import { FormsComponent }           from './pages/forms/forms.component';
import { TypographyComponent }      from './pages/typography/typography.component';
import { MapsComponent }            from './pages/maps/maps.component';
import { NotificationsComponent }   from './pages/notifications/notifications.component';
//Angular pages
import { LoginComponent }           from './pages/login/login.component';
import { RecoverPasswordComponent } from './pages/recover-password/recover-password.component';
import { LogoutComponent }          from './pages/logout/logout.component';
import { ErrorComponent }           from './pages/error/error.component';
import { AdministratorComponent }   from './pages/administrator/administrator.component';
import { ProfileComponent }         from './pages/profile/profile.component';
import { ReportsComponent }         from './pages/reports/reports.component';
import { FacultiesComponent }       from './pages/faculties/faculties.component';
import { MembersComponent }         from './pages/members/members.component';
import { UsersComponent }           from './pages/users/users.component';
import { ProgramsComponent }        from './pages/programs/programs.component';
import { GeneratorComponent }       from './pages/generator/generator.component';
//Certificates list
import { C1Component }              from './pages/certificate/c1/c1.component';
import { C2Component }              from './pages/certificate/c2/c2.component';
import { C3Component }              from './pages/certificate/c3/c3.component';
import { C4Component }              from './pages/certificate/c4/c4.component';
import { C5Component }              from './pages/certificate/c5/c5.component';
import { HistoryReportsComponent }  from './pages/history-reports/history-reports.component';

//Guards
import { AuthenticationGuard }     from './guards/authentication.guard';

const routes: Routes =
[
  {
    path: '',   redirectTo: 'login', pathMatch: 'full'
  },
  {
    path:'login',
    component: LoginComponent
  },
  {
    path:'recover-password',
    component: RecoverPasswordComponent
  },
  {
    path:'administrator',
    component: AdministratorComponent,
    //Guard
    canActivate: [AuthenticationGuard],
    children:[
      //Redirect
      {path: '',   redirectTo: 'dashboard', pathMatch: 'full'},
      //Routes
      {path: 'dashboard',       component: DashboardComponent},
      {path: 'profile',         component: ProfileComponent},
      {path: 'reports',         component: ReportsComponent},
      {path: 'faculties',       component: FacultiesComponent},
      {path: 'members',         component: MembersComponent},
      {path: 'programs',        component: ProgramsComponent},
      {path: 'users',           component: UsersComponent},
      {path: 'history-reports', component: HistoryReportsComponent},
      //Certificate list
      {path: 'certificate/c1',  component: C1Component},
      {path: 'certificate/c2',  component: C2Component},
      {path: 'certificate/c3',  component: C3Component},
      {path: 'certificate/c4',  component: C4Component},
      {path: 'certificate/c5',  component: C5Component},
      /*
      {path: 'settings',        component: SettingsComponent},
      {path: 'students',        component: StudentsComponent},*/
      {path: 'logout',          component: LogoutComponent},
      //Elements design
      {path: 'forms',           component: FormsComponent},
      {path: 'tables',          component: TablesComponent},
      {path: 'typography',      component: TypographyComponent},
      {path: 'maps',            component: MapsComponent},
      {path: 'notifications',   component: NotificationsComponent}
    ]
  },
  {
    path:'generator',
    component: GeneratorComponent,
    //Guard
    canActivate: [AuthenticationGuard],
    children:[
      //Redirect
      {path: '',   redirectTo: 'dashboard', pathMatch: 'full'},
      //Routes
      {path: 'dashboard',       component: DashboardComponent},
      {path: 'profile',         component: ProfileComponent},
      {path: 'reports',         component: ReportsComponent},
      {path: 'members',         component: MembersComponent},
      {path: 'logout',          component: LogoutComponent},
    ]
  },
  { path: 'error', component: ErrorComponent },
  {
    path: '**',
    redirectTo: "/error"
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
