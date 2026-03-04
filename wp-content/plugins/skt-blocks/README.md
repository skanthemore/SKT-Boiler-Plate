# SKT Blocks

Custom ACF block boilerplate for the **SKT Boilerplate** theme. The plugin currently ships with one neutral demo block that is intended to be copied and adapted.

Created by **Cristian Cascante**. `SKT` is the technical prefix and `Skanthemore` is the personal branding used for naming and repository conventions.

## Requirements

- WordPress 5.8+
- **ACF Pro** (required; plugin will deactivate if ACF Pro is missing)
- An active theme that exposes `theme-data/colors.php` if you want the block color selector to match the theme palette

## Block category

Blocks appear under **SKT Blocks** in the block inserter.

## Included block

| Block | Description |
|-------|-------------|
| **Sample Content** | Neutral demo block with eyebrow, title, text, CTA link, image and background color selection from the active theme palette. Uses `wp_get_attachment_image()` for responsive image output. |

## What the demo block shows

- Local ACF field registration in PHP
- PHP render template via `front.php`
- Responsive image output with WordPress attachment helpers
- Theme-aware color selection sourced from `theme-data/colors.php`
- Minimal editor/front-end CSS structure for extending the block safely

## Adding a new block

1. Create a folder under `blocks/`, e.g. `blocks/my-block/`.
2. Add `block.json` with `"name": "skt/my-block"`, `"category": "skt"`, and ACF `renderTemplate`: `front.php`.
3. Add `block.php` to define ACF fields; set `location` to `skt/my-block`.
4. Add `front.php` for front-end markup and escaped output.
5. Optionally add `style.css`, `editor.css`, `script.js` and reference them in `block.json`.

Blocks are loaded from the list declared in `get_supported_blocks()` inside `skt-blocks.php`.

## Text domain

- `skt-blocks` — use for all translatable strings in this plugin.

## File structure

```
skt-blocks/
├── skt-blocks.php    # Main plugin file (namespace SKT\Blocks)
├── blocks/
│   └── sample-content/
│       ├── block.json
│       ├── block.php
│       ├── front.php
│       ├── style.css
│       └── editor.css
└── README.md
```

## Testing & Quality

This plugin currently includes test scaffolding only. It does not yet provide automated PHPUnit coverage, integration tests, or CI-based validation.

For now, plugin quality is checked mainly through:

- manual testing inside a real WordPress and ACF setup
- verification of block registration, field behavior, render output, and editor/front-end consistency
- practical debugging and review tools such as Query Monitor, WordPress debug settings, and code review

The included `tests/` directory is intended as a stable starting point for adding automated checks later without changing the plugin structure.
