# Sandroses Quran Mobile Suite

This repository contains a production-ready starter to deliver **iOS** and **Android** apps for:

- https://www.sandroses.com/quran

It includes:

1. A small PHP backend layer for policy/compliance endpoints and server-side configuration.
2. A native SwiftUI iOS app with `WKWebView` hardening.
3. A native Android app with `WebView` hardening and network security configuration.
4. Store compliance checklists for Apple Developer Program and Google Play Developer Policy.

> Important: policy compliance is a process, not a one-time code change. Use the included checklists before submission.

## Project layout

- `backend/` PHP 8.1+ web layer
- `apps/ios/` native iOS app scaffold
- `apps/android/` native Android app scaffold
- `compliance/` release checklists and required disclosures

## Quick start

### 1) PHP backend

```bash
cd backend
php -S 127.0.0.1:8080 -t public
```

Then open:

- `http://127.0.0.1:8080/` (API metadata)
- `http://127.0.0.1:8080/privacy-policy.php`
- `http://127.0.0.1:8080/.well-known/apple-app-site-association`
- `http://127.0.0.1:8080/.well-known/assetlinks.json`
- `http://127.0.0.1:8080/hijri.php` (PHP Hijri API similar to ihijri-style date output)
- `http://127.0.0.1:8080/hijri-demo.php` (interactive demo for timezone/locale/day adjustment)

### 2) iOS

- Open `apps/ios/QuranApp.xcodeproj` (create project and drop in included files).
- Set your Team ID, bundle ID, and Associated Domains.
- Confirm App Privacy answers match real data handling.

### 3) Android

- Open `apps/android/` in Android Studio.
- Replace package namespace and signing config.
- Confirm Data safety form matches real data handling.

## Security defaults shipped

- HTTPS-only allowed URLs.
- External links opened outside the in-app web view.
- JavaScript enabled only for first-party Quran domain.
- No mixed-content loading.
- No file URL access from the web view.
- Reading bookmark (save current page URL and return later on Android).

## Next steps for production

- Add cookie consent and age-rating disclosures in website content.
- Add Terms of Use and EULA URLs in both store listings.
- Add crash reporting/privacy tooling and update disclosure docs accordingly.

## Android implementation

For a full step-by-step Android publish workflow (namespace, signing, app links, AAB release), see:

- `docs/android-implementation.md`
