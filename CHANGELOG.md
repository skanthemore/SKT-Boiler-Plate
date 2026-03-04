# Changelog

All notable changes to this project will be documented in this file.

## [v0.2.0] - 2026-03-04

### Added
- Test scaffolding placeholders for generator, theme, and plugin.
- Apache basic auth support for protecting generator access.

### Changed
- Clarified testing and quality approach in project documentation.
- Removed public generator demo links from READMEs.
- Aligned theme runtime includes and footer ACF options configuration.
- Refactored theme runtime JS to a project-neutral baseline.
- Improved build pipeline globs to avoid double-minified JS artifacts.
- Standardized compiled CSS output to `assets/css/style.css` as single source of truth.

### Security
- Disabled public generation by default when auth credentials are missing.
