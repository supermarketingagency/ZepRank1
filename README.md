# ZEPRANK — AI-Powered Google Review Management SaaS

ZEPRANK is a comprehensive B2B SaaS platform designed for businesses to collect, manage, and grow their Google reviews effortlessly. It combines Artificial Intelligence, QR technology, and smart reputation protection to build a 5-star online presence.

## 🚀 Key Features

- **Multi-AI Engine**: Powered by GPT-4, Gemini, and Groq for authentic review generation.
- **Frictionless Review Flow**: 4-step mobile journey (Scan -> Rate -> Review -> Post) in under 30 seconds.
- **Reputation Protection**: Automatically intercepts negative ratings and routes them to a private inbox.
- **Manual Web Sync**: Fetch business profile data from Google Maps URLs to personalize AI drafts.
- **Multi-Role Dashboards**: Specific views for Admins, Business Owners, GMB Managers, and Agencies.
- **White-Label Reseller System**: Rebrand the platform with your own domain, logo, and colors.
- **Shared Hosting Optimized**: Built specifically for environments like Hostinger (MySQL, Database Queues).

## 🛠 Installation Guide

ZEPRANK includes a web-based installation wizard to simplify deployment.

1. **Upload Files**: Upload the entire repository to your public_html or subfolder.
2. **Set Permissions**: Ensure `storage` and `bootstrap/cache` are writable (775).
3. **Database**: Create a MySQL database and user in your hosting panel.
4. **Run Installer**: Visit `https://yourdomain.com/install` in your browser.
5. **Follow Steps**:
   - **Step 1**: Environment checks (PHP 8.2+, Extensions).
   - **Step 2**: Database credentials.
   - **Step 3**: App name and URL configuration.
   - **Step 4**: Finalize (runs migrations and seeds initial data).

## 🧑‍💻 Technical Stack

- **Backend**: Laravel 11, PHP 8.2+
- **Frontend**: Blade, Tailwind CSS, Alpine.js
- **Database**: MySQL 8.0
- **AI Integration**: OpenAI, Google Gemini, Groq, Mistral, Anthropic Claude
- **Payments**: Razorpay
- **Auth**: Laravel Breeze + Socialite (Google OAuth)

## 🛡 Security

- **Data Isolation**: Multi-tenant scoping ensures users only see their own business data.
- **Encryption**: Sensitive data (API keys, private feedback) is encrypted at rest.
- **Access Control**: Mandatory 2FA for Admin and Reseller roles.

## 📄 License

Proprietary License - © 2026 ZEPRANK SaaS India.
