# TODO: Fix Admin Hamburger Menu

## Plan
- [x] Step 1: Add hamburger button & toggle JS to `views/admin/layout.php`
- [x] Step 2: Add responsive CSS & `.menu-toggle` styles to `assets/css/dashboard.css`

## Details
### Step 1: views/admin/layout.php
- Insert `<button class="menu-toggle">☰</button>` inside `top-header`.
- Add inline `<script>` before `</body>` to toggle `.sidebar-open` class and close on outside click.

### Step 2: assets/css/dashboard.css
- Add `.menu-toggle` default style (`display: none`).
- Add `@media (max-width: 768px)` to:
  - Show `.menu-toggle`.
  - Make `.sidebar` fixed, hidden off-canvas (`left: -260px`), slide in with `.sidebar-open`.
  - Reduce `.main-content` padding.

