#!/bin/bash
echo "Starting NexusPress local development server..."
echo ""

# Check if PHP is in path
if ! command -v php &> /dev/null; then
    echo "PHP could not be found. Please make sure PHP is installed and in your PATH."
    exit 1
fi

# Start the server
php nx-server.php 