# SKT Boilerplate (theme)

SKT WordPress theme with design tokens, sample blocks support, and English UI. It is an opinionated front-end base designed to run with the **SKT Blocks** plugin.

Created by **Cristian Cascante**. `SKT` is the technical prefix and `Skanthemore` is the personal branding used for naming and repository conventions.

## Requirements

- WordPress 5.8+
- **SKT Blocks** plugin (expected for the intended visual system and block workflow)
- ACF Pro (required by SKT Blocks)

## Features

- **Design tokens** in `theme-data/`: colors, font sizes, spacings, grid. Output as CSS custom properties `--skt-*` in the head.
- **Menus**: Primary, Footer (registered in `inc/theme-setup.php`).
- **Editor support**: wide align, editor color palette, font sizes, spacing (from theme-data).
- **Performance**: emoji script removed, generator meta removed (see `inc/theme-performance.php`).

## Block Styling Strategy

This theme intentionally dequeues `wp-block-library`, `wp-block-library-theme`, and `classic-theme-styles` on the front end (see `inc/theme-enqueue.php`).

This is a deliberate product decision:

- keep styling control inside SKT tokens and SKT blocks
- avoid mixing default core styling with custom design-system rules
- prioritize consistency across SKT-based builds over generic block compatibility

If a project needs broad visual compatibility with core or third-party blocks, re-enable those styles for that project.

## Text domain

- `skt-theme` — use for all translatable strings in this theme.

## Structure

```
skt-theme/
├── style.css           # Theme header (Theme Name: SKT Boilerplate)
├── functions.php       # Loads inc + theme-data
├── header.php          # .skt-header, .skt-mobile-menu
├── footer.php          # .skt-footer
├── page.php, index.php, 404.php, single.php
├── template-example.php  # Example page (design tokens demo)
├── inc/
│   ├── theme-enqueue.php   # Styles/scripts (skt-*)
│   ├── theme-setup.php   # Menus, editor support, --skt-* output
│   ├── theme-performance.php
│   ├── theme-blocks.php
│   ├── theme-acf.php
│   └── theme-cpts.php
├── theme-data/         # Design tokens (PHP arrays)
│   ├── helpers.php      # calculate_clamp()
│   ├── custom.php       # width, grid, section
│   ├── colors.php
│   ├── font-sizes.php
│   └── spacings.php
├── sass/               # Source SCSS (compile to assets/css/style.css)
│   ├── base/
│   ├── layout/         # .skt-header, .skt-footer, etc.
│   ├── components/
│   └── ...
├── assets/
│   ├── css/            # style.css (compiled), critical.css (optional)
│   ├── js/             # main.js
│   ├── fonts/          # fonts.css (optional)
│   └── img/
└── README.md
```

## CSS classes and variables

- **Prefix**: `skt-` (SKT Boilerplate) for layout and components (e.g. `.skt-header`, `.skt-container`, `.skt-main`).
- **CSS variables**: `--skt-color-*`, `--skt-spacing-*`, `--skt-font-size-*`, `--skt-width-default`, `--skt-grid-*`, etc. Defined in `theme-data/*.php` and output by `skt_output_theme_vars()`.

## Building assets

If you use the SASS source in `sass/`, compile to `assets/css/style.css` (e.g. with Gulp, npm scripts, or your build tool). The theme enqueues `assets/css/style.css` and `assets/js/main.js` with filemtime for cache busting.

`assets/css/style.css` is the single compiled CSS target for this theme. Do not use a secondary `css/style.css` output.

`assets/js/main.js` is intentionally project-neutral. Keep project-specific logic (CF7 flows, animation libraries, language menu behavior, etc.) in separate files and enqueue those conditionally where needed.

## Template: Example

**Template Name: Example (SKT Boilerplate)** — demonstrates design tokens with `.skt-example-card` and `.skt-example-section`. Create a page and assign this template to see it.

## Navigation

- Primary menu: `skt-header__menu` (desktop), `skt-mobile-menu__list` (mobile). Toggle via `.js-menu-toggle`.
- Nav link class: `skt-nav__link` (added by `skt_add_menu_link_class` in `functions.php`).

## Testing & Quality

This theme currently includes test scaffolding only. It does not yet ship with automated PHPUnit coverage, browser-based test suites, or CI validation.

For now, theme quality is checked mainly through:

- development and visual validation inside a real WordPress install
- manual verification of templates, navigation, assets, and responsive behavior
- practical debugging and review tools such as Query Monitor, WordPress debug settings, and code review

The included `tests/` directory is intended as a stable starting point for adding automated checks later without changing the theme structure.
