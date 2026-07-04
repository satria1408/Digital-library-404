<?php

namespace Database\Seeders;

use App\Models\Suggestion;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SuggestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil satu user contoh buat testing saran yang ada identitasnya
        $user = User::where('role', 'siswa')->first() ?? User::first();

        // Contoh 1: Saran dari siswa dengan identitas
        Suggestion::create([
            'user_id'         => $user ? $user->id : null,
            'ticket_code'     => 'DEV-' . strtoupper(Str::random(6)), 
            'subjek'          => 'Penambahan Jam Operasional',
            'isi_saran'       => 'Min, kalau bisa perpustakaan buka sampai jam 5 sore dong, soalnya kalau pulang sekolah jam 3 sore nanggung banget mau baca-baca dulu.',
            'reply_developer' => null,
            'status'          => 'unread'
        ]);

        // Contoh 2: Saran Anonim yang belum dibalas
        Suggestion::create([
            'user_id'         => null, 
            'ticket_code'     => 'DEV-' . strtoupper(Str::random(6)),
            'subjek'          => 'Koleksi Buku Komik',
            'isi_saran'       => 'Tolong perbanyak komik edukasi atau novel fiksi ringan biar ga bosen pas jam istirahat.',
            'reply_developer' => null,
            'status'          => 'unread'
        ]);

        // Contoh 3: Saran Anonim yang SUDAH gweh balas (status: replied)
        Suggestion::create([
            'user_id'         => null,
            'ticket_code'     => 'DEV-123456',
            'subjek'          => 'Tampilan Website',
            'isi_saran'       => 'Website-nya bagus banget, betah liatnya lama-lama pas nyari buku.',
            'reply_developer' => 'Wih mantap, makasih banyak apresiasinya bro! Bakal gua kembangin terus biar makin responsif.',
            'status'          => 'replied'
        ]);
    }
}