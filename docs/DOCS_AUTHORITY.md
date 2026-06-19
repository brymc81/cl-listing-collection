# Documentation Authority

This file identifies current documentation authority for
`cl-listing-collection`.

## Plugin Scope

`cl-listing-collection` is a collection-level presentation adapter for listing
embeds and collection UI such as carousels or grids.

## External Authorities

- `../../cl-reso-link/docs/*` owns canonical listing data, search/geography
  contracts, compliance, canonical URLs, and MLS/RESO meaning.
- `../../cl-property-components/docs/*` owns reusable card and saved-row
  presentation contracts when this plugin delegates rendering.

## Local Authority

- `../AGENTS.md` contains implementation rules for this plugin.
- `../README.md` summarizes usage.
- `carousel-contract.md` owns collection-level rendering behavior.

Local docs must not query MLS providers, normalize MLS data, invent compliance
text, or construct listing URLs from guessed identity.

