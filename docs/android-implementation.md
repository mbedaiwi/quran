# Android Implementation Guide (Step-by-step)

This guide explains how to turn the scaffold into a publishable Play Store app.

## 1) Open and sync

1. Open `apps/android/` in Android Studio.
2. Let Gradle sync.
3. If prompted, install SDK 35 and Build Tools.

## 2) Set package and app name

1. Change `applicationId` in `app/build.gradle.kts`.
2. Rename package folder from `com/sandroses/quran` to your final namespace.
3. Update `package` in `AndroidManifest.xml`.

## 3) Configure signing

1. Create keystore:
   ```bash
   keytool -genkeypair -v -keystore release.jks -keyalg RSA -keysize 2048 -validity 10000 -alias release
   ```
2. Add signing config in Gradle (or use Play App Signing).
3. Keep keystore file and passwords secure.

## 4) Configure Android App Links

1. Build a signed app once.
2. Get SHA-256 cert fingerprint:
   ```bash
   keytool -list -v -keystore release.jks -alias release
   ```
3. Put fingerprint into `backend/public/.well-known/assetlinks.json`.
4. Deploy backend so `https://www.sandroses.com/.well-known/assetlinks.json` is public.
5. Reinstall app and verify deep links using:
   ```bash
   adb shell pm get-app-links com.yourcompany.quran
   ```

## 5) Data safety and policy

1. Publish `privacy-policy.php` URL publicly.
2. Fill Play Console Data safety exactly based on SDKs/data.
3. Complete Content rating and App access declarations.

## 6) Build release bundle

```bash
cd apps/android
./gradlew bundleRelease
```

AAB output:
- `app/build/outputs/bundle/release/app-release.aab`

## 7) Upload to Play Console

1. Create app listing and upload AAB.
2. Add store screenshots, icon, feature graphic.
3. Submit for review.


## Bookmark behavior (resume reading)

- Tap **Save mark** to store the current Quran page URL in local device storage (`SharedPreferences`).
- Tap **Go to mark** to jump back to your saved page.
- The app also auto-opens the saved mark on launch if one exists.
- This feature is local-only (no account required, no server sync).
