# Database Schema Documentation

This document provides a complete overview of the Local First Portal database schema, including all tables, columns, relationships, and indexes.

## Table of Contents

- [Core System Tables](#core-system-tables)
- [User Management](#user-management)
- [Location Management](#location-management)
- [Business & Commerce](#business--commerce)
- [Gaming System](#gaming-system)
- [Content Management](#content-management)

---

## Core System Tables

### Cache Tables

#### `cache`
Laravel's cache storage table for application caching.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `key` | string | **Primary Key** | Cache key identifier |
| `value` | mediumText | - | Cached data content |
| `expiration` | integer | - | Cache expiration timestamp |

#### `cache_locks`
Laravel's cache lock storage for distributed locking.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `key` | string | **Primary Key** | Lock key identifier |
| `owner` | string | - | Lock owner identifier |
| `expiration` | integer | - | Lock expiration timestamp |

### Queue System Tables

#### `jobs`
Laravel's job queue storage for background processing.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | bigint | **Primary Key, Auto Increment** | Unique job identifier |
| `queue` | string | **Index** | Queue name for job processing |
| `payload` | longText | - | Serialized job data |
| `attempts` | unsignedTinyInteger | - | Number of processing attempts |
| `reserved_at` | unsignedInteger | **Nullable** | When job was reserved for processing |
| `available_at` | unsignedInteger | - | When job becomes available for processing |
| `created_at` | unsignedInteger | - | Job creation timestamp |

#### `job_batches`
Laravel's job batch storage for grouped job processing.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | string | **Primary Key** | Batch identifier |
| `name` | string | - | Batch name |
| `total_jobs` | integer | - | Total number of jobs in batch |
| `pending_jobs` | integer | - | Number of pending jobs |
| `failed_jobs` | integer | - | Number of failed jobs |
| `failed_job_ids` | longText | - | JSON array of failed job IDs |
| `options` | mediumText | **Nullable** | Batch configuration options |
| `cancelled_at` | integer | **Nullable** | When batch was cancelled |
| `created_at` | integer | - | Batch creation timestamp |
| `finished_at` | integer | **Nullable** | When batch completed |

#### `failed_jobs`
Laravel's failed job storage for debugging and retry.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | bigint | **Primary Key, Auto Increment** | Unique failed job identifier |
| `uuid` | string | **Unique** | Job UUID |
| `connection` | text | - | Database connection used |
| `queue` | text | - | Queue name |
| `payload` | longText | - | Serialized job data |
| `exception` | longText | - | Exception details |
| `failed_at` | timestamp | **Default: CURRENT_TIMESTAMP** | When job failed |

---

## User Management

### `users`
Core user accounts for the platform.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | bigint | **Primary Key, Auto Increment** | Unique user identifier |
| `name` | string | - | User's full name |
| `email` | string | **Unique, Nullable** | User's email address |
| `phone` | string(20) | **Nullable** | User's phone number |
| `address` | string | **Nullable** | User's address (legacy field) |
| `zip_code` | string | **Nullable** | User's zip code (legacy field) |
| `city` | string | **Nullable** | User's city (legacy field) |
| `state` | string | **Nullable** | User's state (legacy field) |
| `country` | string | **Nullable** | User's country (legacy field) |
| `email_verified_at` | timestamp | **Nullable** | Email verification timestamp |
| `role` | enum | **Default: 'user'** | User role: 'user', 'vendor', 'admin' |
| `password` | string | **Nullable** | Hashed password |
| `remember_token` | string | **Nullable** | Remember me token |
| `deleted_at` | timestamp | **Nullable** | Soft delete timestamp |
| `created_at` | timestamp | **Nullable** | Account creation timestamp |
| `updated_at` | timestamp | **Nullable** | Last update timestamp |

**Note:** Legacy address fields will be replaced with proper location relationships in future updates.

### `password_reset_tokens`
Password reset token storage.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `email` | string | **Primary Key** | User's email address |
| `token` | string | - | Password reset token |
| `created_at` | timestamp | **Nullable** | Token creation timestamp |

### `sessions`
User session storage.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | string | **Primary Key** | Session identifier |
| `user_id` | bigint | **Nullable, Index, Foreign Key** | Associated user ID |
| `ip_address` | string(45) | **Nullable** | User's IP address |
| `user_agent` | text | **Nullable** | User's browser/device info |
| `payload` | longText | - | Session data |
| `last_activity` | integer | **Index** | Last activity timestamp |

**Foreign Key:** `user_id` → `users.id`

---

## Location Management

### `countries`
World countries with ISO codes and currency information.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | bigint | **Primary Key, Auto Increment** | Unique country identifier |
| `name` | string | - | Country name |
| `code` | string(2) | **Unique** | ISO 2-letter country code |
| `phone_code` | string | **Nullable** | International phone code |
| `currency` | string | **Nullable** | Country currency code |
| `currency_symbol` | string | **Nullable** | Currency symbol |
| `deleted_at` | timestamp | **Nullable** | Soft delete timestamp |
| `created_at` | timestamp | **Nullable** | Creation timestamp |
| `updated_at` | timestamp | **Nullable** | Last update timestamp |

### `states`
States/provinces within countries.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | bigint | **Primary Key, Auto Increment** | Unique state identifier |
| `name` | string | - | State/province name |
| `code` | string(10) | **Nullable** | State code |
| `country_id` | bigint | **Foreign Key, Index** | Associated country ID |
| `deleted_at` | timestamp | **Nullable** | Soft delete timestamp |
| `created_at` | timestamp | **Nullable** | Creation timestamp |
| `updated_at` | timestamp | **Nullable** | Last update timestamp |

**Foreign Key:** `country_id` → `countries.id` (CASCADE DELETE)
**Indexes:** `country_id`, `name`
**Unique Constraint:** `(country_id, name)`

### `cities`
Cities within states.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | bigint | **Primary Key, Auto Increment** | Unique city identifier |
| `name` | string | - | City name |
| `code` | string(10) | **Nullable** | City code |
| `state_id` | bigint | **Foreign Key, Index** | Associated state ID |
| `deleted_at` | timestamp | **Nullable** | Soft delete timestamp |
| `created_at` | timestamp | **Nullable** | Creation timestamp |
| `updated_at` | timestamp | **Nullable** | Last update timestamp |

**Foreign Key:** `state_id` → `states.id` (CASCADE DELETE)
**Indexes:** `state_id`, `name`
**Unique Constraint:** `(state_id, name)`

---

## Business & Commerce

### `vendors`
Local business profiles and vendor information.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | bigint | **Primary Key, Auto Increment** | Unique vendor identifier |
| `name` | string | - | Business name |
| `description` | text | **Nullable** | Business description |
| `logo` | string | **Nullable** | Business logo image path |
| `website` | string | **Nullable** | Business website URL |
| `contact_email` | string | **Nullable** | Contact email address |
| `contact_phone` | string | **Nullable** | Contact phone number |
| `business_type` | string | **Nullable** | Type of business |
| `city_id` | bigint | **Nullable, Foreign Key** | Business location city |
| `address` | string | **Nullable** | Business address |
| `verified` | boolean | **Default: false** | Vendor verification status |
| `deleted_at` | timestamp | **Nullable** | Soft delete timestamp |
| `created_at` | timestamp | **Nullable** | Creation timestamp |
| `updated_at` | timestamp | **Nullable** | Last update timestamp |

**Foreign Key:** `city_id` → `cities.id` (SET NULL ON DELETE)

### `categories`
Hierarchical product categorization system.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | bigint | **Primary Key, Auto Increment** | Unique category identifier |
| `name` | string | - | Category name |
| `parent_id` | bigint | **Nullable, Foreign Key** | Parent category ID for hierarchy |
| `deleted_at` | timestamp | **Nullable** | Soft delete timestamp |
| `created_at` | timestamp | **Nullable** | Creation timestamp |
| `updated_at` | timestamp | **Nullable** | Last update timestamp |

**Foreign Key:** `parent_id` → `categories.id` (NULL ON DELETE)

### `brands`
Product brands with origin country tracking.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | bigint | **Primary Key, Auto Increment** | Unique brand identifier |
| `name` | string | - | Brand name |
| `description` | text | **Nullable** | Brand description |
| `logo` | string | **Nullable** | Brand logo image path |
| `country_id` | bigint | **Nullable, Foreign Key** | Brand's country of origin |
| `deleted_at` | timestamp | **Nullable** | Soft delete timestamp |
| `created_at` | timestamp | **Nullable** | Creation timestamp |
| `updated_at` | timestamp | **Nullable** | Last update timestamp |

**Foreign Key:** `country_id` → `countries.id` (NULL ON DELETE)

### `products`
Product catalog with local/foreign classification.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | bigint | **Primary Key, Auto Increment** | Unique product identifier |
| `name` | string | - | Product name |
| `description` | text | **Nullable** | Product description |
| `price` | decimal(10,2) | - | Product price |
| `image` | string | **Nullable** | Product image path |
| `category_id` | bigint | **Foreign Key** | Product category |
| `brand_id` | bigint | **Foreign Key** | Product brand |
| `vendor_id` | bigint | **Foreign Key** | Product vendor |
| `is_swadeshi` | boolean | **Default: true** | Whether product is local/Indian |
| `deleted_at` | timestamp | **Nullable** | Soft delete timestamp |
| `created_at` | timestamp | **Nullable** | Creation timestamp |
| `updated_at` | timestamp | **Nullable** | Last update timestamp |

**Foreign Keys:**
- `category_id` → `categories.id` (CASCADE DELETE)
- `brand_id` → `brands.id` (CASCADE DELETE)
- `vendor_id` → `vendors.id` (CASCADE DELETE)

### `product_alternatives`
Mapping of foreign products to local alternatives.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | bigint | **Primary Key, Auto Increment** | Unique alternative identifier |
| `product_id` | bigint | **Foreign Key** | Original product ID |
| `name` | string | - | Alternative product name |
| `description` | text | **Nullable** | Alternative product description |
| `price` | decimal(10,2) | **Nullable** | Alternative product price |
| `image` | string | **Nullable** | Alternative product image |
| `deleted_at` | timestamp | **Nullable** | Soft delete timestamp |
| `created_at` | timestamp | **Nullable** | Creation timestamp |
| `updated_at` | timestamp | **Nullable** | Last update timestamp |

**Foreign Key:** `product_id` → `products.id` (CASCADE DELETE)

---

## Gaming System

### `games`
Game definitions and configuration.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | bigint | **Primary Key, Auto Increment** | Unique game identifier |
| `name` | string | - | Game name |
| `description` | text | **Nullable** | Game description |
| `image` | string | **Nullable** | Game image path |
| `total_questions` | integer | **Nullable** | Number of questions per game (null = all) |
| `per_question_time` | integer | **Nullable** | Time limit per question in seconds |
| `allow_replay` | boolean | **Default: true** | Whether users can replay the game |
| `show_correct_answers` | boolean | **Default: true** | Show correct answers after quiz |
| `is_active` | boolean | **Default: true** | Whether game is active and playable |
| `max_attempts` | integer | **Nullable** | Maximum attempts per user (null = unlimited) |
| `certificate_template` | json | **Nullable** | Certificate template configuration |
| `deleted_at` | timestamp | **Nullable** | Soft delete timestamp |
| `created_at` | timestamp | **Nullable** | Creation timestamp |
| `updated_at` | timestamp | **Nullable** | Last update timestamp |

### `game_questions`
Quiz questions for games.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | bigint | **Primary Key, Auto Increment** | Unique question identifier |
| `game_id` | bigint | **Foreign Key** | Associated game ID |
| `question` | text | - | Question text |
| `type` | string | **Default: 'mcq'** | Question type: 'mcq', 'multi_select', 'true_false' |
| `difficulty` | string | **Nullable** | Question difficulty: 'easy', 'medium', 'hard' |
| `points` | integer | **Default: 10** | Points awarded for correct answer |
| `deleted_at` | timestamp | **Nullable** | Soft delete timestamp |
| `created_at` | timestamp | **Nullable** | Creation timestamp |
| `updated_at` | timestamp | **Nullable** | Last update timestamp |

**Foreign Key:** `game_id` → `games.id` (CASCADE DELETE)

### `game_options`
Answer options for quiz questions with polymorphic relationships.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | bigint | **Primary Key, Auto Increment** | Unique option identifier |
| `question_id` | bigint | **Foreign Key** | Associated question ID |
| `option_text` | string | **Nullable** | Fallback text for display |
| `optionable_id` | bigint | **Nullable** | Polymorphic relation ID |
| `optionable_type` | string | **Nullable** | Polymorphic relation type |
| `is_correct` | boolean | **Default: false** | Whether this option is correct |
| `sort_order` | integer | **Nullable** | Display order for options |
| `deleted_at` | timestamp | **Nullable** | Soft delete timestamp |
| `created_at` | timestamp | **Nullable** | Creation timestamp |
| `updated_at` | timestamp | **Nullable** | Last update timestamp |

**Foreign Key:** `question_id` → `game_questions.id` (CASCADE DELETE)
**Polymorphic Relations:** Can link to `products`, `brands`, etc.

### `game_results`
User game performance and results tracking.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | bigint | **Primary Key, Auto Increment** | Unique result identifier |
| `user_id` | bigint | **Foreign Key** | User who played the game |
| `game_id` | bigint | **Foreign Key** | Game that was played |
| `score` | integer | - | User's score |
| `total_points` | integer | **Default: 0** | Total points earned |
| `max_possible_points` | integer | **Default: 0** | Maximum possible points |
| `correct_answers` | integer | **Default: 0** | Number of correct answers |
| `incorrect_answers` | integer | **Default: 0** | Number of incorrect answers |
| `time_taken` | integer | **Nullable** | Total time taken in seconds |
| `accuracy_percentage` | decimal(5,2) | **Default: 0** | Accuracy percentage |
| `attempt_number` | integer | **Default: 1** | Attempt number for this user and game |
| `certificate_id` | string | **Nullable** | Unique certificate identifier |
| `certificate_generated_at` | timestamp | **Nullable** | Certificate generation timestamp |
| `question_details` | json | **Nullable** | Detailed question-by-question breakdown |
| `performance_metrics` | json | **Nullable** | Additional performance metrics |
| `device_info` | string | **Nullable** | Device/browser information |
| `ip_address` | string | **Nullable** | IP address for analytics |
| `total_questions` | integer | - | Total number of questions |
| `answers` | json | **Nullable** | User's answers |
| `deleted_at` | timestamp | **Nullable** | Soft delete timestamp |
| `created_at` | timestamp | **Nullable** | Creation timestamp |
| `updated_at` | timestamp | **Nullable** | Last update timestamp |

**Foreign Keys:**
- `user_id` → `users.id` (CASCADE DELETE)
- `game_id` → `games.id` (CASCADE DELETE)

### `game_result_questions`
Detailed question-level results for analytics.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | bigint | **Primary Key, Auto Increment** | Unique result question identifier |
| `game_result_id` | bigint | **Foreign Key, Index** | Associated game result ID |
| `question_id` | bigint | **Foreign Key, Index** | Associated question ID |
| `question_text` | string | - | Question text at time of answering |
| `points` | unsignedInteger | **Default: 0** | Points for this question |
| `is_correct` | boolean | **Default: false** | Whether answer was correct |
| `earned_points` | unsignedInteger | **Default: 0** | Points earned for this question |
| `time_taken` | unsignedInteger | **Default: 0** | Time taken for this question |
| `created_at` | timestamp | **Nullable** | Creation timestamp |
| `updated_at` | timestamp | **Nullable** | Last update timestamp |

**Foreign Keys:**
- `game_result_id` → `game_results.id` (CASCADE DELETE)
- `question_id` → `game_questions.id`

**Indexes:** `game_result_id`, `question_id`

### `game_result_answers`
Detailed answer-level results for analytics.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | bigint | **Primary Key, Auto Increment** | Unique result answer identifier |
| `game_result_question_id` | bigint | **Foreign Key, Index** | Associated result question ID |
| `option_id` | bigint | **Foreign Key, Index** | Associated option ID |
| `option_text` | string | - | Option text at time of answering |
| `is_correct_option` | boolean | **Default: false** | Whether this option was correct |
| `selected` | boolean | **Default: false** | Whether user selected this option |
| `created_at` | timestamp | **Nullable** | Creation timestamp |
| `updated_at` | timestamp | **Nullable** | Last update timestamp |

**Foreign Keys:**
- `game_result_question_id` → `game_result_questions.id` (CASCADE DELETE)
- `option_id` → `game_options.id`

**Indexes:** `game_result_question_id`, `option_id`

---

## Content Management

### `pledges`
User commitments to support local products.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | bigint | **Primary Key, Auto Increment** | Unique pledge identifier |
| `user_id` | bigint | **Foreign Key** | User making the pledge |
| `pledge_text` | text | - | Pledge commitment text |
| `status` | enum | **Default: 'pending'** | Pledge status: 'pending', 'approved', 'rejected' |
| `admin_notes` | text | **Nullable** | Admin review notes |
| `deleted_at` | timestamp | **Nullable** | Soft delete timestamp |
| `created_at` | timestamp | **Nullable** | Creation timestamp |
| `updated_at` | timestamp | **Nullable** | Last update timestamp |

**Foreign Key:** `user_id` → `users.id` (CASCADE DELETE)

### `articles`
Educational content and awareness blogs.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | bigint | **Primary Key, Auto Increment** | Unique article identifier |
| `title` | string | - | Article title |
| `content` | text | - | Article content |
| `image` | string | **Nullable** | Article featured image |
| `is_featured` | boolean | **Default: false** | Whether article is featured |
| `deleted_at` | timestamp | **Nullable** | Soft delete timestamp |
| `created_at` | timestamp | **Nullable** | Creation timestamp |
| `updated_at` | timestamp | **Nullable** | Last update timestamp |

---

## Database Relationships Summary

### One-to-Many Relationships
- **Country → States** (1:N)
- **State → Cities** (1:N)
- **City → Vendors** (1:N)
- **Category → Products** (1:N) + **Self-referencing** (parent/child categories)
- **Brand → Products** (1:N)
- **Vendor → Products** (1:N)
- **Product → Product Alternatives** (1:N)
- **Game → Game Questions** (1:N)
- **Game Question → Game Options** (1:N)
- **User → Game Results** (1:N)
- **User → Pledges** (1:N)
- **Game → Game Results** (1:N)
- **Game Result → Game Result Questions** (1:N)
- **Game Result Question → Game Result Answers** (1:N)

### Polymorphic Relationships
- **Game Options** can link to various entities (Products, Brands, etc.)

### Key Features
- **Soft Deletes**: Most tables support soft deletion
- **Cascade Deletes**: Proper referential integrity for related data
- **Indexing**: Strategic indexes on foreign keys and frequently queried columns
- **JSON Fields**: Flexible storage for complex data (certificates, metrics, etc.)
- **Timestamps**: Standard Laravel timestamps on all tables

---

## Migration Order Dependencies

1. **Core System**: `users`, `cache`, `jobs` (Laravel defaults)
2. **Location**: `countries` → `states` → `cities`
3. **Business**: `categories`, `vendors`, `brands`
4. **Commerce**: `products`, `product_alternatives`
5. **Gaming**: `games` → `game_questions` → `game_options`
6. **Content**: `pledges`, `articles`
7. **Analytics**: `game_results` → `game_result_questions` → `game_result_answers`

This schema supports a comprehensive local-first platform with user management, location services, business listings, interactive gaming, and content management capabilities.
