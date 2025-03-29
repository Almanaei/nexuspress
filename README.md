# NexusPress

NexusPress is a modern content management system forked from WordPress, designed for better performance, enhanced security, and modern development workflows.

## About the Conversion

This project was converted from WordPress to NexusPress through a comprehensive transformation of the codebase. The conversion focused on:

- Renaming files and directories
- Replacing function prefixes (`wp_` → `nx_`)
- Updating global variables (`$wpdb` → `$nxdb`)
- Replacing constants (`WP_` → `NX_`)
- Updating database references

## Conversion Scripts

The repository includes several utility scripts for maintaining the NexusPress codebase. You can run these scripts individually or use the convenient runner script:

### Quick Start: Using the Runner Script

The simplest way to run any conversion tool is with the unified runner script:

```bash
# View all available tools
php run-conversion.php help

# Run a specific tool
php run-conversion.php db-references
php run-conversion.php wp-functions
php run-conversion.php constants

# Run all conversion scripts in the recommended order
php run-conversion.php all
```

### 1. Database References Fix (`fix-db-references.php`)

This script replaces all occurrences of `$wpdb` with `$nxdb` across the codebase.

```bash
php fix-db-references.php
# Or use the runner: php run-conversion.php db-references
```

### 2. WordPress Function Prefixes Fix (`fix-wp-functions.php`)

This script replaces WordPress function prefixes (`wp_`) with NexusPress equivalents (`nx_`).

```bash
php fix-wp-functions.php
# Or use the runner: php run-conversion.php wp-functions
```

### 3. Underscore Functions Fix (`fix-wp-underscore-functions.php`)

This script targets and replaces underscore WordPress functions and variables (`_wp_`) with NexusPress equivalents (`_nx_`).

```bash
php fix-wp-underscore-functions.php
# Or use the runner: php run-conversion.php underscore
```

### 4. Constants Fix (`fix-constants.php`)

This script replaces WordPress constants with NexusPress equivalents.

```bash
php fix-constants.php
# Or use the runner: php run-conversion.php constants
```

### 5. Database Structure Fix (`fix-database-structure.php`)

This script updates database table prefixes and option names from WordPress to NexusPress format.

```bash
php fix-database-structure.php
# Or use the runner: php run-conversion.php database
```

### 6. Verification Script (`verify-wp-references.php`)

This script scans the codebase for any remaining WordPress references.

```bash
php verify-wp-references.php
# Or use the runner: php run-conversion.php verify
```

### 7. Conversion Toolkit (`nexuspress-conversion-toolkit.php`)

A comprehensive menu-based interface for running all conversion tools:

```bash
php nexuspress-conversion-toolkit.php
# Or use the runner: php run-conversion.php toolkit
```

## Usage Guidelines

1. **Make backups**: All scripts create backups, but it's always good practice to make your own backup before running conversion scripts.

2. **Run in proper order**: The recommended order is:
   - Database references fix
   - Function prefixes fix
   - Underscore functions fix
   - Constants fix
   - Database structure fix
   
   You can run all scripts in the proper order with: `php run-conversion.php all`

3. **Verify after changes**: Always run the verification script after making changes to ensure consistency.

4. **Test thoroughly**: After conversion, thoroughly test your installation to ensure functionality is maintained.

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher (or equivalent)
- Standard WordPress server requirements

## Development

For developers contributing to NexusPress, please ensure all new code follows the NexusPress coding standards:

- Use `nx_` prefix for all public functions
- Use `_nx_` prefix for all internal/private functions
- Use `NX_` prefix for all constants
- Use appropriate documentation with NexusPress terminology

## License

NexusPress is licensed under the GPL v2 or later, the same license as WordPress.

## About NexusPress

NexusPress is a fork of the WordPress content management system with complete rebranding and naming convention changes. It maintains all the functionality, extensibility, and ease of use that made WordPress popular, while establishing a distinct identity.

## Key Features

- **Complete CMS Platform**: Create, manage, and publish content with ease
- **Theme System**: Customize your site's appearance with themes
- **Plugin Architecture**: Extend functionality with plugins
- **REST API**: Build headless applications with the powerful API
- **User Management**: Comprehensive user roles and permissions
- **Mobile-Friendly**: Responsive admin interface and themes
- **Media Management**: Upload, organize, and embed media files
- **SEO-Friendly**: Built with search engine optimization in mind

## Directory Structure

NexusPress follows a clean, organized structure:

- `index.php`: Main entry point
- `nx-admin/`: Administration interface
- `nx-includes/`: Core functionality
- `nx-content/`: Themes, plugins, and uploads
  - `nx-content/themes/`: Theme files
  - `nx-content/plugins/`: Plugin files
  - `nx-content/uploads/`: User-uploaded media

## Installation

1. Download the latest version of NexusPress
2. Create a database for NexusPress on your web server
3. Upload the NexusPress files to your web server
4. Access the site in a web browser and follow the installation wizard
5. Enter your database connection details
6. Set up your admin account

## System Requirements

- PHP version 7.4 or higher
- MySQL version 5.7 or higher or MariaDB version 10.3 or higher
- HTTPS support
- PHP modules:
  - JSON support
  - MySQL support
  - XML support
  - Exif support (recommended)
  - ImageMagick support (recommended)

## Conversion from WordPress

NexusPress is a comprehensive rebranding of WordPress with:

- Renamed core directories and files
- Updated function and class prefixes
- Preserved functionality and backward compatibility
- Maintained plugin and theme compatibility
- Updated documentation and user interface elements

## Plugin Compatibility

Most WordPress plugins will work with NexusPress with minimal modifications. Some plugins may require updates to path references or function calls. The Plugin Compatibility Checker tool (included) can help identify potential issues.

## Theme Compatibility

WordPress themes are compatible with NexusPress but may require minor updates if they contain hardcoded references to WordPress directories or functions.

## Development

For developers looking to create themes or plugins for NexusPress:

- Use the `nx_` prefix for hooks and functions instead of `wp_`
- Reference `NX_` class prefixes instead of `WP_`
- Update path references from `/wp-*` to `/nx-*`
- Follow standard WordPress development practices otherwise

## License

NexusPress is licensed under the GPL v2 or later, maintaining the same open-source license as WordPress.

## Credits

NexusPress is a fork of WordPress, originally developed by the WordPress team and contributors. We acknowledge their work and contribution to the web publishing ecosystem.

---

For detailed documentation, visit the admin dashboard help section.