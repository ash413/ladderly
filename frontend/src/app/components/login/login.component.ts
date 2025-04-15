import { Component } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { NgIf } from '@angular/common';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [FormsModule, NgIf],
  templateUrl: './login.component.html',
  styleUrl: './login.component.css'
})

export class LoginComponent {
  username: string = '';
  password: string = '';
  message: string = '';

  constructor(private http: HttpClient, private router: Router) {}

  onLogin() {
    const data = { username: this.username, password: this.password };

    this.http.post('http://localhost:8000/backend/login.php', data).subscribe({
      next: (res: any) => {
        if (res.success || res.message){
          this.message="login successful";
          this.router.navigate(['/dashboard'])
        }
        else {
          this.message = res.error || "invalid credentials";
        }
      },
      error: (err) => {
        this.message = err.error?.error ||  "login failed";
      }
    });
  }
}
