import { environment } from "src/environments/environment";
import { Observable } from "rxjs";
import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";

@Injectable({
    providedIn: 'root',
})

export class WeatherClient {
    constructor(private http: HttpClient) { }

    getWeatcherData(): Observable<any> {
        return this.http.get(environment.ApiUrl + '/WeatherForecast');
    }
}
