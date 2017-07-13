import { Component, OnInit } from '@angular/core';
import {ActivatedRoute, Params, Router} from '@angular/router';
 
@Component({
  selector: 'contact',
  templateUrl: './service.component.html',
  styleUrls: ['./service.component.css'] 
})
export class ServiceComponent implements OnInit {

   constructor( private router: Router,
    private route: ActivatedRoute) { }

  ngOnInit() {
      
  }
 
}
