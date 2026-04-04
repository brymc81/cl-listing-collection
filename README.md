# CL Listing Collection

SSR listing presentation components for curated collection embeds.

`listing-card` is a shared UI component.
`listing-grid` and carousel are presentation modes within this plugin.
Carousel is not a separate plugin.

## What This Plugin Does
- Registers `CL Listing Carousel` Bricks element.
- Requests canonical listings from `/api/properties/search`.
- Renders SSR listing cards and optional ItemList structured data.

## Required Inputs
- `community_key` (required)

## Canonical Data Controls
- `community_key`
- `limit`
- `sort` (`modified`, `price`, `dom`)
- `order` (`asc`, `desc`)
- `property_type`
- `property_subtype`
- `price_min`
- `price_max`
- `beds_min`
- `baths_min`

## Dependency on cl-reso-link
- Canonical endpoint: `/api/properties/search`
- Canonical schema/contract authority: `../cl-reso-link/docs/*`

## Unique Behavior
- SSR-first grid/card output
- CSS-only carousel presentation mode (no JS dependency)
- No client-side normalization or filter reconstruction
