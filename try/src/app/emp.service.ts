import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import 'rxjs/add/operator/map';

@Injectable()
export class EmpService {
  employees=[];
  videos=[];
  checkMe:any;
  constructor(private _http:Http) { }
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
}
