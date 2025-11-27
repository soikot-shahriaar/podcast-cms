# 🎙️ Podcast CMS - Episode Management System

A comprehensive Content Management System designed specifically for podcast creators to manage, organize, and publish their podcast episodes with ease.

## 🚀 Project Overview

Podcast CMS is a modern, user-friendly web application that provides podcast creators with a complete solution for managing their podcast content. Built with security and simplicity in mind, it offers an intuitive interface for episode management, user authentication, and content organization.

The system is designed to handle the entire podcast workflow - from episode creation and editing to publication and management. Whether you're a solo podcaster or managing multiple shows, this CMS provides the tools you need to keep your content organized and accessible.

## 🛠️ Technologies Used

### **Backend Technologies**
- **PHP 7.4+** - Server-side scripting language
- **MySQL 5.7+** - Relational database management system
- **PDO** - Database abstraction layer for secure database operations

### **Frontend Technologies**
- **HTML5** - Semantic markup structure
- **CSS3** - Modern styling with Flexbox and Grid
- **JavaScript (ES6+)** - Interactive functionality and form validation
- **Font Awesome 6.0** - Icon library for enhanced UI

### **Web Server & Environment**
- **Apache HTTP Server** - Web server software
- **XAMPP** - Local development environment
- **mod_rewrite** - URL rewriting for clean URLs

### **Security Features**
- **bcrypt** - Secure password hashing
- **Session Management** - Secure user authentication
- **SQL Injection Prevention** - Prepared statements
- **XSS Protection** - Input sanitization and output escaping

## ✨ Key Features

### **🎯 Core Functionality**
- **Episode Management** - Create, edit, delete, and organize podcast episodes
- **User Authentication** - Secure login and registration system
- **Dashboard Interface** - Centralized control panel for all operations
- **File Upload System** - Support for audio file uploads
- **Search & Filter** - Find episodes quickly with advanced search capabilities

### **🔐 Security Features**
- **Password Hashing** - Bcrypt encryption for user passwords
- **Session Security** - Secure session management and validation
- **Input Validation** - Comprehensive form validation and sanitization
- **Access Control** - Role-based user permissions

### **📱 User Experience**
- **Responsive Design** - Mobile-friendly interface that works on all devices
- **Modern UI/UX** - Clean, intuitive design with smooth animations
- **Real-time Feedback** - Immediate validation and success/error messages
- **Accessibility** - Semantic HTML and keyboard navigation support

### **📊 Content Management**
- **Episode Metadata** - Comprehensive episode information management
- **Status Management** - Draft and published episode states
- **Release Scheduling** - Plan and schedule episode releases
- **Content Organization** - Categorize and tag episodes for easy discovery

## 👥 User Roles

### **Administrator**
- **Full System Access** - Complete control over all features
- **User Management** - Create, edit, and delete user accounts
- **System Configuration** - Modify application settings and preferences
- **Content Oversight** - Monitor and manage all podcast content

### **Content Creator**
- **Episode Management** - Create, edit, and delete podcast episodes
- **File Uploads** - Upload and manage audio files
- **Content Publishing** - Publish and schedule episode releases
- **Personal Dashboard** - Access to personal content and statistics

### **Editor**
- **Content Review** - Review and approve episode submissions
- **Quality Control** - Ensure content meets publishing standards
- **Metadata Management** - Optimize episode descriptions and tags
- **Publication Control** - Manage episode release schedules

## 📁 Project Structure

```
podcast-cms/
├── 📁 assets/                 # Static assets
│   ├── 📁 css/               # Stylesheets
│   │   └── style.css         # Main application styles
│   ├── 📁 js/                # JavaScript files
│   │   └── main.js           # Main application scripts
│   └── 📁 uploads/           # File upload directory
├── 📁 config/                 # Configuration files
│   └── database.php          # Database connection settings
├── 📁 includes/               # PHP includes and functions
│   └── functions.php         # Common utility functions
├── 📁 sql/                    # Database scripts
│   └── setup.sql             # Database setup and sample data
├── 📁 templates/              # Reusable template files
│   ├── header.php            # Common header template
│   └── footer.php            # Common footer template
├── 📄 index.php               # Application entry point
├── 📄 login.php               # User authentication
├── 📄 register.php            # User registration
├── 📄 dashboard.php           # Main dashboard interface
├── 📄 episodes.php            # Episode listing and management
├── 📄 episode-add.php         # Add new episodes
├── 📄 episode-edit.php        # Edit existing episodes
├── 📄 episode-delete.php      # Delete episodes
├── 📄 logout.php              # User logout
├── 📄 .htaccess               # Apache configuration
└── 📄 README.md               # Project documentation
```

