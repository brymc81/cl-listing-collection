# CL Listing Collection — Agent Notes

## Documentation Scope
- Plugin-specific implementation guidance only.
- Authoritative API contract details are maintained in `../cl-reso-link/docs/*`.

## Boundaries

- Consumer only. No MLS normalization logic.
- No direct MLS access. Use `/api/properties/search` on the local WordPress site via `wp_remote_get()`.
- Do not modify `cl-reso-link` or `cl-listing-router` from this plugin.

## Rendering

- SSR is the baseline. No JS slider library usage.
- Use canonical fields only:
  `listing_id`, `address.display`, `market.list_price`, `market.close_price`,
  `structure.bedrooms_total`, `structure.bathrooms_total`, `structure.building_area_total`, `media.primary`.
