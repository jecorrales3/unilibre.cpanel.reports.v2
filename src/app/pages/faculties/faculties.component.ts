/*
******************************************************************************
******************************************************************************
                              ANGULAR IMPORT
******************************************************************************
******************************************************************************
*/
import {
  Component,
  OnInit,
  OnDestroy,
  ViewChild,
  ChangeDetectorRef,
  TemplateRef,
} from "@angular/core";
import { FormBuilder, FormGroup, Validators } from "@angular/forms";
import { ToastrService } from "ngx-toastr";
import { Observable } from "rxjs";
import { MatTableDataSource, MatPaginator } from "@angular/material";
import { BsModalService, BsModalRef } from "ngx-bootstrap/modal";

/*
******************************************************************************
******************************************************************************
                              ANGULAR SERVICES
******************************************************************************
******************************************************************************
*/
import { UniversityService } from "./../../services/university.service";
import { GlobalQueriesService } from "./../../services/global-queries.service";

@Component({
  selector: "app-faculties",
  templateUrl: "./faculties.component.html",
  styleUrls: ["./faculties.component.scss"],
})
export class FacultiesComponent implements OnInit, OnDestroy {
  /*
  ******************************************************************************
  ******************************************************************************
                            LIST OF VARIABLES
  ******************************************************************************
  ******************************************************************************
  */
  //ReactiveForm
  faculty_form: FormGroup;
  update_faculty_form: FormGroup;
  submitted_form: boolean = false;
  updated_form: boolean = false;
  //Boolean variables view
  listForm: boolean = true;
  registerForm: boolean = false;
  //Class Bootstrap = Active.
  listClass: string;
  registerClass: string;
  //Button form
  button_form: boolean = false;
  //loading effect
  loading: boolean = true;
  loading_modal: boolean = true;

  //List of services (aux)
  list_faculties_aux: any;
  //List of services
  list_cities: any;
  list_faculties: any;
  list_members = [];

  //Detail data
  detail_faculty_id: number;
  detail_faculty_name: string;
  detail_faculty_acronym: string;
  detail_faculty_city: string;

  //Message
  messageFilterResult: boolean = false;
  messageListFaculties: boolean = false;
  messageListMembers: boolean = false;

  //Paginator
  @ViewChild(MatPaginator) paginator: MatPaginator;
  obs: Observable<any>;
  dataSource: any;

  // Modal settings
  modalRef: BsModalRef;
  config = {
    backdrop: true,
    ignoreBackdropClick: false,
  };

  /*
  ******************************************************************************
  ******************************************************************************
                               CLASS CONSTRUCTOR
  ******************************************************************************
  ******************************************************************************
  */
  constructor(
    private formBuilder: FormBuilder,
    private _universityService: UniversityService,
    public _globalService: GlobalQueriesService,
    private toastr: ToastrService,
    private changeDetectorRef: ChangeDetectorRef,
    private modalService: BsModalService
  ) {
    //Get the cities list
    _globalService.getCities().subscribe((Cities) => {
      this.list_cities = Cities;
    });

    //Get the faculties
    _universityService.getFaculties().subscribe((Faculties) => {
      const ELEMENT_DATA = Faculties;
      //Get the elements
      this.list_faculties_aux = new MatTableDataSource(ELEMENT_DATA);
      this.list_faculties_aux.paginator = this.paginator;
      this.list_faculties = this.list_faculties_aux.connect();

      this.getFaculties();
    });
  }

  /*
  ******************************************************************************
  ******************************************************************************
                              ANGULAR NGONINIT
  ******************************************************************************
  ******************************************************************************
  */
  ngOnInit() {
    //Class Bootstrap = Active.
    this.listClass = "active";

    //Form builder group (Register)
    this.faculty_form = this.formBuilder.group({
      faculty_name: [
        "",
        [
          Validators.required,
          Validators.maxLength(130),
          Validators.pattern("^[A-Za-zñÑáéíóúÁÉÍÓÚ,. ]+$"),
        ],
      ],
      faculty_acronym: [
        "",
        [
          Validators.required,
          Validators.maxLength(10),
          Validators.pattern("^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$"),
        ],
      ],
      faculty_city: ["1", [Validators.required]],
    });

    //Form builder group (Update)
    this.update_faculty_form = this.formBuilder.group({
      faculty_name: [
        "",
        [
          Validators.required,
          Validators.maxLength(130),
          Validators.pattern("^[A-Za-zñÑáéíóúÁÉÍÓÚ,. ]+$"),
        ],
      ],
      faculty_acronym: [
        "",
        [
          Validators.required,
          Validators.maxLength(10),
          Validators.pattern("^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$"),
        ],
      ],
      faculty_city: [{ value: "", disabled: true }],
    });

    this.changeDetectorRef.detectChanges();

    //Label elements
    this.paginator._intl.itemsPerPageLabel = "Ítems por página:";
    this.paginator._intl.firstPageLabel = "Primer página ";
    this.paginator._intl.previousPageLabel = "Anterior";
    this.paginator._intl.nextPageLabel = "Siguiente";
    this.paginator._intl.lastPageLabel = "Última página";
  }

