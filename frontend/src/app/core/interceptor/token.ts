import { Observable } from "rxjs";
import { Injectable } from "@angular/core";
import { AuthService } from "src/app/core/services/auth.service";
import { HttpEvent, HttpHandler, HttpInterceptor, HttpRequest } from "@angular/common/http";

@Injectable()
export class TokenInterceptor implements HttpInterceptor {
    constructor(public authService: AuthService) {}
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
