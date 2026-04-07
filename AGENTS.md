# cl-listing-collection

## Purpose

Reusable listing components (carousel, cards, etc).

This plugin is a direct search consumer.

---

## Filtering Contract

Unlike cl-community-listings, this plugin does NOT use a local route.

It must translate canonical identity before calling search.

---

## Required Flow

1. Accept:
   community_key_input

2. Resolve:
   community_key

3. Resolve context:
   → obtain canonical slug

4. Build search params:

   community = {resolved_slug}

---

## Rules

- Never send `community_key` to search
- Never trust raw builder input as slug
- Always resolve via context layer
- Must support hyphenated slugs exactly

---

## Common Failure

If filtering works for single-word slugs but fails for hyphenated:

→ slug is not being resolved via context

---

## Rendering

Uses shared listing-card system.

No schema normalization allowed.

---

## Status

Aligned to canonical search contract