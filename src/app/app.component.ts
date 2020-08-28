import { Component, Renderer2, AfterViewInit } from "@angular/core";
import { AppService } from "./services/app.service";

@Component({
  selector: "app-root",
  templateUrl: "./app.component.html",
  styleUrls: ["./app.component.scss"],
})
export class AppComponent implements AfterViewInit {
  title = "pro-dashboard-angular";

  constructor(private appService: AppService, private renderer: Renderer2) {}

  getClasses() {
    const classes = {
      "pinned-sidebar": this.appService.getSidebarStat().isSidebarPinned,
      "toggeled-sidebar": this.appService.getSidebarStat().isSidebarToggeled,
    };
    return classes;
  }

  toggleSidebar() {
    this.appService.toggleSidebar();
  }

  ngAfterViewInit() {
    let loader = this.renderer.selectRootElement("#loader");
    this.renderer.setStyle(loader, "display", "none");
  }
}
