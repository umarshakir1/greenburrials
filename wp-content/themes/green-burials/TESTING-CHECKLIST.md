# Green Burials Theme v1.1 - Testing Checklist

## 🧪 Complete Testing Guide

Use this checklist to verify all v1.1 features are working correctly.

---

## 1. Pre-Testing Setup

### Environment Check
- [ ] XAMPP is running (Apache + MySQL)
- [ ] WordPress is accessible: `http://localhost/custom-theme-template/`
- [ ] WooCommerce plugin is active
- [ ] Green Burials theme is activated
- [ ] PHP GD library is enabled (check phpinfo)

### Clear All Caches
- [ ] Browser cache cleared (Ctrl+Shift+Delete)
- [ ] WordPress transients cleared
- [ ] WooCommerce cache cleared
- [ ] Hard reload performed (Ctrl+Shift+R)

---

## 2. Design Testing

### Colors (Figma Exact)
- [ ] Primary green is #73884D (header, buttons, headings)
- [ ] Accent gold #C4B768 visible (if used in design)
- [ ] Star ratings are orange #FFA500
- [ ] Background light gray is #F5F5F5
- [ ] Text dark is #333333
- [ ] No old green #6B8E23 visible anywhere

**How to Check**: Use browser DevTools > Inspect element > Computed styles

### Typography
- [ ] Headings use Playfair Display font
- [ ] Body text uses Roboto font
- [ ] Hero title is 72px (4.5rem)
- [ ] Hero subtitle is italic
- [ ] Letter spacing on h1 is 3px
- [ ] All text is readable and properly sized

**How to Check**: DevTools > Computed > font-family, font-size

### Layout & Spacing
- [ ] Hero section padding is 60px top/bottom (3.75rem)
- [ ] Product grid gap is 20px (1.25rem)
- [ ] Hero images have overlapping effect
- [ ] Product cards have subtle shadow
- [ ] Container max-width is 1200px
- [ ] All sections properly aligned

**How to Check**: DevTools > Computed > padding, gap, box-shadow

### Responsive Design
Test at these breakpoints:

**Mobile (<768px)**
- [ ] Products stack in 1 column
- [ ] Hero images stack vertically
- [ ] Text is readable
- [ ] No horizontal scroll
- [ ] Touch targets are large enough

**Tablet (768px-1024px)**
- [ ] Products in 2-3 columns
- [ ] Hero maintains layout
- [ ] Navigation works
- [ ] Images scale properly

**Desktop (>1024px)**
- [ ] Products in 4 columns
- [ ] Full layout as designed
- [ ] All elements visible
- [ ] No layout breaks

**How to Test**: DevTools > Toggle device toolbar (Ctrl+Shift+M)

---

## 3. Image Testing

### Product Images
- [ ] All products have images (not placeholders)
- [ ] Images are from Figma exports
- [ ] Images are clear and high quality
- [ ] Images load quickly
- [ ] No broken image icons

**Where to Check**: Homepage product grids, product pages

### Image Optimization
- [ ] Images are WebP format (if GD supports)
- [ ] Images are <50KB each
- [ ] `/wp-content/uploads/optimized/` folder exists
- [ ] Optimized images are being used
- [ ] Original images are preserved

**How to Check**: 
1. Right-click image > Open in new tab
2. Check URL for `.webp` extension
3. Check file size in DevTools Network tab

### Retina Support
- [ ] Images have srcset attribute
- [ ] 1x and 2x versions exist
- [ ] Correct image loads based on screen
- [ ] Images are crisp on retina displays

**How to Check**: DevTools > Inspect image > Check srcset attribute

### Lazy Loading
- [ ] Images have `loading="lazy"` attribute
- [ ] Below-fold images don't load immediately
- [ ] Images load when scrolled into view
- [ ] No layout shift when images load

**How to Check**: DevTools > Network tab > Scroll page slowly

---

## 4. Performance Testing

### Load Time (<600ms Target)
- [ ] Homepage loads in <600ms
- [ ] TTFB is <100ms
- [ ] DOM Content Loaded <500ms
- [ ] Fully Loaded <1s

**How to Test**:
1. Open DevTools (F12)
2. Go to Network tab
3. Hard reload (Ctrl+Shift+R)
4. Check bottom status bar for times
5. Check waterfall chart for slow resources

### Page Size (<200KB Target)
- [ ] Total page size <200KB
- [ ] Images total <150KB
- [ ] CSS <30KB
- [ ] JS <20KB
- [ ] HTML <10KB

