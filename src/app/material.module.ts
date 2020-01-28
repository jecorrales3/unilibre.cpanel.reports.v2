import { NgModule }          from '@angular/core';

import { MatStepperModule,
         MatDividerModule,
         MatTooltipModule,
         MatPaginatorModule,
         MatMenuModule,
         MatDatepickerModule,
         MatNativeDateModule,
         MatFormFieldModule,
       } from '@angular/material';

@NgModule({
  imports:[
    MatStepperModule,
    MatDividerModule,
    MatTooltipModule,
    MatPaginatorModule,
    MatMenuModule,
    MatDatepickerModule,
    MatNativeDateModule,
    MatFormFieldModule,
  ],
  exports:[
    MatStepperModule,
    MatDividerModule,
    MatTooltipModule,
    MatPaginatorModule,
    MatMenuModule,
    MatDatepickerModule,
    MatNativeDateModule,
    MatFormFieldModule,
  ]
})

export class MaterialModule {}
