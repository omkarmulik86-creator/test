#!/bin/bash
# Download All Files - WordPress Dashboard

echo "📦 SMARTNET CTF Dashboard - File Package Generator"
echo "=================================================="
echo ""
echo "یہ script تمام ضروری فائلیں organize کرتا ہے"
echo ""

# Create directory structure
mkdir -p smartnet-dashboard/woocommerce/myaccount
mkdir -p smartnet-dashboard/assets/css
mkdir -p smartnet-dashboard/assets/js

echo "✓ Directory structure created"
echo ""

# Files to copy
echo "📋 Files ready to download:"
echo ""
echo "1. Copy to: /wp-content/themes/[THEME]/"
echo "   ├── functions.php"
echo ""
echo "2. Copy to: /wp-content/themes/[THEME]/woocommerce/myaccount/"
echo "   ├── myaccount.php"
echo "   ├── dashboard.php"
echo "   ├── navigation.php"
echo "   └── form-login.php"
echo ""
echo "3. Copy to: /wp-content/themes/[THEME]/assets/css/"
echo "   └── myaccount-dashboard.css"
echo ""
echo "4. Copy to: /wp-content/themes/[THEME]/assets/js/"
echo "   └── myaccount-dashboard.js"
echo ""

echo "📌 Quick Checklist:"
echo ""
echo "☐ Download تمام فائلیں"
echo "☐ Correct folder میں رکھیں"
echo "☐ File permissions 644 set کریں (CSS/JS/PHP)"
echo "☐ All WordPress caches صاف کریں"
echo "☐ Browser cache clear کریں (Ctrl+Shift+R)"
echo "☐ Dashboard page کھولیں"
echo "☐ Colors red ہوں verify کریں"
echo ""

echo "✅ Done! اپنی hosting پر اپ لوڈ کریں"
