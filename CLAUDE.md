# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

TailwindUI PHP is a reusable UI component library for PHP with Tailwind CSS. It provides 13+ ready-to-use components (Button, Card, Form, Alert, Badge, Table, Navigation, Banner, FlyoutMenu, Header, Footer, Modal, Tooltip, Progress, Skeleton) with 150+ methods for building modern web interfaces. The library is designed for vanilla PHP projects and Laravel/Blade compatibility with modern visual effects including gradients, glassmorphism, animations, and accessibility features.

**Key Features:**
- PSR-4 autoloaded namespace: `TailwindUI\`
- Built with PHP 8.0+ requirement
- All components inherit from base `Component` class
- XSS protection through automatic HTML escaping
- Tailwind CSS + Font Awesome dependencies (loaded via CDN)

## Development Setup

### Dependencies Installation
```bash
composer install
```

### Testing the Library
Open the demo file in a browser:
```
examples/demo.php
```

No build process or asset compilation is required - the library generates HTML markup with Tailwind CSS classes.

## Architecture

### Component Hierarchy

All UI components extend `src/Component.php`, which provides:
- `classNames()`: Conditional CSS class generation
- `escape()`: HTML attribute escaping (XSS protection)
- `attributes()`: Array-to-HTML attribute conversion

### Component Pattern

Each component (Button, Card, Form, etc.) follows this pattern:

1. **Static factory methods** for different variants (e.g., `Button::primary()`, `Badge::status()`)
2. **Constants for configuration** (sizes, colors, mappings)
3. **Protected/private render methods** that generate HTML markup
4. **Automatic escaping** for all user-provided values

Example:
```php
// User calls static method
Badge::status('active')
    ↓
