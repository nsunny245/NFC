const { app, BrowserWindow, ipcMain } = require('electron');
const path = require('path');
const fs = require('fs');
const https = require('https');
const http = require('http');

let mainWindow = null;
const defaultConfig = {
  serverUrl: 'https://nawabifoodcorner.com', terminalCode: 'POS-01', terminalToken: '',
  printerName: '', paperWidthMm: 80, autoCut: true, syncIntervalMinutes: 5,
};

function configPath() { return path.join(app.getPath('userData'), 'pos-config.json'); }
function readConfig() {
  try { return { ...defaultConfig, ...JSON.parse(fs.readFileSync(configPath(), 'utf8')) }; }
  catch (_) { return { ...defaultConfig }; }
}
function writeConfig(input) {
  const current = readConfig();
  const allowed = ['serverUrl', 'terminalCode', 'terminalToken', 'printerName', 'paperWidthMm', 'autoCut', 'syncIntervalMinutes'];
  for (const key of allowed) if (Object.prototype.hasOwnProperty.call(input || {}, key)) current[key] = input[key];
  current.serverUrl = String(current.serverUrl || defaultConfig.serverUrl).replace(/\/+$/, '');
  current.terminalCode = String(current.terminalCode || 'POS-01').slice(0, 30);
  current.terminalToken = String(current.terminalToken || '').slice(0, 160);
  fs.writeFileSync(configPath(), JSON.stringify(current, null, 2), { mode: 0o600 });
  return current;
}
function requestJson(method, endpoint, payload) {
  return new Promise((resolve, reject) => {
    const config = readConfig();
    const url = new URL(endpoint, config.serverUrl);
    const transport = url.protocol === 'http:' ? http : https;
    const body = payload == null ? '' : JSON.stringify(payload);
    const request = transport.request(url, {
      method, timeout: 10000,
      headers: { Accept: 'application/json', 'Content-Type': 'application/json', 'X-Terminal-Token': config.terminalToken, ...(body ? { 'Content-Length': Buffer.byteLength(body) } : {}) },
    }, response => {
      let raw = '';
      response.setEncoding('utf8');
      response.on('data', chunk => { raw += chunk; });
      response.on('end', () => {
        let data = {};
        try { data = raw ? JSON.parse(raw) : {}; } catch (_) { data = { message: raw }; }
        if (response.statusCode >= 200 && response.statusCode < 300) resolve(data);
        else reject(new Error(data.message || `Server returned HTTP ${response.statusCode}`));
      });
    });
    request.on('timeout', () => request.destroy(new Error('Connection timed out')));
    request.on('error', reject);
    if (body) request.write(body);
    request.end();
  });
}
function offlineAppPath() {
  const packaged = path.join(process.resourcesPath, 'offline', 'pos-offline-kiosk.html');
  if (app.isPackaged && fs.existsSync(packaged)) return packaged;
  return path.join(__dirname, '..', 'public', 'downloads', 'pos-offline-kiosk.html');
}
function createWindow() {
  mainWindow = new BrowserWindow({
    width: 1366, height: 820, minWidth: 1024, minHeight: 700,
    title: 'Nawabi Food Corner POS', backgroundColor: '#0f172a',
    icon: path.join(__dirname, '..', 'public', 'images', 'logo_circular.png'),
    webPreferences: { preload: path.join(__dirname, 'preload.js'), nodeIntegration: false, contextIsolation: true, sandbox: true, webSecurity: true },
  });
  mainWindow.setMenuBarVisibility(false);
  mainWindow.loadFile(offlineAppPath());
  mainWindow.webContents.setWindowOpenHandler(() => ({ action: 'deny' }));
  mainWindow.on('closed', () => { mainWindow = null; });
}
app.whenReady().then(createWindow);
app.on('activate', () => { if (BrowserWindow.getAllWindows().length === 0) createWindow(); });
app.on('window-all-closed', () => { if (process.platform !== 'darwin') app.quit(); });

ipcMain.handle('pos:get-config', () => {
  const config = readConfig();
  return { ...config, terminalToken: config.terminalToken ? '\u2022'.repeat(12) : '' };
});
ipcMain.handle('pos:save-config', (_event, config) => {
  const current = readConfig();
  const next = { ...config };
  if (next.terminalToken === '\u2022'.repeat(12)) next.terminalToken = current.terminalToken;
  const saved = writeConfig(next);
  return { success: true, configured: Boolean(saved.terminalToken) };
});
ipcMain.handle('pos:sync-health', () => requestJson('GET', '/api/pos/sync/health'));
ipcMain.handle('pos:sync-pull', (_event, payload) => requestJson('POST', '/api/pos/sync/pull', payload || {}));
ipcMain.handle('pos:sync-push', (_event, payload) => requestJson('POST', '/api/pos/sync/push', payload || {}));
ipcMain.handle('pos:get-printers', async () => mainWindow ? mainWindow.webContents.getPrintersAsync() : []);
ipcMain.handle('pos:print-receipt', async (_event, receiptHtml) => {
  if (!mainWindow) return { success: false, error: 'No active window' };
  const config = readConfig();
  let printWindow;
  try {
    printWindow = new BrowserWindow({ show: false, webPreferences: { sandbox: true } });
    const width = Number(config.paperWidthMm) === 58 ? 58 : 80;
    const html = `<!doctype html><html><head><meta charset="utf-8"><style>@page{margin:0;size:${width}mm auto}body{font-family:monospace;font-size:10px;line-height:1.35;width:${width - 6}mm;margin:0 auto;padding:8px 4px;color:#000;background:#fff}</style></head><body>${String(receiptHtml || '')}</body></html>`;
    await printWindow.loadURL(`data:text/html;charset=utf-8,${encodeURIComponent(html)}`);
    return await new Promise(resolve => {
      const options = { silent: true, printBackground: true, margins: { marginType: 'none' }, pageSize: { width: width * 1000, height: 297000 }, ...(config.printerName ? { deviceName: config.printerName } : {}) };
      printWindow.webContents.print(options, (success, failureReason) => {
        printWindow.close();
        resolve(success ? { success: true } : { success: false, error: failureReason });
      });
    });
  } catch (error) {
    if (printWindow && !printWindow.isDestroyed()) printWindow.close();
    return { success: false, error: error.message };
  }
});
