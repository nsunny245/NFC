const { contextBridge, ipcRenderer } = require('electron');

// Expose safe POS hardware and sync APIs to the renderer window
contextBridge.exposeInMainWorld('posDesktop', {
  isDesktop: true,
  platform: process.platform,
  
  // Direct Silent Thermal Printing (USB / COM / LAN ESC-POS)
  printReceiptDirect: (receiptData) => ipcRenderer.invoke('pos:print-receipt', receiptData),
  
  // Hardware Printers Enumeration
  getPrinters: () => ipcRenderer.invoke('pos:get-printers'),
  
  // Offline SQLite Local Storage Query
  getOfflineData: (key) => ipcRenderer.invoke('pos:get-offline-data', key),
  saveOfflineOrder: (order) => ipcRenderer.invoke('pos:save-offline-order', order),
  
  // Trigger Manual Cloud Sync
  triggerSync: () => ipcRenderer.invoke('pos:trigger-sync'),
  
  // Network Status Notification from Main Process
  onConnectivityChanged: (callback) => {
    ipcRenderer.on('pos:connectivity', (event, status) => callback(status));
  }
});
