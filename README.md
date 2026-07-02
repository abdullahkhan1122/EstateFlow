# EstateFlow

EstateFlow is a professional real-estate discovery and listing management platform built with Laravel. It combines a polished public property website, client account features, staff inventory management, lead tracking, and a RAG-powered property assistant that helps visitors find suitable homes.

## Overview

EstateFlow is designed for agencies, property teams, and real-estate businesses that need a complete web presence with operational tools behind it. Visitors can browse listings, search by location and property details, view property pages, save homes, request viewings, and contact listing teams. Staff users can manage inventory, agents, inquiries, and viewing requests from a secured dashboard.

## Core Features

- Public homepage with hero search, featured listings, city/type browsing, sale and rental sections, open houses, and recently reduced listings
- Property catalog with keyword, city, area, type, sale/rent, price, bedroom, bathroom, furnishing, amenity, featured, open-house, price-drop, and sorting filters
- Property detail pages with image galleries, pricing, location, amenities, agent information, payment or move-in estimate, viewing requests, and inquiry forms
- Client accounts for saved properties, saved searches, viewing request history, and recently viewed listings
- Staff dashboard for property metrics, new leads, pending viewings, and recent listing activity
- Admin property management with rich listing fields, image upload/URL support, publishing status, open-house data, virtual tour links, amenities, and price history tracking
- Agent management with role-based access for admins and assigned listing control for agents
- Lead center for public property inquiries and viewing requests
- JSON property API for listing and detail data
- Bottom-right EstateFlow Assistant with retrieval-grounded guidance, property recommendations, and direct property detail links

## EstateFlow Assistant

The built-in assistant is available on public-facing pages as a bottom-right chat widget. It uses a retrieval-augmented workflow so answers are grounded in public EstateFlow information and published listings.

It helps visitors:

- Ask how the website works
- Find properties by city, budget, listing type, home type, and bedrooms
- Receive direct links to matching property detail pages from the live catalog
- Understand saved homes, viewing requests, and inquiry workflows
- Discover featured homes, rentals, and sale listings

The assistant is scoped to real-estate and EstateFlow usage only. It retrieves published listing data and public workflow guidance, sends only that safe context to Gemini, rejects unrelated or sensitive prompts, and never exposes credentials, server configuration, private user data, database structure, or admin-only records.

## User Roles

EstateFlow supports three primary role types:

- Clients: browse listings, save homes, save searches, request viewings, and manage account activity
- Agents: manage assigned listings and view assigned leads
- Admins: manage properties, agents, leads, and platform inventory

Public staff registration is disabled. Client registration is available through the account flow, while staff accounts are managed by administrators.

## Technology Stack

- Laravel 10
- PHP 8.1+
- MySQL
- Blade templates
- Laravel Breeze authentication
- Tailwind CSS
- Alpine.js
- Vite
- Eloquent ORM
- Gemini API for the retrieval-grounded assistant
- PHPUnit feature tests

## Main Pages

- `/` - Public homepage
- `/properties` - Property search and listing catalog
- `/properties/{slug}` - Property detail page
- `/account/register` - Client registration
- `/buyer/dashboard` - Client saved activity
- `/login` - Client login
- `/admin/login` - Staff login
- `/dashboard` - Staff dashboard
- `/admin/properties` - Property management
- `/admin/agents` - Agent management
- `/admin/leads` - Inquiries and viewing requests

## API Endpoints

### List Properties

```http
GET /api/properties
```

Supports filtering by search, property type, listing type, city, price range, and bedrooms.

### Show Property

```http
GET /api/properties/{slug}
```

Returns property details, pricing, images, location data, and listing agent information.

## Local Setup

Create a local `.env` file from `.env.example`, configure the database values for your environment, then run:

```bash
composer install
npm install
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
npm run build
php artisan serve
```

To enable the assistant, add a Gemini API key to the local `.env` file:

```env
GEMINI_API_KEY=your-local-key
GEMINI_MODEL=gemini-flash-latest
```

Keep production keys in environment variables or deployment secrets. Do not commit API keys, database credentials, or staff credentials to the repository.

For development with live asset rebuilding:

```bash
npm run dev
```

## Testing

Run the automated test suite with:

```bash
php artisan test
```

The tests cover public property browsing, filtering, client workflows, viewing requests, property inquiries, staff authorization, admin property management, agent management, API responses, authentication, and the EstateFlow Assistant guardrails.

## Project Structure

- `app/Http/Controllers` - Public, client, admin, API, auth, and assistant controllers
- `app/Models` - Users, properties, images, saved searches, favorites, inquiries, leads, viewings, and settings
- `app/Services` - Retrieval-grounded assistant services and application-level support logic
- `resources/views` - Blade templates and reusable UI components
- `resources/js` - Alpine.js and browser interaction logic
- `resources/css` - Tailwind CSS entry point and base styling
- `routes/web.php` - Public, client, staff, and chatbot routes
- `routes/api.php` - JSON API routes
- `database/migrations` - Database schema
- `database/seeders` - Demo data for local development
- `tests/Feature` - End-to-end feature coverage

## Quality Notes

EstateFlow uses role-based access control, form request validation, route model binding, Eloquent relationships, seeded demo records, responsive Blade views, assistant prompt guardrails, and automated tests to keep the application reliable and maintainable.
