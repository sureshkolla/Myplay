import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { LoadvideosComponent } from './loadvideos.component';

describe('LoadvideosComponent', () => {
  let component: LoadvideosComponent;
  let fixture: ComponentFixture<LoadvideosComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ LoadvideosComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(LoadvideosComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
