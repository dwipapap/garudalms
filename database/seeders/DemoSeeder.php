<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Discussion;
use App\Models\Material;
use App\Models\Reply;
use App\Models\Submission;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Dosen (Lecturers)
        $budiSantoso = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@example.com',
            'password' => Hash::make('password'),
            'role' => 'dosen',
        ]);

        $aniWijaya = User::create([
            'name' => 'Ani Wijaya',
            'email' => 'ani.wijaya@example.com',
            'password' => Hash::make('password'),
            'role' => 'dosen',
        ]);

        // Create Mahasiswa (Students)
        $rudiHartono = User::create([
            'name' => 'Rudi Hartono',
            'email' => 'rudi.hartono@example.com',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
        ]);

        $sitiNurhaliza = User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti.nurhaliza@example.com',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
        ]);

        $ahmadDahlan = User::create([
            'name' => 'Ahmad Dahlan',
            'email' => 'ahmad.dahlan@example.com',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
        ]);

        // Create Courses
        $pemrogramanWeb = Course::create([
            'name' => 'Pemrograman Web',
            'description' => 'Mata kuliah tentang pengembangan aplikasi web modern menggunakan Laravel, Vue.js, dan teknologi terkini dalam web development.',
            'lecturer_id' => $budiSantoso->id,
        ]);

        $basisData = Course::create([
            'name' => 'Basis Data',
            'description' => 'Mata kuliah tentang desain dan implementasi basis data relasional, SQL, normalisasi, dan optimasi query dalam MySQL dan PostgreSQL.',
            'lecturer_id' => $aniWijaya->id,
        ]);

        $jaringanKomputer = Course::create([
            'name' => 'Jaringan Komputer',
            'description' => 'Mata kuliah tentang konsep jaringan komputer, protokol TCP/IP, routing, switching, dan keamanan jaringan.',
            'lecturer_id' => $budiSantoso->id,
        ]);

        // Enroll Students to Courses
        // Rudi: Pemrograman Web, Basis Data
        $pemrogramanWeb->students()->attach($rudiHartono->id);
        $basisData->students()->attach($rudiHartono->id);

        // Siti: All courses
        $pemrogramanWeb->students()->attach($sitiNurhaliza->id);
        $basisData->students()->attach($sitiNurhaliza->id);
        $jaringanKomputer->students()->attach($sitiNurhaliza->id);

        // Ahmad: Jaringan Komputer
        $jaringanKomputer->students()->attach($ahmadDahlan->id);

        // Create Materials for each course (2 per course)
        Material::create([
            'course_id' => $pemrogramanWeb->id,
            'title' => 'Modul 1 - Pengenalan Laravel Framework',
            'file_path' => 'materials/pemrograman-web/modul1-laravel.pdf',
        ]);

        Material::create([
            'course_id' => $pemrogramanWeb->id,
            'title' => 'Modul 2 - Dasar-dasar Routing dan Controller',
            'file_path' => 'materials/pemrograman-web/modul2-routing-controller.pdf',
        ]);

        Material::create([
            'course_id' => $basisData->id,
            'title' => 'Modul 1 - Pengenalan Sistem Basis Data',
            'file_path' => 'materials/basis-data/modul1-pengenalan.pdf',
        ]);

        Material::create([
            'course_id' => $basisData->id,
            'title' => 'Modul 2 - Normalisasi dan Desain Tabel',
            'file_path' => 'materials/basis-data/modul2-normalisasi.pdf',
        ]);

        Material::create([
            'course_id' => $jaringanKomputer->id,
            'title' => 'Modul 1 - Arsitektur Jaringan TCP/IP',
            'file_path' => 'materials/jaringan-komputer/modul1-tcp-ip.pdf',
        ]);

        Material::create([
            'course_id' => $jaringanKomputer->id,
            'title' => 'Modul 2 - Routing dan Switching',
            'file_path' => 'materials/jaringan-komputer/modul2-routing-switching.pdf',
        ]);

        // Create Assignments for each course (2 per course)
        $assign1PemWeb = Assignment::create([
            'course_id' => $pemrogramanWeb->id,
            'title' => 'Tugas 1 - Membuat Project Laravel Pertama',
            'description' => 'Buat project Laravel dasar dengan fitur CRUD untuk data mahasiswa. Sertakan validasi input dan pesan error yang user-friendly.',
            'deadline' => Carbon::now()->addDays(14),
        ]);

        $assign2PemWeb = Assignment::create([
            'course_id' => $pemrogramanWeb->id,
            'title' => 'Tugas 2 - Implementasi Relasi Database',
            'description' => 'Implementasikan relasi one-to-many dan many-to-many dalam project Laravel. Gunakan Eloquent ORM dan eager loading untuk optimasi query.',
            'deadline' => Carbon::now()->addDays(21),
        ]);

        $assign1BD = Assignment::create([
            'course_id' => $basisData->id,
            'title' => 'Tugas 1 - Design ER Diagram',
            'description' => 'Buat Entity-Relationship Diagram untuk sistem e-learning sederhana dengan minimal 5 entitas. Tunjukkan atribut dan relasi dengan jelas.',
            'deadline' => Carbon::now()->addDays(10),
        ]);

        $assign2BD = Assignment::create([
            'course_id' => $basisData->id,
            'title' => 'Tugas 2 - Query dan Optimasi SQL',
            'description' => 'Tulis SQL queries kompleks termasuk JOIN, GROUP BY, dan aggregate functions. Berikan penjelasan tentang query optimization techniques.',
            'deadline' => Carbon::now()->addDays(17),
        ]);

        $assign1JK = Assignment::create([
            'course_id' => $jaringanKomputer->id,
            'title' => 'Tugas 1 - Subnetting dan IP Addressing',
            'description' => 'Lakukan perhitungan subnetting untuk Class B network. Tentukan network address, broadcast address, dan host range untuk 5 subnet berbeda.',
            'deadline' => Carbon::now()->addDays(12),
        ]);

        $assign2JK = Assignment::create([
            'course_id' => $jaringanKomputer->id,
            'title' => 'Tugas 2 - Konfigurasi Router Dasar',
            'description' => 'Konfigurasi router menggunakan Cisco IOS. Setup IP address, static routing, dan verifikasi konektivitas antar subnet.',
            'deadline' => Carbon::now()->addDays(19),
        ]);

        // Create Submissions
        // Rudi submissions for Pemrograman Web assignments
        Submission::create([
            'assignment_id' => $assign1PemWeb->id,
            'student_id' => $rudiHartono->id,
            'file_path' => 'submissions/rudi-hartono/pemweb-tugas1.zip',
            'score' => 85,
        ]);

        Submission::create([
            'assignment_id' => $assign2PemWeb->id,
            'student_id' => $rudiHartono->id,
            'file_path' => 'submissions/rudi-hartono/pemweb-tugas2.zip',
            'score' => null, // Not graded yet
        ]);

        // Rudi submissions for Basis Data assignments
        Submission::create([
            'assignment_id' => $assign1BD->id,
            'student_id' => $rudiHartono->id,
            'file_path' => 'submissions/rudi-hartono/bd-tugas1.pdf',
            'score' => 90,
        ]);

        Submission::create([
            'assignment_id' => $assign2BD->id,
            'student_id' => $rudiHartono->id,
            'file_path' => 'submissions/rudi-hartono/bd-tugas2.sql',
            'score' => null, // Not graded yet
        ]);

        // Siti submissions for Pemrograman Web assignments
        Submission::create([
            'assignment_id' => $assign1PemWeb->id,
            'student_id' => $sitiNurhaliza->id,
            'file_path' => 'submissions/siti-nurhaliza/pemweb-tugas1.zip',
            'score' => 92,
        ]);

        Submission::create([
            'assignment_id' => $assign2PemWeb->id,
            'student_id' => $sitiNurhaliza->id,
            'file_path' => 'submissions/siti-nurhaliza/pemweb-tugas2.zip',
            'score' => 88,
        ]);

        // Siti submissions for Basis Data assignments
        Submission::create([
            'assignment_id' => $assign1BD->id,
            'student_id' => $sitiNurhaliza->id,
            'file_path' => 'submissions/siti-nurhaliza/bd-tugas1.pdf',
            'score' => 88,
        ]);

        Submission::create([
            'assignment_id' => $assign2BD->id,
            'student_id' => $sitiNurhaliza->id,
            'file_path' => 'submissions/siti-nurhaliza/bd-tugas2.sql',
            'score' => null, // Not graded yet
        ]);

        // Siti submissions for Jaringan Komputer assignments
        Submission::create([
            'assignment_id' => $assign1JK->id,
            'student_id' => $sitiNurhaliza->id,
            'file_path' => 'submissions/siti-nurhaliza/jk-tugas1.pdf',
            'score' => 95,
        ]);

        Submission::create([
            'assignment_id' => $assign2JK->id,
            'student_id' => $sitiNurhaliza->id,
            'file_path' => 'submissions/siti-nurhaliza/jk-tugas2.txt',
            'score' => null, // Not graded yet
        ]);

        // Ahmad submissions for Jaringan Komputer assignments
        Submission::create([
            'assignment_id' => $assign1JK->id,
            'student_id' => $ahmadDahlan->id,
            'file_path' => 'submissions/ahmad-dahlan/jk-tugas1.pdf',
            'score' => 80,
        ]);

        Submission::create([
            'assignment_id' => $assign2JK->id,
            'student_id' => $ahmadDahlan->id,
            'file_path' => 'submissions/ahmad-dahlan/jk-tugas2.txt',
            'score' => null, // Not graded yet
        ]);

        // Create Discussions (2 per course)
        $disc1PemWeb = Discussion::create([
            'course_id' => $pemrogramanWeb->id,
            'user_id' => $budiSantoso->id,
            'content' => 'Diskusi: Bagaimana cara memilih antara monolith architecture vs microservices architecture untuk aplikasi web modern?',
        ]);

        $disc2PemWeb = Discussion::create([
            'course_id' => $pemrogramanWeb->id,
            'user_id' => $rudiHartono->id,
            'content' => 'Pertanyaan: Apa perbedaan antara Session-based authentication dan Token-based (JWT) authentication? Kapan sebaiknya menggunakan yang mana?',
        ]);

        $disc1BD = Discussion::create([
            'course_id' => $basisData->id,
            'user_id' => $aniWijaya->id,
            'content' => 'Diskusi: Penjelasan tentang ACID properties dalam basis data dan pentingnya transaction dalam menjaga data consistency.',
        ]);

        $disc2BD = Discussion::create([
            'course_id' => $basisData->id,
            'user_id' => $sitiNurhaliza->id,
            'content' => 'Pertanyaan: Bagaimana cara mengoptimasi query yang lambat? Apa saja indexing strategies yang bisa digunakan?',
        ]);

        $disc1JK = Discussion::create([
            'course_id' => $jaringanKomputer->id,
            'user_id' => $budiSantoso->id,
            'content' => 'Diskusi: Perbedaan antara IPv4 dan IPv6, serta strategi migrasi dari IPv4 ke IPv6 di jaringan enterprise.',
        ]);

        $disc2JK = Discussion::create([
            'course_id' => $jaringanKomputer->id,
            'user_id' => $ahmadDahlan->id,
            'content' => 'Pertanyaan: Bagaimana cara meningkatkan keamanan jaringan? Apa saja best practices untuk network security di era cloud computing?',
        ]);

        // Create Replies for discussions (2-3 replies per discussion)
        Reply::create([
            'discussion_id' => $disc1PemWeb->id,
            'user_id' => $rudiHartono->id,
            'content' => 'Saya pikir monolith architecture lebih cocok untuk startup karena lebih mudah di-deploy. Microservices lebih kompleks dan memerlukan infrastructure yang lebih sophisticated.',
        ]);

        Reply::create([
            'discussion_id' => $disc1PemWeb->id,
            'user_id' => $sitiNurhaliza->id,
            'content' => 'Setuju dengan Rudi, tapi seiring aplikasi berkembang, microservices menjadi lebih maintainable karena separation of concerns yang lebih jelas.',
        ]);

        Reply::create([
            'discussion_id' => $disc1PemWeb->id,
            'user_id' => $budiSantoso->id,
            'content' => 'Kedua perspektif benar. Pilihannya tergantung pada skala, tim, dan requirements project. Jangan over-engineer dari awal.',
        ]);

        Reply::create([
            'discussion_id' => $disc2PemWeb->id,
            'user_id' => $sitiNurhaliza->id,
            'content' => 'Session-based lebih tradisional dan sederhana implementasinya. JWT lebih cocok untuk API dan microservices karena stateless.',
        ]);

        Reply::create([
            'discussion_id' => $disc2PemWeb->id,
            'user_id' => $budiSantoso->id,
            'content' => 'Poin bagus Siti. JWT juga lebih scalable karena tidak perlu shared session storage di server.',
        ]);

        Reply::create([
            'discussion_id' => $disc1BD->id,
            'user_id' => $rudiHartono->id,
            'content' => 'ACID yang dimaksud adalah Atomicity, Consistency, Isolation, dan Durability ya? Ini sangat penting untuk database integrity.',
        ]);

        Reply::create([
            'discussion_id' => $disc1BD->id,
            'user_id' => $sitiNurhaliza->id,
            'content' => 'Benar. Terutama Consistency dan Durability sangat krusial dalam aplikasi financial atau e-commerce.',
        ]);

        Reply::create([
            'discussion_id' => $disc1BD->id,
            'user_id' => $aniWijaya->id,
            'content' => 'Tepat sekali. ACID memastikan bahwa setiap transaksi database berjalan dengan aman dan handal.',
        ]);

        Reply::create([
            'discussion_id' => $disc2BD->id,
            'user_id' => $rudiHartono->id,
            'content' => 'Biasanya kita bisa menggunakan EXPLAIN ANALYZE untuk melihat query execution plan. Dari sana kita bisa tahu ada index yang hilang atau query yang tidak efisien.',
        ]);

        Reply::create([
            'discussion_id' => $disc2BD->id,
            'user_id' => $aniWijaya->id,
            'content' => 'Bagus Rudi. Jangan lupa juga tentang column selectivity dan covering indexes. Index pada column yang paling sering di-filter biasanya lebih effective.',
        ]);

        Reply::create([
            'discussion_id' => $disc1JK->id,
            'user_id' => $sitiNurhaliza->id,
            'content' => 'IPv6 memiliki address space yang jauh lebih besar dibanding IPv4. Tapi adoption-nya masih lambat di beberapa organisasi.',
        ]);

        Reply::create([
            'discussion_id' => $disc1JK->id,
            'user_id' => $ahmadDahlan->id,
            'content' => 'Migrasi ke IPv6 memang tidak mudah karena masih banyak devices dan services yang hanya support IPv4.',
        ]);

        Reply::create([
            'discussion_id' => $disc2JK->id,
            'user_id' => $budiSantoso->id,
            'content' => 'Network security bukan hanya tentang firewall. Segmentation, encryption, authentication, dan monitoring juga penting.',
        ]);

        Reply::create([
            'discussion_id' => $disc2JK->id,
            'user_id' => $sitiNurhaliza->id,
            'content' => 'Setuju. Apalagi dengan cloud computing, concept seperti network isolation dan VPC menjadi lebih penting.',
        ]);
    }
}
