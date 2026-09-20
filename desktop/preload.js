const { contextBridge, ipcRenderer } = require('electron');

contextBridge.exposeInMainWorld('posDesktop', {
  isDesktop: true,
  platform: process.platform,
  getConfig: () => ipcRenderer.invoke('pos:get-config'),
  saveConfig: config => ipcRenderer.invoke('pos:save-config', config),
  health: () => ipcRenderer.invoke('pos:sync-health'),
  pull: payload => ipcRenderer.invoke('pos:sync-pull', payload),
  push: payload => ipcRenderer.invoke('pos:sync-push', payload),
  printReceiptDirect: receiptHtml => ipcRenderer.invoke('pos:print-receipt', receiptHtml),
  getPrinters: () => ipcRenderer.invoke('pos:get-printers'),
});
