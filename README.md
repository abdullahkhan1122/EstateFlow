# EstateFlow

EstateFlow is a Laravel 10 real-estate listing and administration platform built as a professional portfolio project. It includes a professional public website, advanced property search, map-style listing mode, property comparison, buyer accounts, saved searches, favourites, viewing requests, CRM-ready inquiry tracking, agent profiles, a secure staff dashboard, admin and agent roles, property CRUD, image galleries, filtering, pagination, JSON API endpoints, validation, policies, seed data, and feature tests.

## Stack

- Laravel 10 on PHP 8.1
- Laravel Breeze with Blade templates
- Tailwind CSS, Alpine.js, and Vite
- MySQL with Eloquent ORM
- Form Requests, Policies, API Resources, factories, seeders, and PHPUnit tests

## User-Facing Features

- Public homepage with featured real-estate listings
- Professional homepage with search, featured listings, latest listings, city/type sections, sale/rental sections, reduced listings, open houses, agent highlights, CTA, and footer contact details
- Advanced property catalog with keyword, reference number, city, area/neighbourhood, type, sale/rent, price, bedrooms, bathrooms, area, amenities, furnishing, featured, open-house, recently-added, price-reduced, sorting, pagination, active chips, and clear-all filters
- Desktop filter sidebar, mobile filter drawer, grid/list/map-style result views, result count, URL-preserved filters, and saved-search support
- Different image galleries for seeded demo properties
- Save-to-shortlist interaction stored in the visitor's browser
- Logged-in buyer favourites stored in MySQL
- Property comparison for two to four listings
- Property detail pages with image thumbnails, feature tags, amenities, location details, map coordinates, video-tour link, virtual-tour link, print brochure action, agent contact information, and payment or move-in estimate calculator
- Public inquiry form that stores buyer or renter leads in MySQL with CRM metadata and activity history
- Viewing-request workflow for in-person or virtual viewing requests
- Public agent profile pages with biography, contact details, languages, specialities, service areas, office information, and active listings

## Buyer Account Features

- Buyer registration at `/buyer/register`
- Buyer dashboard at `/buyer/dashboard`
- Saved properties
- Saved searches
- Viewing request history
- Recently viewed listings
- Profile and password management through Breeze

## Admin Features

- Secure Breeze authentication with public registration disabled
- Admin dashboard with listing metrics and recent inventory
- Admin property CRUD with validation, publishing status, featured listings, image URL support, and image upload support
- Admin agent management
- Agent role access limited to assigned properties
- Price-history records when listing prices change
- Professional property fields including reference number, area, neighbourhood, amenities, furnishing status, year built, coordinates, open-house dates, reduced-price flag, availability, video URL, virtual-tour URL, approval status, internal notes, and listing expiry fields
- Settings table for configurable contact, social, SEO, and business details

## Local Configuration

The application is configured for:

- Database: `estate_flow`
- Username: `root`
- Password: `admin123`

The seeded staff accounts are:

- Admin: `admin@estateflow.test` / `password`
- Agent: `nora@estateflow.test` / `password`
- Agent: `evan@estateflow.test` / `password`
- Agent: `lena@estateflow.test` / `password`
- Buyer: `buyer@estateflow.test` / `password`

Public staff registration is disabled. Buyers can register through the buyer registration page, while staff users are created by admins.

## Main URLs

- Public home: `/`
- Public properties: `/properties`
- Property comparison: `/properties/compare/list`
- Buyer registration: `/buyer/register`
- Buyer dashboard: `/buyer/dashboard`
- Staff login: `/login`
- Dashboard: `/dashboard`
- Admin properties: `/admin/properties`
- Admin agents: `/admin/agents`

## Stored Data

EstateFlow stores users, properties, property images, favourites, saved searches, property views, comparisons, viewing requests, notification preferences, price histories, password reset tokens, API tokens, failed jobs, settings, lead sources, property inquiries, inquiry notes, inquiry activities, and inquiry tags in MySQL. Public inquiry submissions are saved in the `property_inquiries` table and linked to the selected property.

## API

All API responses are JSON and use Laravel pagination metadata where applicable.

### List Properties

`GET /api/properties`

Supported query parameters:

- `search`: title, address, or city search
- `reference_number`: listing reference search
- `type`: `House`, `Apartment`, `Condo`, `Townhome`, `Studio`, `Land`
- `listing_type`: `For Sale` or `For Rent`
- `city`: exact city match
- `area`: area or neighbourhood search
- `min_price`: minimum price
- `max_price`: maximum price
- `bedrooms`: minimum bedrooms
- `bathrooms`: minimum bathrooms
- `min_area`: minimum square footage
- `furnishing_status`: furnishing filter
- `featured`: featured listings
- `open_house`: listings with open-house dates
- `price_reduced`: recently reduced listings
- `recently_added`: listings published in the last 14 days
- `amenities[]`: amenity filters

Example:

```http
GET /api/properties?city=Austin&listing_type=For%20Sale
```

### Show Property

`GET /api/properties/{slug}`

Example:

```http
GET /api/properties/cedar-ridge-family-home
```

Response fields include property details, pricing, location, features, agent contact details, and image URLs.

## Development Commands

```bash
composer install
npm install
php artisan migrate:fresh --seed
php artisan storage:link
npm run build
php artisan test
./vendor/bin/pint
php artisan serve
```

## Features Covered By Tests

- Public homepage and property filtering
- Buyer dashboard favourites
- Property comparison session handling
- Viewing request storage
- Public registration disabled
- Admin property creation and image recording
- Public inquiry storage
- Agent authorization boundaries
- Admin agent creation
- JSON API listing and detail endpoints
- Breeze login, password reset, profile, and verification flows
