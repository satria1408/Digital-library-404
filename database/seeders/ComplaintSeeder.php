<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ComplaintSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('complaints')->insert([
            [
                'ticket_code' => 'PGD-2026-0001',
                'user_id' => 1,
                // DISESUAIKAN: Mengubah 'kerusakan' menjadi 'pengaduan' sesuai enum database lo
                'type' => 'pengaduan', 
                'category' => 'Kelas',
                'description' => 'Proyektor di kelas XI-RPL macet total, lampu indikatornya kedip-kedip merah padahal mau dipake presentasi.',
                'photo_path' => 'complaints/proyektor_rusak.jpg',
                'is_anonymous' => false,
                'status' => 'diterima',
                'admin_notes' => null,
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'ticket_code' => 'PGD-2026-0002',
                'user_id' => 1,
                // DISESUAIKAN: Mengubah 'keluhan' menjadi 'pengaduan'
                'type' => 'pengaduan', 
                'category' => 'Wifi',
                'description' => 'Wifi di area kantin lemot banget dari minggu lalu, gak bisa buat buka materi web Laravel.',
                'photo_path' => null,
                'is_anonymous' => true,
                'status' => 'diproses',
                'admin_notes' => 'Tim IT sedang melakukan pemindahan posisi router ke area tengah kantin.',
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now(),
            ],
            [
                'ticket_code' => 'PGD-2026-0003',
                'user_id' => 1,
                'type' => 'pengaduan', 
                'category' => 'Toilet',
                'description' => 'Kran air di toilet cowok lantai 2 patah, airnya ngalir terus mubazir.',
                'photo_path' => 'complaints/kran_patah.jpg',
                'is_anonymous' => true,
                'status' => 'selesai',
                'admin_notes' => 'Kran air sudah diganti dengan yang baru dari besi oleh pak kebersihan.',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDay(),
            ],
        ]);

        // Seeder untuk log akuntabilitas admin
        DB::table('complaint_logs')->insert([
            [
                'complaint_id' => 2,
                'changed_by_admin_id' => 2,
                'status_from' => 'diterima',
                'status_to' => 'diproses',
                'notes' => 'Mulai pengecekan kekuatan sinyal router kantin.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'complaint_id' => 3,
                'changed_by_admin_id' => 2,
                'status_from' => 'diproses',
                'status_to' => 'selesai',
                'notes' => 'Selesai dipasang kran baru, aliran air sudah kembali normal.',
                'created_at' => Carbon::now()->subDay(),
                'updated_at' => Carbon::now()->subDay(),
            ],
        ]);
    }
}