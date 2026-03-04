# SKT Blocks

Custom ACF block boilerplate for the **SKT Boilerplate** theme. The plugin currently ships with demo blocks intended to be copied and adapted.

Created by **Cristian Cascante**. `SKT` is the technical prefix and `Skanthemore` is the personal branding used for naming and repository conventions.

## Requirements

- WordPress 5.8+
- **ACF Pro** (required; plugin will deactivate if ACF Pro is missing)
- An active theme that exposes `theme-data/colors.php` if you want the block color selector to match the theme palette

## Block category

Blocks appear under **SKT Blocks** in the block inserter.

## Included blocks

| Block | Description |
|-------|-------------|
| **Sample Content** | Neutral demo block with eyebrow, title, text, CTA link, image and background color selection from the active theme palette. Uses `wp_get_attachment_image()` for responsive image output. |
| **Exemple amb test unitari** | Minimal example block with a text message and highlight toggle, including a unit-testable helper function. |

## Exemple amb test unitari

- Block name: `skt/example-unit-test`
- Title in editor: `Exemple amb test unitari`
- Fields: `message` (required text), `highlight` (true/false toggle)
- Render flow: `front.php` reads ACF fields and calls `build_example_unit_test_state()`
- Helper output: `helpers.php` returns sanitized classes + `data_highlight`

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
├── .gitignore
├── blocks/
│   ├── sample-content/
│   │   ├── block.json
│   │   ├── block.php
│   │   ├── front.php
│   │   ├── style.css
│   │   └── editor.css
│   └── example-unit-test/
│       ├── block.json
│       ├── block.php
│       ├── front.php
│       ├── helpers.php
│       ├── style.css
│       └── editor.css
├── phpunit.xml.dist
└── tests/
    ├── bootstrap.php
    └── unit/
        └── ExampleUnitTestHelpersTest.php
```

## Testing & Quality

This plugin includes an initial PHPUnit setup for isolated unit tests that do not require booting WordPress.

Current coverage:

- `tests/unit/ExampleUnitTestHelpersTest.php` validates class generation.
- `tests/unit/ExampleUnitTestHelpersTest.php` validates highlight state output.
- `tests/unit/ExampleUnitTestHelpersTest.php` validates input sanitization behavior.

Install test dependencies from the plugin folder:

```bash
composer install
```

Run all plugin tests with one command (global for this plugin):

```bash
composer test
```

Note:

- `vendor/` is intentionally ignored by git (see plugin `.gitignore`).
