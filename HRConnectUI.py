import tkinter as tk
from tkinter import scrolledtext, messagebox
import subprocess
import threading
import os
import webbrowser
import signal
import sys

server_process = None

def run_laravel():
    global server_process
    if server_process is not None:
        messagebox.showinfo("Already Running", "Laravel server is already running.")
        return

    output_text.insert(tk.END, "🚀 Starting Laravel server...\n")
    output_text.see(tk.END)

    def run_server():
        global server_process
        try:
            server_process = subprocess.Popen(
                ["php", "artisan", "serve"],
                stdout=subprocess.PIPE,
                stderr=subprocess.STDOUT,
                text=True
            )
            for line in iter(server_process.stdout.readline, ''):
                output_text.insert(tk.END, line)
                output_text.see(tk.END)
        except Exception as e:
            output_text.insert(tk.END, f"❌ Error: {e}\n")

    threading.Thread(target=run_server, daemon=True).start()

def stop_laravel():
    global server_process
    if not server_process:
        messagebox.showinfo("Not Running", "Laravel server is not running.")
        return

    output_text.insert(tk.END, "\n🛑 Stopping Laravel server...\n")
    if os.name == "nt":
        subprocess.run(["taskkill", "/F", "/T", "/PID", str(server_process.pid)])
    else:
        os.killpg(os.getpgid(server_process.pid), signal.SIGTERM)
    server_process = None

def open_browser():
    webbrowser.open("http://127.0.0.1:8000")

def auto_setup():
    cmds = [
        ("composer install", "Installing PHP dependencies..."),
        ("npm install", "Installing frontend packages..."),
        ("php artisan key:generate", "Generating app key..."),
        ("php artisan migrate --seed", "Migrating and seeding database...")
    ]

    def run_setup():
        for cmd, desc in cmds:
            output_text.insert(tk.END, f"\n⚙️ {desc}\n")
            output_text.see(tk.END)
            process = subprocess.Popen(cmd, shell=True, stdout=subprocess.PIPE, stderr=subprocess.STDOUT, text=True)
            for line in process.stdout:
                output_text.insert(tk.END, line)
                output_text.see(tk.END)
            process.wait()
        output_text.insert(tk.END, "\n✅ Setup complete!\n")

    threading.Thread(target=run_setup, daemon=True).start()

def on_close():
    if server_process:
        stop_laravel()
    root.destroy()
    sys.exit(0)

root = tk.Tk()
root.title("HR Connect Launcher")
root.geometry("820x520")
root.configure(bg="#f4f4f9")

tk.Label(root, text="💼 HR Connect App Launcher", font=("Segoe UI", 16, "bold"), bg="#f4f4f9").pack(pady=10)

btn_frame = tk.Frame(root, bg="#f4f4f9")
btn_frame.pack(pady=5)

tk.Button(btn_frame, text="⚙️ Auto Setup", command=auto_setup, bg="#FFA500", fg="white", width=15).grid(row=0, column=0, padx=5)
tk.Button(btn_frame, text="▶️ Run App", command=run_laravel, bg="#4CAF50", fg="white", width=12).grid(row=0, column=1, padx=5)
tk.Button(btn_frame, text="⏹ Stop App", command=stop_laravel, bg="#f44336", fg="white", width=12).grid(row=0, column=2, padx=5)
tk.Button(btn_frame, text="🌐 Open in Browser", command=open_browser, bg="#2196F3", fg="white", width=16).grid(row=0, column=3, padx=5)

output_text = scrolledtext.ScrolledText(root, wrap=tk.WORD, width=90, height=22, bg="#1e1e1e", fg="white", font=("Consolas", 9))
output_text.pack(padx=10, pady=10)

tk.Label(root, text="Status: Ready", font=("Segoe UI", 10), bg="#f4f4f9", fg="#555").pack(pady=5)
root.protocol("WM_DELETE_WINDOW", on_close)
root.mainloop()
