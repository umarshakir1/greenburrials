# Green Burials - Custom WordPress Theme

A pixel-perfect, high-performance WordPress theme for eco-friendly burial products, optimized for extreme speed (<1 second load time).

## Features

- **Pixel-Perfect Design**: Exact replication of Figma mockup
- **WooCommerce Integration**: Full e-commerce functionality
- **Extreme Speed Optimization**: <1 second homepage load time
  - HTML/CSS/JS minification
  - Lazy loading images
  - Optimized database queries
  - Deferred JavaScript loading
  - Removed WordPress bloat
- **Responsive Design**: Mobile-first approach with tablet and desktop breakpoints
- **SEO Optimized**: Semantic HTML5, proper heading structure
- **No Dependencies**: Pure vanilla JavaScript, no jQuery
- **Clean Code**: Well-documented, maintainable codebase

## Installation

1. **Upload Theme**
   - Copy the `green-burials` folder to `wp-content/themes/`
   - Or upload as ZIP through WordPress admin

2. **Activate Theme**
   - Go to Appearance > Themes in WordPress admin
   - Click "Activate" on Green Burials theme

3. **Install WooCommerce**
   - Install and activate WooCommerce plugin
   - Complete WooCommerce setup wizard

4. **Populate Products**
   - Visit: `http://localhost/custom-theme-template/wp-content/themes/green-burials/setup-dummy-products.php`
   - Or run the script from WordPress admin
   - This creates 27 sample products with categories

5. **Set Homepage**
   - Go to Settings > Reading
   - Set "Your homepage displays" to "A static page"
   - Select "Home" as homepage (created automatically on theme activation)

6. **Configure Menu**
   - Go to Appearance > Menus
   - Create a new menu with links: Home, About, How To, As Seen In, Military, Blog, Shop
   - Assign to "Primary Menu" location

## Theme Structure

```
green-burials/
├── style.css                 # Main stylesheet (minified)
├── functions.php             # Theme functions and optimizations
├── header.php                # Site header with navigation
├── footer.php                # Site footer with columns
├── front-page.php            # Homepage template
├── index.php                 # Default template
├── page.php                  # Page template
├── setup-dummy-products.php  # Product population script
├── js/
│   └── script.js            # Vanilla JavaScript (deferred)
├── assets/
│   └── images/              # Theme images
└── README.md                # This file
```

## Speed Optimization Techniques

### Implemented Optimizations:

1. **HTML Minification**: Removes whitespace and comments
2. **CSS Optimization**: Single minified stylesheet, no external dependencies
3. **JavaScript Optimization**: Deferred loading, vanilla JS only
4. **Image Optimization**: Lazy loading, WebP support
5. **Database Optimization**: Efficient WP_Query with limits, no unnecessary meta queries
6. **WordPress Bloat Removal**:
   - Removed emoji scripts
   - Removed block library CSS
   - Removed jQuery
   - Removed embed scripts
   - Removed query strings from static resources
7. **WooCommerce Optimization**: Cart fragments disabled on homepage
8. **Caching Ready**: Compatible with caching plugins

### Performance Targets:

- **Homepage Load Time**: <1 second (target: 800ms)
- **Time to First Byte (TTFB)**: <200ms
- **DOM Content Loaded**: <500ms
- **Page Size**: <500KB (including images)

## Testing Performance

1. Open browser DevTools (F12)
2. Go to Network tab
3. Reload homepage
4. Check:
   - Load time in bottom status bar
   - TTFB in timing tab
   - Total page size

## Customization

### Colors

Edit CSS variables in `style.css`:
```css
:root {
    --primary-green: #6B8E23;
    --dark-green: #5A7A1F;
    --light-green: #8BA446;
}
```

### Fonts

System fonts are used by default for speed. To use Google Fonts:
1. Enqueue in `functions.php`
2. Update font-family in `style.css`

### Images

Replace placeholder images in `assets/images/`:
- Hero images: 500x400px
- Product images: 300x300px
- Blog images: 400x200px
- Optimize to <100KB each (use WebP format)

## WooCommerce Setup

### Product Categories Created:
- Water Cremation Urns
- Earth Burial Urns
- Caskets
- Biodegradable Caskets
- Burial Shrouds
- Memorial Products
- Memorial Petals
- Water Burials

### Sample Products:
27 products across all categories with realistic pricing and descriptions.

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Credits

- **Theme Name**: Green Burials
- **Author**: Muhammad Umar
- **Version**: 1.0
- **License**: GPL v2 or later

## Support

For issues or questions:
1. Check WordPress debug log
2. Verify WooCommerce is active
3. Clear all caches
4. Test with default WordPress theme to isolate issues

## Changelog

### Version 1.0 (December 2025)
- Initial release
- Pixel-perfect homepage design
- WooCommerce integration
- Speed optimizations
- Responsive design
- 27 sample products
