import { Component, OnInit } from '@angular/core';
import { EmpService } from '../../emp.service';
import { Employee } from '../../employee';
import {ActivatedRoute, Params, Router} from '@angular/router';
import { LocalStorageService } from 'angular-2-local-storage';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css']
})
export class NavbarComponent implements OnInit { 
  signUpvalue:any; 
  signInvalue:any; 
  uplaodValue:any; 
  status:boolean;
  gender:string;
  
  upload = new Employee();
  register = new Employee();
  login = new Employee();
  aut:any;
  api:any;
  constructor(private empService: EmpService) { 
	this.signUpvalue = false;
	this.signInvalue = false;
	this.uplaodValue = false;
 
   }
  ngOnInit(){}
  
  signUp(){ 	 
    this.signUpvalue= !this.signUpvalue;
  }
   signIn(){    
    this.signInvalue= !this.signInvalue;
  }
   uploadmodal(){   	 
    this.uplaodValue= !this.uplaodValue;
  }
  close(){  
    this.signUpvalue= this.signInvalue=this.uplaodValue= false;
  } 
  submitUploads(){ 
      this.empService
        .submitUploads(this.upload)
        .subscribe(()=>"");
  }  
  submitRegister(){ 
      this.empService
        .submitRegister(this.register)
        .subscribe(()=>"");
  } 
   submitLogin(){ 
        this.empService
        .submitLogin(this.login)
        .subscribe(aut => {
            this.aut =  aut; 
            this.api;
            localStorage.setItem('Authorization',aut.apikey);
         },
          function(error) {
              console.log("Error happened " + error)
          },
          function() {
              console.log("the subscription is completed")
          }
        );
  }       
}
