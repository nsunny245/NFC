const { app, BrowserWindow, ipcMain, dialog } = require('electron');
const path = require('path');
const fs = require('fs');

let mainWindow = null;

// Config: Default POS Cloud/Local URL & Terminal Token
const configPath = path.join(app.getPath('userData'), 'pos-config.json');
let posConfig = {
  posUrl: 'https://nawabifoodcorner.com/pos',
  apiUrl: 'https://nawabifoodcorner.com/api/pos/sync',
  terminalCode: 'POS-01',
  printerName: '',
  paperWidthMm: 80,
  autoCut: true,
  syncIntervalMinutes: 5
};

if (fs.existsSync(configPath)) {
  try {
    posConfig = { ...posConfig, ...JSON.parse(fs.readFileSync(configPath, 'utf8')) };
  } catch (e) {
    console.error('Failed to load pos-config.json:', e);
  }
}

function createWindow() {
  mainWindow = new BrowserWindow({
    width: 1280,
    height: 800,
    minWidth: 1024,
    minHeight: 700,
    title: 'Nawabi Food Corner - POS Terminal (Standalone)',
    icon: path.join(__dirname, '../public/images/logo_circular.png'),
    webPreferences: {
      preload: path.join(__dirname, 'preload.js'),
      nodeIntegration: false,
      contextIsolation: true,
      webSecurity: true,
    }
  });

  // Remove default menu bar for clean cashier experience
  mainWindow.setMenuBarVisibility(false);

  // Load POS Terminal Dashboard
  mainWindow.loadURL(posConfig.posUrl).catch((err) => {
    console.log('Cannot reach POS server directly, loading offline splash...', err);
  });

  mainWindow.on('closed', () => {
    mainWindow = null;
  });
}

app.whenReady().then(() => {
  createWindow();

  app.on('activate', () => {
    if (BrowserWindow.getAllWindows().length === 0) createWindow();
  });
});

app.on('window-all-closed', () => {
  if (process.platform !== 'darwin') app.quit();
});

// =========================================================================
// HARDWARE THERMAL PRINTING IPC HANDLERS
// =========================================================================

// Enumerate available printers on the PC
ipcMain.handle('pos:get-printers', async () => {
  if (!mainWindow) return [];
  return await mainWindow.webContents.getPrintersAsync();
});

// Direct Silent Printing to Thermal Receipt Printer
ipcMain.handle('pos:print-receipt', async (event, receiptHtml) => {
  if (!mainWindow) return { success: false, error: 'No active window' };

  try {
    // Create a hidden background window for pure silent thermal print
    const printWin = new BrowserWindow({
      show: false,
      webPreferences: { nodeIntegration: false }
    });

    const thermalStyles = `
      <style>
        @page { margin: 0; size: ${posConfig.paperWidthMm}mm auto; }
        body {
          font-family: monospace;
          font-size: 10px;
          line-height: 1.35;
          width: ${posConfig.paperWidthMm - 6}mm;
          margin: 0 auto;
          padding: 8px 4px;
          color: #000;
          background: #fff;
        }
      </style>
    `;

    const fullHtml = `<!DOCTYPE html><html><head>${thermalStyles}</head><body>${receiptHtml}</body></html>`;
    await printWin.loadURL('data:text/html;charset=utf-8,' + encodeURIComponent(fullHtml));

    const printOptions = {
      silent: true,
      printBackground: true,
      margins: { marginType: 'none' },
      pageSize: {
        width: posConfig.paperWidthMm * 1000,
        height: 297000
      }
    };

    if (posConfig.printerName) {
      printOptions.deviceName = posConfig.printerName;
    }

    return new Promise((resolve) => {
      printWin.webContents.print(printOptions, (success, failureReason) => {
        printWin.close();
        if (success) {
          resolve({ success: true });
        } else {
          resolve({ success: false, error: failureReason });
        }
      });
    });
  } catch (err) {
    return { success: false, error: err.message };
  }
});

// Cloud Sync Trigger IPC
ipcMain.handle('pos:trigger-sync', async () => {
  return { status: 'sync_invoked', terminal: posConfig.terminalCode };
});
