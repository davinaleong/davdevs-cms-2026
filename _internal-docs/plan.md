# 🚀 MASTER BUILD PLAN (SPLIT: BACKEND vs FRONTEND)

---

# ⚙️ BACKEND — Laravel (Headless CMS + Engine)

---

# 🟩 PHASE B1 — Foundation

**Goal:** Solid API base

### Setup

* [ ] Install Laravel (latest)
* [ ] Configure DB + `.env`
* [ ] Enable UUIDs (BaseModel)

### Architecture

* [ ] Folder structure:

  * `Services/`
  * `Actions/`
  * `DTOs/` (optional but nice)
* [ ] API routes (`routes/api.php`)
* [ ] API response format (standardised JSON)

---

# 🟦 PHASE B2 — Content Core

**Goal:** Replace MD files with DB content

---

## Database

* [ ] `post_types`

  * id (UUID)
  * name
  * slug
  * default_is_premium (bool)

* [ ] `posts`

  * id (UUID)
  * post_type_id
  * title
  * slug
  * excerpt
  * content_md
  * status
  * published_at

---

## Models

* [ ] Post → belongsTo PostType
* [ ] Accessor:

  * `$post->is_premium`

---

## API

* [ ] `GET /posts`
* [ ] `GET /posts/{slug}`
* [ ] `GET /post-types`

---

## Seeder

* [ ] Seed post types:

  * blog (free)
  * devlog (premium)
  * deep-dive (premium)
  * testimony (free)

---

# 🟨 PHASE B3 — Engagement System

---

## 🧩 Voting

### DB

* [ ] `votes`

  * id
  * post_id
  * fingerprint_hash
  * vote_type

---

### API

* [ ] `POST /votes`

---

### Logic

* [ ] Hash(IP + UA)
* [ ] 1 vote / post / 24h
* [ ] Prevent duplicates

---

## 🧩 Reading Tracking

### DB

* [ ] `user_engagements`

  * id
  * user_id
  * metric_type (read, premium_read, upvote)
  * reference_id (post_id)

---

### API

* [ ] `POST /engagement/read`

---

### Logic

* [ ] Deduplicate reads
* [ ] Only count authenticated users

---

## 🧩 Comment Eligibility Engine

### Service

* [ ] `CommentEligibilityService`

---

### Rules

* [ ] upvotes ≥ 5
* [ ] OR premium_reads ≥ 3
* [ ] OR active subscription

---

### Optimization

* [ ] Cache eligibility result
* [ ] Recompute on events

---

# 🟥 PHASE B4 — Comments System

---

## DB

* [ ] `comments`

  * id
  * user_id
  * post_id
  * content
  * status (visible, hidden, flagged)

---

## API

* [ ] `GET /posts/{id}/comments`
* [ ] `POST /comments`

---

## Logic

* [ ] Only eligible users can comment
* [ ] Soft delete
* [ ] Basic moderation flags

---

# 🟪 PHASE B5 — Monetisation (Stripe)

---

## Stripe Setup

* [ ] Create products
* [ ] Create prices
* [ ] Store Stripe IDs

---

## DB

* [ ] `subscriptions`

  * user_id
  * stripe_id
  * status
  * current_period_end

---

## Webhooks

* [ ] checkout.session.completed
* [ ] customer.subscription.updated
* [ ] invoice.payment_failed

---

## API

* [ ] `GET /me/subscription`
* [ ] `POST /checkout/session`

---

## Logic

* [ ] `hasActiveSubscription()`
* [ ] Sync Stripe → DB

---

# 🟫 PHASE B6 — Auth (Sanctum)

---

## Setup

* [ ] Laravel Sanctum
* [ ] Cookie-based auth

---

## Features

* [ ] Register
* [ ] Login
* [ ] Logout
* [ ] `/me` endpoint

---

---

# 🟩 PHASE B7 — Admin Panel (Laravel Only)

---

## Features

* [ ] Create/edit posts (Markdown editor)
* [ ] Assign post type
* [ ] Publish/unpublish

---

## Optional

* [ ] Engagement stats
* [ ] Comment moderation

---

# 🟦 PHASE B8 — Security & Performance

---

