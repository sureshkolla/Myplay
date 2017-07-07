import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';
import { AppRoutingModule } from './app-routing.module';

import { AppComponent } from './app.component';
import { NavbarComponent } from './ems/navbar/navbar.component';
import { HomeComponent } from './ems/home/home.component';
import { AddComponent } from './ems/add/add.component';
import { EditComponent } from './ems/edit/edit.component';
import { ShowComponent } from './ems/show/show.component';
import { MyVideosComponent } from './ems/myvideos/myvideos.component';
import { FootersComponent } from './ems/footer/footer.component';
import { EmpService } from './emp.service';
import { AddoneComponent } from './ems/addone/addone.component';
import { FavoritesComponent } from './favorites/favorites.component';
import { LoadvideosComponent } from './ems/loadvideos/loadvideos.component';

@NgModule({
  declarations: [
    AppComponent,
    NavbarComponent,
    HomeComponent,
    AddComponent,
    EditComponent,
    ShowComponent,
    MyVideosComponent,
    FootersComponent,
    AddoneComponent,
    FavoritesComponent,
    LoadvideosComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpModule,
    AppRoutingModule
  ],
  providers: [EmpService],
  bootstrap: [AppComponent]
})
export class AppModule { }
