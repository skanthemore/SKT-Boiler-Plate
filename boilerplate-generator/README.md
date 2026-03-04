# Boilerplate Generator

Rustic PHP app that exports the active WordPress boilerplate from:

- `wp-content/themes/skt-theme`
- `wp-content/plugins/skt-blocks`

It rewrites the project name, slug and code prefix, then creates:

- a theme ZIP
- a plugin ZIP
- a combined bundle ZIP

## Live Demo

- [http://boilerplate.cristiancascante.com/boilerplate-generator/](http://boilerplate.cristiancascante.com/boilerplate-generator/)

## Usage

1. Open `/boilerplate-generator/` in the browser.
2. Enter `Project name`, optional `Project slug`, and `Code prefix`.
3. Click `Generate boilerplate ZIPs`.
4. Download the theme, plugin, or the combined bundle.

## Access Control

This generator is now closed by default.

To enable it, configure both environment variables on the server:

- `BOILERPLATE_GENERATOR_AUTH_USER`
- `BOILERPLATE_GENERATOR_AUTH_PASS`

When those variables are present, the app requires HTTP Basic Auth for access and serves ZIP downloads through PHP instead of exposing direct build URLs from the interface.

For Apache-based servers, `builds/.htaccess` also denies direct access to generated artifacts. If you use Nginx or another server, you should add an equivalent rule there as well.

## Source of truth

This generator reads directly from the active theme and plugin. Any improvement made there will be reflected in the next generated export.

## Testing & Quality

This generator currently includes test scaffolding only. It does not yet ship with automated PHPUnit coverage, ZIP validation tests, or CI-based verification.

For now, generator quality is checked mainly through:

- manual testing of the browser flow and generated ZIP outputs
- verification of naming replacements, file inclusion, and export structure
- practical debugging and code review during real project use

The included `tests/` directory is intended as a stable starting point for adding automated checks later without changing the generator structure.
