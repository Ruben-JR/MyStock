import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AuthGuard } from './components/account/clients/auth.guard';
import { LoginComponent } from './components/account/login/login.component';
import { RegisterComponent } from './components/account/register/register.component';
import { HomeComponent } from './components/home/home.component';
import { ProductComponent } from './components/product/product.component';

const routes: Routes = [
  { path: '', redirectTo: '/home', pathMatch: 'full',  },
  { path: 'home', component: HomeComponent, canActivate: [AuthGuard] },
  { path: 'product', component: ProductComponent, canActivate: [AuthGuard] },
  { path: 'register', component: RegisterComponent },
  { path: 'login', component: LoginComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
