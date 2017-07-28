import { Injectable } from '@angular/core';
import { Http, Response, Headers, RequestOptions } from '@angular/http';
import {BrowserModule } from '@angular/platform-browser';
import { HttpClient,HttpHeaders,HTTP_PROVIDERS  } from 'http-client';
import 'rxjs/add/operator/map';
import { Observable } from 'rxjs/Observable';
import { HttpModule } from '@angular/http';
import { HttpService } from './http.service';
import { NavbarComponent } from './ems/navbar/navbar.component';
@Injectable()
export class EmpService {
  employees=[];
  videos=[];
  checkMe:any;
 headers:any;
  constructor(private _http:Http) { 
 
  }
  getEmployees(){
    return this._http.get("http://localhost/angular/angular2-api/select.php/")
      .map(res=>{
        this.checkMe = res; 
        if(this.checkMe._body !== "0"){
           return res.json()
        }
       
      });
  }
  getVideos(){
    return this._http.get("http://localhost/web/v1/loadvideos/all")
      .map(res=>{
        this.checkMe = res;
        if(this.checkMe._body !== "0"){
           return res.json()
        } 
      });
  }
  getMyVideos(){
    return this._http.get("http://localhost/web/v1/myvideos/1")
      .map(res=>{
        this.checkMe = res;
        if(this.checkMe._body !== "0"){
           return res.json()
        } 
    });
  }
  getMyFaveriteVideos(){
    return this._http.get("http://localhost/web/v1/favorites/1")
      .map(res=>{
        this.checkMe = res;
        if(this.checkMe._body !== "0"){
           return res.json()
        } 
    });
  }
    getLoadVideos(id){ 
    return this._http.get("http://localhost/web/v1/loadvideos/"+id)
      .map(res=>{
        this.checkMe = res;
        if(this.checkMe._body !== "0"){
           return res.json()
        } 
    });
  }
  getCategory(){
    return this._http.get("http://localhost/web/v1/getcategory")
      .map(res=>{
        this.checkMe = res;
        if(this.checkMe._body !== "0"){
           return res.json()
        } 
    });
  }
 
  liked(vid){
	var headers = new Headers();
	headers.append('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
    vid.owner=5;
    vid.Authorization= localStorage.getItem('Authorization');
    return this._http.post("http://localhost/web/v1/liked", this.serialize(vid), {headers: headers})
      .map(()=>""); 
  }
 
  submitUploads1(uploads){  
    console.log("setHeaders started"); 
          var headers = new Headers();
            headers.append('Content-Type', 'application/json');
            headers.set('Authorization', 'bearer ' + '3d2d73252a546471c67243a97458371b');
            let obs = new Observable(observer => {
                this._http.post("http://localhost/web/v1/createvideo/",this.serialize(uploads), {headers: headers}).subscribe(
                    (response: Response) => {
                        observer.next(response);
                        observer.complete();
                    },
                    error=> {
                        observer.error(error);
                    });
            });
            return obs;
  }
   submitUploads(uploads): Observable<NavbarComponent> {
    var headers = new Headers( );
	  headers.append('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
    uploads.owner=5;
    uploads.Authorization= localStorage.getItem('Authorization');
    return this._http.post("http://localhost/web/v1/createvideo",this.serialize(uploads), {headers: headers} )
      .map(res=>{
             this.checkMe = res;
             if(this.checkMe._body !== "0"){
                 return res.json()
          } 
      });
  }
   
  submitRegister(register){ 
    var headers = new Headers();
	  headers.append('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
    return this._http.post("http://localhost/web/v1/createuser",this.serialize(register), {headers: headers} )
      .map(res=>{
            this.checkMe = res;
             if(this.checkMe._body !== "0"){
                 return res.json()
          } 
      });
  }
   submitLogin(login){ 
    var headers = new Headers();
	headers.append('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
    return this._http.post("http://localhost/web/v1/userlogin",this.serialize(login), {headers: headers} )
       .map(res=>{
          this.checkMe = res;
             if(this.checkMe._body !== "0"){
                 return res.json();
          } 
      });
  }
  
  addEmployee(info){
    return this._http.post("http://localhost/angular/angular2-api/insert.php",info)
      .map(()=>"");
  }
  getEmployee(id){
    return this._http.post("http://localhost/angular/angular2-api/selectone.php/",{'id':id})
      .map(res=>res.json());
  }
  deleteEmployee(id){
    return this._http.post("http://localhost/angular/angular2-api/delete.php/",{'id':id})
      .map(()=>this.getEmployees());
  }
  updateEmployee(info){
    return this._http.post("http://localhost/angular/angular2-api/update.php/", info)
      .map(()=>"");
  }
  private serialize(obj) {
	  var str = [];
	  for(var p in obj)
	    if (obj.hasOwnProperty(p)) {
	      str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
	    }
	  return str.join("&");
 }

}
 
