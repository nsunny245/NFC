# Nawabi Food Corner POS - Standalone Desktop Application

This directory contains the packaging files for the **Nawabi Food Corner POS Standalone Desktop Terminal** for Windows (`.exe`) and macOS (`.dmg`).

## Features
- **Offline-First Execution**: Continues taking orders, settling payments, managing shifts, and printing receipts even when the internet drops.
- **Direct Silent Thermal Printing**: ESC/POS thermal printing directly to USB, Serial COM, or LAN receipt printers without interrupting cashiers with browser print preview dialogs.
- **Automatic Cloud Sync**: Automatically connects with `/api/pos/sync/pull` and `/api/pos/sync/push` on the central cloud server to upload offline orders and download price/menu updates.

---

## How to Build the Standalone Installers

### Prerequisites
- Node.js (v18 or v20+) installed on your PC or Mac.

### Step 1: Install Dependencies
Open your terminal inside the `desktop/` folder:
```bash
cd desktop
npm install
```

### Step 2: Build for Windows (.exe installer)
To generate the Windows installer:
```bash
npm run build:win
```
The output `.exe` files will be generated in `desktop/dist/`:
- `Nawabi Food Corner POS Setup 2.0.0.exe` (Standard Windows Installer)
- `Nawabi Food Corner POS 2.0.0.exe` (Portable Standalone Executable)

### Step 3: Build for macOS (.dmg file)
To generate the macOS installer:
```bash
npm run build:mac
```
The output `.dmg` file will be generated in `desktop/dist/`:
- `Nawabi Food Corner POS-2.0.0.dmg`

---

## Configuration (`pos-config.json`)
The application automatically creates `pos-config.json` inside user application data with the following customizable parameters:
```json
{
  "posUrl": "http://127.0.0.1:8003/pos",
  "apiUrl": "http://127.0.0.1:8003/api/pos/sync",
  "terminalCode": "POS-01",
  "printerName": "POS-80C",
  "paperWidthMm": 80,
  "autoCut": true,
  "syncIntervalMinutes": 5
}
```
- For production cloud deployment, set `"posUrl"` and `"apiUrl"` to your cloud server domain (e.g. `https://pos.nawabidera.com/pos`).
