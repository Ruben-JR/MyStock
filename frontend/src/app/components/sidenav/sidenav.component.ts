import { animate, keyframes, style, transition, trigger } from '@angular/animations';
import { Component, OnInit, Output, EventEmitter, HostListener } from '@angular/core';
import { navbarData } from './nav-data';

interface SideNavToggle {
  screnWidth: number;
  collapsed: boolean;
}

@Component({
  selector: 'app-sidenav',
  templateUrl: './sidenav.component.html',
  styleUrls: ['./sidenav.component.css'],
  animations: [
    trigger('fadeInOut', [
      transition(':enter', [
        style({opacity: 0}),
        animate('350ms',
          style({opacity: 1})
        )
      ]),
      transition(':leave', [
        style({opacity: 1}),
        animate('350ms',
          style({opacity: 0})
        )
      ])
    ]),
    trigger('rotate', [
      transition(':enter', [
        animate('1000ms',
          keyframes([
            style({transfom: 'rotate(0deg', offset : '0'}),
            style({transform: 'rotate(2trun', offset: '1'}),
          ])
        )
      ])
    ])
  ]
})

export class SidenavComponent implements OnInit {
  @Output() onTogglesideNav: EventEmitter<SideNavToggle> = new EventEmitter();
  collapsed = false;
  screnWidth = 0;
  navData = navbarData;

  constructor() { }

  ngOnInit(): void {
  }

  @HostListener('window:resize', ['$event'])
  onResize(event: any){
    this.screnWidth = window.innerWidth;
    if(this.screnWidth <= 768){
      this.collapsed = false;
      this.onTogglesideNav.emit({collapsed: this.collapsed, screnWidth: this.screnWidth});
    }
  }

  toogleCollapsed(): void {
    this.collapsed = !this.collapsed;
    this.onTogglesideNav.emit({collapsed: this.collapsed, screnWidth: this.screnWidth});
  }

  closeSideNav(): void {
    this.collapsed = false;
    this.onTogglesideNav.emit({collapsed: this.collapsed, screnWidth: this.screnWidth});
  }
}
