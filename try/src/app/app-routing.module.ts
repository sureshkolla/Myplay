import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Routes, RouterModule } from '@angular/router';
import { HomeComponent } from './ems/home/home.component';
import { AddComponent } from './ems/add/add.component';
import { EditComponent } from './ems/edit/edit.component';
import { ShowComponent } from './ems/show/show.component';
import { MyVideosComponent } from './ems/myvideos/myvideos.component';
import { AddoneComponent } from './ems/addone/addone.component';
import { FavoritesComponent } from './favorites/favorites.component';
import { LoadvideosComponent } from './ems/loadvideos/loadvideos.component';

const routes: Routes = [
  {path:"", redirectTo:"/home", pathMatch:"full"},
  {path:"home", component:HomeComponent},
  {path:"add", component:AddComponent},
  {path:"edit/:id", component:EditComponent},
  {path:"show/:id", component:ShowComponent},
  {path:"myvideos/:id", component: MyVideosComponent},
  {path:"addone", component: AddoneComponent},
  {path:"myfavorites/:id", component:FavoritesComponent},
  {path:"loadvideos/:id", component:LoadvideosComponent}
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
