import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css']
})
export class NavbarComponent implements OnInit {
 
  signUpvalue:any; 
  signInvalue:any; 
  uplaodValue:any; 
  constructor() { 
	this.signUpvalue = false;
	this.signInvalue = false;
	this.uplaodValue = false;
   }

  ngOnInit() {
  }
 
  signUp(){ 	 
    this.signUpvalue= !this.signUpvalue;
  }
   signIn(){    
    this.signInvalue= !this.signInvalue;
  }
   upload(){   	 
    this.uplaodValue= !this.uplaodValue;
  }
  close(){  
    this.signUpvalue= this.signInvalue=this.uplaodValue= false;
  } 
}
