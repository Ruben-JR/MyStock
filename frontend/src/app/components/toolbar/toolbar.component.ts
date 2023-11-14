import { Component } from '@angular/core';
import { AuthService } from 'src/app/core/services/auth.service';
import { WeatherClient } from 'src/app/core/auth/weather.client';
import { Observable } from 'rxjs';

@Component({
  selector: 'app-toolbar',
  templateUrl: './toolbar.component.html',
  styleUrls: ['./toolbar.component.scss']
})
export class ToolbarComponent {
  public weather: Observable<any> = this.weatherClient.getWeatcherData();
  constructor(private authService: AuthService, private weatherClient: WeatherClient) {}

  logout(): void {
    this.authService.logout();
  }
}
