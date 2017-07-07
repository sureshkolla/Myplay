import { Component, OnInit } from '@angular/core';
import { EmpService } from '../../emp.service';
import { Employee } from '../../employee';
import {ActivatedRoute, Params, Router} from '@angular/router';

@Component({
  selector: 'app-loadvideos',
  templateUrl: './loadvideos.component.html',
  styleUrls: ['./loadvideos.component.css']
})
export class LoadvideosComponent implements OnInit {
  videos:any;
  videosTitle:string;
  id: number;
  private sub: any;
  
  constructor(
  private _empService:EmpService,
  private router: Router,
  private route: ActivatedRoute
   ) {
   		 this.videosTitle='My favorite Videos';
    }
   ngOnInit() { 
    this.sub = this.route.params.subscribe(params => {
       this.id = +params['id'];
      
    });
     this.getLoadVideos();   
  }
  
 
  //id = this.route.snapshot.params['id'];
  getLoadVideos(){
     this._empService
        .getLoadVideos(this.id)
        .subscribe(videos => {
          this.videos =  videos; 
          console.log(videos);
      } )
  }

}
