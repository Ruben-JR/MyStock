import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AuthGuard } from 'src/app/core/guards/auth.guard';
import { LoginComponent } from 'src/app/pages/account/login/login.component';
import { RegisterComponent } from 'src/app/pages/account/register/register.component';
import { HomeComponent } from 'src/app/pages/home/home.component';
import { ProductComponent } from 'src/app/pages/product/product.component';

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
