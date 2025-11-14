# 📁 Struktur Project PPDB

## Root Directory Structure

```
ppdb/
├── app/                    # Application logic
├── bootstrap/              # Framework bootstrap files
├── config/                 # Configuration files
├── database/               # Migrations, seeders, factories
├── docs/                   # Documentation files
├── public/                 # Public assets & entry point
├── resources/              # Views, CSS, JS
├── routes/                 # Route definitions
├── storage/                # Storage & logs
├── tests/                  # Testing files
├── vendor/                 # Composer dependencies
├── .env.example            # Environment example
├── artisan                 # Artisan CLI
├── composer.json           # PHP dependencies
├── package.json            # Node dependencies
├── phpunit.xml             # PHPUnit config
├── README.md               # Main documentation
└── vite.config.js          # Vite configuration
```

## App Directory

```
app/
├── Exports/
│   └── ApplicantsExport.php         # Excel export class
│
├── Filament/
│   ├── Resources/
│   │   ├── Applicants/
│   │   │   ├── ApplicantResource.php          # Main resource
│   │   │   ├── Pages/
│   │   │   │   ├── CreateApplicant.php
│   │   │   │   ├── EditApplicant.php
│   │   │   │   ├── ListApplicants.php         # Export actions here
│   │   │   │   └── ViewApplicant.php
│   │   │   ├── Schemas/
│   │   │   │   ├── ApplicantForm.php          # Form schema
│   │   │   │   └── ApplicantInfolist.php      # Infolist display
│   │   │   └── Tables/
│   │   │       └── ApplicantsTable.php        # Table config + bulk export
│   │   │
│   │   ├── Announcements/
│   │   │   ├── AnnouncementResource.php
│   │   │   ├── Pages/
│   │   │   │   ├── CreateAnnouncement.php
│   │   │   │   ├── EditAnnouncement.php
│   │   │   │   └── ListAnnouncements.php
│   │   │   ├── Schemas/
│   │   │   │   ├── AnnouncementForm.php
│   │   │   │   └── AnnouncementInfolist.php
│   │   │   └── Tables/
│   │   │       └── AnnouncementsTable.php
│   │   │
│   │   └── Majors/
│   │       ├── MajorResource.php
│   │       ├── Pages/
│   │       │   ├── CreateMajor.php
│   │       │   ├── EditMajor.php
│   │       │   └── ListMajors.php
│   │       ├── Schemas/
│   │       │   └── MajorForm.php
│   │       └── Tables/
│   │           └── MajorsTable.php
│   │
│   ├── Widgets/
│   │   └── DocumentVerificationStats.php     # Dashboard stats widget
│   │
│   └── Pages/
│       └── Dashboard.php                      # Admin dashboard
│
├── Http/
│   ├── Controllers/
│   │   ├── RegistrationController.php        # Public registration
│   │   └── StatusCheckController.php         # Status check
│   │
│   └── Middleware/                            # Custom middleware
│
├── Models/
│   ├── Applicant.php                         # Applicant model
│   ├── Announcement.php                      # Announcement model
│   ├── Document.php                          # Document model
│   ├── Major.php                             # Major model
│   └── User.php                              # User model
│
└── Providers/
    └── AppServiceProvider.php                # Service provider
```

## Database Directory

```
database/
├── factories/
│   ├── UserFactory.php
│   └── ApplicantFactory.php
│
├── migrations/
│   ├── 0001_01_01_000000_create_users_table.php
│   ├── 0001_01_01_000001_create_cache_table.php
│   ├── 0001_01_01_000002_create_jobs_table.php
│   ├── xxxx_xx_xx_create_permission_tables.php    # Spatie permissions
│   ├── xxxx_xx_xx_create_majors_table.php
│   ├── xxxx_xx_xx_create_applicants_table.php
│   ├── xxxx_xx_xx_create_documents_table.php
│   └── xxxx_xx_xx_create_announcements_table.php
│
├── seeders/
│   ├── DatabaseSeeder.php                     # Main seeder
│   ├── RolePermissionSeeder.php               # Roles & permissions
│   ├── UserSeeder.php                         # Default users
│   ├── MajorSeeder.php                        # Sample majors
│   ├── ApplicantSeeder.php                    # Sample applicants
│   └── AnnouncementSeeder.php                 # Sample announcements
│
└── database.sqlite                            # SQLite database (if used)
```

## Resources Directory

```
resources/
├── css/
│   └── app.css                                # Main CSS (Tailwind)
│
├── js/
│   ├── app.js                                 # Main JS entry
│   └── bootstrap.js                           # Bootstrap logic
│
└── views/
    ├── welcome.blade.php                      # Landing page
    │
    ├── registration/
    │   └── create.blade.php                   # Registration form
    │
    └── status/
        └── check.blade.php                    # Status check page
```

