# SKT WordPress Boilerplate Workspace

This repository contains my working WordPress boilerplate setup. It is not just a static starter kit: it is the same base I use and refine while building real projects, then export through a small web-based generator.

Two websites have already been built from this setup, so the goal here is not to present a finished product. The goal is to show a practical workflow, reusable structure, and a way of evolving a custom theme and plugin in a real WordPress environment.

## Live Demo

- Boilerplate generator demo: [http://boilerplate.cristiancascante.com/boilerplate-generator/](http://boilerplate.cristiancascante.com/boilerplate-generator/)

## Overview

The tracked parts of this workspace are:

- A custom theme: [`wp-content/themes/skt-theme`](./wp-content/themes/skt-theme/)
- A custom blocks plugin: [`wp-content/plugins/skt-blocks`](./wp-content/plugins/skt-blocks/)
- A rustic PHP generator: [`boilerplate-generator`](./boilerplate-generator/)

WordPress core, third-party plugins, uploads, and local environment files are intentionally not part of the source of truth.

## Project Structure

```text
web/
├── boilerplate-generator/
├── wp-content/
│   ├── plugins/
│   │   └── skt-blocks/
│   └── themes/
│       └── skt-theme/
└── README.md
```

## Tracked Components

### Theme

[`skt-theme`](./wp-content/themes/skt-theme/) is the main front-end base. It includes:

- theme setup and design tokens
- menu registration and semantic theme markup
- asset loading and performance-oriented defaults
- a neutral structure intended to be adapted project by project

Theme documentation:

- [`wp-content/themes/skt-theme/README.md`](./wp-content/themes/skt-theme/README.md)

### Plugin

[`skt-blocks`](./wp-content/plugins/skt-blocks/) contains the custom block boilerplate. In its current beta state it ships with one neutral demo block, `Sample Content`, used to demonstrate:

- ACF field registration in PHP
- PHP block rendering
- responsive image output with WordPress helpers
- theme-aware color selection

Plugin documentation:

- [`wp-content/plugins/skt-blocks/README.md`](./wp-content/plugins/skt-blocks/README.md)

### Boilerplate Generator

[`boilerplate-generator`](./boilerplate-generator/) is a simple PHP app that reads the active theme and plugin, replaces project identifiers, and generates ZIP packages for reuse.

Live demo:

- [http://boilerplate.cristiancascante.com/boilerplate-generator/](http://boilerplate.cristiancascante.com/boilerplate-generator/)

It currently produces:

- a theme ZIP
- a plugin ZIP
- a combined boilerplate ZIP

Generator documentation:

- [`boilerplate-generator/README.md`](./boilerplate-generator/README.md)

## Workflow

The workflow behind this repository is simple:

1. Build and refine the active theme and plugin inside a real WordPress install.
2. Validate ideas on the front end instead of designing everything in isolation.
3. Keep the reusable parts clean and neutral.
4. Export the current state through the boilerplate generator when the setup is ready to reuse.

This makes the theme and plugin the real source of truth, while the generator acts as the export layer.

## Git Scope

The repository is intentionally narrow. It tracks only:

- the custom theme
- the custom plugin
- the boilerplate generator
- repository-level documentation

Everything else is ignored on purpose. This keeps the repository focused on authored code rather than WordPress core files or local environment noise.

## Current Status

This workspace is in beta. The intention is to keep it practical, neutral, and reusable rather than over-engineered.

At this stage, the most important thing it demonstrates is how I work:

- refining a reusable base over time
- validating decisions in a live front-end environment
- keeping theme and plugin concerns separated
- packaging the result into a reusable boilerplate

## Testing & Quality

This beta workspace does not yet include a full automated testing stack such as PHPUnit suites, integration tests, or CI-driven test pipelines.

At this stage, quality is validated primarily through:

- development inside a real WordPress environment
- manual testing and focused checklists for key flows
- practical debugging and review tools such as Query Monitor, WordPress debug settings, and code review

Basic test scaffolding directories are already included so the quality layer can grow later without changing the project structure.

If the boilerplate continues to evolve or is adopted in larger production contexts, automated testing can be added incrementally using standard WordPress tooling and workflows. Contributions in that area are welcome.
