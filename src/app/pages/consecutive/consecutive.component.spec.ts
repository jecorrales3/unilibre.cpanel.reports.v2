import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ConsecutiveComponent } from './consecutive.component';

describe('ConsecutiveComponent', () => {
  let component: ConsecutiveComponent;
  let fixture: ComponentFixture<ConsecutiveComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ConsecutiveComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ConsecutiveComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
