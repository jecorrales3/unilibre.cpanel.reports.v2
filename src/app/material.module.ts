import { NgModule }          from '@angular/core';

import { MatStepperModule,
         MatDividerModule,
         MatTooltipModule,
         MatPaginatorModule,
         MatMenuModule,
       } from '@angular/material';

@NgModule({
  imports:[
    MatStepperModule,
    MatDividerModule,
    MatTooltipModule,
    MatPaginatorModule,
    MatMenuModule,
  ],
  exports:[
    MatStepperModule,
    MatDividerModule,
    MatTooltipModule,
    MatPaginatorModule,
    MatMenuModule,
  ]
})

export class MaterialModule {}
