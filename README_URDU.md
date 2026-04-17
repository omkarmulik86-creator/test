# سمارٹ نیٹ سی ٹی ایف ڈیش بورڈ - تمام فائلیں

**تاریخ:** 17 اپریل 2026  
**ورژن:** 2.0.0  
**رنگ تھیم:** Red Gradient (#E63946 to #C1121F)

---

## 📁 فائلیں کہاں رکھیں

آپ کے WordPress میں یہ ڈائریکٹری سٹریکچر بنائیں:

```
/wp-content/themes/[YOUR-CHILD-THEME]/
│
├── functions.php  ⬅️ پری فائل (functions.php سے replace کریں)
│
├── woocommerce/
│   └── myaccount/
│       ├── myaccount.php         ⬅️ نئی فائل
│       ├── dashboard.php         ⬅️ نئی فائل
│       ├── navigation.php        ⬅️ نئی فائل
│       └── form-login.php        ⬅️ نئی فائل
│
└── assets/
    ├── css/
    │   └── myaccount-dashboard.css     ⬅️ نئی فائل
    └── js/
        └── myaccount-dashboard.js      ⬅️ نئی فائل
```

---

## 📋 فائلوں کی تفصیل

### 1️⃣ **functions.php**
- **مقام:** Child Theme root میں
- **مقصد:** WooCommerce کو override کرتا ہے اور CSS/JS enqueue کرتا ہے
- **سائز:** ~1000 lines
- **اہم چیزیں:**
  - Header hide کرنا
  - رنگ override (سب purples کو red میں)
  - Mobile menu toggle
  - AJAX registration

### 2️⃣ **myaccount-dashboard.css**
- **مقام:** `assets/css/`
- **مقصد:** تمام styling (سائڈبار، کارڈز، فارمز)
- **رنگ کوڈز:**
  - Primary: `#E63946` (Red)
  - Secondary: `#C1121F` (Dark Red)
  - Accent: `#CCFF00` (Yellow)
  - Cyan: `#00D9FF`

### 3️⃣ **myaccount-dashboard.js**
- **مقام:** `assets/js/`
- **مقصد:** Mobile menu، form validation، toast notifications
- **Features:**
  - Hamburger menu toggle
  - Active link detection
  - Smooth scroll
  - Form validation
  - Toast notifications

### 4️⃣ **WooCommerce Templates**
یہ فائلیں WooCommerce کے default templates کو override کرتی ہیں:
- `myaccount.php` - Main layout with sidebar
- `dashboard.php` - Dashboard stats
- `navigation.php` - Menu items
- `form-login.php` - Login/Register form

---

## ⚙️ اپ لوڈ کرنے کی ہدایات

### **آپشن 1: FTP کے ذریعے** (بہتر)
1. FTP client (FileZilla, etc.) کھولیں
2. اپنے hosting سے connect کریں
3. اپنی child theme کی directory تک جائیں
4. فائلیں drag-drop کریں صحیح فولڈرز میں

### **آپشن 2: WordPress File Manager**
1. WordPress Admin میں جائیں
2. Tools > File Manager کھولیں
3. `/wp-content/themes/[THEME]/` navigate کریں
4. فائلیں اپ لوڈ کریں

### **آپشن 3: cPanel File Manager**
1. cPanel کھولیں
2. File Manager > public_html
3. wp-content → themes → [YOUR-THEME]
4. فائلیں رکھیں

---

## 🔧 Cache صاف کرنے کے طریقے

### **WordPress Caching Plugins:**
```
WP Super Cache:
→ WP Super Cache menu
→ "Purge Cache" بٹن دبائیں

W3 Total Cache:
→ Performance > Purge All Caches

Cloudflare:
→ Admin میں جائیں
→ Purge Everything
```

### **Browser Cache:**
```
Chrome/Firefox:
Ctrl + Shift + Delete
→ Cookies and Cached Data صاف کریں

Hard Refresh:
Ctrl + Shift + R (یا Cmd + Shift + R Mac میں)
```

### **Hosting Level Caching:**
جو hosting استعمال کر رہے ہو اسکے لیے:
```
WP Engine: Purge All Caches
SiteGround: Caching → Purge
Bluehost: Performance > Clear Cache
```

---

## ✅ کیا Check کریں

اپ لوڈ کے بعد یہ verify کریں:

```
1. Dashboard کھولیں
2. F12 دبائیں (DevTools)
3. Network tab میں جائیں
4. Refresh کریں (F5)
5. یہ فائلیں ہونی چاہیں:
   ✓ myaccount-dashboard.css (2xx status)
   ✓ myaccount-dashboard.js (2xx status)
   ✓ Response میں #E63946 (red color)
```

---

## 🎨 رنگ Reference

| نام | کوڈ | استعمال |
|------|------|--------|
| Primary Red | `#E63946` | Buttons، Headers |
| Dark Red | `#C1121F` | Gradients، Borders |
| Yellow | `#CCFF00` | Text، Active states |
| Cyan | `#00D9FF` | Accents، Focus states |
| Dark BG | `#07051a` | Page background |

---

## 📞 اگر مسائل ہوں

**اگر رنگ نہیں بدلے:**
1. ہار-رفریش کریں (Ctrl+Shift+R)
2. تمام caches صاف کریں
3. CSS file version بدلیں (functions.php میں)
4. Browser developer tools میں check کریں

**اگر layout broken ہو:**
1. WooCommerce templates check کریں
2. Parent theme conflict ہو سکتی ہے
3. Functions.php میں error ہو سکتی ہے

**اگر JavaScript کام نہ کرے:**
1. Console میں errors check کریں (F12)
2. smartnetAccount global variable check کریں
3. nonce verify کریں

---

## 📝 Last Updated
**April 17, 2026** - Version 2.0.0
- ✅ Red gradient theme
- ✅ Mobile responsive
- ✅ Form validation
- ✅ Toast notifications
- ✅ Smooth animations
