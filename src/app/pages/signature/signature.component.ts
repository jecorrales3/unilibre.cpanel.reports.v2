/*
******************************************************************************
******************************************************************************
                              ANGULAR IMPORT
******************************************************************************
******************************************************************************
*/
import { Component, OnInit, OnDestroy,
         ViewChild, ChangeDetectorRef }       from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ToastrService }                      from 'ngx-toastr';
import { Observable }                         from 'rxjs';
import { MatTableDataSource, MatPaginator }   from '@angular/material';
import { HttpClient }                         from '@angular/common/http';

/*
******************************************************************************
******************************************************************************
                              ANGULAR SERVICES
******************************************************************************
******************************************************************************
*/
import { SettingsService }      from './../../services/settings.service';
import { GlobalQueriesService } from './../../services/global-queries.service';

/*
******************************************************************************
******************************************************************************
                              ANGULAR INTERFACE
******************************************************************************
******************************************************************************
*/
import { Global }      from './../../interfaces/global';


@Component({
  selector: 'app-signature',
  templateUrl: './signature.component.html',
  styleUrls: ['./signature.component.scss']
})
export class SignatureComponent  implements OnInit, OnDestroy
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
  private api_production = 'backend/production/file/';

  //Boolean variables view
  listForm:boolean = true;
  //Class Bootstrap = Active.
  listClass:string;
  //Button form
  button_form:boolean = false;
  //loading effect
  loading:boolean = true;

  //List of services (aux)
  list_members_aux: any;
  //List of services
  list_members: any;

  //Detail data
  detail_member_id:number;
  detail_member_name:string;
  detail_member_lastname:string;
  detail_member_signature:string;
  detail_member_document:string;
  detail_member_faculty:number;
  detail_member_type:number;

  //Message
  messageFilterResult:boolean  = false;
  messageListMembers:boolean   = false;

  //Signature image
  files:any;
  signature_image:File = null;
  state_image:boolean  = false;

  //Paginator
  @ViewChild(MatPaginator) paginator: MatPaginator;
  obs: Observable<any>;
  dataSource: any;


  /*
  ******************************************************************************
  ******************************************************************************
                               CLASS CONSTRUCTOR
  ******************************************************************************
  ******************************************************************************
  */
  constructor(private http: HttpClient,
  			      private _settingsService:SettingsService,
              public  _globalService:GlobalQueriesService,
              private toastr: ToastrService,
              private changeDetectorRef: ChangeDetectorRef)
  {
    //Get the members list
    _settingsService.getMemberSignature()
    .subscribe(Members => {
      const ELEMENT_DATA = Members;
      //Get the elements
      this.list_members_aux = new MatTableDataSource(ELEMENT_DATA);
      this.list_members_aux.paginator = this.paginator;
      this.list_members = this.list_members_aux.connect();
      this.getMemberSignature();
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
    //Class Bootstrap = Active.
    this.listClass = 'active';

    this.changeDetectorRef.detectChanges();

    //Label elements
    this.paginator._intl.itemsPerPageLabel = 'Ítems por página:';
    this.paginator._intl.firstPageLabel    = 'Primer página ';
    this.paginator._intl.previousPageLabel = 'Anterior';
    this.paginator._intl.nextPageLabel     = 'Siguiente';
    this.paginator._intl.lastPageLabel     = 'Última página';
  };

  ngOnDestroy()
  {
    if (this.list_members_aux)
    {
      this.list_members_aux.disconnect();
    }
  };


  /*
  ******************************************************************************
  ******************************************************************************
                               COMPONENT FUNCTIONS
  ******************************************************************************
  ******************************************************************************
  */
  listSection()
  {
    //Variable form
    this.listForm      = true;
    //Class Bootstrap = Active.
    this.listClass     = 'active';
  };

  /*
  ******************************************************************************
  ******************************************************************************
  ******************************    SEARCH DATA   ******************************
  ******************************************************************************
  ******************************************************************************
  */

  applyFilter(filterValue: string)
  {
    this.list_members_aux.filter = filterValue.trim().toLowerCase();

    if (this.list_members_aux.filteredData.length == 0)
    {
      this.messageFilterResult = true;
      this.messageListMembers  = false;
    }
    else
    {
      this.messageFilterResult = false;
    }
  };


  /*
  ******************************************************************************
  ******************************************************************************
                              METHODS FROM SERVICE RESULT
  ******************************************************************************
  ******************************************************************************
  */
  getMemberSignature()
  {
    //Loading effect
    this.loading = false;
    //Length data
    if (this.list_members_aux.filteredData.length > 0)
    {
      this.messageListMembers = false;
    }
    else
    {
      this.messageListMembers = true;
    }
  };

  /*
  ******************************************************************************
  ******************************************************************************
                              LOAD DETAIL (MODAL WINDOW)
  ******************************************************************************
  ******************************************************************************
  */
  loadDetail(member: { id_integrante: number; nombre_integrante: string; apellido_integrante: string; imagen_firma_integrante: string; })
  {
    this.detail_member_id        = member.id_integrante;
    this.detail_member_name      = member.nombre_integrante;
    this.detail_member_lastname  = member.apellido_integrante;
    this.detail_member_signature = member.imagen_firma_integrante;
  };

  /*
  ******************************************************************************
  ******************************************************************************
                      UPLOAD SIGNATURE IMAGE (MODAL WINDOW)
  ******************************************************************************
  ******************************************************************************
  */
  uploadSignatureImage(event: { target: { files: File[]; }; })
  {
    //Get data from image
    this.signature_image = <File>event.target.files[0];

    if (this.signature_image.type == 'image/jpeg' ||
        this.signature_image.type == 'image/jpg'  ||
        this.signature_image.type == 'image/png')
    {
      if (this.signature_image.size <= 2000000)
      {
        const formData  = new FormData();
        const member_id = this.detail_member_id;

        formData.append('file', this.signature_image);
          //Metodo POST
          this.http.post<Global>(this.api_localhost + 'uploadSignatureImage.php' + '?member_id=' + member_id, formData)
          .subscribe(data=>
          {
            if (data.message == "El servidor ha procesado la firma digital del integrante.")
            {
              //Show the result of the action
              this.toastr.success(data.message, "OK", {
                timeOut: 2000,
                positionClass: 'toast-bottom-center'
              });

              //Refresh the page
              location.reload();
            }
            else
            {
              //Show the result of the action
              this.toastr.error(data.message, "ERROR", {
                timeOut: 2000,
                positionClass: 'toast-bottom-center'
              });
            }
          });
      }
      else
      {
        //Show the result of the action
        this.toastr.success("Tamaño de la imagen supera el límite establecido.", "OK", {
          timeOut: 2000,
          positionClass: 'toast-bottom-center'
        });
      }
    }
  };


}
