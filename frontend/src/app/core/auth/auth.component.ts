import { HttpClient } from "@angular/common/http";
import { environment } from "src/environments/environment";
import { Injectable } from "@angular/core";
import { Observable } from "rxjs";

@Injectable({
    providedIn: 'root',
})

export class Auth {
    apiUrl = environment.ApiUrl;

    constructor(private http: HttpClient) { }

    public login(username: string, password: string): Observable<string> {
        return this.http.post(this.apiUrl + '/user/login',
            {
                username: username,
                password: password,
            },
            { responseType: 'text' }
        );
    }

    public register(username: string, email: string, password: string, phone: number): Observable<string> {
        return this.http.post(this.apiUrl + '/user/register', 
        {
            username: username,
            email: email,
            password: password,
            phone: phone,
        },
        { responseType: 'text' }
        );
    }
}