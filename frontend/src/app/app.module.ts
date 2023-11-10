import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations'
import { MatButtonModule } from '@angular/material/button';
import { MatTableModule } from '@angular/material/table';
import { MatFormFieldModule } from '@angular/material/form-field';
import { ReactiveFormsModule, FormsModule } from '@angular/forms';
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';
import { MatIconModule } from '@angular/material/icon';
import { MatMenuModule } from '@angular/material/menu';
import { IonicModule } from '@ionic/angular';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { ApiService } from './service/api.service';
import { BodyComponent } from './components/body/body.component';
import { SidenavComponent } from './components/sidenav/sidenav.component';
import { ProductComponent } from './components/product/product.component';
import { HomeComponent } from './components/home/home.component';
import { ToolbarComponent } from './components/toolbar/toolbar.component';
import { RegisterComponent } from './components/account/register/register.component';
import { LoginComponent } from './components/account/login/login.component';
import { ProfileComponent } from './components/account/profile/profile.component';
import { TokenInterceptor } from './components/account/clients/token.interceptor';

@NgModule({
  declarations: [
    AppComponent,
    BodyComponent,
    SidenavComponent,
    ProductComponent,
    HomeComponent,
    ToolbarComponent,
    RegisterComponent,
    LoginComponent,
    ProfileComponent,
  ],
  imports: [
    BrowserModule,
    BrowserAnimationsModule,
    AppRoutingModule,
    MatButtonModule,
    MatTableModule,
    MatFormFieldModule,
    ReactiveFormsModule,
    HttpClientModule,
    FormsModule,
    MatIconModule,
    MatMenuModule,
    IonicModule
  ],
  providers: [
    ApiService,
    {
      provide: HTTP_INTERCEPTORS,
      useClass: TokenInterceptor,
      multi: true
    }
  ],
  bootstrap: [
    AppComponent,
  ]
})
export class AppModule { }