// Internally maps 'active' → green color + 'Actif' label
// Returns escaped HTML string
```

### Auto-mapping Features

Several components include intelligent auto-mapping:
- `Badge::status()`: Maps status strings ('active', 'pending', etc.) to colors and French labels
- `Badge::priority()`: Maps priority levels ('low', 'medium', 'high', 'urgent') to colors
- `Table::statusCell()` and `Table::priorityCell()`: Convenience wrappers using Badge auto-mapping

## Component Usage Patterns

### Button Component (`src/Button.php`)

Modern button system with visual effects:
- Variants: `primary()`, `secondary()`, `success()`, `danger()`, `warning()`, `info()`
- Special: `glass()`, `glow()`, `gradient()`, `outline()`
- Icons: `withIcon()`, `icon()` (icon-only)
- Sizes: 'xs', 'sm', 'md', 'lg', 'xl'
- Features: Hover animations, focus rings, active states

### Card Component (`src/Card.php`)

Flexible card containers:
- `basic()`: Simple content wrapper
- `withHeader()`: Header + content + optional footer
- `stat()`: Statistic cards with icon and color
- `project()`: Project-specific card format
- `empty()`: Empty state with icon, message, and CTA

### Form Component (`src/Form.php`)

Form field generators:
- `input()`, `textarea()`, `select()`, `checkbox()`, `radio()`, `file()`, `color()`, `datetime()`
- All methods accept error messages and help text
- `grid()`: Multi-column field layout (specify column count)
- Automatic labels and styling

### Alert Component (`src/Alert.php`)

Notification and alert system:
- Static methods: `success()`, `error()`, `warning()`, `info()`
- `flashMessages()`: Display flash session messages
- `toast()`: Toast notification with auto-dismiss (JavaScript)
- Dismissible by default (pass `false` to disable)

### Badge Component (`src/Badge.php`)

Labels and indicators:
- Color variants: `primary()`, `success()`, `danger()`, `warning()`, `info()`, `secondary()`
- Auto-mapping: `status()`, `priority()`
- Special: `withIcon()`, `withDot()`, `count()`, `group()`

### Table Component (`src/Table.php`)

Data table rendering:
- Base: `simple()`, `striped()`, `hoverable()`, `full()`, `responsive()`
- Cell helpers: `statusCell()`, `priorityCell()`, `iconCell()`, `actionsCell()`
- Action buttons: `actionButton()` (generates icon buttons for CRUD)
- `pagination()`: Generates pagination controls

### Navigation Component (`src/Navigation.php`)

Navigation UI elements:
- `navbar()`: Top navigation bar with brand, links, user menu
- `breadcrumb()`: Breadcrumb trail
- `tabs()`: Tab navigation with counts and icons
- `sidebar()`: Sidebar menu with badges
- `dropdown()`: Dropdown menu with dividers
- `link()`: Individual navigation link

## Code Style Guidelines

### HTML Generation
- Always use static factory methods (no `new Component()`)
- Return HTML strings (not echo'd)
- Accept optional `$attributes` array for custom classes/props
- Use heredoc (`<<<HTML`) for multi-line HTML in render methods

### Security
- All user input MUST pass through `self::escape()`
- Use `self::attributes()` for generating HTML attributes
- Never concatenate raw user data into HTML

### Customization
Users can extend components or add custom classes:
```php
Button::primary('Text', ['class' => 'my-custom-class'])
```

Classes in `$attributes['class']` are merged with component defaults.

## Documentation

Full component documentation with interactive examples:
- Online: https://babs95.github.io/my_biblio_tailwindUI_PHP/
- Local: `docs/UI_COMPONENTS.md`

README includes installation instructions and usage examples for all components.

## Laravel Integration

Configured for Laravel with service provider and facade (see `composer.json` extra section):
```php
// In Blade templates
{!! Alert::success('Message') !!}
```

## New Components (Latest Update)

### Modal Component (`src/Modal.php`)

Interactive modal dialogs with animations and accessibility:
- `basic()`: Standard modal with header, body, footer
- `confirm()`: Confirmation dialog with confirm/cancel buttons
- `glass()`: Glassmorphism effect modal
- `fullscreen()`: Full-screen modal
- `drawer()`: Slide-in panel from sides (right, left, top, bottom)
- `trigger()`: Button to open specific modal

Features:
- Click-outside and Escape key to close
- Smooth animations (fade and scale)
- ARIA attributes for accessibility
- Backdrop blur effects
- JavaScript event delegation pattern

### Tooltip Component (`src/Tooltip.php`)

Hover tooltips with multiple positions and themes:
- `top()`, `bottom()`, `left()`, `right()`: Positioned tooltips
- `icon()`: Tooltip attached to icon
- `custom()`: Custom HTML content in tooltip

Themes: dark, light, primary, success, danger
Features: Automatic positioning, arrow indicators, smooth fade transitions

### Progress Component (`src/Progress.php`)

Loading states and progress indicators:
- `bar()`: Horizontal progress bar with gradient
- `circle()`: Circular progress indicator (SVG-based)
- `animated()`: Infinite loading animation
- `spinner()`: Spinning loader
- `dots()`: Bouncing dots animation
- `steps()`: Multi-step progress indicator

### Skeleton Component (`src/Skeleton.php`)

Loading placeholders with pulse animation:
- `text()`, `title()`: Text placeholders
- `avatar()`, `button()`, `image()`: Element placeholders
- `card()`, `list()`, `table()`, `profile()`: Complex layouts
- `grid()`: Grid of skeleton cards

All skeletons use gradient animation for smooth loading effect.

### Button Component Enhancements

New variants added:
- `gradientAnimated()`: Animated gradient background
- `neon()`: Neon glow effect (cyan, pink, green)
- `threed()`: 3D pressed effect with border
- `dark()`: Dark mode variant
- `ghost()`: Transparent with hover
- `loading()`: Loading state with spinner
- `withBadge()`: Button with notification badge

### Card Component Enhancements

New methods:
- `feature()`: Feature card with icon and description
- `pricing()`: Pricing plan card with features list
- `testimonial()`: Testimonial/review card with avatar

Existing methods enhanced with gradients, shadows, and hover effects.

## Common Tasks

### Adding a new component method
1. Add static public method to component class
2. Define any needed constants (colors, sizes, mappings)
3. Implement protected render method with HTML generation
4. Use `self::escape()` for all dynamic values
5. Test in `examples/demo.php`

### Modifying component styles
Components use Tailwind utility classes. Update class strings in:
- Constants (e.g., `Button::SIZES`)
- Render methods
- Variant-specific class combinations

### Extending auto-mapping
Edit the mapping arrays in component classes:
- `Badge::STATUS_MAPPING`
- `Badge::PRIORITY_MAPPING`

Add new mappings following the pattern: `'key' => ['color' => '...', 'label' => '...']`

### Working with JavaScript components
Modal and Tooltip components include embedded JavaScript:
- Uses event delegation pattern for performance
- Single script tag included once per page (scriptIncluded flag)
- Vanilla JavaScript (no dependencies)
- resetScriptFlag() method for testing
