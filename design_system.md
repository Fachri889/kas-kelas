---
name: Claritas Class Ledger
colors:
  surface: '#f8f9ff'
  surface-dim: '#cbdbf5'
  surface-bright: '#f8f9ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#eff4ff'
  surface-container: '#e5eeff'
  surface-container-high: '#dce9ff'
  surface-container-highest: '#d3e4fe'
  on-surface: '#0b1c30'
  on-surface-variant: '#434655'
  inverse-surface: '#213145'
  inverse-on-surface: '#eaf1ff'
  outline: '#737686'
  outline-variant: '#c3c6d7'
  surface-tint: '#0053db'
  primary: '#004ac6'
  on-primary: '#ffffff'
  primary-container: '#2563eb'
  on-primary-container: '#eeefff'
  inverse-primary: '#b4c5ff'
  secondary: '#006e2f'
  on-secondary: '#ffffff'
  secondary-container: '#6bff8f'
  on-secondary-container: '#007432'
  tertiary: '#735c00'
  on-tertiary: '#ffffff'
  tertiary-container: '#cea700'
  on-tertiary-container: '#4e3d00'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#dbe1ff'
  primary-fixed-dim: '#b4c5ff'
  on-primary-fixed: '#00174b'
  on-primary-fixed-variant: '#003ea8'
  secondary-fixed: '#6bff8f'
  secondary-fixed-dim: '#4ae176'
  on-secondary-fixed: '#002109'
  on-secondary-fixed-variant: '#005321'
  tertiary-fixed: '#ffe083'
  tertiary-fixed-dim: '#eec200'
  on-tertiary-fixed: '#231b00'
  on-tertiary-fixed-variant: '#574500'
  background: '#f8f9ff'
  on-background: '#0b1c30'
  surface-variant: '#d3e4fe'
typography:
  display-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 36px
    fontWeight: '700'
    lineHeight: 44px
    letterSpacing: -0.02em
  display-lg-mobile:
    fontFamily: Plus Jakarta Sans
    fontSize: 28px
    fontWeight: '700'
    lineHeight: 36px
    letterSpacing: -0.01em
  headline-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
    letterSpacing: -0.01em
  headline-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
  headline-sm:
    fontFamily: Plus Jakarta Sans
    fontSize: 16px
    fontWeight: '600'
    lineHeight: 24px
  body-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  body-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  body-sm:
    fontFamily: Plus Jakarta Sans
    fontSize: 12px
    fontWeight: '400'
    lineHeight: 18px
  label-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 14px
    fontWeight: '600'
    lineHeight: 20px
  label-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 12px
    fontWeight: '600'
    lineHeight: 16px
    letterSpacing: 0.01em
  label-sm:
    fontFamily: Plus Jakarta Sans
    fontSize: 11px
    fontWeight: '700'
    lineHeight: 14px
    letterSpacing: 0.04em
  currency-stat:
    fontFamily: Plus Jakarta Sans
    fontSize: 30px
    fontWeight: '700'
    lineHeight: 38px
    letterSpacing: -0.02em
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  gutter: 1.5rem
  gutter-mobile: 1rem
  margin: 2rem
  margin-mobile: 1rem
  space-xs: 0.25rem
  space-sm: 0.5rem
  space-md: 1rem
  space-lg: 1.5rem
  space-xl: 2rem
---

## Brand & Style

This design system establishes a focused, reassuring, and intuitive SaaS financial environment tailored for modern educational institutions, class treasurers, teachers, and student representatives. The emotional target is immediate financial clarity, institutional trust, and effortless accountability.

### Design Movement
The design movement is **Clean Modern SaaS** blended with accessible educational utility:
- **Calm, High-Information Density:** Financial ledgers, student rosters, and fee breakdowns are legible without feeling cluttered.
- **Visual Reassurance:** Cash inflows, outgoing expenses, and overdue obligations are immediately distinguishable using disciplined, semantic color cues.
- **Friendly Professionalism:** Soft architectural radii and crisp borders prevent the interface from feeling rigid or intimidating for student operators, while preserving fiscal seriousness for auditing parents and faculty.

