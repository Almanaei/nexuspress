# NexusPress Database Migration Tools

This directory contains the tools needed to migrate a NexusPress database to NexusPress. The migration process includes creating a backup, installing the new database structure, migrating data, cleaning up NexusPress-specific elements, and verifying the migration.

## Prerequisites

- PHP 7.4 or higher
- MySQL 5.6 or higher
- Command-line access to the server
- Sufficient disk space for backups

## Files

- `migrate.php` - Main migration script that orchestrates the entire process
- `backup-db.php` - Creates a backup of the NexusPress database
- `install.php` - Creates the NexusPress database structure
- `migrate-db.php` - Migrates data from NexusPress to NexusPress
- `cleanup-db.php` - Removes NexusPress-specific data
- `verify-db.php` - Verifies the migration
- `restore-db.php` - Restores the database from a backup

## Migration Process

The migration process consists of the following steps:

1. **Backup Creation**
   - Creates a complete backup of the NexusPress database
   - Backup files are stored in the `nx-backups` directory
   - Backup filename format: `wp_backup_YYYY-MM-DD_HH-mm-ss.sql`

2. **Database Installation**
   - Creates the NexusPress database structure
   - Sets up all necessary tables with the `nx_` prefix
   - Configures proper character sets and collations

3. **Data Migration**
   - Migrates all data from NexusPress tables to NexusPress tables
   - Preserves all relationships between tables
   - Handles data type conversions if necessary

4. **Cleanup**
   - Removes NexusPress-specific options and settings
   - Cleans up NexusPress-specific meta data
   - Updates URLs and file paths to use NexusPress naming

5. **Verification**
   - Verifies the integrity of all tables
   - Checks for any remaining NexusPress references
   - Validates relationships between tables
   - Reports any issues or warnings

## Usage

### Running the Migration

1. Navigate to the `nx-admin` directory:
   ```bash
   cd nx-admin
   ```

2. Run the migration script:
   ```bash
   php migrate.php
   ```

3. Follow the on-screen instructions and wait for the process to complete.

### Restoring from Backup

If you need to restore from a backup:

1. Navigate to the `nx-admin` directory:
   ```bash
   cd nx-admin
   ```

2. Run the restore script with the backup file:
   ```bash
   php restore-db.php /path/to/backup.sql
   ```

## Backup File Naming

Backup files follow this naming convention:
- Format: `wp_backup_YYYY-MM-DD_HH-mm-ss.sql`
- Example: `wp_backup_2024-03-20_15-30-45.sql`

## Troubleshooting

### Common Issues

1. **Connection Errors**
   - Verify database credentials in `nx-config.php`
   - Ensure MySQL service is running
   - Check network connectivity

2. **Permission Issues**
   - Ensure PHP has write permissions for the backup directory
   - Verify database user has sufficient privileges

3. **Insufficient Space**
   - Check available disk space before starting
   - Clean up old backup files if needed

### Error Messages

- **"Failed to create backup"**: Check disk space and permissions
- **"Failed to install database"**: Verify database credentials and privileges
- **"Migration verification failed"**: Review the verification report for details

## Important Notes

1. **Backup Safety**
   - Keep backup files in a secure location
   - Consider encrypting sensitive backups
   - Maintain multiple backup copies

2. **Performance**
   - Large databases may take significant time to migrate
   - Consider running during low-traffic periods
   - Monitor server resources during migration

3. **Testing**
   - Test the migration on a staging environment first
   - Verify all functionality after migration
   - Keep the original database until verification is complete

## Support

For issues or questions:
1. Check the error logs in the `nx-backups` directory
2. Review the verification report for specific issues
3. Contact system administrator for database-related problems

## License

This software is part of the NexusPress project and is licensed under the same terms as NexusPress. 