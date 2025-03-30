#!/bin/bash

echo "Creating NexusPress Production Package..."

# Create a clean directory
rm -rf nexuspress-production
mkdir -p nexuspress-production

# Copy all PHP files except development ones
find . -name "*.php" -not -path "./nexuspress-production/*" \
       -not -path "./build/*" \
       -not -name "dev-*.php" \
       -not -name "debug*.php" \
       -not -name "test-*.php" \
       -not -name "error-monitor.php" \
       -not -name "production-*.php" \
       -exec cp --parents {} nexuspress-production \;

# Copy essential files
cp .htaccess nexuspress-production/
cp -r nx-admin/.htaccess nexuspress-production/nx-admin/
cp -r nx-content nexuspress-production/
cp -r nx-includes nexuspress-production/

# Make sure key directories exist
mkdir -p nexuspress-production/nx-content/uploads
mkdir -p nexuspress-production/nx-content/upgrade

# Remove any remaining dev files from copied directories
find nexuspress-production -name "dev-*.php" -delete
find nexuspress-production -name "debug*.php" -delete
find nexuspress-production -name "test-*.php" -delete

# Create package
echo "Production package created in nexuspress-production directory"
echo "Number of files copied: $(find nexuspress-production -type f | wc -l)"
echo ""
echo "NEXT STEPS:"
echo "1. Review the files in nexuspress-production directory"
echo "2. Update domain and DB settings in nexuspress-production/nx-config.php"
echo "3. Update the authentication keys and salts"
echo "4. Package with: cd nexuspress-production && zip -r ../nexuspress-production.zip ." 