## Colors

The color palette centers on functional readability, high contrast compliance (WCAG AA/AAA), and clear financial semantics.

### Palette Architecture
- **Primary (`#2563EB` / Primary Dark `#1D4ED8` / Primary Light `#DBEAFE`):** Represents structural authority, actions, active navigation states, and primary transactional triggers.
- **Secondary (`#22C55E` / Secondary Light `#DCFCE7`):** Dedicated to positive financial health, incoming funds, verified deposits, and the `Lunas` (Fully Paid) badge.
- **Accent / Warning (`#FACC15` / Tint `#FEF9C3`):** Applied strictly to pending transactions, partial payments (`Sebagian`), and verification alerts.
- **Destructive / Danger (`#EF4444` / Tint `#FEE2E2`):** Communicates arrears, cash outflows, operational expenses, and overdue student dues (`Belum Lunas`).
- **Surfaces & Neutral Base:**
  - Canvas Background: `#F8FAFC` (Slate-50)
  - Card & Surface: `#FFFFFF`
  - High Container / Hover Surface: `#F1F5F9` (Slate-100)
  - Border & Dividers: `#E2E8F0` (Slate-200)
  - Text Primary: `#0F172A` (Slate-900)
  - Text Muted: `#64748B` (Slate-500)

Never use saturated status colors for decorative purposes. Colors strictly indicate transactional state, navigation focus, or data delta.

## Typography

**Plus Jakarta Sans** provides a contemporary geometric presence with humanist warmth, ensuring that numbers, acronyms, and transactional lists remain legible across high-density desktop dashboards and mobile ledger views.

### Typographic Rules
- **Numerical Alignment:** All ledger amounts, balance summaries, and tabular currency values must use tabular numerals (`font-variant-numeric: tabular-nums`) to maintain vertical alignment of Indonesian Rupiah figures (`Rp 50.000`).
- **Hierarchy Separation:** Section titles rely on weight (`600` or `700`) rather than dramatic size spikes, maintaining compact administrative control.
- **Labels & Micro-copy:** Badge text, metadata timestamps, and table headers adopt uppercase tracking (`letter-spacing: 0.04em`) at `11px` to `12px` sizes using `label-sm` and `label-md`.

## Layout & Spacing

The design system implements a **fluid grid anchored by a persistent structural sidebar layout**.

### Grid & Breakpoints
- **Desktop (≥1200px):** Fixed 260px vertical sidebar with an expanding, fluid 12-column content container. Max-width constraint of 1440px on primary workspace. Gutters sit at `1.5rem` (24px) with `2rem` (32px) margins.
- **Tablet (768px – 1199px):** Collapsible 72px icon-only sidebar. 8-column fluid grid with `1.25rem` (20px) gutters and `1.5rem` (24px) margins.
- **Mobile (<768px):** Collapsible bottom bar or drawer navigation. Single-column stacked cards with `1rem` (16px) margins and gutters.

### Spacing Architecture
- Use `space-xs` (4px) and `space-sm` (8px) for internal element stacking (icon-to-text, label-to-input gap).
- Use `space-md` (16px) for interior card padding, table cell vertical paddings, and button horizontal insets.
- Use `space-lg` (24px) for major card container paddings and grouping separated widget modules.
- Use `space-xl` (32px) strictly between distinct dashboard panels (e.g., metric cards to ledger table).

## Elevation & Depth

Visual hierarchy uses **tonal layer separation combined with diffused, low-opacity ambient shadows**. Heavy drop shadows are strictly prohibited to maintain SaaS clarity.

