import { Component, OnInit } from '@angular/core';
import { EmpService } from '../../emp.service';
import { Employee } from '../../employee';
import {ActivatedRoute, Params, Router} from '@angular/router';
@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
  name:string;
  employees:any;
  videos:any;
  constructor(
    private _empService:EmpService,
    private router: Router
   ){}

  ngOnInit() {
    this.getEmployees();
    this.getVideos();
  }

  getEmployees(){
     this._empService
        .getEmployees()
        .subscribe(employees => {
          this.employees = employees;
      } )
  }
  getVideos(){
     this._empService
        .getVideos()
        .subscribe(videos => {
          this.videos =  videos;
        console.log(JSON.stringify(videos));
          console.log(videos);
      } )
  }
  deleteEmployee(id){
      this._empService
        .deleteEmployee(id)
        .subscribe(() => {
        this.getEmployees();
      } )
  }
 
}
