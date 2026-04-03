# CL Listing Collection

SSR listing card renderer for curated collection embeds.

Carousel is one presentation mode within this plugin.
It is not a separate plugin.

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
- SSR-first card output
- JS click enhancement only
- No client-side normalization or filter reconstruction
