import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';
import { Auth } from 'src/app/core/auth/auth.component';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  apiUrl = environment.ApiUrl;
  private tokenKey = 'token';

  constructor(private authentication: Auth, private router: Router) { }

  public login(username: string, password: string): void {
    this.authentication.login(username, password).subscribe((token) => {
      localStorage.setItem(this.tokenKey, token);
      this.router.navigate(['/']);
    });
  }

  public register(username: string, email: string, password: string, phone: number): void {
    this.authentication.register(username, email, password, phone).subscribe((token) => {
      localStorage.setItem(this.tokenKey, token);
      this.router.navigate(['/']);
    });
  }

  public logout() {
    localStorage.removeItem(this.tokenKey);
    this.router.navigate(['/login']);
  }

  public isLoggedIn(): boolean {
    let token = localStorage.getItem(this.tokenKey);
    return token != null && token.length > 0;
  }

  public getToken(): string | null {
    return this.isLoggedIn() ? localStorage.getItem(this.tokenKey) : null;
  }
}
