import { NgModule }          from '@angular/core';

import { MatStepperModule,
         MatDividerModule,
         MatTooltipModule,
         MatPaginatorModule,
         MatMenuModule,
         MatDatepickerModule,
         MatNativeDateModule,
         MatFormFieldModule,
         MatExpansionModule,
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
    MatExpansionModule,
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
    MatExpansionModule,
  ]
})

export class MaterialModule {}
