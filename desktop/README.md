# Nawabi Food Corner POS desktop builds

The desktop application runs the bundled POS interface locally. Orders, the menu cache,
and shift data remain available without internet; authenticated sync uploads queued orders
and refreshes the catalog when connectivity returns.

## Supported packages

| Package | Operating systems | Architectures |
| --- | --- | --- |
| Modern Windows | Windows 10 and 11 | x64 |
| Legacy Windows | Windows 7 SP1, 8, 8.1 | x86 and x64 |
| macOS | Supported Intel and Apple Silicon macOS releases | x64 and arm64 |

Windows 7/8 uses Electron 22.3.27, the final Electron line supporting those operating
systems. It is intentionally separated from the security-supported modern build. A
Windows 7 machine should have SP1 and current SHA-2/root-certificate updates installed.

## Build

```bash
npm ci
npm run build:win
npm run build:win7
npm run build:mac
```

Code signing and notarization require the organization's Windows code-signing certificate
and Apple Developer ID credentials. Unsigned development artifacts are suitable for QA,
but should not be distributed to client terminals as final production installers.

## First launch

Open **Settings** in the app and enter the server URL, terminal code, and the terminal
sync token shown in **Admin > Standalone POS Apps**. The token is written with owner-only
permissions to the operating system's application-data directory.
