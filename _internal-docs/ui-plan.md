# 🎨 GLOBAL UI FOUNDATION (Do this once)

**Applies to Website + CMS Panel + User Panel**

### ✅ Typography Setup

* [x] Install **Montserrat** (primary UI font)

* [x] Install **Playfair Display** (headings / accents)

* [x] Install **Source Code Pro** (code / tools)

* [x] Configure Tailwind:

```js
theme: {
  extend: {
    fontFamily: {
      sans: ['Montserrat', 'sans-serif'],
      serif: ['Playfair Display', 'serif'],
      mono: ['Source Code Pro', 'monospace'],
    }
  }
}
```

---

### ✅ Brand Colours (Tailwind Extension — NOT override)

* [x] Extend Tailwind config with:

  * [x] Blue spectrum (`blue-50 → blue-900`)
  * [x] Slate spectrum (`slate-50 → slate-900`)
* [x] Do NOT override defaults
* [x] Define semantic aliases:

  * [x] `primary` → blue
  * [x] `neutral` → slate

---

### ✅ Shared UI System

* [x] Base layout (`layouts/app.blade.php`)
* [x] Typography classes (prose, headings)
* [x] Buttons (primary, secondary, danger)
* [x] Form components (input, textarea, select)
* [x] Card component
* [x] Badge / tag component
* [x] Alert / toast system

---

# 🌐 PART 1 — WEBSITE (PORT FROM ASTRO → BLADE)

**Goal: Pixel-consistent migration. NO redesign.**

---

## 🧱 Phase 1 — Layout Porting

* [x] Identify all Astro layouts:

  * [x] Main layout
  * [x] Blog/project layout
  * [x] Tool layout
* [x] Convert to Blade layouts:

  * [x] `layouts/app.blade.php`
  * [x] `layouts/post.blade.php`
* [x] Port:

  * [x] Header
  * [x] Footer
  * [x] Navigation

---

## 📄 Phase 2 — Page Template Porting

* [x] Home page
* [x] About page
* [x] Projects listing
* [x] Project detail
* [x] Tools listing
* [x] Tool detail
* [x] Jokes page
* [x] Contact page

👉 Each should:

* [x] Match Astro structure exactly
* [x] Replace static content with Blade variables

---

## 🧩 Phase 3 — Component Porting

* [x] Cards (projects/tools)
* [x] Hero sections
* [x] Section headers
* [x] CTA blocks
* [x] Lists / grids

👉 Convert Astro components → Blade partials:

```blade
@include('components.card', [...])
```

---

## 🧠 Phase 4 — Dynamic Data Injection

* [x] Replace static content with:

  * [x] `$post`
  * [x] `$posts`
* [x] Loop through collections
* [x] Bind slugs to routes

---

## 🔍 Phase 5 — SEO Layer

* [x] Inject meta dynamically
* [x] OG tags
* [x] Canonical tags

---

## 😂 Phase 6 — Jokes UI

* [x] Statement UI
* [x] Q/A UI:

  * [x] Show question first
  * [x] Delay reveal answer
* [x] “Refresh joke” button
* [x] Premium lock state UI

---

## 🛠 Phase 7 — Tools UI (React Islands)

* [x] Blade placeholder container
* [x] Pass props via `data-*`
* [x] Hydrate React component
* [x] Fallback UI if JS disabled

---

## ❤️ Phase 8 — Engagement UI

* [x] Like button (toggle state)
* [x] Like count display
* [x] Auth-required state

---

## 🔐 Phase 9 — Auth UI (Frontend)

* [x] Login page
* [x] Register page
* [x] Email verification page
* [x] 2FA challenge screen

---

# 🧑‍💼 PART 2 — CMS PANEL (Admin Only)

**Goal: Functional, fast, clean. Not pretty-first.**

---

## 🔐 Phase 1 — Admin Auth UI

* [x] Admin login page
* [x] Force password change screen
* [x] 2FA setup UI:

  * [x] QR code display
  * [x] OTP input

---

## 📊 Phase 2 — Dashboard

* [x] Stats cards:

  * [x] Total posts
  * [x] Drafts
  * [x] Users
* [x] Recent activity list

---

## 📝 Phase 3 — Post Management UI

### Listing

* [x] Table view:

  * [x] Title
  * [x] Type
  * [x] Status
  * [x] Published date
* [x] Filters:

  * [x] By type
  * [x] By status

---

### Create/Edit Post

* [x] Title input
* [x] Slug input (auto-generate)
* [x] Post type selector
* [x] Status toggle

---

## 🧩 Phase 4 — Block Editor UI

* [x] Add block button
* [x] Select block type
* [x] Dynamic form per block
* [x] Reorder blocks (drag/drop or up/down)
* [x] Delete block

---

## 🔍 Phase 5 — SEO UI

* [x] Meta title input
* [x] Meta description textarea
* [x] OG image upload
* [x] Canonical URL

---

## 🛠 Phase 6 — Tool Management UI

* [x] Select React component
* [x] Upload / define bundle path
* [x] Preview tool

---

## 😂 Phase 7 — Joke Management UI

* [x] Select type:

  * [x] Statement
  * [x] Q/A
* [x] Conditional fields:

  * [x] Question
  * [x] Answer

---

## 👥 Phase 8 — User Management

* [x] View users list
* [x] View user details
* [x] Toggle premium status

---

## 🔒 Phase 9 — Security UI

* [x] Admin 2FA management
* [x] Regenerate recovery codes
* [x] Copy all button

---

# 👤 PART 3 — USER PANEL

**Goal: Lightweight, useful, monetisation-ready**

---

## 🔐 Phase 1 — Auth UI

* [x] Register
* [x] Login
* [x] Email verification
* [x] Password reset

---

## 🏠 Phase 2 — User Dashboard

* [x] Welcome message
* [x] Subscription status
* [x] Recent activity

---

## ❤️ Phase 3 — User Engagement

* [x] Liked posts list
* [x] Saved/favourite posts (optional)

---

## 💰 Phase 4 — Subscription UI

* [x] Plan display (Free vs Pro)
* [x] Upgrade button
* [x] Payment flow (future-ready)

---

## 🔁 Phase 5 — Premium Features UI

* [x] Unlock “Refresh Joke”
* [x] Locked tool UI state
* [x] Premium badge display

---

## 🔐 Phase 6 — 2FA UI

* [x] Enable 2FA flow
* [x] Show QR code
* [x] Enter OTP
* [x] Recovery codes:

  * [x] Copy all
  * [x] Download

---

## ⚙️ Phase 7 — Account Settings

* [x] Update email
* [x] Change password
* [x] Manage 2FA
* [x] Notification preferences

---

# 🧭 Recommended Build Order (UI)

If you want momentum:

### Step 1

* Global UI foundation
* Website layout port

### Step 2

* Website pages (static → dynamic)

### Step 3

* CMS panel (basic CRUD)

### Step 4

* Block editor UI

### Step 5

* Auth UI + 2FA

### Step 6

* User panel

---

# ⚠️ Final Pushback (Important)

If you try to:

> “perfect the CMS panel UI”

You will stall.

👉 Your priority should be:

1. Website renders from CMS
2. You can create/edit posts

Everything else = iteration
