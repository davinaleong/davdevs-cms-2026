# 🎨 GLOBAL UI FOUNDATION (Do this once)

**Applies to Website + CMS Panel + User Panel**

### ✅ Typography Setup

* [ ] Install **Montserrat** (primary UI font)

* [ ] Install **Playfair Display** (headings / accents)

* [ ] Install **Source Code Pro** (code / tools)

* [ ] Configure Tailwind:

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

* [ ] Extend Tailwind config with:

  * [ ] Blue spectrum (`blue-50 → blue-900`)
  * [ ] Slate spectrum (`slate-50 → slate-900`)
* [ ] Do NOT override defaults
* [ ] Define semantic aliases:

  * [ ] `primary` → blue
  * [ ] `neutral` → slate

---

### ✅ Shared UI System

* [ ] Base layout (`layouts/app.blade.php`)
* [ ] Typography classes (prose, headings)
* [ ] Buttons (primary, secondary, danger)
* [ ] Form components (input, textarea, select)
* [ ] Card component
* [ ] Badge / tag component
* [ ] Alert / toast system

---

# 🌐 PART 1 — WEBSITE (PORT FROM ASTRO → BLADE)

**Goal: Pixel-consistent migration. NO redesign.**

---

## 🧱 Phase 1 — Layout Porting

* [ ] Identify all Astro layouts:

  * [ ] Main layout
  * [ ] Blog/project layout
  * [ ] Tool layout
* [ ] Convert to Blade layouts:

  * [ ] `layouts/app.blade.php`
  * [ ] `layouts/post.blade.php`
* [ ] Port:

  * [ ] Header
  * [ ] Footer
  * [ ] Navigation

---

## 📄 Phase 2 — Page Template Porting

* [ ] Home page
* [ ] About page
* [ ] Projects listing
* [ ] Project detail
* [ ] Tools listing
* [ ] Tool detail
* [ ] Jokes page
* [ ] Contact page

👉 Each should:

* [ ] Match Astro structure exactly
* [ ] Replace static content with Blade variables

---

## 🧩 Phase 3 — Component Porting

* [ ] Cards (projects/tools)
* [ ] Hero sections
* [ ] Section headers
* [ ] CTA blocks
* [ ] Lists / grids

👉 Convert Astro components → Blade partials:

```blade
@include('components.card', [...])
```

---

## 🧠 Phase 4 — Dynamic Data Injection

* [ ] Replace static content with:

  * [ ] `$post`
  * [ ] `$posts`
* [ ] Loop through collections
* [ ] Bind slugs to routes

---

## 🔍 Phase 5 — SEO Layer

* [ ] Inject meta dynamically
* [ ] OG tags
* [ ] Canonical tags

---

## 😂 Phase 6 — Jokes UI

* [ ] Statement UI
* [ ] Q/A UI:

  * [ ] Show question first
  * [ ] Delay reveal answer
* [ ] “Refresh joke” button
* [ ] Premium lock state UI

---

## 🛠 Phase 7 — Tools UI (React Islands)

* [ ] Blade placeholder container
* [ ] Pass props via `data-*`
* [ ] Hydrate React component
* [ ] Fallback UI if JS disabled

---

## ❤️ Phase 8 — Engagement UI

* [ ] Like button (toggle state)
* [ ] Like count display
* [ ] Auth-required state

---

## 🔐 Phase 9 — Auth UI (Frontend)

* [ ] Login page
* [ ] Register page
* [ ] Email verification page
* [ ] 2FA challenge screen

---

# 🧑‍💼 PART 2 — CMS PANEL (Admin Only)

**Goal: Functional, fast, clean. Not pretty-first.**

---

## 🔐 Phase 1 — Admin Auth UI

* [ ] Admin login page
* [ ] Force password change screen
* [ ] 2FA setup UI:

  * [ ] QR code display
  * [ ] OTP input

---

## 📊 Phase 2 — Dashboard

* [ ] Stats cards:

  * [ ] Total posts
  * [ ] Drafts
  * [ ] Users
* [ ] Recent activity list

---

## 📝 Phase 3 — Post Management UI

### Listing

* [ ] Table view:

  * [ ] Title
  * [ ] Type
  * [ ] Status
  * [ ] Published date
* [ ] Filters:

  * [ ] By type
  * [ ] By status

---

### Create/Edit Post

* [ ] Title input
* [ ] Slug input (auto-generate)
* [ ] Post type selector
* [ ] Status toggle

---

## 🧩 Phase 4 — Block Editor UI

* [ ] Add block button
* [ ] Select block type
* [ ] Dynamic form per block
* [ ] Reorder blocks (drag/drop or up/down)
* [ ] Delete block

---

## 🔍 Phase 5 — SEO UI

* [ ] Meta title input
* [ ] Meta description textarea
* [ ] OG image upload
* [ ] Canonical URL

---

## 🛠 Phase 6 — Tool Management UI

* [ ] Select React component
* [ ] Upload / define bundle path
* [ ] Preview tool

---

## 😂 Phase 7 — Joke Management UI

* [ ] Select type:

  * [ ] Statement
  * [ ] Q/A
* [ ] Conditional fields:

  * [ ] Question
  * [ ] Answer

---

## 👥 Phase 8 — User Management

* [ ] View users list
* [ ] View user details
* [ ] Toggle premium status

---

## 🔒 Phase 9 — Security UI

* [ ] Admin 2FA management
* [ ] Regenerate recovery codes
* [ ] Copy all button

---

# 👤 PART 3 — USER PANEL

**Goal: Lightweight, useful, monetisation-ready**

---

## 🔐 Phase 1 — Auth UI

* [ ] Register
* [ ] Login
* [ ] Email verification
* [ ] Password reset

---

## 🏠 Phase 2 — User Dashboard

* [ ] Welcome message
* [ ] Subscription status
* [ ] Recent activity

---

## ❤️ Phase 3 — User Engagement

* [ ] Liked posts list
* [ ] Saved/favourite posts (optional)

---

## 💰 Phase 4 — Subscription UI

* [ ] Plan display (Free vs Pro)
* [ ] Upgrade button
* [ ] Payment flow (future-ready)

---

## 🔁 Phase 5 — Premium Features UI

* [ ] Unlock “Refresh Joke”
* [ ] Locked tool UI state
* [ ] Premium badge display

---

## 🔐 Phase 6 — 2FA UI

* [ ] Enable 2FA flow
* [ ] Show QR code
* [ ] Enter OTP
* [ ] Recovery codes:

  * [ ] Copy all
  * [ ] Download

---

## ⚙️ Phase 7 — Account Settings

* [ ] Update email
* [ ] Change password
* [ ] Manage 2FA
* [ ] Notification preferences

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
