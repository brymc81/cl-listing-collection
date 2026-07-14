# Carousel Contract

## Scope

This document defines the consumer-side contract for the `cl-listing-carousel` presentation layer in `cl-listing-collection`.

It does not redefine MLS or compliance schema authority. `cl-reso-link/docs/*` remains the source of truth for canonical listing fields, search parameters, and compliance payloads.

## Responsibility

The carousel:

- resolves builder input into canonical search filters
- requests canonical listing data from `cl-reso-link`
- renders SSR-first listing cards
- optionally enhances the rendered markup with JavaScript
- owns collection-level wrapper/layout behavior (for example instance-scoped width/gap/ratio variables and grid/scroll layout)

The carousel does not:

- call MLS providers directly
- normalize upstream MLS fields
- infer missing data
- invent fallback content
- define compensation display
- author local compliance text
- reshape canonical payloads into a private schema
- own reusable card-internal CSS for `.clpc-*` elements

## Required Inputs

### Builder / Runtime Geography

- `geo_shape_id_input` is the sole supported builder control key.
- Dynamic values must be resolved with Bricks runtime methods before sanitization.
- The resolved value must be sanitized after dynamic resolution.
- A valid resolved `geo_shape_id_input` maps directly to canonical `geo_shape_id`.
- If no valid canonical geographic input resolves, render the safe empty state.
- The prior Community Key fallback is removed; saved values from that retired control are ignored.

### Query Controls

The carousel may forward only allowlisted canonical search options to `cl-reso-link`.

Allowed today:

- `geo_shape_id`
- `limit`
- `sort`
- `order`
- `property_type`
- `property_subtype`
- `style`
- `status`
- `price_min`
- `price_max`
- `beds_min`
- `baths_min`
- `sqft_min`
- `sqft_max`
- `year_min`
- `year_max`
- `acres_min`
- `acres_max`
- `primary_bedroom_main_level`

`property_type` is a single-select broad category with exactly these canonical values: `Residential`, `Rental`, `Multi-Family`, and `Vacant Land`. Its builder default is `Residential`. `property_subtype` is a separate narrower filter; it is not a substitute for broad `property_type` values.

`style` is an optional canonical text filter. Dynamic Bricks values resolve before generic text sanitization; non-empty exact values are forwarded as a comma-separated list. The carousel does not infer `property_subtype`, define style vocabulary, or interpret style meaning. Those responsibilities remain with `cl-reso-link`.

For `price`, square-feet, year-built, and acreage min/max pairs, a supplied minimum greater than its supplied maximum causes both values in that pair to be omitted. Equal values are preserved. `primary_bedroom_main_level` forwards only the canonical `true` value; blank, false, or invalid values apply no filter. Final parameter validation and search semantics remain owned by `cl-reso-link`.

Presentation-only controls that do not change canonical search semantics:

- `structured_data_mode`
- `clickable`
- `open_in_new_tab`
- `image_aspect_ratio`
- `card_width`
- `gap`
- `show_location`
- `show_facts`
- `show_status`
- `compliance_display`

Layout control behavior:

- `card_width` defaults to `clamp(240px, 72vw, 360px)` and maps to `--cllc-card-width` on the carousel instance wrapper.
- `gap` defaults to `1rem` and maps to `--cllc-gap` on the carousel instance wrapper.
- `image_aspect_ratio` continues to control the card ratio class and may also be exposed on the wrapper as `--cllc-image-ratio`.
- CSS must consume these values with safe fallbacks so existing elements without explicit layout settings preserve current appearance.
- Variables are scoped per instance wrapper so multiple carousel instances can use different sizing on the same page.
- Carousel image frames must keep a fixed ratio even when the primary listing photo is portrait/vertical.
- Primary photos should fill that frame with `object-fit: cover` and must not increase card height or break row alignment.
- Current `cl-property-components` card markup uses `.clpc-card-link` as the media-only wrapper; if that selector ever wraps the full card, carousel CSS must target the replacement media frame instead.

Display control behavior:

- `show_location` defaults to `true` and controls location-row visibility in card rendering.
- `show_facts` defaults to `true` and controls facts-row visibility in card rendering.
- `show_status` defaults to `true` and controls status-row visibility in card rendering.
- `compliance_display` defaults to `compact`.
- Display controls are presentation-only and must not alter query/filter behavior.

Compact recommended config (presentation only):

- `card_width`: `clamp(150px, 24vw, 190px)`
- `image_aspect_ratio`: `16:9`
- `show_location`: `false`
- `show_facts`: `false`
- `show_status`: `false`
- `compliance_display`: `compact`

Portrait-image QA note:

- Use at least one listing fixture whose `media.primary_photo` is a vertical image.
- Confirm every carousel card keeps the same image frame height and the row remains aligned.
- Confirm IDX/compliance text and icons remain visible and unchanged below the image.

Future additions must be added only after this document and the canonical engine docs are updated together.

## Response Contract

The carousel consumes canonical search responses from `cl-reso-link`.

Reference the upstream contract instead of redefining it here:

- `cl-reso-link/docs/api.md`
- `cl-reso-link/docs/search-contract-v1.8.md`
- `cl-reso-link/docs/idx-compliance-contract.md`