  ngOnDestroy() {
    if (this.list_faculties_aux) {
      this.list_faculties_aux.disconnect();
    }
  }

  /*
  ******************************************************************************
  ******************************************************************************
                               COMPONENT FUNCTIONS
  ******************************************************************************
  ******************************************************************************
  */
  listSection() {
    //Variable form
    this.listForm = true;
    this.registerForm = false;
    //Class Bootstrap = Active.
    this.listClass = "active";
    this.registerClass = "";
  }

  registerSection() {
    //Variable form
    this.listForm = false;
    this.registerForm = true;
    //Class Bootstrap = Active.
    this.listClass = "";
    this.registerClass = "active";
  }

  openDetailModal(detailTemplate: TemplateRef<any>) {
    this.modalRef = this.modalService.show(detailTemplate, this.config);
  }

  openDeleteModal(deleteTemplate: TemplateRef<any>) {
    this.modalRef = this.modalService.show(deleteTemplate, this.config);
  }

  openListModal(listTemplate: TemplateRef<any>) {
    this.modalRef = this.modalService.show(listTemplate, this.config);
  }

  /*
   ******************************************************************************
   ******************************************************************************
   ******************************    SEARCH DATA   ******************************
   ******************************************************************************
   ******************************************************************************
   */

  applyFilter(filterValue: string) {
    this.list_faculties_aux.filter = filterValue.trim().toLowerCase();

    if (this.list_faculties_aux.filteredData.length == 0) {
      this.messageFilterResult = true;
      this.messageListFaculties = false;
    } else {
      this.messageFilterResult = false;
    }
  }

  /*
  ******************************************************************************
  ******************************************************************************
                              METHODS FROM SERVICE RESULT
  ******************************************************************************
  ******************************************************************************
  */
  getFaculties() {
    //Loading effect
    this.loading = false;
    //Length data
    if (this.list_faculties_aux.filteredData.length > 0) {
      this.messageListFaculties = false;
    } else {
      this.messageListFaculties = true;
    }
  }

  /*
  ******************************************************************************
  ******************************************************************************
                              LOAD DETAIL (MODAL WINDOW)
  ******************************************************************************
  ******************************************************************************
  */
  loadDetail(faculty: {
    id_facultad: number;
    nombre_facultad: string;
    siglas_facultad: string;
    id_ciudad: string;
  }) {
    this.detail_faculty_id = faculty.id_facultad;
    this.detail_faculty_name = faculty.nombre_facultad;
    this.detail_faculty_acronym = faculty.siglas_facultad;
    this.detail_faculty_city = faculty.id_ciudad;

    //Set the values
    this.update_faculty_form.setValue({
      faculty_name: this.detail_faculty_name,
      faculty_acronym: this.detail_faculty_acronym,
      faculty_city: this.detail_faculty_city,
    });
  }

  loadDetailMemberList(faculty: { id_facultad: any }) {
    //Loading effect
    this.loading_modal = true;
    //Get the value
    let faculty_id = faculty.id_facultad;
    //Clean array
    this.list_members = [];

    //Get the member list of the faculty
    this._universityService
      .getDetailMemberList(faculty_id)
      .subscribe((Members) => {
        //Loading effect
        this.loading_modal = false;

        if (Members.length > 0) {
          // Store JSON data from the service in 'data' variable.
          let data = Members;

          let groupsMap = new Map();

          // Iterate over the data array.
          data.forEach((element) => {
            const groupName = element.nombre_tipo_integrante;

            delete element.nombre_tipo_integrante;

            let value;

            // If group already exists in the map, get current value.
            if (groupsMap.has(groupName)) {
              value = groupsMap.get(groupName);
            } else {
              value = {
                member_type: groupName,
                member_list: [],
              };
            }

            // Add current element to the group's member_list list.
            value.member_list.push(element);

            // Add updated value to the map.
            groupsMap.set(groupName, value);
          });

          groupsMap.forEach((value, key) => {
            this.list_members.push(value);
          });

          this.messageListMembers = false;
        } else {
          //Show the message
          this.messageListMembers = true;
        }
      });
  }

