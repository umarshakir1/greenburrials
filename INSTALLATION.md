# Green Burials Theme - Installation Guide

## Prerequisites

- WordPress 5.0 or higher
- PHP 7.4 or higher
- WooCommerce 5.0 or higher
- XAMPP (or similar local server)

## Step-by-Step Installation

### 1. Install WordPress

If you haven't already installed WordPress:

1. Download WordPress from https://wordpress.org/download/
2. Extract to `C:/xampp/htdocs/custom-theme-template/`
3. Create a database in phpMyAdmin (http://localhost/phpmyadmin)
4. Visit http://localhost/custom-theme-template/ and complete WordPress installation

### 2. Install WooCommerce Plugin

1. Log into WordPress admin: http://localhost/custom-theme-template/wp-admin
2. Go to **Plugins > Add New**
3. Search for "WooCommerce"
4. Click **Install Now**, then **Activate**
5. Complete the WooCommerce setup wizard (you can skip most steps for testing)

### 3. Activate Green Burials Theme

The theme is already in the correct location. To activate:

1. Go to **Appearance > Themes**
2. Find "Green Burials" theme
3. Click **Activate**

### 4. Populate Dummy Products

**Method 1: Via Browser (Recommended)**

1. Visit: http://localhost/custom-theme-template/wp-content/themes/green-burials/setup-dummy-products.php
2. Wait for the script to complete
3. You should see "Setup Complete!" with a count of created products

**Method 2: Via WordPress Admin**

1. Copy the contents of `setup-dummy-products.php`
2. Create a temporary page in WordPress
3. Paste the code (excluding the wp-load.php line)
4. Execute via a custom plugin or code snippets plugin

### 5. Configure Homepage

The homepage should be automatically set, but verify:

1. Go to **Settings > Reading**
2. Set "Your homepage displays" to **A static page**
3. Select **Home** as the homepage
4. Click **Save Changes**

### 6. Create Navigation Menu

1. Go to **Appearance > Menus**
2. Click **Create a new menu**
3. Name it "Primary Menu"
4. Add pages:
   - Home (custom link: http://localhost/custom-theme-template/)
   - About
   - How To
   - As Seen In
   - Military
   - Blog
   - Shop (WooCommerce shop page)
5. Check **Primary Menu** under "Display location"
6. Click **Save Menu**

### 7. Configure WooCommerce Settings

1. Go to **WooCommerce > Settings**
2. **General Tab**:
   - Set your store address (optional for testing)
   - Set currency to USD
3. **Products Tab**:
   - Shop page: Should be set automatically
   - Set product image sizes (300x300 for thumbnails)
4. **Shipping Tab**:
   - Add a flat rate shipping method (optional)
5. Click **Save changes**

### 8. Add Product Images (Optional)

For better visuals, add real product images:

1. Go to **Products > All Products**
2. Click on a product
3. Set a **Product image** in the right sidebar
4. Recommended image size: 300x300px, optimized to <100KB
5. Use WebP format for best performance

### 9. Create Sample Blog Posts (Optional)

1. Go to **Posts > Add New**
2. Create 3 blog posts with titles like:
   - "Green Burials: An Eco-Friendly Choice"
   - "Understanding Biodegradable Urns"
   - "The Benefits of Natural Burial"
3. Add featured images (400x200px)
4. Publish the posts

### 10. Test Performance

1. Open homepage: http://localhost/custom-theme-template/
2. Open browser DevTools (F12)
3. Go to **Network** tab
4. Reload the page (Ctrl+Shift+R)
5. Check load time in bottom status bar
6. Target: <1 second (should be 500-800ms on localhost)

## Verification Checklist

- [ ] Theme is activated
- [ ] WooCommerce is installed and active
- [ ] 27 products are created across 8 categories
- [ ] Homepage displays correctly with all sections
- [ ] Navigation menu works
- [ ] Product sections show items dynamically
- [ ] Footer displays with all columns
- [ ] Page loads in under 1 second
- [ ] No JavaScript errors in console
- [ ] Responsive design works on mobile/tablet

## Troubleshooting

### Products Not Showing

**Problem**: Homepage shows empty product grids

**Solution**:
1. Verify WooCommerce is active
2. Run the setup-dummy-products.php script again
3. Check **Products > All Products** to confirm products exist
4. Clear all caches (browser, WordPress, WooCommerce)

### Slow Load Time

**Problem**: Homepage takes longer than 1 second to load

**Solutions**:
1. Disable other plugins temporarily
2. Check XAMPP performance (restart Apache/MySQL)
3. Verify HTML minification is working (view page source - should be compressed)
4. Check Network tab in DevTools for slow resources
5. Ensure images are optimized

### Menu Not Displaying

**Problem**: Navigation menu shows default links

**Solution**:
1. Go to **Appearance > Menus**
2. Assign menu to "Primary Menu" location
3. Save changes

### WooCommerce Pages Not Found

**Problem**: Shop/Cart/Checkout pages show 404 errors

**Solution**:
1. Go to **Settings > Permalinks**
2. Click **Save Changes** (this refreshes rewrite rules)
3. Test shop page again

### Theme Doesn't Appear

**Problem**: Green Burials theme not visible in Appearance > Themes

**Solution**:
1. Verify folder is at: `wp-content/themes/green-burials/`
2. Check that `style.css` has proper theme headers
3. Check file permissions (should be readable)

### Images Not Loading

**Problem**: Placeholder images don't show

**Solution**:
1. Verify SVG files exist in `assets/images/` folder
2. Check file permissions
3. Try accessing image directly in browser

## Performance Optimization Tips

### For Production

1. **Install a caching plugin**: WP Super Cache or W3 Total Cache
2. **Enable Gzip compression**: Add to .htaccess
3. **Use a CDN**: For static assets
4. **Optimize database**: Use WP-Optimize plugin
5. **Minify CSS/JS**: Already done in theme
6. **Use WebP images**: Convert all images to WebP format
7. **Enable browser caching**: Configure in .htaccess

### XAMPP Optimization

1. Increase PHP memory limit in php.ini:
   ```
   memory_limit = 256M
   ```

2. Enable OPcache in php.ini:
   ```
   opcache.enable=1
   opcache.memory_consumption=128
   ```

3. Restart Apache after changes

## Additional Configuration

### Customize Colors

Edit `style.css` line 10-20:
```css
:root {
    --primary-green: #6B8E23;  /* Change to your color */
    --dark-green: #5A7A1F;
    --light-green: #8BA446;
}
```

### Add Google Fonts

1. Edit `functions.php`
2. Add in `green_burials_scripts()` function:
```php
wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;600;700&display=swap', array(), null);
```

3. Update `style.css` font-family

### Change Logo

1. Replace SVG in `header.php` (line 13-15)
2. Or use WordPress Customizer to add logo support

## Support & Documentation

- Theme files location: `wp-content/themes/green-burials/`
- Documentation: See README.md
- WordPress Codex: https://codex.wordpress.org/
- WooCommerce Docs: https://woocommerce.com/documentation/

## Next Steps

1. Add real product images
2. Write product descriptions
3. Configure shipping methods
4. Set up payment gateways
5. Create additional pages (About, FAQ, etc.)
6. Test checkout process
7. Optimize for SEO
8. Set up Google Analytics

## Success!

Your Green Burials theme should now be fully functional with:
- ✅ Pixel-perfect design
- ✅ 27 sample products
- ✅ Dynamic WooCommerce integration
- ✅ <1 second load time
- ✅ Fully responsive layout
- ✅ Optimized for speed

Visit your homepage: http://localhost/custom-theme-template/
