# 🌍 Local First Portal

A platform that promotes **local products and services** while helping users reduce reliance on foreign goods.  
First showcased at **Fashion Anantaa Women Expo (Mahesana)**.

## 🚀 Features

- 🛍️ **Explore Local Products & Services** - Discover quality local alternatives
- 🔄 **Find Alternatives** - Get recommendations for foreign product substitutes  
- ✍️ **Take the Pledge** - Commit to supporting local economy with digital certificate
- 🎮 **Interactive Games** - Local vs foreign quiz and usage calculator
- 🏪 **Vendor Profiles** - Comprehensive listings for local businesses
- 📰 **Educational Content** - Articles and blogs to spread awareness

## 🏗️ Tech Stack

- **Backend**: Laravel 12.0 (PHP 8.2+)
- **Database**: MySQL 8.0+
- **Frontend**: Blade Templates
- **Assets**: Vite for modern build tooling
- **Future Ready**: Livewire
- **Admin Panel**: Filament

## 📂 Project Structure

```
local-first-portal/
├── app/
│   ├── Http/Controllers/     # Application controllers
│   ├── Models/              # Eloquent models
│   └── Providers/           # Service providers
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/            # Database seeders
├── resources/
│   ├── views/              # Blade templates
│   ├── css/                # Stylesheets
│   └── js/                 # JavaScript assets
├── routes/
│   ├── web.php             # Web routes
│   └── api.php             # API routes
├── public/                 # Public assets
├── storage/                # File storage
├── docs/                   # Documentation
└── README.md              # This file
```

## 🗄️ Database Schema Overview

### Core Tables
- **users** → Platform users (admin, vendor, customer)
- **vendors** → Vendor business profiles and details
- **brands** → Product brands with origin country tracking
- **categories** → Hierarchical product categorization
- **products** → All products (distinguished by `product_type`)

### Location Management Tables
- **countries** → Countries with ISO codes and unique names
- **states** → States/provinces linked to countries with cascade delete
- **cities** → Cities linked to states with cascade delete

### Feature Tables
- **product_alternatives** → Maps foreign products to local alternatives
- **pledges** → User commitments to support local products
- **pledge_certificates** → Digital certificates for pledges
- **games** → Game definitions (quiz, calculator, etc.)
- **game_questions** → Quiz questions for events
- **game_results** → User scores and game performance
- **articles** → Educational content and awareness blogs

## ⚡ Quick Start

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & npm
- MySQL 8.0+

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/local-first-portal.git
   cd local-first-portal
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure your `.env` file**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=local_first_portal
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run database migrations**
   ```bash
   php artisan migrate
   ```

7. **Build assets**
   ```bash
   npm run dev
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

Visit `http://localhost:8000` to access the application.

## 🔧 Development

### Running in Development Mode
```bash
# Start Laravel server
php artisan serve

# Watch for asset changes
npm run dev
```

### Database Operations
```bash
# Create new migration
php artisan make:migration create_table_name

# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Seed database
php artisan db:seed
```

## 📈 Roadmap

- [x] **Phase 1**: Project setup and database design
- [x] **Phase 2**: User authentication system
- [ ] **Phase 3**: Vendor onboarding module
- [ ] **Phase 4**: Product catalog and listings
- [ ] **Phase 5**: Alternative products mapping
- [ ] **Phase 6**: Pledge system with certificate generation
- [ ] **Phase 7**: Interactive games module
- [ ] **Phase 8**: Content management for articles
- [ ] **Phase 9**: Expo integration and launch event
- [ ] **Phase 10**: Mobile optimization and PWA features

## 🤝 Contributing

We welcome contributions from the community! Here's how you can help:

1. **Fork the repository**
2. **Create a feature branch** (`git checkout -b feature/amazing-feature`)
3. **Make your changes**
4. **Commit your changes** (`git commit -m 'Add some amazing feature'`)
5. **Push to the branch** (`git push origin feature/amazing-feature`)
6. **Open a Pull Request**

### Coding Standards
- Follow PSR-12 PHP coding standards
- Write meaningful commit messages
- Add tests for new features
- Update documentation as needed

## 📝 Documentation

Additional documentation can be found in the `_Documents/` directory:
- [AI Generated Files Summary](_Documents/AI_GENERATED_FILES_SUMMARY.md)
- [Country, State, and City Management Implementation](_Documents/COUNTRY_STATE_CITY_IMPLEMENTATION.md) - Comprehensive guide for the location management system
- [Seeder Data Optimization Implementation](_Documents/SEEDER_DATA_OPTIMIZATION.md) - Complete overview of realistic data implementation for Swadeshi mission
- Database schema diagrams
- API documentation
- Deployment guides
- Development notes

## 🐛 Issues & Support

If you encounter any issues or have questions:
1. Check existing [Issues](https://github.com/yourusername/local-first-portal/issues)
2. Create a new issue with detailed information
3. Use appropriate labels for categorization

## 📄 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- **Fashion Anantaa Women Expo (Mahesana)** for the platform launch opportunity
- Local businesses and vendors for their support
- The Laravel and open-source community

---

**Made with ❤️ for promoting local businesses and reducing dependency on foreign goods.**

*Join the movement - Support Local, Think Global! 🇮🇳*
