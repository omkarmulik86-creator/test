# Upload Instructions - WooCommerce Dashboard Color Update

## آپ کے WordPress میں یہ فائلیں اپ لوڈ کریں:

### **مرحلہ 1: Cache صاف کریں**
پہلے یہ کریں:
1. WordPress Admin میں جائیں
2. اگر WP Super Cache ہے تو: WP Super Cache > Purge Cache
3. اگر W3 Total Cache ہے تو: Performance > Purge All Caches
4. Browser DevTools > Network > Empty cache

### **مرحلہ 2: فائلیں اپ لوڈ کریں**

**اپنے Child Theme میں یہ فائلیں رکھیں:**

```
/wp-content/themes/[YOUR-CHILD-THEME]/
├── functions.php (پوری فائل replace کریں)
├── woocommerce/
│   └── myaccount/
│       ├── myaccount.php
│       ├── dashboard.php
│       ├── navigation.php
│       └── form-login.php
└── assets/
    ├── css/
    │   └── myaccount-dashboard.css
    └── js/
        └── myaccount-dashboard.js
```

### **مرحلہ 3: فائل پرمیشنز**
Terminal میں (یا Hosting File Manager کے ذریعے):
```bash
chmod 644 /path/to/child-theme/functions.php
chmod 644 /path/to/child-theme/assets/css/myaccount-dashboard.css
chmod 644 /path/to/child-theme/assets/js/myaccount-dashboard.js
```

### **مرحلہ 4: سب کچھ دوبارہ صاف کریں**
1. WordPress Admin میں Settings > Permalinks جائیں
2. "Save Changes" دبائیں (cache reset کے لیے)
3. My Account صفحہ کھولیں اور **Ctrl+Shift+R** (Hard Refresh)

---

## اگر پھر بھی کام نہیں کرے:

**DevTools میں check کریں:**
1. Dashboard page کھولیں
2. F12 دبائیں (DevTools)
3. Network tab میں `myaccount-dashboard.css` تلاش کریں
4. اگر ہے تو Response میں `#E63946` color ہونی چاہیے
5. اگر نہیں ہے تو Hosting Contact کریں - file path غلط ہو سکتا ہے

---

## فائلوں کی List:
- ✅ functions.php (1000+ lines)
- ✅ myaccount-dashboard.css (complete)
- ✅ myaccount-dashboard.js (complete)
- ✅ myaccount.php
- ✅ dashboard.php
- ✅ navigation.php
- ✅ form-login.php
