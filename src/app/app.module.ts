//Angular import
import { BrowserModule }                    from '@angular/platform-browser';
import { NgModule }                         from '@angular/core';
import { CommonModule }                     from '@angular/common';
import { HttpClientModule }                 from '@angular/common/http';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
//Importacion de pipes
import { TruncatePipe }                     from './pipes/truncate.pipe';
import { NgxCurrencyModule }                from "ngx-currency";
//Bootstrap design
import { BrowserAnimationsModule }          from '@angular/platform-browser/animations';
import { CollapseModule }                   from 'ngx-bootstrap/collapse';
import { ToastrModule }                     from 'ngx-toastr';
//Routing
import { AppRoutingModule }                 from './app-routing.module';
import { HashLocationStrategy,
         LocationStrategy }                 from '@angular/common';
//Angular material
import { MaterialModule }                   from './material.module';
//Angular components
import { AppComponent }                     from './app.component';
import { NavbarComponent }                  from './components/navbar/navbar.component';
import { SidebarComponent }                 from './components/sidebar/sidebar.component';
import { FooterComponent }                  from './components/footer/footer.component';
//Elements design
import { TablesComponent }                  from './pages/tables/tables.component';
import { FormsComponent }                   from './pages/forms/forms.component';
import { TypographyComponent }              from './pages/typography/typography.component';
import { MapsComponent }                    from './pages/maps/maps.component';
import { NotificationsComponent }           from './pages/notifications/notifications.component';
//Angular pages
import { DashboardComponent }               from './pages/dashboard/dashboard.component';
import { LoginComponent }                   from './pages/login/login.component';
import { RecoverPasswordComponent }         from './pages/recover-password/recover-password.component';
import { LogoutComponent }                  from './pages/logout/logout.component';
import { ErrorComponent }                   from './pages/error/error.component';
import { AdministratorComponent }           from './pages/administrator/administrator.component';
import { ProfileComponent }                 from './pages/profile/profile.component';
import { ReportsComponent }                 from './pages/reports/reports.component';
import { FacultiesComponent }               from './pages/faculties/faculties.component';
import { MembersComponent }                 from './pages/members/members.component';
import { UsersComponent }                   from './pages/users/users.component';
import { ProgramsComponent }                from './pages/programs/programs.component';
import { GeneratorComponent }               from './pages/generator/generator.component';
import { StudentsComponent }                from './pages/students/students.component';
import { HistoryReportsComponent }          from './pages/history-reports/history-reports.component';
import { ConsecutiveComponent }             from './pages/consecutive/consecutive.component';
//Certificates list
import { C1Component }                      from './pages/certificate/c1/c1.component';
import { C2Component }                      from './pages/certificate/c2/c2.component';
import { C3Component }                      from './pages/certificate/c3/c3.component';
import { C4Component }                      from './pages/certificate/c4/c4.component';
import { C5Component }                      from './pages/certificate/c5/c5.component';
import { C6Component }                      from './pages/certificate/c6/c6.component';

@NgModule({
  declarations: [
    //Components
    AppComponent,
    NavbarComponent,
    SidebarComponent,
    FooterComponent,
    //Angular form
    FormsComponent,
    //Elements for design
    TablesComponent,
    FormsComponent,
    TypographyComponent,
    MapsComponent,
    NotificationsComponent,
    //Declaracion de Pipes
    TruncatePipe,
    //Pages
    DashboardComponent,
    LoginComponent,
    RecoverPasswordComponent,
    LogoutComponent,
    ErrorComponent,
    AdministratorComponent,
    ProfileComponent,
    ReportsComponent,
    FacultiesComponent,
    MembersComponent,
    UsersComponent,
    ProgramsComponent,
    GeneratorComponent,
    StudentsComponent,
    HistoryReportsComponent,
    //Certificates list
    C1Component,
    C2Component,
    C3Component,
    C4Component,
    C5Component,
    C6Component,
    ConsecutiveComponent
  ],
  imports: [
    //Angular
    BrowserModule,
    AppRoutingModule,
    CommonModule,
    //Angular material
    BrowserAnimationsModule,
    MaterialModule,
    CollapseModule.forRoot(),
    ToastrModule.forRoot(),
    //Reactive forms
    FormsModule,
    ReactiveFormsModule,
    //Request HTTP
    HttpClientModule,
    NgxCurrencyModule,
    ],
  providers:
  [
    {
      provide: LocationStrategy,
      useClass: HashLocationStrategy
    }
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
