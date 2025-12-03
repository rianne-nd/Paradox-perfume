# Development Guide

## Getting Started

### Prerequisites
- A modern web browser (Chrome, Firefox, Safari, or Edge)
- A text editor or IDE (VS Code, Sublime Text, etc.)
- (Optional) Node.js for running a local development server
- Git for version control

### Initial Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/rianne-nd/Paradox-perfume.git
   cd Paradox-perfume
   ```

2. **Install dependencies** (optional, for development tools)
   ```bash
   npm install
   ```

3. **Start development server**
   ```bash
   npm start
   ```
   This will open the website at `http://localhost:8000`

## Project Structure

```
Paradox-perfume/
├── index.html              # Main website file (HTML, CSS, JS all-in-one)
├── manifest.json           # PWA manifest
├── robots.txt              # Search engine directives
├── sitemap.xml             # Site structure for SEO
├── package.json            # Project metadata and scripts
├── .editorconfig           # Editor configuration
├── .prettierrc             # Code formatting rules
├── .prettierignore         # Files to ignore for formatting
├── .gitignore              # Git ignore rules
├── LICENSE                 # MIT License
├── README.md               # Project overview
├── CONTRIBUTING.md         # Contribution guidelines
├── CODE_OF_CONDUCT.md      # Community standards
├── SECURITY.md             # Security policy
├── CHANGELOG.md            # Version history
├── ARCHITECTURE.md         # Technical architecture
├── RESOURCES.md            # Additional resources
└── .github/
    ├── workflows/
    │   └── static.yml      # GitHub Pages deployment
    ├── ISSUE_TEMPLATE/
    │   ├── bug_report.md
    │   ├── feature_request.md
    │   ├── documentation.md
    │   └── config.yml
    └── pull_request_template.md
```

## Development Workflow

### Making Changes

1. **Create a new branch**
   ```bash
   git checkout -b feature/your-feature-name
   ```

2. **Make your changes**
   - Edit `index.html` for content, styling, or functionality
   - Test changes in multiple browsers
   - Ensure mobile responsiveness

3. **Format your code**
   ```bash
   npm run format
   ```

4. **Commit your changes**
   ```bash
   git add .
   git commit -m "Description of changes"
   ```

5. **Push to GitHub**
   ```bash
   git push origin feature/your-feature-name
   ```

6. **Create a Pull Request**
   - Go to GitHub and create a PR from your branch
   - Fill out the PR template
   - Wait for review

### Code Style Guidelines

#### HTML
- Use semantic HTML5 elements
- Indent with 2 spaces
- Add comments for major sections
- Use descriptive class names

#### CSS (Tailwind)
- Use Tailwind utility classes
- Keep custom CSS to a minimum
- Follow the defined color palette
- Maintain consistent spacing

#### JavaScript
- Use modern ES6+ syntax
- Add comments for complex logic
- Keep functions small and focused
- Use meaningful variable names
- Handle errors gracefully

### Testing Checklist

Before submitting changes, test:
- [ ] Desktop browsers (Chrome, Firefox, Safari, Edge)
- [ ] Mobile devices (iOS Safari, Chrome Mobile)
- [ ] Different screen sizes (320px, 768px, 1024px, 1920px)
- [ ] Cart functionality (add, remove, persist)
- [ ] Quiz functionality (all paths)
- [ ] Navigation (mobile menu, smooth scroll)
- [ ] GitHub export feature
- [ ] Console for JavaScript errors
- [ ] Network tab for failed requests

## Key Components

### Shopping Cart

**Location**: Inline JavaScript in `<script>` tags

**Key Functions**:
- `addToCart(item)` - Adds item to cart
- `removeFromCart(index)` - Removes item
- `updateCart()` - Updates UI and localStorage
- `toggleCart()` - Opens/closes cart drawer

**Storage**: localStorage key `paradox_cart`

### Scent Finder Quiz

**Location**: Modal in HTML, JavaScript for logic

**Flow**:
1. User answers 3 questions about preferences
2. Answers stored in `quizAnswers` array
3. `showResult()` recommends fragrances
4. Modal displays personalized results

### GitHub Export

**Location**: Modal and inline JavaScript

**Process**:
1. User enters GitHub credentials
2. Creates/checks repository
3. Uploads index.html and workflow
4. Sets up GitHub Pages deployment

**API Used**: GitHub REST API v3

## Common Tasks

### Adding a New Product

1. Find the collections section (~line 500)
2. Copy an existing product div
3. Update:
   - Product name
   - Description
   - Price
   - Image source
   - Data attributes

### Changing Colors

1. Find Tailwind config (~line 200)
2. Update color values in `theme.extend.colors`
3. Use new color classes in HTML

### Modifying Quiz Questions

1. Find quiz modal section (~line 465)
2. Update question text
3. Update answer options
4. Adjust `showResult()` logic if needed

### Adding Animations

1. Find animation section in `<style>` (~line 250)
2. Add new `@keyframes` definition
3. Apply animation with Tailwind classes

## Performance Optimization

### Best Practices
- Minimize inline styles
- Optimize images (WebP format recommended)
- Use lazy loading for images
- Minimize JavaScript execution
- Leverage browser caching

### Tools
- Lighthouse (built into Chrome DevTools)
- PageSpeed Insights
- WebPageTest

## Debugging

### Common Issues

**Cart not persisting**
- Check localStorage in DevTools
- Verify JSON parsing doesn't fail
- Check browser privacy settings

**Quiz not showing results**
- Check `quizAnswers` array in console
- Verify all questions answered
- Check `showResult()` logic

**GitHub export fails**
- Verify token has correct permissions
- Check network tab for API errors
- Ensure repository name is valid

### Developer Tools

**Console Commands**:
```javascript
// Check cart contents
JSON.parse(localStorage.getItem('paradox_cart'))

// Clear cart
localStorage.removeItem('paradox_cart')

// Check quiz state
quizAnswers
```

## Deployment

### GitHub Pages

Deployment is automatic on push to `main` branch:

1. Push changes to main
2. GitHub Actions workflow runs
3. Site deployed to GitHub Pages
4. Available at: `https://rianne-nd.github.io/Paradox-perfume/`

### Manual Deployment

If needed, you can manually deploy:

1. Go to Actions tab
2. Select "Deploy static content to Pages"
3. Click "Run workflow"
4. Choose branch and run

### Custom Domain

To use a custom domain:

1. Add `CNAME` file with your domain
2. Configure DNS records:
   ```
   A    185.199.108.153
   A    185.199.109.153
   A    185.199.110.153
   A    185.199.111.153
   ```
3. Enable HTTPS in GitHub Pages settings

## Additional Resources

- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [GitHub Pages Docs](https://docs.github.com/pages)
- [Material Symbols](https://fonts.google.com/icons)
- [MDN Web Docs](https://developer.mozilla.org/)

## Getting Help

- 📖 Read the [documentation](README.md)
- 💬 Open a [discussion](../../discussions)
- 🐛 Report a [bug](../../issues/new?template=bug_report.md)
- 💡 Request a [feature](../../issues/new?template=feature_request.md)

## License

This project is licensed under the MIT License - see [LICENSE](LICENSE) for details.
