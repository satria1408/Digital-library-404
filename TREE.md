# Project Structure
Last updated: Mon Jul 27 03:46:58 UTC 2026
```
.
├── README.md
├── TREE.md
├── app
│   ├── Http
│   │   ├── Controllers
│   │   │   ├── Auth
│   │   │   │   └── AuthController.php
│   │   │   ├── Controller.php
│   │   │   ├── Developer
│   │   │   │   ├── SuggestionController.php
│   │   │   │   └── SuggestionsExportController.php
│   │   │   ├── DigitalLibrary
│   │   │   │   ├── Admin
│   │   │   │   │   ├── AdminController.php
│   │   │   │   │   ├── BookController.php
│   │   │   │   │   ├── TransactionController.php
│   │   │   │   │   └── UserController.php
│   │   │   │   ├── Basecontroller.php
│   │   │   │   ├── Denda
│   │   │   │   │   ├── AdminDendaController.php
│   │   │   │   │   └── DendaController.php
│   │   │   │   └── Siswa
│   │   │   │       ├── SiswaController.php
│   │   │   │       └── WishlistController.php
│   │   │   ├── Owner
│   │   │   │   └── OwnerController.php
│   │   │   ├── SaranaPengaduan
│   │   │   │   ├── Admin
│   │   │   │   │   └── ComplaintController.php
│   │   │   │   ├── Base.php
│   │   │   │   └── Siswa
│   │   │   │       └── SiswaComplaintController.php
│   │   │   └── SecurityLogController.php
│   │   └── Middleware
│   │       ├── CheckRole.php
│   │       ├── RedirectAuthenticated.php
│   │       └── SqlInjectionMiddleware.php
│   ├── Imports
│   │   └── BukuImport.php
│   ├── Models
│   │   ├── Auth
│   │   │   └── User.php
│   │   ├── DigitalLibrary
│   │   │   ├── Admin
│   │   │   │   ├── Book.php
│   │   │   │   ├── Denda.php
│   │   │   │   └── Transaction.php
│   │   │   ├── Developer
│   │   │   │   └── Suggestion.php
│   │   │   ├── Owner
│   │   │   │   └── Owner.php
│   │   │   └── Wishlist.php
│   │   ├── SaranaPengaduan
│   │   │   ├── Admin
│   │   │   │   ├── Complaint.php
│   │   │   │   └── ComplaintLog.php
│   │   │   └── Base.php
│   │   └── SecurityLog.php
│   └── Providers
│       └── AppServiceProvider.php
├── artisan
├── bootstrap
│   ├── app.php
│   ├── cache
│   └── providers.php
├── composer.json
├── composer.lock
├── config
│   ├── app.php
│   ├── auth.php
│   ├── cache.php
│   ├── database.php
│   ├── filesystems.php
│   ├── logging.php
│   ├── mail.php
│   ├── queue.php
│   ├── services.php
│   └── session.php
├── database
│   ├── factories
│   │   └── UserFactory.php
│   ├── migrations
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2026_06_20_034256_create_books_table.php
│   │   ├── 2026_06_20_034410_create_transactions_table.php
│   │   ├── 2026_06_23_055535_create_dendas_table.php
│   │   ├── 2026_06_27_083355_create_security_logs_table.php
│   │   ├── 2026_06_30_064450_create_wishlists_table.php
│   │   ├── 2026_07_04_071317_create_suggestions_table.php
│   │   ├── 2026_07_07_060505_create_owners_table.php
│   │   ├── 2026_07_09_070157_create_complaints_table.php
│   │   └── 2026_07_09_070348_create_complaints_logs_table.php
│   └── seeders
│       ├── ComplaintSeeder.php
│       ├── DatabaseSeeder.php
│       └── SuggestionSeeder.php
├── package.json
├── phpunit.xml
├── public
│   ├── admin
│   │   ├── js
│   │   │   ├── admin.js
│   │   │   └── dashboard.js
│   │   └── none.js
│   ├── dashboard-siswa.js
│   ├── favicon.ico
│   ├── index.php
│   ├── robots.txt
│   └── siswa
│       └── peminjaman.js
├── resources
│   ├── css
│   │   └── app.css
│   ├── js
│   │   ├── app.js
│   │   └── bootstrap.js
│   └── views
│       ├── auth
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       ├── developer
│       │   ├── dashboard.blade.php
│       │   └── suggestions
│       │       └── index.blade.php
│       ├── digital_library
│       │   ├── admin
│       │   │   ├── books
│       │   │   │   ├── create.blade.php
│       │   │   │   ├── edit.blade.php
│       │   │   │   └── index.blade.php
│       │   │   ├── dashboard.blade.php
│       │   │   ├── dendas
│       │   │   │   └── index.blade.php
│       │   │   ├── transactions
│       │   │   │   ├── create.blade.php
│       │   │   │   ├── edit.blade.php
│       │   │   │   └── index.blade.php
│       │   │   └── users
│       │   │       ├── create.blade.php
│       │   │       ├── edit.blade.php
│       │   │       └── index.blade.php
│       │   ├── base.blade.php
│       │   └── siswa
│       │       ├── dashboard.blade.php
│       │       ├── partials
│       │       │   ├── peminjaman.blade.php
│       │       │   ├── pengembalian.blade.php
│       │       │   └── stats.blade.php
│       │       └── wishlish
│       │           └── index.blade.php
│       ├── layout
│       │   ├── admin_pengaduan.blade.php
│       │   ├── app.blade.php
│       │   ├── auth.blade.php
│       │   ├── dashboard-admin.blade.php
│       │   ├── dashboard-siswa.blade.php
│       │   ├── developer.blade.php
│       │   └── siswa_pengaduan.blade.php
│       ├── owner
│       │   └── dasboard.blade.php
│       ├── sarana_pengaduan
│       │   ├── admin
│       │   │   ├── index.blade.php
│       │   │   └── show.blade.php
│       │   ├── dashboard.blade.php
│       │   └── siswa
│       │       ├── create.blade.php
│       │       ├── index.blade.php
│       │       └── show.blade.php
│       ├── security
│       │   ├── logs
│       │   │   ├── index.blade.php
│       │   │   └── show.blade.php
│       │   └── none.blade.php
│       └── welcome.blade.php
├── routes
│   ├── auth.php
│   ├── console.php
│   ├── limiters.php
│   ├── modules
│   │   ├── developer.php
│   │   ├── digitallibrary
│   │   │   ├── admin.php
│   │   │   └── siswa.php
│   │   ├── owner.php
│   │   ├── saranapengaduan
│   │   │   ├── admin.php
│   │   │   └── siswa.php
│   │   ├── security.php
│   │   └── siswa.php
│   └── web.php
├── tests
│   ├── Feature
│   │   └── ExampleTest.php
│   ├── TestCase.php
│   └── Unit
│       └── ExampleTest.php
└── vite.config.js

66 directories, 135 files
```
