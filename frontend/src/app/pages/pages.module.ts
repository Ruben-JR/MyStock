import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { ReactiveFormsModule, FormsModule } from '@angular/forms';

import { MatIconModule } from '@angular/material/icon';
import { AppRoutingModule } from 'src/app/app-routing.module';

import { HomeComponent } from 'src/app/pages/home/home.component';
import { LoginComponent } from 'src/app/pages/account/login/login.component';
import { RegisterComponent } from 'src/app/pages/account/register/register.component';
import { ProductComponent } from 'src/app/pages/product/product.component';
import { ProfileComponent } from 'src/app/pages/account/profile/profile.component';

import { ApiService } from 'src/app/services/api.service';

@NgModule({
  declarations: [
    HomeComponent,
    LoginComponent,
    RegisterComponent,
    ProfileComponent,
    ProductComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    FormsModule,
    MatIconModule,
    ReactiveFormsModule,
  ],
  providers: [
    ApiService,
  ],
})
export class PagesModule { }