### Depth Tiers
1. **Canvas (Base - Level 0):** `#F8FAFC`. The foundational canvas across all screens.
2. **Surface Resting (Level 1 - Cards, Table Containers):** `#FFFFFF` paired with an outline of `1px solid #E2E8F0` and an ambient shadow: `0 1px 3px 0 rgba(15, 23, 42, 0.05), 0 1px 2px -1px rgba(15, 23, 42, 0.05)`.
3. **Interactive Hover (Level 2 - Card Elevate, Floating Action Rows):** `#FFFFFF` with `0 10px 15px -3px rgba(15, 23, 42, 0.07), 0 4px 6px -4px rgba(15, 23, 42, 0.05)` and border shifting to `#CBD5E1`.
4. **Overlays & Modals (Level 3 - Transaction Dialogs, Student Detail Sheets):** `#FFFFFF` framed by `0 20px 25px -5px rgba(15, 23, 42, 0.1), 0 8px 10px -6px rgba(15, 23, 42, 0.08)` over an overlay backdrop tinted with `rgba(15, 23, 42, 0.45)`.
5. **Inner Depressed Tiers (Search bars, Form Fields):** Flat `#FFFFFF` or `#F1F5F9` framed with crisp 1px borders without inner drop-shadows.

## Shapes

The interface embraces a **balanced, modern SaaS roundedness profile (`roundedness: 2`)**.

### Shape Implementation Rules
- **Cards & Modules:** Explicitly set to `16px` (`rounded-2xl` in typical CSS frameworks) to evoke a friendly, contemporary aesthetic.
- **Action Buttons & Form Controls:** Set to `10px` to `12px` (`rounded-xl`), creating comfortable touch points that match card interior radiuses.
- **Status Badges & Avatar Containers:** Strictly pill-shaped (`rounded-full` / `9999px`) to create distinction between actionable controls and informative tags.
- **Nested Corners:** When an element is placed inside a 16px card with 16px padding, nested interactive zones utilize an 8px to 10px radius to preserve concentric geometry.

## Components

### Buttons
- **Primary:** Solid `#2563EB`, text `#FFFFFF`, radius `12px`, padding `10px 20px`. Hover: `#1D4ED8`. Focus: `0 0 0 3px #DBEAFE`.
- **Secondary / Ghost:** Background `#F1F5F9`, text `#0F172A`, border `1px solid #E2E8F0`. Hover: `#E2E8F0`.
- **Destructive:** Background `#EF4444`, text `#FFFFFF`. Hover: `#DC2626`. Focus ring: `#FEE2E2`.

### Status Badges (Pills)
Full-pill (`rounded-full`), padding `4px 12px`, typography `label-sm`, uppercase:
- **Lunas (Paid):** Background `#DCFCE7`, text `#15803D` (Secondary Green).
- **Belum Lunas (Unpaid / Arrears):** Background `#FEE2E2`, text `#B91C1C` (Danger Red).
- **Sebagian (Partial / Pending):** Background `#FEF9C3`, text `#A16207` (Amber / Yellow).

### Financial Data Tables
- **Header:** Background `#F8FAFC`, height `44px`, text `label-md` `#64748B`, uppercase tracking, border-bottom `1px solid #E2E8F0`.
- **Rows:** Height `56px`, background `#FFFFFF`, alternating hover transition to `#F8FAFC`. Subtle horizontal divider `1px solid #F1F5F9`.
- **Numeric Columns:** Right-aligned, `font-variant-numeric: tabular-nums`, bold weight for totals. Currency prefix (`Rp`) formatted with muted color `#64748B`.

### Form Inputs & Selects
- Height `44px`, radius `10px`, border `1px solid #E2E8F0`, background `#FFFFFF`, text `body-md` `#0F172A`.
- Placeholder: `#94A3B8`.
- Focus state: Border `#2563EB`, ring `0 0 0 3px #DBEAFE`.

### Cards & Metric Tiles
- Background `#FFFFFF`, radius `16px`, border `1px solid #E2E8F0`, padding `20px` to `24px`.
- Metric layout: Header with muted label + category icon in a soft tinted circle (`40px`), large `currency-stat` value, footer with percentage trend or micro-status label.

### Navigation Sidebar
- Vertical container background `#FFFFFF`, border-right `1px solid #E2E8F0`.
- Nav Items: Height `44px`, radius `10px`, gap `12px`, text `label-lg` `#64748B`.
- Active Nav State: Background `#DBEAFE`, text `#1D4ED8`, leading icon `#2563EB` with an optional 3px vertical accent pill on the container edge.