## 🚀 Setup Instructions

### **Prerequisites**
- **XAMPP** (or similar local server stack)
- **PHP 7.4+** with PDO and MySQL extensions
- **MySQL 5.7+** database server
- **Web browser** (Chrome, Firefox, Safari, Edge)

### **Installation Steps**

#### **1. Download and Extract**
```bash
# Clone or download the project
git clone [repository-url]
cd podcast-cms
```

#### **2. Configure Database**
```bash
# Create database using phpMyAdmin or MySQL command line
# Import the setup.sql file to create tables and sample data
```

#### **3. Configure Database Connection**
```php
// Edit config/database.php with your database credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'podcast_cms');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
```

#### **4. Set File Permissions**
```bash
# Ensure uploads directory is writable
chmod 755 assets/uploads/
```

#### **5. Start Web Server**
```bash
# Start Apache and MySQL in XAMPP Control Panel
# Access application at: http://localhost/podcast-cms/
# (Replace 'podcast-cms' with your actual project directory name)
```

### **Default Login Credentials**
- **Username:** `admin`
- **Password:** `admin123`
- **Note:** Change these credentials after first login

## 📖 Usage

### **Getting Started**
1. **Access the Application** - Navigate to your local server URL
2. **Login or Register** - Use default admin credentials or create new account
3. **Explore Dashboard** - Familiarize yourself with the main interface
4. **Create Your First Episode** - Use the "Add Episode" feature to get started

### **Episode Management**
1. **Adding Episodes** - Fill in episode details, upload audio files, and set status
2. **Editing Content** - Modify episode information, descriptions, and metadata
3. **Publishing** - Change episode status from draft to published
4. **Organization** - Use search and filter tools to manage episode library

### **User Management**
1. **Account Creation** - Register new user accounts as needed
2. **Profile Management** - Update personal information and preferences
3. **Security** - Change passwords regularly and maintain secure access

### **Content Organization**
1. **Metadata Optimization** - Use descriptive titles and detailed descriptions
2. **File Management** - Organize audio files and maintain consistent naming
3. **Status Tracking** - Monitor episode publication status and schedules

## 🎯 Intended Use

### **Primary Use Cases**
- **Podcast Production** - Manage episode creation and editing workflows
- **Content Publishing** - Organize and publish podcast episodes
- **Team Collaboration** - Enable multiple users to contribute content
- **Content Management** - Centralized repository for podcast assets

### **Target Audience**
- **Podcast Creators** - Individual content creators and podcast hosts
- **Production Teams** - Teams managing multiple podcast shows
- **Content Managers** - Professionals overseeing podcast content operations
- **Educational Institutions** - Schools and universities with podcast programs

### **Business Applications**
- **Content Marketing** - Business podcasts for brand building
- **Educational Content** - Academic and training podcast series
- **Entertainment** - Entertainment and lifestyle podcast shows
- **Corporate Communications** - Internal company podcast channels

### **Scalability Considerations**
- **Small Scale** - Perfect for individual podcasters and small teams
- **Medium Scale** - Suitable for growing podcast networks
- **Custom Development** - Foundation for enterprise-level solutions

## 📄 License

**License for RiverTheme**

RiverTheme makes this project available for demo, instructional, and personal use. You can ask for or buy a license from [RiverTheme.com](https://RiverTheme.com) if you want a pro website, sophisticated features, or expert setup and assistance. A Pro license is needed for production deployments, customizations, and commercial use.

**Disclaimer**

The free version is offered "as is" with no warranty and might not function on all devices or browsers. It might also have some coding or security flaws. For additional information or to get a Pro license, please get in touch with [RiverTheme.com](https://RiverTheme.com).

---

**Developed by RiverTheme**

*Podcast CMS - Making podcast management simple and efficient*