**How to Check**: DevTools > Network tab > Bottom status bar

### HTTP Requests (<15 Target)
- [ ] Total requests <15
- [ ] No duplicate requests
- [ ] No 404 errors
- [ ] All resources load successfully

**How to Check**: DevTools > Network tab > Count rows

### Caching
- [ ] Second page load is faster
- [ ] Transients exist in database
- [ ] Cache expires after 1 hour
- [ ] Performance timer shows in HTML

**How to Check**:
1. Load page twice
2. Compare load times
3. View page source > Search for "Page generated in"
4. Check database: `wp_options` table for `_transient_gb_*`

---

## 5. Functionality Testing

### Navigation
- [ ] All menu links work
- [ ] Active page is highlighted
- [ ] Hover effects work
- [ ] Mobile menu works (if implemented)
- [ ] Logo links to homepage

### Product Sections
- [ ] Featured products display (4 items)
- [ ] Best sellers display (4 items)
- [ ] Latest products display (4 items)
- [ ] Product images load
- [ ] Product prices show correctly
- [ ] "Shop Now" buttons work

### WooCommerce
- [ ] Product pages load
- [ ] Add to cart works
- [ ] Cart icon updates count
- [ ] Cart page works
- [ ] Checkout page works
- [ ] Product categories work

### Forms
- [ ] Newsletter signup form displays
- [ ] Email validation works
- [ ] Submit button works
- [ ] No console errors on submit

### Footer
- [ ] All footer links work
- [ ] Payment icons display
- [ ] Copyright text shows
- [ ] Footer columns aligned

---

## 6. Google Fonts Testing

### Font Loading
- [ ] Fonts load without flash of unstyled text
- [ ] Preconnect tags in <head>
- [ ] Font CSS loads from Google
- [ ] Fonts render correctly

**How to Check**:
1. DevTools > Network tab
2. Filter by "fonts.googleapis.com"
3. Should see font requests
4. View page source > Check for preconnect tags

### Font Display
- [ ] Headings are Playfair Display
- [ ] Body is Roboto
- [ ] Italic styles work
- [ ] Bold styles work
- [ ] No font fallback visible

**How to Check**: DevTools > Computed > font-family

---

## 7. Critical CSS Testing

### Inline CSS
- [ ] Critical CSS in <head>
- [ ] Contains above-the-fold styles
- [ ] No render-blocking CSS
- [ ] Styles apply before main CSS loads

**How to Check**:
1. View page source (Ctrl+U)
2. Search for `<style id="critical-css">`
3. Should contain header, hero styles

### Performance Impact
- [ ] First Contentful Paint improved
- [ ] Largest Contentful Paint improved
- [ ] No layout shift
- [ ] Smooth rendering

**How to Test**: Lighthouse audit in DevTools

---

## 8. Browser Compatibility

Test in multiple browsers:

### Chrome
- [ ] All features work
- [ ] No console errors
- [ ] Performance is good
- [ ] WebP images load

### Firefox
- [ ] All features work
- [ ] No console errors
- [ ] Performance is good
- [ ] Images load correctly

### Safari (if available)
- [ ] All features work
- [ ] Fonts load correctly
- [ ] Images display properly

### Edge
- [ ] All features work
- [ ] No compatibility issues

---

## 9. Console & Error Testing

### JavaScript Errors
- [ ] No errors in console
- [ ] No warnings in console
- [ ] All scripts load successfully
- [ ] No 404s for JS files

### CSS Errors
- [ ] No CSS errors
- [ ] All styles apply correctly
- [ ] No missing stylesheets
- [ ] No 404s for CSS files

### Network Errors
- [ ] No failed requests
- [ ] All images load
- [ ] All fonts load
- [ ] No CORS errors

**How to Check**: DevTools > Console tab (should be clean)

---

## 10. SEO & Accessibility

### SEO
- [ ] Page title is set
- [ ] Meta description exists
- [ ] Headings are hierarchical (h1, h2, h3)
- [ ] Images have alt text
- [ ] URLs are clean

### Accessibility
- [ ] Keyboard navigation works
- [ ] Focus indicators visible
- [ ] ARIA labels on icons
- [ ] Color contrast is sufficient
- [ ] Screen reader friendly

**How to Test**: Lighthouse audit > Accessibility score

---

## 11. Database Testing

### Transients
- [ ] Transients are created
- [ ] Keys are: `_transient_gb_featured_*`
- [ ] Keys are: `_transient_gb_bestsellers_*`
- [ ] Keys are: `_transient_gb_latest_*`
- [ ] Expiration is set (1 hour)

