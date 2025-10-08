import os, subprocess, sys, platform, time

def run_command(command, desc=None):
    print(f"\n{'='*60}\n▶️  {desc or command}\n{'='*60}")
    result = subprocess.run(command, shell=True)
    if result.returncode != 0:
        print(f"❌ Failed: {command}")
        sys.exit(1)

def install_dependencies():
    print("📦 Checking dependencies...")
    run_command("composer install", "Installing PHP dependencies (Composer)")
    run_command("npm install", "Installing frontend packages (npm)")
    run_command("php artisan key:generate", "Generating Laravel key")
    run_command("php artisan migrate --seed", "Migrating and seeding database")

def serve_app():
    print("\n🚀 Starting HR Connect server...")
    subprocess.run("php artisan serve", shell=True)

if __name__ == "__main__":
    os.system("cls" if platform.system() == "Windows" else "clear")
    print("💼 HR Connect Auto Setup\n=========================\n")

    print("Checking environment...\n")
    time.sleep(1)

    try:
        subprocess.run(["php", "--version"], capture_output=True, check=True)
        subprocess.run(["composer", "--version"], capture_output=True, check=True)
        subprocess.run(["npm", "--version"], capture_output=True, check=True)
    except:
        print("❌ Missing dependencies! Please install PHP, Composer, and Node.js.")
        sys.exit(1)

    install_dependencies()
    serve_app()
