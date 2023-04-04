import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Product } from './interfaces';
import { Observable, throwError } from 'rxjs';
import { retry, catchError } from 'rxjs/operators';
import { environment } from '../../environments/environment';
import { AuthenticationClient } from '../components/account/clients/authentication.client';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class ApiService {
  apiUrl = environment.ApiUrl;
  private tokenKey = 'token';

  constructor(private http: HttpClient, private authClient: AuthenticationClient, private router: Router) { }

  httpOptions = {
    headers: new HttpHeaders({
      'content-type': 'application/json',
    }),
  };

  public login(username: string, password: string): void {
    this.authClient.login(username, password).subscribe((token) => {
      localStorage.setItem(this.tokenKey, token);
      this.router.navigate(['/']);
    });
  }

  public register(username: string, email: string, password: string, phone: number): void {
    this.authClient.register(username, email, password, phone).subscribe((token) => {
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

  getProducts(): Observable<Product> {
    return this.http
      .get<Product>(this.apiUrl + '/product')
      .pipe(retry(1), catchError(this.handleError));
  }

  getProductsId(id: any):Observable<Product> {
    return this.http
      .get<Product>(this.apiUrl + '/productId' + id)
      .pipe(retry(1), catchError(this.handleError));
  }

  createProduct(product: any): Observable<Product> {
    return this.http
      .post<Product>(this.apiUrl + '/createProduct', JSON.stringify(product), this.httpOptions)
      .pipe(retry(1), catchError(this.handleError));
  }

  updateProduct(id: any, product: any): Observable<Product> {
    return this.http
      .put<Product>(this.apiUrl + '/updateProduct' + id, JSON.stringify(product), this.httpOptions)
      .pipe(retry(1), catchError(this.handleError));
  }

  deleteProduct(id: any) {
    return this.http
      .delete<Product>(this.apiUrl + '/deleteProduct' + id, this.httpOptions)
      .pipe(retry(1), catchError(this.handleError));
  }

  handleError(error: any) {
    let errorMessage = '';
    if (error.error instanceof ErrorEvent) {
      // Get client-side error
      errorMessage = error.error.message;
    } else {
      // Get server-side error
      errorMessage = `Error Code: ${error.status}\nMessage: ${error.message}`;
    }
    window.alert(errorMessage);
    return throwError(() => {
      return errorMessage;
    });
  }
}
