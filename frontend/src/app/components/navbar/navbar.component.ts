import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { Router, RouterLink } from '@angular/router';

@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [CommonModule, RouterLink],
  templateUrl: './navbar.component.html',
  styleUrl: './navbar.component.css'
})

export class NavbarComponent {
  constructor(private router: Router){}
  onLogout() {
    fetch('http://localhost:8000/backend/logout.php', {
      method: 'POST',
      credentials: 'include'
    }).then(() => {
      this.router.navigate(['/login']);
    });
  }
}
