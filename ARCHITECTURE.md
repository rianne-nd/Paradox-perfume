# Architecture Overview

## Project Structure

Paradox Manila is a static website built with vanilla HTML, CSS, and JavaScript. It uses a single-page application (SPA) approach with all content in one HTML file.

## Technology Choices

### Frontend
- **HTML5**: Semantic markup for better accessibility and SEO
- **Tailwind CSS**: Utility-first CSS framework for rapid development
- **Vanilla JavaScript**: No framework dependencies for faster load times
- **Material Symbols**: Google's icon library for consistent iconography

### Styling Approach
- Tailwind CSS via CDN for zero build step
- Custom color palette defined in Tailwind config
- CSS animations for smooth transitions
- Responsive design using Tailwind breakpoints

### State Management
- LocalStorage for cart persistence
- In-memory state for quiz and UI interactions
- No external state management library

## Key Features

### 1. Shopping Cart
- Persistent storage using localStorage
- Add/remove items functionality
- Item quantity management
- Total price calculation

### 2. Scent Finder Quiz
- Multi-step questionnaire
- Personalized fragrance recommendations
- Modal-based interface
- Dynamic result display

### 3. GitHub Integration
- Export functionality to save project
- Direct GitHub API integration
- Repository creation and file upload
- Automated workflow generation

### 4. Responsive Design
- Mobile-first approach
- Breakpoints: sm (640px), md (768px), lg (1024px), xl (1280px)
- Touch-friendly interactions
- Optimized images and assets

## Performance Considerations

### Optimization Strategies
1. **Minimal Dependencies**: Only CDN-loaded libraries
2. **Lazy Loading**: Images loaded as needed
3. **Efficient DOM Manipulation**: Vanilla JS for direct DOM access
4. **CSS Animations**: Hardware-accelerated transitions
5. **LocalStorage Caching**: Reduce repeated calculations

### Load Time Goals
- First Contentful Paint (FCP): < 1.5s
- Time to Interactive (TTI): < 3s
- Total Page Size: < 500KB (excluding images)

## Browser Support

### Supported Browsers
- Chrome/Edge: Last 2 versions
- Firefox: Last 2 versions
- Safari: Last 2 versions
- Mobile Safari: iOS 12+
- Chrome Mobile: Android 5+

### Fallbacks
- CSS Grid with flexbox fallback
- Modern JavaScript with polyfills where needed
- SVG with PNG fallbacks for older browsers

## Security

### Best Practices
- No sensitive data stored in localStorage
- GitHub tokens never persisted
- Input sanitization for user data
- HTTPS-only external resources
- Content Security Policy headers

### OWASP Compliance
- XSS Prevention: Escaped user input
- CSRF Protection: No state-changing GET requests
- Secure Headers: Implemented via GitHub Pages

## Deployment

### GitHub Pages
- Automatic deployment on push to main
- CDN distribution worldwide
- HTTPS by default
- Custom domain support available

### CI/CD Pipeline
1. Push to main branch
2. GitHub Actions workflow triggered
3. Static files uploaded to Pages
4. Deployment completed
5. Site live within minutes

## Future Enhancements

### Planned Improvements
1. **Backend Integration**: Real payment processing
2. **Analytics**: User behavior tracking
3. **SEO**: Meta tags and structured data
4. **Accessibility**: ARIA labels and keyboard navigation
5. **Performance**: Image optimization and lazy loading
6. **Progressive Web App**: Service worker and offline support

### Code Organization
- Extract inline CSS to separate stylesheet
- Modularize JavaScript into separate files
- Implement build process for optimization
- Add TypeScript for type safety

## Contributing

See [CONTRIBUTING.md](CONTRIBUTING.md) for development guidelines and architecture decisions.
