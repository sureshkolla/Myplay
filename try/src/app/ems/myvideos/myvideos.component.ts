import { Component, OnInit } from '@angular/core';
import { EmpService } from '../../emp.service';
import { Employee } from '../../employee';
import {ActivatedRoute, Params, Router} from '@angular/router';
@Component({
  selector: 'app-home',
  templateUrl: './myvideos.component.html',
  styleUrls: ['./myvideos.component.css']
})
export class MyVideosComponent implements OnInit {
 
  videos:any;
  constructor(
    private _empService:EmpService,
    private router: Router
   ) { }
  employees:any;
   ngOnInit() { 
    this.getMyVideos();
  }
   
  getMyVideos(){
     this._empService
        .getMyVideos()
        .subscribe(videos => {
          this.videos =  videos; 
          console.log(videos);
      } )
  }
  

}
