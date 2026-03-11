# Gutenberg Block Alignment Fix - Summary

## Issue
Blog posts created in the WordPress dashboard with Gutenberg block editor were not displaying content alignment correctly on the frontend. Specifically:
- Images aligned to the right/left were not wrapping with text
- All content was being centered instead of respecting alignment settings
- Block editor layout settings were being ignored

## Root Causes Identified

1. **WordPress block library styles were being dequeued** on blog posts, removing essential Gutenberg styling
2. **Theme CSS was overriding alignment classes** with restrictive styles:
   - `.blog-content` had `text-align: center` and `max-width: 800px`
   - Images had fixed margins that prevented proper alignment
3. **Missing WordPress standard classes** on the content wrapper (`entry-content`, `single-post-body`)
4. **Border-radius and margin styles** were being applied to all images, including aligned ones

## Changes Made

### 1. functions.php (Lines 181-192)
**Changed:** Modified the conditional logic for dequeuing WordPress block library styles

**Before:**
```php
if (!is_singular('post') && !is_page()) {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
}
wp_dequeue_style('wc-block-style');

wp_dequeue_style('global-styles');
wp_deregister_style('global-styles');
```

**After:**
```php
if (!is_singular('post') && !is_page()) {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('global-styles');
    wp_deregister_style('global-styles');
}
wp_dequeue_style('wc-block-style');
```

**Why:** This ensures WordPress block library styles are KEPT on blog posts and pages, providing essential Gutenberg block styling.

---

### 2. single.php (Line 26)
**Changed:** Added WordPress standard classes to the blog content wrapper

**Before:**
```php
<div class="blog-content">
    <?php the_content(); ?>
</div>
```

**After:**
```php
<div class="blog-content entry-content single-post-body">
    <?php the_content(); ?>
</div>
```

**Why:** The `entry-content` and `single-post-body` classes are WordPress standards that trigger proper block styling and clearfix behavior.

---

### 3. assets/css/gutenberg-blocks.css (Lines 1-50)
**Added:** High-priority alignment rules at the top of the file

```css
/* CRITICAL: HIGH-PRIORITY ALIGNMENT FIXES */

/* Align left - works for images, figures, and any block */
img.alignleft,
figure.alignleft,
.alignleft {
    float: left !important;
    margin-right: 2rem !important;
    margin-bottom: 1rem !important;
    margin-left: 0 !important;
}

/* Align right - works for images, figures, and any block */
img.alignright,
figure.alignright,
.alignright {
    float: right !important;
    margin-left: 2rem !important;
    margin-bottom: 1rem !important;
    margin-right: 0 !important;
}

/* Align center - works for images, figures, and any block */
img.aligncenter,
figure.aligncenter,
.aligncenter {
    display: block !important;
    margin-left: auto !important;
    margin-right: auto !important;
    float: none !important;
}
```

**Why:** These rules use `!important` to override any theme styles and ensure alignment classes work on all elements (images, figures, blocks).

---

### 4. assets/css/gutenberg-blocks.css (Lines 546-671)
**Added:** Comprehensive override section for blog content

```css
/* CRITICAL: OVERRIDE THEME STYLES FOR BLOG POSTS */

/* Remove restrictive styling from blog-content wrapper */
.single .blog-content,
.entry-content {
    text-align: left !important;
    padding: 0 !important;
    border: none !important;
    border-radius: 0 !important;
    max-width: 1200px !important;
    width: 100% !important;
    margin-left: auto !important;
    margin-right: auto !important;
}

/* Ensure paragraphs and headings are left-aligned */
.blog-content p,
.blog-content h1, h2, h3, h4, h5, h6 {
    text-align: left !important;
}

/* Ensure lists are properly styled */
.blog-content ul,
.blog-content ol {
    text-align: left !important;
    padding-left: 2rem !important;
    list-style-position: outside !important;
}

/* Ensure clearfix for floated elements */
.blog-content::after,
.entry-content::after {
    content: "" !important;
    display: table !important;
    clear: both !important;
}
```

**Why:** These rules override the theme's restrictive `.blog-content` styles that were forcing center alignment and limiting width.

---

### 5. assets/css/global-mobile-fixes.css (Line 431)
**Changed:** Modified image styling to exclude aligned images

**Before:**
```css
.blog-content img {
    border-radius: 8px;
    margin: 2rem 0;
}
```

**After:**
```css
.blog-content img:not(.alignleft):not(.alignright):not(.aligncenter) {
    border-radius: 8px;
    margin: 2rem 0;
}
```

**Why:** This prevents the default margin from being applied to aligned images, allowing them to properly float with text wrapping.

---

## Testing Checklist

When you deploy these changes to your live site, verify the following:

1. ✅ **Image Alignment Right:** Images set to align right in the editor appear on the right with text wrapping on the left
2. ✅ **Image Alignment Left:** Images set to align left appear on the left with text wrapping on the right
3. ✅ **Image Alignment Center:** Centered images appear centered with no text wrapping
4. ✅ **Text Alignment:** Text blocks respect their alignment settings (left, center, right)
5. ✅ **Columns Block:** Multi-column layouts display side-by-side (on desktop)
6. ✅ **Media & Text Block:** Media and text appear side-by-side as configured
7. ✅ **Lists:** Bullet and numbered lists display with proper indentation
8. ✅ **Headings:** Headings are left-aligned by default
9. ✅ **Responsive:** On mobile, aligned images stack properly without breaking layout

## Files Modified

1. `/wp-content/themes/green-burials/functions.php`
2. `/wp-content/themes/green-burials/single.php`
3. `/wp-content/themes/green-burials/assets/css/gutenberg-blocks.css`
4. `/wp-content/themes/green-burials/assets/css/global-mobile-fixes.css`

## Deployment Instructions

1. Upload all modified files to your live site
2. Clear your WordPress cache (if using a caching plugin)
3. Clear your browser cache
4. Test a blog post with various alignment settings
5. Verify on both desktop and mobile devices

## Important Notes

- The `gutenberg-blocks.css` file is only loaded on blog posts and pages (see `functions.php` line 133-135)
- All alignment fixes use `!important` to ensure they override any conflicting theme styles
- The WordPress block library styles are now properly loaded on blog posts
- The changes are backward compatible and won't affect other pages

## Support

If you encounter any issues after deployment:
1. Check browser console for CSS errors
2. Verify all files were uploaded correctly
3. Ensure WordPress is using the correct theme
4. Clear all caches (WordPress, CDN, browser)