## Config Directory

```
config/
├── app.php                                    # App config
├── auth.php                                   # Auth config
├── cache.php                                  # Cache config
├── database.php                               # Database config
├── excel.php                                  # Laravel Excel config ✨
├── filesystems.php                            # Storage config
├── logging.php                                # Logging config
├── mail.php                                   # Mail config
├── permission.php                             # Spatie permission config
├── queue.php                                  # Queue config
├── services.php                               # Third-party services
└── session.php                                # Session config
```

## Storage Directory

```
storage/
├── app/
│   ├── private/                               # Private files
│   └── public/
│       └── ppdb_documents/                    # Uploaded documents
│           ├── foto/
│           ├── ijazah/
│           ├── kartu_keluarga/
│           ├── akta_kelahiran/
│           └── rapor/
│
├── framework/
│   ├── cache/                                 # Framework cache
│   ├── sessions/                              # Session files
│   ├── testing/                               # Testing storage
│   └── views/                                 # Compiled views
│
└── logs/
    └── laravel.log                            # Application logs
```

## Routes Directory

```
routes/
├── web.php                                    # Web routes
├── console.php                                # Console commands
└── channels.php                               # Broadcasting channels
```

## Public Directory

```
public/
├── build/                                     # Built assets (Vite)
│   ├── manifest.json
│   └── assets/
│       ├── app-[hash].js
│       └── app-[hash].css
│
├── storage/                                   # Symlink to storage/app/public
│   └── ppdb_documents/                        # Accessible documents
│
├── favicon.ico                                # Site favicon
├── index.php                                  # Entry point
└── robots.txt                                 # Robots file
```

## Documentation Directory

```
docs/
├── EXPORT_FEATURE.md                         # Export feature docs
├── API.md                                     # API documentation (future)
└── DEPLOYMENT.md                              # Deployment guide (future)
```

## Tests Directory

```
tests/
├── Feature/
│   ├── ExampleTest.php
│   ├── RegistrationTest.php                   # Registration tests
│   ├── ApplicantExportTest.php                # Export tests
│   └── StatusCheckTest.php                    # Status check tests
│
├── Unit/
│   ├── ExampleTest.php
│   └── ApplicantModelTest.php                 # Model unit tests
│
├── Pest.php                                   # Pest config
└── TestCase.php                               # Base test case
```

## Key Files

### Environment & Config
- `.env` - Environment variables (not in git)
- `.env.example` - Environment template
- `composer.json` - PHP dependencies
- `package.json` - Node dependencies
- `vite.config.js` - Vite bundler config

### Development
- `artisan` - Laravel CLI tool
- `phpunit.xml` - PHPUnit configuration
- `.gitignore` - Git ignore patterns

## Important Paths

### URLs
- Admin Panel: `/admin`
- Registration: `/pendaftaran`
- Status Check: `/cek-status`
- Storage: `/storage/ppdb_documents/{filename}`

### Commands
```bash
# Development
php artisan serve              # Start dev server
npm run dev                    # Start Vite dev server

# Database
php artisan migrate            # Run migrations
php artisan db:seed            # Run seeders
php artisan migrate:fresh --seed  # Fresh migrate + seed

# Cache
php artisan cache:clear        # Clear cache
php artisan config:clear       # Clear config cache
php artisan route:clear        # Clear route cache
php artisan view:clear         # Clear view cache

# Storage
php artisan storage:link       # Create storage symlink

# Filament
php artisan filament:upgrade   # Upgrade Filament assets
```

## File Naming Conventions

### PHP Classes
- Models: `Applicant.php`, `Major.php` (Singular, PascalCase)
- Controllers: `ApplicantController.php` (Singular + Controller)
- Resources: `ApplicantResource.php` (Singular + Resource)
- Migrations: `xxxx_xx_xx_create_applicants_table.php` (Plural)
- Seeders: `ApplicantSeeder.php` (Singular + Seeder)

### Views
- Blade files: `create.blade.php`, `edit.blade.php` (lowercase)
- Directories: `registration/`, `status/` (lowercase)

### JavaScript/CSS
- All lowercase: `app.js`, `app.css`

## Permission Structure

### Roles
- `admin` - Full access
- `tu` - TU (Tata Usaha) access
- `calon_siswa` - Student applicant access

### Permissions (Spatie)
- `view_applicant`
- `create_applicant`
- `update_applicant`
- `delete_applicant`
- `export_applicant` ✨
- `view_major`
- `create_major`
- `update_major`
- `delete_major`
- `view_announcement`
- `create_announcement`
- `update_announcement`
- `delete_announcement`

---

**Note**: Structure ini mengikuti best practices Laravel dan Filament v4.
