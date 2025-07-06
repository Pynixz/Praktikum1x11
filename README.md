<div align="center">
   <img src="https://upload.wikimedia.org/wikipedia/commons/2/27/PHP-logo.svg" width="100" alt="PHP Logo">
   <img src="https://www.svgrepo.com/show/353579/codeigniter.svg" width="100" alt="CodeIgniter 4 Logo">
   <img src="https://upload.wikimedia.org/wikipedia/commons/9/95/Vue.js_Logo_2.svg" width="100" alt="Vue.js Logo">
</div>

# 📰 Article Management System

**Modern Article Management System** built with CodeIgniter 4, featuring Vue.js integration, advanced authentication, and responsive design.

## 👤 Developer Profile

| Atribut         | Keterangan            |
| --------------- | --------------------- |
| **Nama**        | Dhiyaulhaq Al Maududi |
| **NIM**         | 312310508             |
| **Kelas**       | TI.23.A.5             |
| **Mata Kuliah** | Pemrograman Website 2 |
| **TUGAS**       | Praktikum 1-11        |

---
## 🚀 Features

### 📝 Article Management
- ✅ **CRUD Operations** - Create, Read, Update, Delete artikel
- ✅ **Image Upload** - Upload gambar untuk artikel dengan validasi
- ✅ **Slug Generation** - URL-friendly slug otomatis
- ✅ **Read More/Less** - Expandable content dengan tombol interaktif
- ✅ **Rich Content** - Support HTML formatting dan line breaks
- ✅ **Status Management** - Published/Draft status untuk artikel

### 🏷️ Category Management
- ✅ **Vue.js Integration** - Modern category management dengan Vue.js
- ✅ **Sequential ID** - Auto-reorder ID setelah deletion
- ✅ **AJAX Operations** - Smooth user experience tanpa reload
- ✅ **Real-time Updates** - Instant category updates
- ✅ **Category Assignment** - Link artikel dengan kategori

### 🔐 Authentication System
- ✅ **Secure Login** - Password hashing dengan bcrypt
- ✅ **Session Management** - Secure session handling
- ✅ **Auto-redirect** - Smart redirect after login/logout
- ✅ **User Bubble** - Floating user info display
- ✅ **Auth Filter** - Protected admin routes

### 🎨 User Interface
- ✅ **Responsive Design** - Mobile-friendly layout
- ✅ **Modern Styling** - Clean and professional design
- ✅ **Auto-close Notifications** - 3-second auto-dismiss alerts
- ✅ **Smooth Animations** - CSS transitions and effects
- ✅ **Progress Indicators** - Visual feedback for notifications
- ✅ **Card-based Layout** - Modern article display

---
 
## 🛠️ Tech Stack

- **Backend**: CodeIgniter 4
- **Frontend**: HTML5, CSS3, JavaScript, Vue.js
- **Database**: MySQL
- **Authentication**: Session-based with bcrypt
- **Styling**: Custom CSS with CSS Variables
- **Package Manager**: Composer

## 📋 Requirements

- PHP 8.1 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- Composer
- Node.js (for Vue.js components)

## 🔧 Installation

### 1. Data File
```bash
cd Lab11_ci4
   Lab_vuejs
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Environment Setup
```bash
cp env .env
```

Edit `.env` file:
```env
CI_ENVIRONMENT = development

database.default.hostname = localhost
database.default.database = lab11_ci4
database.default.username = your_username
database.default.password = your_password
database.default.DBDriver = MySQLi
```

### 4. Database Setup
```sql
-- Create database
CREATE DATABASE lab11_ci4;

