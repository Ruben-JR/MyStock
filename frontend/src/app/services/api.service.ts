import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Product } from './interfaces';
import { Observable, throwError } from 'rxjs';
import { retry, catchError } from 'rxjs/operators';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class ApiService {
  apiUrl = environment.ApiUrl;

  constructor(private http: HttpClient) { }

  httpOptions = {
    headers: new HttpHeaders({
      'content-type': 'application/json',
    }),
  };

  getProducts(): Observable<Product> {
    return this.http
      .get<Product>(this.apiUrl + '/get-products')
      .pipe(retry(1), catchError(this.handleError));
  }

  getProductsId(id: any):Observable<Product> {
    return this.http
      .get<Product>(this.apiUrl + '/get-products-id/' + id)
      .pipe(retry(1), catchError(this.handleError));
  }

  createProduct(product: any): Observable<Product> {
    return this.http
      .post<Product>(this.apiUrl + '/create-products', JSON.stringify(product), this.httpOptions)
      .pipe(retry(1), catchError(this.handleError));
  }

  updateProduct(id: any, product: any): Observable<Product> {
    return this.http
      .put<Product>(this.apiUrl + '/update-products/' + id, JSON.stringify(product), this.httpOptions)
      .pipe(retry(1), catchError(this.handleError));
  }

  deleteProduct(id: any) {
    return this.http
      .delete<Product>(this.apiUrl + '/delete-products/' + id, this.httpOptions)
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
