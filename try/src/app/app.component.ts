import { Component, OnInit } from '@angular/core';
import { EmpService } from './emp.service';
import { Employee } from './employee';
import {ActivatedRoute, Params, Router} from '@angular/router';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'app works!';
  showCat:any; 
  categories:any;
  constructor(
    private _empService:EmpService,
    private router: Router
   ) {
     this.showCat = false;
    }
   ngOnInit() { 
    this.getCategory();
   }
   
  getCategory(){
     this._empService
        .getCategory()
        .subscribe(categories => {
          this.categories =  categories;  
      } )
  }
  changeShowStatus(){   
    this.showCat = !this.showCat;
  } 
}
