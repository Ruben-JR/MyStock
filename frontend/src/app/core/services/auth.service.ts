import { Injectable } from '@angular/core';
import { Auth } from 'src/app/core/auth/auth.component';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private tokenKey = 'token';

  constructor(private authentication: Auth, private router: Router) { }

  public login(email: string, password: string): void {
    this.authentication.login(email, password).subscribe((token) => {
      localStorage.setItem(this.tokenKey, token);
      this.router.navigate(['/']);
    });
  }

  public register(firstName: string, lastName: string, email: string, password: string, phone: number): void {
    this.authentication.register(firstName, lastName, email, password, phone).subscribe((token) => {
      localStorage.setItem(this.tokenKey, token);
      this.router.navigate(['/login']);
    });
  }

  public logout(): void {
    // this.authentication.logout(this.tokenKey).subscribe(() => {
        localStorage.removeItem(this.tokenKey);
        this.router.navigate(['/login']);
    // });
  }

  public isLoggedIn(): boolean {
    let token = localStorage.getItem(this.tokenKey);
    return token != null && token.length > 0;
  }

  public getToken(): string | null {
    return this.isLoggedIn() ? localStorage.getItem(this.tokenKey) : null;
  }
}
