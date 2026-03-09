# TODO - Landing Page Redesign

## Task: Redesign Landing Page for PIC School Website

### Requirements Analysis:
1. **Navigation Bar**: Logo "Pontianak International College", centered rounded menu buttons (Home, Events, History, Profile), Login & Profile buttons on right, Home button active with darker blue
2. **Hero Section**: Full-width college building image, floating navbar above
3. **Introduction Section**: Two-column - student image left, blue semi-transparent text box right
4. **News Section**: "News" title, 2x2 grid (4 cards), image + headline per card

### Implementation Plan (with Tailwind CSS):

- [x] 1. Update `app/views/layouts/header.php` - Add Tailwind CSS CDN + Google Fonts (Poppins)
- [x] 2. Update `app/views/layouts/navbar.php` - Redesign with floating navbar, centered rounded menu, Login/Profile buttons
- [x] 3. Update `app/views/layouts/footer.php` - Keep basic footer
- [x] 4. Update `app/views/landing/index.php` - Create Hero, Introduction, and News sections with Tailwind
- [x] 5. Keep existing `style.css` for any custom styles

### To view the page:
- Run: `php -S localhost:3000 -t public`
- Open: **http://localhost:3000** in your browser

