import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Routes, RouterModule } from '@angular/router';
import { HomeComponent } from './home/home.component';
 import { ContactComponent }  from './contactus/contact.component';
 import { AboutComponent }  from './about/about.component';
import { GalleryComponent }  from './gallery/gallery.component';
import { ServiceComponent }  from './service/service.component';
const routes: Routes = [
  {path:"", redirectTo:"/home", pathMatch:"full"},
  {path:"home", component:HomeComponent},
   {path:"contactus", component:ContactComponent},
     {path:"about", component:AboutComponent},
       {path:"gallery", component:GalleryComponent},
         {path:"services", component:ServiceComponent}
   
];
@NgModule({
  imports: [
    CommonModule,
    RouterModule.forRoot(routes) 
  ],
  exports: [RouterModule],
  declarations: []
})
export class AppRoutingModule { }