**How to Check**: phpMyAdmin > `wp_options` table > Search "transient_gb"

### Products
- [ ] 27 products exist
- [ ] All have images
- [ ] All have prices
- [ ] All have categories
- [ ] Featured/bestseller tags set

**How to Check**: WordPress admin > Products > All Products

---

## 12. Performance Monitoring

### Admin View
- [ ] Performance timer visible (admin only)
- [ ] Shows generation time
- [ ] Time is <0.5 seconds

**How to Check**: 
1. Log in as admin
2. View page source
3. Search for "Page generated in"

### Lighthouse Audit
Run Lighthouse in DevTools:

- [ ] Performance score >90
- [ ] Accessibility score >90
- [ ] Best Practices score >90
- [ ] SEO score >90

**How to Run**: DevTools > Lighthouse tab > Generate report

---

## 13. Image Compression Testing

### GD Library
- [ ] GD is enabled in PHP
- [ ] WebP support available
- [ ] Image compression works
- [ ] No errors during compression

**How to Check**: Create `info.php` with `<?php phpinfo(); ?>`

### Compression Results
- [ ] Images are compressed
- [ ] Quality is acceptable
- [ ] File sizes reduced
- [ ] No visual degradation

**How to Test**: Compare original vs optimized file sizes

---

## 14. Setup Script Testing

### Run Script
- [ ] Script runs without errors
- [ ] Categories created
- [ ] Products created
- [ ] Images assigned
- [ ] Compression applied

**How to Test**: Visit `setup-dummy-products-v2.php`

### Results
- [ ] "Setup Complete!" message shows
- [ ] Product count is correct (27)
- [ ] Image assignments logged
- [ ] No PHP errors

---

## 15. Final Verification

### Overall Check
- [ ] Homepage looks pixel-perfect
- [ ] Matches Figma design exactly
- [ ] Load time <600ms
- [ ] Page size <200KB
- [ ] No errors anywhere
- [ ] All features work
- [ ] Responsive on all devices
- [ ] Images are optimized
- [ ] Fonts load correctly
- [ ] Caching works

### User Experience
- [ ] Site feels fast
- [ ] Navigation is smooth
- [ ] Images load quickly
- [ ] No lag or jank
- [ ] Professional appearance

---

## 📊 Testing Results Template

```
=== Green Burials v1.1 Testing Results ===

Date: _______________
Tester: _______________

DESIGN:
✅/❌ Colors match Figma
✅/❌ Fonts correct (Playfair + Roboto)
✅/❌ Spacing exact (60px hero, 20px gaps)
✅/❌ Responsive on all devices

IMAGES:
✅/❌ Real Figma images assigned
✅/❌ WebP compression working
✅/❌ Retina srcset present
✅/❌ Lazy loading enabled

PERFORMANCE:
Load Time: _____ ms (Target: <600ms)
Page Size: _____ KB (Target: <200KB)
HTTP Requests: _____ (Target: <15)
TTFB: _____ ms (Target: <100ms)

FUNCTIONALITY:
✅/❌ Navigation works
✅/❌ Products display
✅/❌ Cart works
✅/❌ No console errors

OVERALL SCORE: _____ / 100

NOTES:
_________________________________
_________________________________
_________________________________
```

---

## 🎯 Pass Criteria

To pass testing, ALL of these must be true:

1. ✅ Homepage loads in <600ms
2. ✅ Page size is <200KB
3. ✅ No console errors
4. ✅ All images load correctly
5. ✅ Fonts are Playfair + Roboto
6. ✅ Colors match Figma exactly
7. ✅ Responsive on mobile/tablet/desktop
8. ✅ All links work
9. ✅ WooCommerce functions properly
10. ✅ Lighthouse score >85

---

## 🐛 If Tests Fail

1. **Check CHANGELOG.md** for known issues
2. **Review UPDATE-GUIDE.md** troubleshooting
3. **Clear all caches** and retest
4. **Check browser console** for errors
5. **Verify system requirements** (PHP GD, etc.)
6. **Test with default theme** to isolate issue

---

## ✅ Testing Complete!

Once all tests pass:
- [ ] Document results
- [ ] Take screenshots
- [ ] Note any issues
- [ ] Plan fixes if needed
- [ ] Deploy to production (if ready)

**Happy Testing!** 🧪

---

*For support, see UPDATE-GUIDE.md or CHANGELOG.md*