-- Import database structure
-- (Run the SQL files provided in the project)
```

### 5. Set Permissions
```bash
chmod -R 777 writable/
chmod -R 777 public/gambar/
```

---
 
## �️ Database Structure

### Articles Table
```sql
CREATE TABLE artikel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    isi TEXT NOT NULL,
    slug VARCHAR(200) NOT NULL,
    status TINYINT(1) DEFAULT 1,
    gambar VARCHAR(200),
    kategori_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (kategori_id) REFERENCES kategori(id)
);
```

### Categories Table
```sql
CREATE TABLE kategori (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Users Table
```sql
CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    useremail VARCHAR(100) NOT NULL UNIQUE,
    userpassword VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## � Default Login

**Admin Account:**
- Email: `admin@email.com`
- Password: `admin123`

---
 
## 🎯 Usage

### 1. Access the Application
```
http://localhost:8080
```

### 2. Login as Admin
```
http://localhost:8080/user/login
```

### 3. Manage Articles
```
http://localhost:8080/admin/artikel
```

### 4. Manage Categories (Vue.js)
```
http://localhost:8080/lab8_vuejs
```

## 📁 Project Structure

```
ci4/
├── app/
│   ├── Controllers/
│   │   ├── Artikel.php          # Article CRUD operations
│   │   ├── User.php             # Authentication
│   │   ├── Home.php             # Homepage
│   │   └── Page.php             # Static pages
│   ├── Models/
│   │   ├── ArtikelModel.php     # Article model
│   │   ├── UserModel.php        # User model
│   │   └── KategoriModel.php    # Category model
│   ├── Views/
│   │   ├── artikel/             # Article views
│   │   ├── admin/               # Admin panel views
│   │   ├── user/                # Authentication views
│   │   ├── template/            # Layout templates
│   │   └── layout/              # Base layouts
│   ├── Filters/
│   │   └── Auth.php             # Authentication filter
│   └── Cells/
│       └── ArtikelLatest.php    # Latest articles widget
├── public/
│   ├── style.css                # Main stylesheet
│   ├── gambar/                  # Image uploads
│   └── lab8_vuejs/              # Vue.js category management
└── writable/                    # Cache and logs
```

---
 
## 🎨 Key Features Explained

### 📝 Read More/Less Functionality
- **Smart Truncation**: Automatically truncates content at 200 characters
- **Interactive Buttons**: "📖 Baca Selengkapnya" and "📚 Sembunyikan" buttons
- **Smooth Transitions**: CSS animations for expand/collapse
- **Conditional Display**: Only shows buttons when content exceeds limit

### 🔐 Authentication Flow
- **Login**: Redirect to home page after successful login
- **Logout**: Redirect to login page with success message
- **User Bubble**: Floating user info display (not in navbar)
- **Auto-redirect**: Smart redirect to originally requested page

### 🎯 Auto-Close Notifications
- **3-Second Timer**: Notifications auto-close after 3 seconds
- **Progress Bar**: Visual countdown indicator
- **Manual Close**: Users can still close manually with × button
- **Smooth Animations**: Slide in/out effects

### 🏷️ Vue.js Category Management
- **Modern Interface**: Vue.js powered category management
- **AJAX Operations**: No page reloads required
- **Sequential IDs**: Auto-reorder after deletion
- **Real-time Updates**: Instant feedback

---
 
## � Development Commands

### Run Development Server
```bash
php spark serve
```

### Database Migration
```bash
php spark migrate
```

### View Routes
```bash
php spark routes
```

### Clear Cache
```bash
php spark cache:clear
```

## 🎨 Styling Features

### CSS Variables
```css
:root {
  --bg-color: #f4f4f4;
  --text-color: #5a5a5a;
  --nav-bg: #1f5faa;
  --nav-hover: #2b83ea;
  --footer-bg: #1d1d1d;
  --card-bg: #e4e4e5;
}
```

### Responsive Design
- **Mobile-first approach**
- **Flexible grid system**
- **Touch-friendly buttons**
- **Optimized images**

### Modern UI Elements
- **Card-based layouts**
- **Gradient buttons**
- **Smooth hover effects**
- **Loading animations**

---
 
## � Configuration

### Environment Variables
```env
# Database Configuration
database.default.hostname = localhost
database.default.database = lab11_ci4
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi

# App Configuration
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'
```

### Routes Configuration
```php
// Public Routes
$routes->get('/', 'Home::index');
$routes->get('/artikel', 'Artikel::index');
$routes->get('/artikel/(:segment)', 'Artikel::view/$1');

// Authentication Routes
$routes->get('/user/login', 'User::login');
$routes->post('/user/login', 'User::login');
$routes->get('/user/logout', 'User::logout');

// Admin Routes (Protected)
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('artikel', 'Artikel::admin_index');
    $routes->add('artikel/add', 'Artikel::add');
    $routes->add('artikel/edit/(:any)', 'Artikel::edit/$1');
    $routes->get('artikel/delete/(:any)', 'Artikel::delete/$1');
});
```

---
 
## 🚀 Getting Started

### Quick Start
1. **Clone the repository**
2. **Install dependencies** with Composer
3. **Configure database** in `.env` file
4. **Import database** structure
5. **Set permissions** for writable directories
6. **Access the application** at `http://localhost:8080`

### First Login
- Navigate to `http://localhost:8080/user/login`
- Use credentials: `admin@email.com` / `admin123`
- You'll be redirected to the home page
- User info will appear as a floating bubble

### Managing Content
- **Articles**: Go to admin panel to create/edit articles
- **Categories**: Use Vue.js interface at `/lab8_vuejs`
- **Images**: Upload images through the article form

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📝 License

This project is open source and available under the [MIT License](LICENSE).

## 🙏 Acknowledgments

- **CodeIgniter 4** - The PHP framework
- **Vue.js** - For modern category management
- **Bootstrap** - For responsive components
- **Font Awesome** - For icons
 
## ✅ Conclusion

This Article Management System demonstrates modern web development practices using CodeIgniter 4 with enhanced user experience features:

### 🎯 Key Achievements
- **Full CRUD Operations** for articles and categories
- **Modern Authentication** with secure session management
- **Vue.js Integration** for dynamic category management
- **Responsive Design** that works on all devices
- **Auto-close Notifications** for better UX
- **Read More/Less Functionality** for content management
- **Image Upload** with validation
- **SEO-friendly URLs** with slug generation

### 🚀 Technical Highlights
- **MVC Architecture** following CodeIgniter 4 best practices
- **Database Relationships** between articles and categories
- **Authentication Filters** for route protection
- **CSS Variables** for consistent theming
- **JavaScript Enhancements** for interactivity
- **Progressive Enhancement** approach

### 📈 Future Enhancements
- User registration system
- Comment system for articles
- Article search functionality
- Tag system implementation
- Email notifications
- Social media integration
- SEO optimization tools
- Multi-language support

---

**Built with ❤️ using CodeIgniter 4, Vue.js, and modern web technologies.**

*For questions or contributions, please open an issue or submit a pull request.*
