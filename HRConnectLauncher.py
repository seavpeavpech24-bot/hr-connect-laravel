import os
import subprocess
import sys
import time
import shutil

def check_command(cmd):
    """Check if a command exists in PATH."""
    return shutil.which(cmd) is not None

def run_command(command, shell=True):
    """Run a command and stream its output."""
    process = subprocess.Popen(command, shell=shell, stdout=subprocess.PIPE, stderr=subprocess.STDOUT, text=True)
    while True:
        output = process.stdout.readline()
        if output == '' and process.poll() is not None:
            break
        if output:
            print(output.strip())
    return process.poll()

def main():
    print("=" * 70)
    print("🚀 HR Connect - Laravel Auto Setup & Launcher")
    print("=" * 70)

    # 1️⃣ Check system requirements
    requirements = {
        "PHP": check_command("php"),
        "Composer": check_command("composer"),
        "Node.js": check_command("node"),
        "NPM": check_command("npm"),
    }

    for tool, ok in requirements.items():
        if not ok:
            print(f"❌ {tool} is not installed. Please install it before running HR Connect.")
            return
        else:
            print(f"✅ {tool} detected")

    # 2️⃣ Install PHP dependencies
    print("\n📦 Installing PHP dependencies (composer install)...")
    run_command("composer install")

    # 3️⃣ Install Node.js dependencies
    print("\n📦 Installing Node.js dependencies (npm install)...")
    run_command("npm install")

    # 4️⃣ Generate app key
    print("\n🔑 Generating Laravel app key...")
    run_command("php artisan key:generate")

    # 5️⃣ Run database migrations
    print("\n🧱 Running migrations...")
    run_command("php artisan migrate --seed")

    # 6️⃣ Start Laravel development server
    print("\n🌐 Starting Laravel development server...")
    print("The app will be available at http://127.0.0.1:8000")
    print("Press CTRL+C to stop.\n")

    run_command("php artisan serve")

if __name__ == "__main__":
    try:
        main()
    except KeyboardInterrupt:
        print("\n🛑 HR Connect stopped by user.")
        sys.exit(0)
