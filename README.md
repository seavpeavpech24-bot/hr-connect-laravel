# HR Connect – Laravel HR Management System

HR Connect is a free and open-source Laravel application that helps HR teams manage applicants, send interview invitations, and automate approval/rejection emails through Gmail.

It includes a modern dashboard, applicant tracking, Gmail integration, and one-click setup using Python for non-technical users.

## ✨ Features

- **📊 Dashboard Overview** – Track applicant stats and system insights
- **🧑‍💼 Applicant Management** – Add, edit, approve, or reject applicants
- **📧 Email Integration** – Send interview, approval, or rejection messages via Gmail
- **📨 Message History** – View sent email logs and status
- **⚙️ Settings Panel** – Manage Gmail credentials, app users, and SMTP settings
- **🧠 Smart Templates** – Predefined Gmail templates for HR use
- **💻 One-Click Python Launcher** – Auto installs & runs the app for non-coders

## 🧩 Tech Stack

| Layer      | Technology                  |
|------------|-----------------------------|
| Frontend   | Blade + TailwindCSS + Alpine.js |
| Backend    | Laravel 11                  |
| Database   | SQLite / MySQL              |
| Email      | Gmail SMTP                  |
| Automation | Python 3 (Launcher Script)  |

## ⚙️ Installation Guide (Developers)

### 1️⃣ Clone the Repo
```bash
git clone https://github.com/yourusername/hr-connect-laravel.git
cd hr-connect-laravel
```

### 2️⃣ Install Dependencies
```bash
composer install
npm install
```

### 3️⃣ Configure .env
```bash
cp .env.example .env
```

Update the following lines:

```
APP_NAME=HR Connect
APP_URL=http://127.0.0.1:8000

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your@gmail.com
MAIL_FROM_NAME="HR Connect"
```

⚠️ Generate an App Password from your Gmail account (not your real password!)

#### 📖 How to create a Gmail App Password
[Follow Google's guide here](https://support.google.com/accounts/answer/185833)

### 4️⃣ Run Migrations
```bash
php artisan migrate --seed
```

### 5️⃣ Start the App
```bash
php artisan serve
```

Visit 👉 http://127.0.0.1:8000

## 💡 For Non-Technical Users

You don’t need to install anything manually!

Just double-click the provided file: **HRConnectLauncher.py**

It will automatically:

- install Composer and Node packages
- run database migrations
- launch the app in your browser

## 🧠 Folder Overview
```
hr-connect-laravel/
├── app/              # Laravel app logic
├── resources/views/  # Blade templates (Dashboard, Messages, Settings, etc.)
├── public/           # Public assets
├── database/         # Migrations & seeds
├── HRConnectLauncher.py  # Python one-click launcher
└── README.md
```

## 🧑‍💻 Developer Info

Developed by SeavPeav PECH  
🌐 [LinkedIn](https://www.linkedin.com/in/seavpeav-pech-557556254/)  
• [GitHub](https://github.com/seavpeavpech24-bot)

## ⚖️ License

This project is licensed under the MIT License — free for personal and commercial use. See the [LICENSE](LICENSE) file for details.