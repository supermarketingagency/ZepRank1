# Changelog

All notable changes to the **ZEPRANK** platform will be documented in this file.

## [1.0.0] - 2026-03-13

### Added
- **Multi-Tenant Architecture**: Robust data isolation using Laravel Global Scopes and `current_business_id` context.
- **Frictionless Review Flow**: A 4-step mobile-first journey (`/r/{slug}`) for customers to rate and review without login.
- **Reputation Protection**: Smart routing that directs positive ratings to Google and negative ratings to a private feedback inbox.
- **AI Intelligence Factory**: Multi-provider support (Groq, OpenAI, Gemini, Claude, Mistral) for generating human-sounding review drafts.
- **Manual Web Sync**: Ability to fetch (simulated) business profile data from public Google Maps URLs to tailor AI drafts.
- **Web Installation Wizard**: 4-step installer for shared hosting (Environment Check, DB Setup, App Config, Finalization).
- **Multi-Role Dashboards**: Specific interfaces for Admins, Business Owners, GMB Managers, Agencies, and Resellers.
- **Creative Hub**: Generation of branded festive posters and social media scheduling.
- **White-Label Support**: Custom domain and branding support for resellers.

### Fixed
- **N+1 Queries**: Optimized performance in Dashboard and Review Log by eager loading relationships.
- **Migration Conflicts**: Consolidated schema changes to ensure reliable deployment on both MySQL and SQLite.
- **Security**: Mandatory 2FA for Admins and Resellers; encrypted storage for all API keys and feedback.
- **Installer Handling**: Robust `.env` file updating with character escaping.

### Improved
- **User Experience**: Google Material Design 3 inspired UI with responsive mobile navigation.
- **Test Suite**: 47 feature tests with 124 assertions covering all critical application paths.
