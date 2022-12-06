import { Component } from '@angular/core';

interface SideNavToggle {
  screenWidth: number;
  collapsed: boolean;
}

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {

  isSideNavCollapsed = false;
  screenwidth = 0;

  onToggleSideNav(data: SideNavToggle): void {
    this.screenwidth = data.screenWidth;
    this.isSideNavCollapsed = data.collapsed
  }
}
