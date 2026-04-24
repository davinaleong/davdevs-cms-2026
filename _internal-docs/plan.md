# 🚀 PHASE 0 — Foundation (Don’t skip this)

## Progress Log

- [x] Iteration 1 (2026-04-24): API scaffolding with Sanctum, UUID base model strategy, core CMS schema/models, post API CRUD, Blade post rendering, and passing Pest tests for API + web routes.
- [x] Iteration 2 (2026-04-24): Implemented Projects block templates (hero/problem/solution/tech_stack/gallery), Tools domain + hydration container pipeline, Jokes system (table, logic, random API, web page), and added passing Pest coverage.
- [x] Iteration 3 (2026-04-24): Implemented Likes engagement system (likes table, authenticated toggle endpoint, post like count in API, JS UI button + guest state) with passing Pest coverage.
- [x] Iteration 4 (2026-04-24): Implemented Phase 5 auth API (register/login/logout/me), email verification flow, and queued new-post notifications to verified users with passing Pest coverage.
- [x] Iteration 5 (2026-04-24): Implemented Phase 6 admin auth foundation with separate admin provider/guard, admins table, default admin seeder, and force-password-change API with passing Pest coverage.
- [x] Iteration 6 (2026-04-24): Hardened API authorization with reusable `admin` middleware and protected admin endpoints plus post write routes, with updated passing Pest coverage.
- [x] Iteration 7 (2026-04-24): Implemented user/admin 2FA setup + OTP verification APIs with otpauth QR URI payloads, encrypted secret storage, hashed recovery code storage, and expanded passing Pest coverage.
- [x] Iteration 8 (2026-04-24): Implemented 2FA recovery-code verification fallback, regeneration endpoints with copy-ready text payloads, and `.txt` download endpoints for users/admins with expanded passing Pest coverage.
- [x] Iteration 9 (2026-04-24): Completed website/admin/user UI execution with unified Blade layouts, full web route wiring, admin CRUD screens, account settings/auth pages (including password reset UI), Tailwind theme updates, and passing Pest suite.

**Goal: Set up a stable base you won’t regret later**

### ✅ Project Setup

* [x] Initialize Laravel project
* [x] Configure UUIDs globally (models + migrations)
* [x] Set up environment (DB, mail, queue)
* [ ] Install auth starter (Laravel Breeze or Fortify)

### ✅ Core Architecture Decisions

* [x] Decide: REST or GraphQL (you can start REST)
* [x] Define post types enum (`project`, `tool`, `joke`, etc.)
* [x] Decide JSON structure for `post_blocks`

---

# 🧱 PHASE 1 — Core CMS Engine

**Goal: You can create and render content**

### ✅ Database

* [x] Create `posts` table
* [x] Create `post_meta` table (SEO)
* [x] Create `post_blocks` table (structured content)
* [x] Add indexes (slug, type, status)

### ✅ Models

* [x] Post model (UUID, relationships)
* [x] PostMeta model
* [x] PostBlock model

### ✅ Admin CRUD (Basic)

* [x] Create post (title, type, slug)
* [x] Edit post
* [x] Delete post
* [x] Publish/unpublish toggle

---

# 🎨 PHASE 2 — Blade Rendering System

**Goal: Your portfolio is fully powered by CMS**

### ✅ Routing

* [x] `/posts/{slug}` route
* [x] Controller to fetch post + blocks + meta

### ✅ Dynamic Rendering

* [x] Create `posts/{type}.blade.php`
* [x] Implement block renderer:

  * [x] `@include("blocks.{type}")`
* [x] Build base layout (SEO-ready)

### ✅ SEO Metadata

* [x] Meta title + description
* [x] Open Graph tags
* [x] Canonical URL support

---

# 🧩 PHASE 3 — Post Type Systems

**Goal: Match your portfolio structure**

---

## 🧑‍💻 Projects

* [x] Define blocks:

  * [x] hero
  * [x] problem
  * [x] solution
  * [x] tech_stack
  * [x] gallery
* [x] Build Blade components for each block

---

## 🛠 Tools (React Integration)

