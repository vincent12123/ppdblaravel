# CHANGELOG

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.2.0] - 2025-11-14

### Added
- **Export to Excel Feature** 🎉
  - Export all applicants data to Excel (.xlsx)
  - Export filtered data by status (Terdaftar, Diterima, Ditolak, etc.)
  - Bulk export selected records
  - Professional Excel formatting with colored headers
  - Auto-width columns for better readability
  - Indonesian labels for status and gender
  - Dynamic filename with timestamp
  - Export button in header actions (green with download icon)
  - Bulk action for exporting selected records
  - Comprehensive documentation:
    - `docs/EXPORT_FEATURE.md` - Technical documentation
    - `docs/EXPORT_QUICKSTART.md` - Quick start guide
    - `docs/PROJECT_STRUCTURE.md` - Project structure
    - `docs/EXPORT_IMPLEMENTATION_SUMMARY.md` - Implementation summary

- **Dependencies**
  - `maatwebsite/excel` v3.1.67
  - `phpoffice/phpspreadsheet` v1.30.1
  - Related dependencies for Excel functionality

### Changed
- Updated `README.md` with export feature documentation
- Updated Laravel Framework to v12.38.1
- Enhanced applicants table with improved bulk actions
- Updated technology stack documentation

### Removed
- Obsolete table filters for `documents_verified` and `payment_verified`
- Redundant verification filters from `ApplicantsTable.php`

### Fixed
- Table configuration cleanup for better performance

---

## [1.1.0] - 2025-11-13

### Added
- Parent/guardian contact information (name and phone)
- Optional email field for applicants
- Optional document uploads
- Structured infolist with tabs layout
- Direct document preview from admin panel

### Changed
- Document uploads are now optional
- Email field is now nullable
- Simplified applicant verification workflow
- Enhanced infolist display with better organization
- Major choice display now shows names instead of IDs

### Removed
- **Documents Resource** - No longer needed (documents managed in applicant context)
- `documents_verified` field - Removed as uploads are optional
- `payment_verified` field - Not relevant for PPDB process
- `rapor_average` field - Removed to avoid applicant confusion
- Document verification action buttons - Simplified to accept/reject only

### Fixed
- Filament v4 Schema-based API compatibility
- Layout issues in infolist (right panel positioning)
- Major choice displaying IDs instead of names
- HTML content rendering in announcements
- Broken route references after Documents resource removal

---

## [1.0.0] - 2025-11-10

### Added
- Initial release of PPDB System
- Public registration portal
- Status check functionality
- Admin panel with Filament 4
- Dashboard with statistics widget
- Applicant management (CRUD)
- Major management (CRUD)
- Announcement management (CRUD)
- Role & Permission system (Admin, TU, Calon Siswa)
- Document upload system
- Status tracking (Registered → Verified → Accepted/Rejected → Registered Final)

### Core Features
- Laravel 12 framework
- Filament 4 admin panel
- MySQL database
- Spatie Laravel Permission
- TailwindCSS styling
- Vite asset bundling

### Database Tables
- `users` - User accounts
- `applicants` - Applicant data
- `majors` - Major/jurusan data
- `documents` - Document uploads
- `announcements` - Public announcements
- `roles` & `permissions` - Spatie permission tables

### Seeded Data
- Default admin user
- Default TU user
- Default student user
- Sample majors (TKJ, RPL, MM, AKL, OTKP)
- 20 sample applicants with documents
- Sample announcements

---

## Version History

### Version 1.2.0 - Export Feature
**Release Date**: November 14, 2025
**Focus**: Data export functionality with Excel format

**Key Highlights**:
- Professional Excel export with styling
- Multiple export methods (all, filtered, selected)
- Comprehensive documentation
- Production-ready implementation

### Version 1.1.0 - Simplification & Improvements
**Release Date**: November 13, 2025
**Focus**: Workflow simplification and UX improvements

**Key Highlights**:
- Optional document uploads
- Parent contact information
- Removed confusing verification fields
- Better data display with relationships

### Version 1.0.0 - Initial Release
**Release Date**: November 10, 2025
**Focus**: Core PPDB system functionality

**Key Highlights**:
- Complete PPDB workflow
- Admin panel with Filament
- Role-based access control
- Public registration and status check

---

## Upgrade Guide

### From 1.1.0 to 1.2.0

1. **Install Dependencies**
   ```bash
   composer require maatwebsite/excel
   ```

2. **Publish Configuration** (Optional)
   ```bash
   php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider" --tag=config
   ```

3. **Clear Cache**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   ```

4. **Test Export Feature**
   - Login as admin
   - Go to Applicants page
   - Click "Export Excel" button
   - Verify file downloads correctly

### From 1.0.0 to 1.1.0

1. **Backup Database**
   ```bash
   php artisan db:backup  # if backup package installed
   ```

2. **Run Migration**
   ```bash
   php artisan migrate:fresh --seed
   ```
   ⚠️ **Warning**: This will reset all data

3. **Update Dependencies**
   ```bash
   composer update
   npm install
   npm run build
   ```

4. **Clear All Cache**
   ```bash
   php artisan optimize:clear
   ```

---

## Breaking Changes

### Version 1.2.0
- None (backward compatible)

### Version 1.1.0
- **Documents Resource removed** - Any custom code referencing Documents resource will break
- **Migration changes** - Fresh migration required (data loss)
- **Removed fields**: `documents_verified`, `payment_verified`, `rapor_average`

### Version 1.0.0
- Initial release (no breaking changes)

---

## Security Updates

### Version 1.2.0
- Export feature restricted to admin and TU roles only
- No sensitive data exposure in exports

### Version 1.1.0
- No security issues

### Version 1.0.0
- Implemented Spatie Permission for role-based access
- Protected routes with authentication middleware

---

## Known Issues

### Version 1.2.0
- Export large datasets (> 10,000 rows) may take longer
- Solution: Use chunking for very large datasets (documented in `EXPORT_FEATURE.md`)

### Version 1.1.0
- None

### Version 1.0.0
- None

---

## Roadmap

### Upcoming (v1.3.0)
- [ ] Email/WhatsApp notifications
- [ ] Import from Excel
- [ ] PDF export with custom templates
- [ ] Advanced reporting and analytics

### Future (v2.0.0)
- [ ] Multi-year academic support
- [ ] Online payment integration
- [ ] Mobile app
- [ ] Real-time notifications
- [ ] Advanced dashboard charts

---

## Contributors

- **Vincent12123** - Initial work and all features
- **GitHub Copilot** - Development assistance

---

## License

This project is licensed under the MIT License - see the LICENSE file for details.

---

**Project Repository**: https://github.com/vincent12123/ppdblaravel
**Documentation**: `/docs` directory
**Support**: Contact system administrator

**Last Updated**: November 14, 2025
