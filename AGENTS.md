# CL Listing Collection — Agent Notes

## Documentation Scope
- Plugin-specific implementation guidance only.
- Authoritative API contract details are maintained in `../cl-reso-link/docs/*`.

## Boundaries
- Consumer only. No MLS normalization logic.
- No direct MLS access. Use `/api/properties/search` on the local WordPress site via `wp_remote_get()`.
- This plugin contains shared listing presentation components.
- `listing-card` is a shared UI component.
- `listing-grid` and carousel are presentation modes only.
- Shared components must be stateless.
- Shared components must not contain business logic.
- Shared components must not interpret, reshape, or normalize listing data.
- Shared components must not construct URLs or infer context.
- Carousel is a presentation mode within this plugin, not a separate plugin or data layer.
- Do not modify `cl-reso-link` or `cl-listing-router` from this plugin.
- All listing rendering behavior in this plugin must align with `../cl-community-listings/AGENTS.md` (reference consumer behavior).

## Rendering
- SSR is the baseline. No JS slider library usage.
- Shared listing card rules and inputs are defined in:
  `listing-card/listing-card-spec.md`.
- Do not duplicate canonical field contracts in this file; `../cl-reso-link/docs/*` is authoritative.