Consumer expectations:

- the payload is authoritative only after `cl-reso-link` has applied its canonical filters, normalization, and compliance handling
- search items are opaque canonical listing objects plus compact compliance payloads
- this carousel must not reinterpret the engine output
- card links must come only from canonical `detail_url` supplied by `cl-reso-link`
- if a listing has no non-empty canonical `detail_url`, that listing is omitted from carousel rendering

Active shared card renderer:

- active carousel card rendering uses `cl-property-components` (`clpc_render_property_card`) and emits `.clpc-*` card markup
- `cl-property-components` is the owner of card-internal presentation for `.clpc-card`, `.clpc-card-link`, `.clpc-card-photo`, `.clpc-card-body`, `.clpc-card-price`, `.clpc-card-address`, `.clpc-card-meta`, `.clpc-card-status`, `.clpc-card-compliance`, `.clpc-card-compliance-text`, and `.clpc-card-idx-icon`
- `cl-listing-collection` owns collection wrappers/layout context (for example `.cl-listing-carousel` and `.cl-listing-grid`) and per-instance layout variables
- legacy internal `listing-card/*` artifacts in this plugin are not part of the active carousel render path

## SSR Baseline

- The page must render usable listing markup on the server.
- Cards must be present in the initial HTML.
- JavaScript enhancement is optional and must not be required for the listings to be readable.
- JS may handle slide navigation, drag interaction, lazy loading, and non-data UI polish.
- JS must not fetch listings, rewrite listing content, or change compliance meaning.

## Empty, Error, and Loading States

- Missing required input or unresolved canonical context must render a safe empty state.
- Search errors must render a safe empty or error state.
- No fabricated placeholder listings.
- No placeholder compliance copy.
- Loading state is only for optional frontend enhancement and must not hide valid SSR content.

## Multi-Instance Rules

- Each carousel instance must be isolated.
- State must be scoped to the instance root, not to the global page.
- No shared mutable DOM state across instances.
- Multiple carousels on the same page must operate independently.
- No event listener may assume a single carousel exists.

## Accessibility Requirements

- Cards remain standard links and must remain keyboard reachable.
- The carousel must not trap focus.
- Interactive controls must have accessible names.
- Visible focus styling must be preserved.
- The reading order must still make sense if JS does not run.
- Do not rely on image alt text as the only accessible label for a card.
- If motion is added, respect reduced-motion preferences.

## Compliance Display Requirements

Compliance rendering must follow `cl-reso-link/docs/idx-compliance-contract.md`.

Required rules:

- use canonical compliance payloads only
- preserve source MLS attribution and copyright notices
- preserve listing-firm and participant attribution when canonical display flags allow it
- never display compensation offers
- never support MLS-data-backed compensation UI
- never invent local compliance text
- never alter, remove, or conceal text, photos, copyright notices, or copyright management information except as allowed for formatting or MLS/RESO compliance
- do not leak contact info or compensation-related text from remarks or other broader payloads
- if a required compliance field is missing from the canonical payload, fail safe by omitting the restricted element or the listing rather than inventing substitute language

Compact compliance rendering rules:

- compact mode may render IDX/MLS icon metadata when `idx_icon_url` is present in canonical compact compliance
- compact mode may render `Listed by {listing brokerage name}` only when canonical `listing_firm_name` is present
- compact mode may render `Sold by {selling brokerage name}` only for sold/closed listing statuses and only when canonical compact compliance includes a non-empty selling brokerage name
- compact mode must not render full copyright text
- compact mode must not invent brokerage names or fallback copy from non-canonical sources
- compact mode must never expose compensation text or contact/remarks leakage

Upstream contract TODO:

- canonical compact compliance in `cl-reso-link/docs/idx-compliance-contract.md` does not currently include selling brokerage name fields.
- until `cl-reso-link` adds canonical compact selling brokerage attribution, consumers must omit `Sold by ...` in compact mode and must not infer or fabricate it.

If the requested display surface cannot be justified by the canonical compliance payload, the carousel must not attempt a best-effort interpretation.

## Validation Checklist

Before a carousel refactor is accepted:

1. Confirm the carousel resolves `geo_shape_id_input` first and validates it before request construction.
2. Confirm the query sent to `cl-reso-link` uses canonical filters only.
3. Confirm no raw MLS provider call exists in the carousel path.
4. Confirm SSR output renders valid cards without JavaScript.
5. Confirm JS enhancement does not fetch or reshape listings.
6. Confirm empty and error states are safe and do not invent listings or compliance text.
7. Confirm multiple carousel instances operate independently.
8. Confirm compliance blocks and attribution slots obey the canonical compliance payload and never expose compensation text.
9. Confirm the card layer can be reused from `cl-property-components` without becoming a data authority.
10. Confirm the implementation still points to `cl-reso-link/docs/*` for engine and compliance authority rather than duplicating schema details locally.
11. Confirm rendered cards and ItemList entries include only canonical payload URLs and never local `/listing/{id}/` URL construction.
12. Confirm `geo_shape_id` is included in request filters only when explicitly supplied via builder/runtime input.
13. Confirm missing or invalid `geo_shape_id_input` renders the safe empty state without a geographic fallback.
