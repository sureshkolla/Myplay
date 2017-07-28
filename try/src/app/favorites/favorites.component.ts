import { Component, OnInit } from '@angular/core';
import { EmpService } from '../emp.service';
import { Employee } from '../employee';
import {ActivatedRoute, Params, Router} from '@angular/router';
@Component({
  selector: 'app-favorites',
   templateUrl: '../ems/home/home.component.html',
  styleUrls: ['./favorites.component.css']
})
export class FavoritesComponent implements OnInit {

  videos:any;
  videosTitle:string;
  constructor(
    private _empService:EmpService,
    private router: Router
   ) {
    this.videosTitle='My favorite Videos';
    }
  employees:any;
   ngOnInit() { 
    this.getMyFaveriteVideos();
  }
    
  getMyFaveriteVideos(){
     this._empService
        .getMyFaveriteVideos()
        .subscribe(videos => {
          this.videos =  videos; 
          console.log(videos);
      } )
  }
}

 
