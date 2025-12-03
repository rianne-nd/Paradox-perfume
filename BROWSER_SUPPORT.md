# Browser Support

## Supported Browsers

Paradox Manila is tested and fully supported on the following browsers:

### Desktop Browsers

| Browser | Minimum Version | Status |
|---------|----------------|--------|
| Chrome  | 90+            | ✅ Full Support |
| Firefox | 88+            | ✅ Full Support |
| Safari  | 14+            | ✅ Full Support |
| Edge    | 90+            | ✅ Full Support |
| Opera   | 76+            | ✅ Full Support |

### Mobile Browsers

| Browser | Minimum Version | Status |
|---------|----------------|--------|
| Chrome Mobile | 90+     | ✅ Full Support |
| Safari iOS    | 14+     | ✅ Full Support |
| Samsung Internet | 14+ | ✅ Full Support |
| Firefox Mobile | 88+   | ✅ Full Support |

## Feature Support

### Core Features
- ✅ Responsive Design
- ✅ Shopping Cart with LocalStorage
- ✅ Interactive Quiz
- ✅ Smooth Animations
- ✅ Mobile Navigation

### Browser-Specific Notes

#### Safari
- Tested on Safari 14+ (macOS and iOS)
- All features fully supported
- LocalStorage works correctly
- Smooth scrolling enabled

#### Firefox
- Tested on Firefox 88+
- Full CSS Grid support
- All animations work smoothly
- No known issues

#### Edge
- Tested on Chromium-based Edge 90+
- Full compatibility with Chrome features
- Excellent performance

#### Internet Explorer
- ❌ **Not Supported**
- IE 11 and below are not supported
- Users will see basic functionality only
- Consider upgrading to a modern browser

## Progressive Enhancement

The site is built with progressive enhancement in mind:
- Core content is accessible without JavaScript
- CSS Grid with Flexbox fallback
- LocalStorage with cookie fallback
- Smooth scrolling with instant fallback

## Testing

We test on:
- Latest 2 versions of major browsers
- iOS 14+ (Safari)
- Android 10+ (Chrome)
- Various screen sizes (320px to 4K)

## Reporting Browser Issues

If you encounter a browser-specific issue:
1. [Open an issue](../../issues/new?template=bug_report.md)
2. Include browser name and version
3. Include operating system
4. Provide screenshots if applicable
5. Describe the expected vs actual behavior

## Accessibility

We strive for WCAG 2.1 Level AA compliance:
- Semantic HTML structure
- Keyboard navigation support
- ARIA labels where appropriate
- Sufficient color contrast
- Responsive text sizing

## Performance Targets

| Metric | Target | Desktop | Mobile |
|--------|--------|---------|--------|
| First Contentful Paint | < 1.5s | ✅ | ✅ |
| Time to Interactive | < 3s | ✅ | ✅ |
| Largest Contentful Paint | < 2.5s | ✅ | ⚠️ |
| Cumulative Layout Shift | < 0.1 | ✅ | ✅ |

## Polyfills

No polyfills are currently required for supported browsers. If you need to support older browsers, consider adding:
- Promise polyfill
- Fetch polyfill
- CSS Grid polyfill
- LocalStorage polyfill

## Questions?

For browser support questions, please [open an issue](../../issues/new?template=bug_report.md).
