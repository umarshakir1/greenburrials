# Green Burials Theme - Live Deployment Checklist

## ✅ Pre-Deployment Verification

### 1. **Category System Compatibility**
- ✅ **Dynamic Category Detection**: The theme now automatically detects and displays all available product categories
- ✅ **Menu Order Support**: Categories will sort by the "Menu Order" field you set in WooCommerce
- ✅ **No Hardcoded Categories**: Filter buttons and product grids are generated dynamically
- ✅ **Fallback System**: If categories are missing, the theme gracefully handles it

### 2. **Files Modified for Live Compatibility**

#### **front-page.php** (Homepage)
- Lines 110-150: Dynamic category filter buttons
- Lines 128-180: Dynamic category product grid
- **What it does**: Automatically detects all your live categories and displays them in the correct order

#### **sidebar-shop.php** (Shop Sidebar)
- Lines 74-81: Dynamic category sorting by menu order
- **What it does**: Categories in the shop sidebar will display in your custom menu order

#### **functions.php** (Theme Functions)
- Added filters for category menu order support
- **What it does**: Ensures WooCommerce respects your category ordering

#### **style.css** (Styles)
- Added responsive filter name display
- Fixed product card borders
- Removed dotted background from My Account page

### 3. **Features That Work on Both Localhost & Live**

✅ **Category Filtering**: Automatically adapts to available categories
✅ **Menu Order Sorting**: Categories display in the order you set (1, 2, 3, etc.)
✅ **Product Display**: Shows correct products for each category
✅ **Responsive Design**: Works on mobile, tablet, and desktop
✅ **Border Fixes**: Clean single borders on product cards
✅ **Shop Page**: 404 error fixed with rewrite rules

---

## 🚀 Deployment Steps

### Step 1: Upload Theme Files
1. Compress your theme folder: `green-burials`
2. Upload via **Appearance > Themes > Add New > Upload Theme**
3. Or upload via FTP to: `/wp-content/themes/green-burials/`

### Step 2: Activate Theme
1. Go to **Appearance > Themes**
2. Activate "Green Burials" theme

### Step 3: Flush Rewrite Rules (Important!)
**Option A - Via WordPress Admin:**
1. Go to **Settings > Permalinks**
2. Click "Save Changes" (don't change anything, just save)

**Option B - Via PHP Script:**
Upload this file to your site root and run it once:
```php
<?php
require_once('wp-load.php');
flush_rewrite_rules(true);
echo "Rewrite rules flushed!";
// Delete this file after running
?>
```

### Step 4: Verify Categories
1. Go to **Products > Categories**
2. Check that all categories have proper "Menu Order" values
3. Categories with lower numbers (1, 2, 3) will appear first

### Step 5: Test Homepage
1. Visit your homepage
2. Check "Top Categories" section
3. Click each filter button to verify correct products display
4. Verify all your live categories appear (not just localhost ones)

### Step 6: Test Shop Page
1. Visit `/shop/` page
2. Verify sidebar categories display in correct order
3. Test category filtering
4. Check product card borders (should be single, clean borders)

---

## 🔍 Post-Deployment Verification

### Homepage Tests
- [ ] All category filter buttons appear
- [ ] Clicking filters shows correct products
- [ ] First category is active by default
- [ ] Mobile filter toggle works
- [ ] Product cards have clean borders

### Shop Page Tests
- [ ] Shop page loads (no 404 error)
- [ ] Sidebar categories display in menu order
- [ ] Category filtering works correctly
- [ ] Product cards display properly
- [ ] Border styling is correct

### My Account Page Tests
- [ ] No dotted background pattern
- [ ] Clean white background
- [ ] All account sections work

### Mobile Tests
- [ ] Category filters scroll horizontally
- [ ] Product cards display in 2 columns
- [ ] Borders are clean (no double borders)
- [ ] Filter button names truncate properly

---

## 🛠️ Troubleshooting

### Issue: Categories Not Showing
**Solution**: 
1. Check that categories have products assigned
2. Verify categories are not hidden (hide_empty = true)
3. Check menu order values are set

### Issue: Shop Page 404 Error
**Solution**: 
1. Go to Settings > Permalinks
2. Click "Save Changes"
3. Or run the flush rewrite rules script

### Issue: Wrong Products in Category Filter
**Solution**: 
1. Check product category assignments in WooCommerce
2. Verify category slugs match
3. Clear any caching plugins

### Issue: Categories Not in Correct Order
**Solution**: 
1. Go to Products > Categories
2. Edit each category
3. Set "Menu Order" field (lower numbers = higher priority)
4. Save changes

---

## 📋 Key Improvements Made

1. **Dynamic Category System**: No more hardcoded categories - works on any environment
2. **Menu Order Support**: Categories sort by your custom order values
3. **Clean Borders**: Fixed double-border issue on product cards
4. **404 Fix**: Shop page rewrite rules corrected
5. **Account Page**: Removed dotted background
6. **Responsive**: Full mobile/tablet/desktop support

---

## 💡 Important Notes

- **No Manual Configuration Needed**: Theme automatically detects your categories
- **Order Control**: Use WooCommerce's "Menu Order" field to control category display order
- **Safe Fallbacks**: If a category has no products, it won't display
- **Cache Friendly**: Clear cache after activation for best results

---

## 📞 Support

If you encounter any issues after deployment:
1. Check the troubleshooting section above
2. Verify all categories have products assigned
3. Ensure menu order values are set correctly
4. Clear browser and server cache

---

**Last Updated**: 2026-02-17
**Theme Version**: Compatible with WooCommerce 8.6.0+
**WordPress Version**: 5.0+
