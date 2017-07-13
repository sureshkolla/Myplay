import { NgModule }      from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { AppRoutingModule } from './app-routing.module';

import { AppComponent }  from './app.component';
import { HeaderComponent }  from './header/header.component';
import { FooterComponent }  from './footer/footer.component';
import { HomeComponent }  from './home/home.component';
import { ContactComponent }  from './contactus/contact.component';
import { AboutComponent }  from './about/about.component';
import { GalleryComponent }  from './gallery/gallery.component';
import { ServiceComponent }  from './service/service.component';
@NgModule({
  imports:      [ BrowserModule,AppRoutingModule ],
  declarations: [ 
  AppComponent,
  HeaderComponent,
  FooterComponent ,
  HomeComponent,
  ContactComponent,
  AboutComponent,
  GalleryComponent,
  ServiceComponent
   ],
  bootstrap:    [ AppComponent ]
})
export class AppModule { }
