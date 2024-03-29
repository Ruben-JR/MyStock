import { HttpClient } from "@angular/common/http";
import { environment } from "src/environments/environment";
import { Injectable } from "@angular/core";
import { Observable, concat } from "rxjs";

@Injectable({
    providedIn: 'root',
})

export class Auth {
    apiUrl = environment.ApiUrl;

    constructor(private http: HttpClient) { }

    public login(username: string, password: string): Observable<string> {
        return this.http.post(this.apiUrl + '/login',
        {
            username: username,
            password: password,
        },
        { responseType: 'text' }
        );
    }
    
    public register(firstName: string, lastName: string, email: string, password: string, phone: number): Observable<string> {
        return this.http.post(this.apiUrl + '/register',
            {
                username: firstName + " " + lastName,
                firstName: firstName,
                lastName: lastName,
                email: email,
                password: password,
                phone: phone,
            },
            { responseType: 'text' }
        );
    }

    // public logout(token: string): Observable<string> {
    //     return this.http.post(this.apiUrl + '/logout',
    //          {
    //              token: token,
    //          },
    //          { responseType: 'text' }
    //     );
    // }
}
