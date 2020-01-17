import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { HistoryReportsComponent } from './history-reports.component';

describe('HistoryReportsComponent', () => {
  let component: HistoryReportsComponent;
  let fixture: ComponentFixture<HistoryReportsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ HistoryReportsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(HistoryReportsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
