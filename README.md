# Interview Garuda Cyber

E-Learning menggunakan Laravel 12 dengan auth berbasis Sanctum


## Basic

- PHP 8.2
- Laravel 12
- Laravel Sanctum
- MySQL

## Role

- Mahasiswa: lihat mata kuliah, enroll kelas, upload jawaban tugas, diskusi forum.
- Dosen: kelola mata kuliah, upload materi, buat tugas, beri nilai, lihat laporan.

## Setup

1. Install dependency:

```bash
composer install
```

2. Salin file environment:

```bash
cp .env.example .env
```

3. Generate app key:

```bash
php artisan key:generate
```

4. Atur koneksi database pada `.env`.

5. Jalankan migrasi:

```bash
php artisan migrate
```

6. Buat symbolic link storage untuk file materi/submission:

```bash
php artisan storage:link
```

7. Jalankan server:

```bash
php artisan serve
```

URL: `http://127.0.0.1:8000`

## Frontend (Livewire)

The application includes a full Livewire-powered web interface.

### Accessing the Frontend

1. Start the server: `php artisan serve`
2. Visit: `http://127.0.0.1:8000`
3. Login or register to access the dashboard

### Features

**Dosen (Lecturer) can:**
- Create and manage courses
- Upload learning materials (PDF)
- Create assignments with deadlines
- Grade student submissions
- View reports and statistics
- Participate in course discussions

**Mahasiswa (Student) can:**
- Browse and enroll in courses
- Download course materials
- Submit assignments
- View grades and feedback
- Participate in course discussions

### Test Accounts

After seeding, you can login with:
- Dosen: budi.santoso@example.com / password
- Dosen: ani.wijaya@example.com / password
- Mahasiswa: rudi.hartono@example.com / password
- Mahasiswa: siti.nurhaliza@example.com / password
- Mahasiswa: ahmad.dahlan@example.com / password

## Autentikasi API

- Login/registrasi akan mengembalikan token Sanctum.
- Endpoint yang membutuhkan login harus memakai header:

```http
Authorization: Bearer {token}
Accept: application/json
```

## Ringkasan Endpoint API

endpoint prefix `/api`.

### Auth

- `POST /register` - Registrasi user.
- `POST /login` - Login + token.
- `POST /logout` - Logout + revoke token.

### Courses

- `GET /courses` - List semua mata kuliah.
- `POST /courses` - Tambah mata kuliah.
- `PUT /courses/{id}` - Update mata kuliah.
- `DELETE /courses/{id}` - Hapus mata kuliah.
- `POST /courses/{id}/enroll` - Enroll ke mata kuliah.

### Materials

- `POST /materials` - Upload materi.
- `GET /materials/{id}/download` - Download.

### Assignments dan Submissions

- `POST /assignments` - tugas.
- `POST /submissions` - Upload jawaban tugas.
- `POST /submissions/{id}/grade` - Beri nilai.

### Discussions

- `POST /discussions` - Membikin diskusi.
- `POST /discussions/{id}/replies` - Balas diskusi.

### Reports

- `GET /reports/courses` - Statistik jumlah mahasiswa per mata kuliah.
- `GET /reports/assignments` - Statistik tugas sudah/belum dinilai.
- `GET /reports/students/{id}` - Statistik tugas dan nilai mahasiswa.
