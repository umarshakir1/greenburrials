# Green Burials Theme - Quick Start Guide

## 🚀 Get Started in 5 Minutes

### Step 1: Activate Theme (30 seconds)
1. Go to WordPress Admin: http://localhost/custom-theme-template/wp-admin
2. Navigate to **Appearance > Themes**
3. Click **Activate** on "Green Burials"

### Step 2: Install WooCommerce (1 minute)
1. Go to **Plugins > Add New**
2. Search "WooCommerce"
3. Click **Install Now** → **Activate**
4. Skip the setup wizard (click "Skip setup store details")

### Step 3: Populate Products (1 minute)
1. Visit: http://localhost/custom-theme-template/wp-content/themes/green-burials/setup-dummy-products.php
2. Wait for completion message
3. You should see "27 products created successfully"

### Step 4: Set Homepage (30 seconds)
1. Go to **Settings > Reading**
2. Select "A static page"
3. Choose "Home" as homepage
4. Click **Save Changes**

### Step 5: Create Menu (2 minutes)
1. Go to **Appearance > Menus**
2. Create new menu: "Primary Menu"
3. Add these pages:
   - Custom Link: "/" → Label: "Home"
   - About
   - How To
   - As Seen In
   - Military
   - Blog
   - Shop (from WooCommerce Pages)
4. Check "Primary Menu" location
5. Click **Save Menu**

### Step 6: View Your Site! 🎉
Visit: http://localhost/custom-theme-template/

## ✅ What You Get

- **27 Sample Products** across 8 categories
- **Pixel-Perfect Homepage** matching Figma design
- **Lightning Fast** (<1 second load time)
- **Fully Responsive** mobile/tablet/desktop
- **WooCommerce Ready** with cart, checkout, products
- **SEO Optimized** semantic HTML5

## 📊 Performance Check

Open DevTools (F12) → Network Tab → Reload page

**Target Metrics:**
- Load Time: <1 second ✅
- Page Size: <500KB ✅
- Requests: <20 ✅

## 🎨 Customization

### Change Colors
Edit `style.css` line 10:
```css
--primary-green: #6B8E23; /* Your color here */
```

### Add Real Images
1. Go to **Products > All Products**
2. Click product → Set product image
3. Use 300x300px, <100KB, WebP format

### Edit Content
- Homepage sections: Edit `front-page.php`
- Footer info: Edit `footer.php`
- Header/nav: Edit `header.php`

## 🐛 Troubleshooting

**Products not showing?**
- Run setup-dummy-products.php again
- Check WooCommerce is active

**Slow loading?**
- Restart XAMPP
- Clear browser cache
- Disable other plugins

**Menu not working?**
- Assign menu to "Primary Menu" location
- Save menu

## 📚 Documentation

- Full guide: See `INSTALLATION.md`
- Theme info: See `README.md`
- Support: Check WordPress/WooCommerce docs

## 🎯 Next Steps

1. ✅ Theme activated
2. ✅ Products populated
3. ✅ Homepage working
4. → Add real product images
5. → Write product descriptions
6. → Create blog posts
7. → Configure shipping/payments
8. → Launch! 🚀

---

**Need Help?** Check INSTALLATION.md for detailed troubleshooting.

**Theme Location:** `wp-content/themes/green-burials/`

**Version:** 1.0 | **Author:** Mesum Bin Shaukat
