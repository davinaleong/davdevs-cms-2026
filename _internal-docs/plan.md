# 🚀 PHASE 0 — Foundation (Don’t skip this)

**Goal: Set up a stable base you won’t regret later**

### ✅ Project Setup

* [ ] Initialize Laravel project
* [ ] Configure UUIDs globally (models + migrations)
* [ ] Set up environment (DB, mail, queue)
* [ ] Install auth starter (Laravel Breeze or Fortify)

### ✅ Core Architecture Decisions

* [ ] Decide: REST or GraphQL (you can start REST)
* [ ] Define post types enum (`project`, `tool`, `joke`, etc.)
* [ ] Decide JSON structure for `post_blocks`

---

# 🧱 PHASE 1 — Core CMS Engine

**Goal: You can create and render content**

### ✅ Database

* [ ] Create `posts` table
* [ ] Create `post_meta` table (SEO)
* [ ] Create `post_blocks` table (structured content)
* [ ] Add indexes (slug, type, status)

### ✅ Models

* [ ] Post model (UUID, relationships)
* [ ] PostMeta model
* [ ] PostBlock model

### ✅ Admin CRUD (Basic)

* [ ] Create post (title, type, slug)
* [ ] Edit post
* [ ] Delete post
* [ ] Publish/unpublish toggle

---

# 🎨 PHASE 2 — Blade Rendering System

**Goal: Your portfolio is fully powered by CMS**

### ✅ Routing

* [ ] `/posts/{slug}` route
* [ ] Controller to fetch post + blocks + meta

### ✅ Dynamic Rendering

* [ ] Create `posts/{type}.blade.php`
* [ ] Implement block renderer:

  * [ ] `@include("blocks.{type}")`
* [ ] Build base layout (SEO-ready)

### ✅ SEO Metadata

* [ ] Meta title + description
* [ ] Open Graph tags
* [ ] Canonical URL support

---

# 🧩 PHASE 3 — Post Type Systems

**Goal: Match your portfolio structure**

---

## 🧑‍💻 Projects

* [ ] Define blocks:

  * [ ] hero
  * [ ] problem
  * [ ] solution
  * [ ] tech_stack
  * [ ] gallery
* [ ] Build Blade components for each block

---

## 🛠 Tools (React Integration)

* [ ] Create `tools` table (component name, bundle path)
* [ ] Blade container for hydration
* [ ] Load React component dynamically
* [ ] Ensure standalone rendering works

---

## 😂 Jokes System

* [ ] Create `jokes` table
* [ ] Add fields:

  * [ ] type (statement / qa)
  * [ ] question
  * [ ] answer

### Logic

* [ ] Statement → render immediately
* [ ] Q/A → delayed reveal (JS)

### API

* [ ] `/api/jokes/random`

---

# ❤️ PHASE 4 — Engagement Features

### ✅ Likes

* [ ] Create `likes` table
* [ ] Like/unlike toggle endpoint
* [ ] Store count on post (optional cache)
* [ ] UI button (Livewire or JS)

---

# 👤 PHASE 5 — User System

### ✅ Authentication

* [ ] Register
* [ ] Login
* [ ] Email verification

### ✅ Notifications

* [ ] Notify users on new posts
* [ ] Queue email sending

---

# 🔐 PHASE 6 — Security (Critical)

---

## 👥 Admin Auth (Separate Guard)

* [ ] Create `admins` table
* [ ] Configure guard
* [ ] Seeder:

  * [ ] Default admin account
  * [ ] Force password change

---

## 🔒 2FA (User + Admin)

* [ ] Enable 2FA setup flow
* [ ] QR code generation
* [ ] Verify OTP flow

### Recovery Codes

* [ ] Generate backup codes
* [ ] Store hashed
* [ ] “Copy all” button
* [ ] Download as `.txt`

---

# 🔍 PHASE 7 — SEO & Crawlers

* [ ] Auto sitemap generator
* [ ] robots.txt config
* [ ] Structured data (JSON-LD)
* [ ] Slug uniqueness validation

---

# 🔌 PHASE 8 — Headless Mode

### API

* [ ] `/api/posts`
* [ ] `/api/posts/{slug}`
* [ ] `/api/posts?type=project`

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

* [ ] Feature tests for:

  * [ ] Post CRUD
  * [ ] Auth
  * [ ] Likes
* [ ] Unit tests for models
* [ ] API tests

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
