# Listing Card Spec

Location: `cl-listing-collection/listing-card/`  
Scope: Shared listing card UI layer for listing collections, carousel views, and future home search reuse.  
Authority: Canonical field contract is owned by `cl-reso-link/docs/*`.

---

## 1) Data Contract

### Canonical Inputs
- `address.display` (optional; hidden when missing)
- `market.price` (optional; hidden when missing)
- `media.primary_photo` (optional; placeholder when missing)

### Required Context Input (Non-Data Field)
- `link_url`

Rules:
- Card MUST receive a resolved URL from the parent plugin.
- Card MUST return empty output when `link_url` is missing/empty.
- Card MUST NOT construct, infer, or modify URLs.
- Card MUST NOT use URL fallbacks.
- Entire card MUST be wrapped with this URL.

### Optional Inputs
- `structure.beds`
- `structure.baths`
- `structure.sqft`
- `market.status` (future use only; not rendered in current card)

### Contract Rules
- Card MUST consume canonical fields exactly as provided.
- Card MUST NOT derive, compute, normalize, or infer values.
- Card MUST NOT introduce new fields.
- Card MUST NOT apply numeric or string formatting logic.
- Missing fields are hidden unless explicitly defined otherwise in this spec.

---

## 2) Canonical Card Layout

Single layout only, rendered in this order:

1. Image container  
2. Price  
3. Address (single line)  
4. Attributes row (`beds`, `baths`, `sqft`)  

Layout rules:
- Layout structure MUST remain consistent regardless of missing optional fields.
- Only attribute visibility may change; hierarchy MUST NOT shift.

---

## 3) Image Rules

- Aspect ratio: `4:3` (canonical fixed ratio)
- Media behavior: image fills container with `object-fit: cover`
- Source field: `media.primary_photo` only

### Image Field Shape
- `media.primary_photo` MUST resolve to a usable image URL string
- Card MUST NOT parse nested image objects
- Any normalization MUST occur in `cl-reso-link`

### Placeholder
- If image is missing:
  - render a neutral static placeholder
  - MUST use shared class: `.cl-card-image--placeholder`
  - MUST match 4:3 aspect ratio
  - MUST NOT include text or icons

- No image URL derivation or fallback source selection

---

## 4) Price Rules

- Source field: `market.price` only
- Price MUST be rendered as:
  - `$` + raw numeric value
- If missing, the price row is hidden.
- No helpers, locale formatting, abbreviation, rounding, or transformations

---

## 5) Address Rules

- Source field: `address.display` only
- Render as a single line
- If missing, the address row is hidden.
- No splitting, reconstruction, or secondary composition

---

## 6) Attributes Row Rules

Allowed fields:
- `structure.beds`
- `structure.baths`
- `structure.sqft`

Display rules:
- Attribute order MUST be:
  1. beds
  2. baths
  3. sqft

- Render only fields that exist
- Hide missing fields entirely
- No placeholders

### Attribute Formatting Rules
- Values MUST be rendered as raw values only
- No unit suffixes (e.g., "sqft", "bd", "ba")
- No computed labels or derived values

---

## 7) Interaction Model

- Entire card is one clickable link
- No nested interactive elements
- Link behavior is controlled by parent plugin

---

## 8) CSS Structure

Required reusable class names:

- `.cl-listing-card`
- `.cl-card-image`
- `.cl-card-image--placeholder`
- `.cl-card-price`
- `.cl-card-address`
- `.cl-card-attributes`

CSS rules:
- No plugin-specific class leakage in shared card markup
- Styles MUST be reusable across contexts
- Styles MUST NOT depend on container/grid/carousel layout

---

## 9) SSR Requirements

- Card MUST render fully server-side
- Card MUST NOT initiate data fetching
- JS is NOT required for initial display
- JS may add progressive enhancement later (e.g. hover, lazy loading)

---

## 10) Future Hooks (Documented Only)

Reserved extension points (not implemented):

- Status badge using `market.status`
- Card variants: `horizontal`, `compact`
- Optional formatting layer (future only, if approved)

---

## 11) Non-Goals

- No implementation code
- No schema expansion
- No UI-layer data fallback behavior
- No UI-layer business/data logic
