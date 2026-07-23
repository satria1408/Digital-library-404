<?php

use Illuminate\Support\Facades\Route;

require __DIR__.'/limiters.php';

require __DIR__.'/auth.php';

require __DIR__.'/modules/siswa.php';

require __DIR__.'/modules/digitallibrary/admin.php';
require __DIR__.'/modules/digitallibrary/siswa.php';

require __DIR__.'/modules/saranapengaduan/admin.php';
require __DIR__.'/modules/saranapengaduan/siswa.php';

require __DIR__.'/modules/developer.php';
require __DIR__.'/modules/owner.php';
require __DIR__.'/modules/security.php';