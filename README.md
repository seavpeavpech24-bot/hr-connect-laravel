# 💼 HR Connect

**HR Connect** is a free, open-source Laravel web application built to help Human Resources teams manage applicants efficiently — including invitations, rejections, and approvals — and send professional emails directly through Gmail.

---

## 🚀 Overview

**HR Connect** allows HR teams to:
- Manage applicant data and job positions
- Send interview invitations, approval, or rejection messages via Gmail
- Maintain email history and message templates
- Work completely locally or deploy to a server

---

## 🧩 Features

✅ Applicant management (view, add, edit, delete)  
✅ Email sending via Gmail (using your App Password)  
✅ Message templates for invitations, rejections, and approvals  
✅ Secure environment configuration  
✅ Built with **Laravel** full stack and **TailwindCSS**  
✅ Cross-platform compatible (Windows, macOS, Linux)

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-------------|
| Backend | Laravel (PHP 10+) |
| Frontend | Blade + TailwindCSS |
| Database | SQLite / MySQL |
| Email | Gmail SMTP (App Password) |

---

## 🧠 Requirements (Developers)

Before cloning or running the project manually, make sure you have:

- PHP 8.2+  
- Composer  
- Node.js 18+  
- npm or yarn  
- Git  

---

## ⚡ Quick Start (Developers)

```bash
# 1. Clone the repo
git clone https://github.com/seavpeavpech24-bot/hr-connect-laravel.git
cd hr-connect-laravel

# 2. Copy environment file
cp .env.example .env

# 3. Install dependencies
composer install
npm install

# 4. Generate key and migrate
php artisan key:generate
php artisan migrate

# 5. Run the app
php artisan serve
```

Then open 👉 **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

## 🗂️ Project Structure

```
hr-connect-laravel/
├── app/                 # Laravel backend logic
├── database/            # Migrations & seeders
├── public/              # Public assets (favicon, logo)
├── resources/           # Views (Blade, Tailwind)
├── routes/              # Web & API routes
├── .env.example         # Environment sample
└── README.md
```

---

## 🔑 Gmail Setup

### How to Generate a Gmail App Password

#### Why You Need It
Gmail requires an App Password to allow third-party apps like HR Connect to send emails securely. It’s safer and limited to this specific app.

Follow these steps to generate one:

1. Open your Google Account [here](https://myaccount.google.com/security).
2. Go to Security → enable 2-Step Verification.
3. Return to the Security page, and find “App passwords”.
4. Select “Other (Custom name)” and type HR Connect.
5. Click Create, then copy the 16-character code.
6. Paste it into your HR Account Settings → “App Password”.

> The app stores credentials locally in `.env` and **never uploads or shares** them.

---

## 🧰 Developer Mode (Advanced)

To rebuild frontend assets:

```bash
npm run dev
# or
npm run build
```

To refresh database:

```bash
php artisan migrate:fresh
```

To clear cache:

```bash
php artisan optimize:clear
```

---

## 🤝 Contributing

Contributions, issues, and feature requests are welcome!
Feel free to open a pull request or issue on GitHub.

---

## 💰 Support

For premium support, customization, or troubleshooting, contact me at a fee of $5+.

---

## 📜 License

This project is **MIT Licensed** — free to use, modify, and share.

---

## 🌍 Author

**👨‍💻 Developed by:** SeavPeav PECH  
🌐 [LinkedIn](https://www.linkedin.com/in/seavpeav-pech-557556254/)  
• [GitHub](https://github.com/seavpeavpech24-bot)  
💬 Open Source • Community Driven • Made with ❤️ in Cambodia
