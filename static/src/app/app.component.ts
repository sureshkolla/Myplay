import { Component } from '@angular/core';
import {ActivatedRoute, Params, Router} from '@angular/router';
@Component({
  selector: 'my-app',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css',
  '../../assets/css/icons.css',
  '../../assets/css/responsive.css',
  '../../assets/css/skinblue.css',
  '../../assets/css/slider.css',
  '../../assets/css/style.css'
  ]
})
export class AppComponent  { name = 'Angular';

 constructor(
     
    private router: Router
   ) {
     this.showCat = false;
    }

 }
