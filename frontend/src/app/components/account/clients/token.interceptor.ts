import { ApiService } from "src/app/service/api.service";
import { HttpEvent, HttpHandler, HttpInterceptor, HttpRequest } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { Observable } from "rxjs";

@Injectable()
export class TokenInterceptor implements HttpInterceptor {
    constructor(public authService: ApiService) {}
    intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
        if(this.authService.isLoggedIn()) {
            let newRequest = req.clone({
                setHeaders: {
                    authorization: `Bearer ${this.authService.getToken()}`,
                }
            });
            return next.handle(newRequest);
        }
        return next.handle(req);
    }
}