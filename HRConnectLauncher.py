import os
import subprocess
import sys
import shutil

ENV_PATH = ".env"

def check_command(cmd):
    return shutil.which(cmd) is not None

def run_command(command, shell=True):
    process = subprocess.Popen(
        command,
        shell=shell,
        stdout=subprocess.PIPE,
        stderr=subprocess.STDOUT,
        text=True
    )
    while True:
        line = process.stdout.readline()
        if line == '' and process.poll() is not None:
            break
        if line:
            print(line.strip())
    return process.poll()

def setup_env():
    """Create or update the .env file with Gmail settings"""
    print("\n⚙️  Checking .env configuration...")

    # If .env does not exist, copy from example if available
    if not os.path.exists(ENV_PATH):
        if os.path.exists(".env.example"):
            shutil.copy(".env.example", ENV_PATH)
            print("✅ Created .env from .env.example")
        else:
            open(ENV_PATH, "w").close()
            print("⚠️  .env.example not found, creating empty .env")

    # Read current env content
    with open(ENV_PATH, "r", encoding="utf-8") as f:
        lines = f.readlines()

    env_data = {}
    for line in lines:
        if "=" in line and not line.startswith("#"):
            key, val = line.strip().split("=", 1)
            env_data[key] = val

    # Ask for Gmail setup if missing
    gmail_user = env_data.get("MAIL_USERNAME", "")
    gmail_pass = env_data.get("MAIL_PASSWORD", "")

    if not gmail_user or not gmail_pass:
        print("\n✉️  Gmail setup required for sending emails.")
        print("You can generate an App Password here:")
        print("👉 https://support.google.com/accounts/answer/185833\n")

        gmail_user = input("Enter your Gmail address: ").strip()
        gmail_pass = input("Enter your Gmail App Password: ").strip()

        env_data.update({
            "MAIL_MAILER": "smtp",
            "MAIL_HOST": "smtp.gmail.com",
            "MAIL_PORT": "587",
            "MAIL_USERNAME": gmail_user,
            "MAIL_PASSWORD": gmail_pass,
            "MAIL_ENCRYPTION": "tls",
            "MAIL_FROM_ADDRESS": gmail_user,
            "MAIL_FROM_NAME": "\"HR Connect\""
        })

    # Rewrite .env with updated values
    with open(ENV_PATH, "w", encoding="utf-8") as f:
        for k, v in env_data.items():
            f.write(f"{k}={v}\n")

    print("✅ .env file configured successfully!\n")

def main():
    print("=" * 70)
    print("🚀 HR Connect - Laravel Auto Setup & Launcher")
    print("=" * 70)

    requirements = {
        "PHP": check_command("php"),
        "Composer": check_command("composer"),
        "Node.js": check_command("node"),
        "NPM": check_command("npm"),
    }

    for tool, ok in requirements.items():
        print(f"{'✅' if ok else '❌'} {tool}")
        if not ok:
            print(f"Please install {tool} before running HR Connect.")
            return

    setup_env()

    print("\n📦 Installing Composer packages...")
    run_command("composer install")

    print("\n📦 Installing Node.js packages...")
    run_command("npm install")

    print("\n🔑 Generating app key...")
    run_command("php artisan key:generate")

    print("\n🧱 Running database migrations...")
    run_command("php artisan migrate --seed")

    print("\n🌐 Starting Laravel development server...")
    print("App running at 👉 http://127.0.0.1:8000")
    print("Press CTRL+C to stop.\n")

    run_command("php artisan serve")

if __name__ == "__main__":
    try:
        main()
    except KeyboardInterrupt:
        print("\n🛑 HR Connect stopped by user.")
        sys.exit(0)