  /*
  ******************************************************************************
  ******************************************************************************
                              REGISTER FACULTY FORM
  ******************************************************************************
  ******************************************************************************
  */
  get rf() {
    return this.faculty_form.controls;
  }

  registerFaculty() {
    //Disabled form
    this.button_form = true;
    //Submitted
    this.submitted_form = true;
    //Invalid value form
    if (this.faculty_form.invalid) {
      //Disabled form
      this.button_form = false;
      //Finish process
      return;
    }

    //Form values
    const faculty_name = this.faculty_form.get("faculty_name").value;
    const faculty_acronym = this.faculty_form.get("faculty_acronym").value;
    const faculty_city = this.faculty_form.get("faculty_city").value;

    this._universityService
      .registerFaculty(faculty_name, faculty_acronym, faculty_city)
      .subscribe((data) => {
        if (data.message == "Facultad registrada.") {
          //Submitted
          this.submitted_form = false;
          //Show the result of the action
          this.toastr.success(data.message, "OK", {
            timeOut: 2000,
            positionClass: "toast-bottom-center",
          });

          //Set the values to null
          this.faculty_form.setValue({
            faculty_name: null,
            faculty_acronym: null,
            faculty_city: null,
          });

          this.refreshData();
        } else {
          //Show the result of the action
          this.toastr.error(data.message, "ERROR", {
            timeOut: 2000,
            positionClass: "toast-bottom-center",
          });
        }
        //Disabled form
        this.button_form = false;
      });
  }

  /*
  ******************************************************************************
  ******************************************************************************
                              UPDATE MEMBER FORM
  ******************************************************************************
  ******************************************************************************
  */
  get uf() {
    return this.update_faculty_form.controls;
  }

  updateFaculty() {
    //Submitted
    this.updated_form = true;
    //Invalid value form
    if (this.update_faculty_form.invalid) {
      //Finish process
      return;
    }

    //Form values
    const faculty_id = this.detail_faculty_id;
    const faculty_name = this.update_faculty_form.get("faculty_name").value;
    const faculty_acronym = this.update_faculty_form.get("faculty_acronym")
      .value;
    const faculty_city = this.update_faculty_form.get("faculty_city").value;

    this._universityService
      .updateFaculty(faculty_id, faculty_name, faculty_acronym, faculty_city)
      .subscribe((data) => {
        if (data.message == "Facultad actualizada.") {
          //Submitted
          this.updated_form = false;
          //Show the result of the action
          this.toastr.success(data.message, "OK", {
            timeOut: 2000,
            positionClass: "toast-bottom-center",
          });

          this.refreshData();
        } else {
          //Show the result of the action
          this.toastr.error(data.message, "ERROR", {
            timeOut: 2000,
            positionClass: "toast-bottom-center",
          });
        }
      });
  }

  /*
  ******************************************************************************
  ******************************************************************************
                               DELETE FACULTY
  ******************************************************************************
  ******************************************************************************
  */
  deleteFaculty() {
    //Get the id
    const faculty_id = this.detail_faculty_id;

    //Method
    this._universityService.deleteFaculty(faculty_id).subscribe((data) => {
      if (data.message == "Facultad eliminada.") {
        //Show the result of the action
        this.toastr.success(data.message, "OK", {
          timeOut: 2000,
          positionClass: "toast-bottom-center",
        });

        this.refreshData();
      } else {
        //Show the result of the action
        this.toastr.error(data.message, "ERROR", {
          timeOut: 2000,
          positionClass: "toast-bottom-center",
        });
      }
    });
  }

  /*
  ******************************************************************************
  ******************************************************************************
                              REFRESH DATA METHOD
  ******************************************************************************
  ******************************************************************************
  */
  refreshData() {
    //Get the faculties
    this._universityService.getFaculties().subscribe((Faculties) => {
      const ELEMENT_DATA = Faculties;
      //Get the elements
      this.list_faculties_aux = new MatTableDataSource(ELEMENT_DATA);
      this.list_faculties_aux.paginator = this.paginator;
      this.list_faculties = this.list_faculties_aux.connect();
      this.getFaculties();
    });
  }
}