* [x] Create `tools` table (component name, bundle path)
* [x] Blade container for hydration
* [x] Load React component dynamically
* [x] Ensure standalone rendering works

---

## 😂 Jokes System

* [x] Create `jokes` table
* [x] Add fields:

  * [x] type (statement / qa)
  * [x] question
  * [x] answer

### Logic

* [x] Statement → render immediately
* [x] Q/A → delayed reveal (JS)

### API

* [x] `/api/jokes/random`

---

# ❤️ PHASE 4 — Engagement Features

### ✅ Likes

* [x] Create `likes` table
* [x] Like/unlike toggle endpoint
* [x] Store count on post (optional cache)
* [x] UI button (Livewire or JS)

---

# 👤 PHASE 5 — User System

### ✅ Authentication

* [x] Register
* [x] Login
* [x] Email verification

### ✅ Notifications

* [x] Notify users on new posts
* [x] Queue email sending

---

# 🔐 PHASE 6 — Security (Critical)

---

## 👥 Admin Auth (Separate Guard)

* [x] Create `admins` table
* [x] Configure guard
* [x] Seeder:

  * [x] Default admin account
  * [x] Force password change

---

## 🔒 2FA (User + Admin)

* [x] Enable 2FA setup flow
* [x] QR code generation
* [x] Verify OTP flow

### Recovery Codes

* [x] Generate backup codes
* [x] Store hashed
* [x] “Copy all” button
* [x] Download as `.txt`

---

# 🔍 PHASE 7 — SEO & Crawlers

* [ ] Auto sitemap generator
* [ ] robots.txt config
* [ ] Structured data (JSON-LD)
* [ ] Slug uniqueness validation

---

# 🔌 PHASE 8 — Headless Mode

### API

* [x] `/api/posts`
* [x] `/api/posts/{slug}`
* [x] `/api/posts?type=project`

### Optional (Later)

* [ ] GraphQL schema
* [ ] Post + blocks query

---

# 💰 PHASE 9 — Monetisation Layer

---

## 🪙 Subscription System

* [ ] Create `subscriptions` table
* [ ] Plan enum (free, pro)
* [ ] Expiry handling

---

## 💡 Feature Gating

* [ ] Middleware for premium features
* [ ] Attach to routes (tools, refresh, etc.)

---

## 🎲 Jokes Monetisation

* [ ] Limit refresh for free users
* [ ] Unlimited refresh for premium

---

## 🛠 Tool Monetisation

* [ ] Mark tools as:

  * [ ] free
  * [ ] premium
* [ ] Restrict access

---

## 📩 Email Monetisation

* [ ] Weekly digest system
* [ ] Premium-only content emails

---

## 💼 Lead Generation

* [ ] “Hire me” CTA module
* [ ] Contact form (public + admin panel)

---

# ⚡ PHASE 10 — UX Enhancements

* [ ] Smooth loading states
* [ ] Skeleton loaders
* [ ] Toast notifications
* [ ] Copy-to-clipboard UX (2FA, codes)

---

# 🧠 PHASE 11 — Admin Panel (Upgrade)

* [ ] Block-based editor UI
* [ ] Drag-and-drop block ordering
* [ ] Preview before publish
* [ ] Draft autosave

---

# 🧪 PHASE 12 — Testing

* [x] Feature tests for:

  * [x] Post CRUD
  * [x] Auth
  * [x] Likes
* [ ] Unit tests for models
* [x] API tests

---

# 🚀 PHASE 13 — Deployment

* [ ] Production env config
* [ ] Queue worker setup
* [ ] Email service (Postmark, etc.)
* [ ] Domain + SSL
* [ ] Backup strategy

---

# 🧭 Suggested Build Order (Realistic)

If you want to *actually finish*:

1. Phase 0–2 (Core CMS + rendering)
2. Projects + Jokes
3. Admin panel basic
4. Auth + Likes
5. Tools (React)
6. 2FA
7. Monetisation

---

# ⚠️ Final Reality Check

If you try to:

> build everything at once → you’ll burn out

If you:

> ship Phase 1–3 first → you’ll already have a working CMS powering your portfolio
