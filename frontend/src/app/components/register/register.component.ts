import { Component } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { FormsModule } from '@angular/forms';
import { NgIf } from '@angular/common';

@Component({
  selector: 'app-register',
  standalone: true,
  imports: [FormsModule, NgIf],
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css']
})

export class RegisterComponent {
  username: string = '';
  password: string = '';
  message: string = '';

  constructor(private http: HttpClient) {}

  onRegister() {
    const data = { username: this.username, password: this.password };

    this.http.post('http://localhost:8000/backend/register.php', data).subscribe({
      next: (res: any) => {
        this.message = res.message || 'registration successful';
      },
      error: (err) => {
        this.message = err.error?.error || 'registration failed';
      }
    });
  }
}
