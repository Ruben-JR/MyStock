import { Component } from '@angular/core';
import { ApiService } from 'src/app/service/api.service';
import { WeatherClient } from '../account/clients/weather.client';
import { Observable } from 'rxjs';

@Component({
  selector: 'app-toolbar',
  templateUrl: './toolbar.component.html',
  styleUrls: ['./toolbar.component.scss']
})
export class ToolbarComponent {
  public weather: Observable<any> = this.weatherClient.getWeatcherData();
  constructor(private api: ApiService, private weatherClient: WeatherClient) {}

  logout(): void {
    this.api.logout();
  }
}
