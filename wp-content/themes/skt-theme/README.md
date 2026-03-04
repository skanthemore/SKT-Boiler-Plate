# SKT Boilerplate (theme)

SKT WordPress theme with design tokens, sample blocks support, and English UI. Use together with the **SKT Blocks** plugin.

Created by **Cristian Cascante**. `SKT` is the technical prefix and `Skanthemore` is the personal branding used for naming and repository conventions.

## Requirements

- WordPress 5.8+
- **SKT Blocks** plugin (for sample blocks; optional if you only use the theme shell)
- ACF Pro (required by SKT Blocks)

## Features

- **Design tokens** in `theme-data/`: colors, font sizes, spacings, grid. Output as CSS custom properties `--skt-*` in the head.
- **Menus**: Primary, Footer (registered in `inc/theme-setup.php`).
- **Editor support**: wide align, editor color palette, font sizes, spacing (from theme-data).
- **Performance**: emoji script removed, generator meta removed (see `inc/theme-performance.php`).

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

## Template: Example

**Template Name: Example (SKT Boilerplate)** — demonstrates design tokens with `.skt-example-card` and `.skt-example-section`. Create a page and assign this template to see it.

## Navigation

- Primary menu: `skt-header__menu` (desktop), `skt-mobile-menu__list` (mobile). Toggle via `.js-menu-toggle`.
- Nav link class: `skt-nav__link` (added by `skt_add_menu_link_class` in `functions.php`).
