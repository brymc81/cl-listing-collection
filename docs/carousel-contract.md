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

The carousel does not:

- call MLS providers directly
- normalize upstream MLS fields
- infer missing data
- invent fallback content
- define compensation display
- author local compliance text
- reshape canonical payloads into a private schema

## Required Inputs

### Builder / Runtime Geography

- `geo_shape_id_input` is the preferred builder control key.
- Dynamic values must be resolved with Bricks runtime methods before sanitization.
- The resolved value must be sanitized after dynamic resolution.
- A valid resolved `geo_shape_id_input` maps directly to canonical `geo_shape_id`.
- Legacy saved `community_key_input` or `community_key` may be read only for backward compatibility.
- Legacy community fallback must map only to canonical `community` filter semantics and must not involve slug/path inference.
- If no valid canonical geographic input resolves, render the safe empty state.

### Query Controls

The carousel may forward only allowlisted canonical search options to `cl-reso-link`.

Allowed today:

- `geo_shape_id`
- `community`
- `limit`
- `sort`
- `order`
- `property_type`
- `property_subtype`
- `status`
- `price_min`
- `price_max`
- `beds_min`
- `baths_min`

Presentation-only controls that do not change canonical search semantics:

- `structured_data_mode`
- `clickable`
- `open_in_new_tab`
- `image_aspect_ratio`

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
13. Confirm legacy community fallback is used only when `geo_shape_id_input` is unresolved and legacy input is explicitly present.
