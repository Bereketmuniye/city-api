#!/bin/bash

# Script to push code to GitHub repository
# Make sure you've created the repository at: https://github.com/Bereketmuniye/city-api

echo "Pushing code to GitHub..."
echo "Repository: https://github.com/Bereketmuniye/city-api"
echo ""

# Set remote (using HTTPS - you'll be prompted for credentials)
git remote set-url origin https://github.com/Bereketmuniye/city-api.git

# Push to GitHub
git push -u origin main

echo ""
echo "Done! Your repository is available at: https://github.com/Bereketmuniye/city-api"