## Security

* [ ] Rate limiting (votes, engagement)
* [ ] Validate all inputs
* [ ] Sanitize Markdown

---

## Performance

* [ ] Cache posts
* [ ] Cache eligibility
* [ ] Queue webhooks

---

---

# 🎨 FRONTEND — Next.js (Your Existing Site)

---

# 🟩 PHASE F1 — API Integration

---

## Replace MD Loader

* [ ] Remove local MD file fetching
* [ ] Fetch from Laravel API

---

## Data Fetching

* [ ] `getStaticProps` / `generateStaticParams`
* [ ] ISR setup (revalidation)

---

## Pages

* [ ] `/posts`
* [ ] `/posts/[slug]`

---

---

# 🟦 PHASE F2 — Content Rendering

---

## Markdown

* [ ] Render MD → HTML (remark/rehype)

---

## SEO

* [ ] Meta tags from API
* [ ] OG tags preserved

---

---

# 🟨 PHASE F3 — Paywall UI

---

## Logic

* [ ] Fetch `/me/subscription`

---

## Behaviour

* [ ] If premium + not subscribed:

  * show preview only

---

## UI

* [ ] “Unlock full post”
* [ ] Clean paywall section

---

---

# 🟧 PHASE F4 — Voting UI

---

## Features

* [ ] Upvote button
* [ ] Downvote button
* [ ] Optimistic UI update

---

## API

* [ ] Call `/votes`

---

## UX

* [ ] Disable after vote
* [ ] Show count

---

---

# 🟥 PHASE F5 — Reading Detection

---

## Logic

* [ ] Track:

  * time ≥ 15s
  * scroll ≥ 50–80%

---

## Trigger

* [ ] Call `/engagement/read`

---

## Safeguards

* [ ] Send once per post
* [ ] Silent background call

---

---

# 🟪 PHASE F6 — Comments UI

---

## Display

* [ ] Fetch comments
* [ ] Show list

---

## Input

* [ ] Comment form

---

## Eligibility

* [ ] Fetch eligibility status
* [ ] Show:

  * unlocked → form
  * locked → progress UI

---

## UX

* [ ] “Unlock by engaging 💛”
* [ ] Progress indicators

---

---

# 🟫 PHASE F7 — Auth Integration

---

## Features

* [ ] Login/register UI
* [ ] Persist session (cookies)

---

## API

* [ ] `/login`
* [ ] `/me`

---

---

# 🟦 PHASE F8 — Stripe Checkout Flow

---

## UI

* [ ] Pricing page
* [ ] Subscribe button

---

## Flow

* [ ] Call `/checkout/session`
* [ ] Redirect to Stripe
* [ ] Return success page

---

---

# 🟩 PHASE F9 — Polish & UX

---

## States

* [ ] Loading states
* [ ] Empty states
* [ ] Error states

---

## Messaging

* [ ] Friendly paywall copy
* [ ] Engagement encouragement

---

---

# 🔄 MIGRATION PLAN (CRITICAL)

---

## Step 1 — Extract MD Files

* [ ] Parse `.md`
* [ ] Extract:

  * title
  * slug
  * content
  * metadata

---

## Step 2 — Insert into DB

* [ ] Map to posts table
* [ ] Assign post types

---

## Step 3 — Switch Frontend

* [ ] Replace MD loader → API
* [ ] Test SEO

---

---

# 🎯 BUILD ORDER (FASTEST PATH TO VALUE)

If you want momentum:

---

## Week 1

* Backend: Content API + post types
* Frontend: Fetch + render posts

---

## Week 2

* Paywall + Stripe
* Premium content gating

---

## Week 3

* Voting + reading detection
* Engagement system

---

## Week 4

* Comments + eligibility
* Polish + launch

---

---

# ❤️ FINAL SYSTEM

You’re building:

### 🧠 Headless CMS

* Clean, structured, scalable

### 💰 Monetised Content Platform

* Subscription-based
* Premium gating

### 💛 Healthy Community System

* Earned engagement
* No toxic free-for-all comments

---

# ⚖️ Final Thought

This is no longer:

> “a blog upgrade”

This is:

> **your personal creator platform with full control**
