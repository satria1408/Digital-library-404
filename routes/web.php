<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Loader
|--------------------------------------------------------------------------
| File ini cuma nge-load semua route module. Jangan taro logic route
| langsung di sini. Tambahan module baru cukup daftarin di bawah.
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

require __DIR__.'/modules/digitallibrary/admin.php';
require __DIR__.'/modules/digitallibrary/siswa.php';

require __DIR__.'/modules/saranapengaduan/admin.php';
require __DIR__.'/modules/saranapengaduan/siswa.php';

require __DIR__.'/modules/developer.php';
require __DIR__.'/modules/owner.php';
require __DIR__.'/modules/security.php';