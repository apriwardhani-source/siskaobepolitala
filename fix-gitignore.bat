@echo off
chcp 65001 >nul
echo.
echo ╔══════════════════════════════════════════════════════════════╗
echo ║      🔒 FIX GITIGNORE - SISKAOBE POLITALA                    ║
echo ║     Memperbaiki security issues dan update .gitignore        ║
echo ║            untuk mencegah commit file sensitif               ║
echo ╚══════════════════════════════════════════════════════════════╝
echo.

echo ⚠️  SECURITY ISSUES YANG AKAN DIPERBAIKI:
echo.
echo   🔴 CRITICAL:
echo      • .env exposed di Git (contains API keys!)
echo      • .wwebjs_cache/ di-track (WhatsApp session cache)
echo      • whatsapp-auth/ di-track (WhatsApp auth data)
echo      • database.sqlite di-track (database file)
echo.
echo   🟡 MEDIUM:
echo      • Testing/debug files pattern
echo      • Backup files pattern
echo      • Excel data files pattern
echo.
echo   📝 ACTIONS:
echo      1. Update .gitignore dengan pattern baru
echo      2. Remove cached files dari Git (tetap ada di local)
echo      3. Create backup .gitignore sebelum update
echo.

set /p confirm="Lanjutkan fix gitignore & remove cached files? (Y/N): "
if /i not "%confirm%"=="Y" (
    echo.
    echo ❌ Fix gitignore dibatalkan.
    pause
    exit /b
)

echo.
echo 💾 Backup .gitignore yang ada...

if exist ".gitignore" (
    copy ".gitignore" ".gitignore.backup"
    echo    ✅ Backup created: .gitignore.backup
) else (
    echo    ⚠️  .gitignore tidak ada, akan dibuat baru
)

echo.
echo 📝 Update .gitignore...

REM Append new patterns to .gitignore
(
echo.
echo # ============================================
echo # Added by fix-gitignore.bat - Security Fix
echo # ============================================
echo.
echo # Environment files - CRITICAL!
echo .env
echo .env.local
echo .env.*.local
echo.
echo # WhatsApp Integration - SENSITIVE!
echo .wwebjs_cache/
echo whatsapp-auth/
echo evolution-whatsapp/*.json
echo.
echo # Database files
echo database/database.sqlite
echo database/database.sqlite-journal
echo *.sqlite
echo *.sqlite-journal
echo.
echo # Testing and Debug files
echo read-*.php
echo debug-*.php
echo test-*.ps1
echo test-*.js
echo screenshot-*.js
echo.
echo # Backup files
echo *.bak
echo *.old
echo *.tmp
echo *.backup
echo.
echo # Excel data files ^(keep templates^)
echo *.xlsx
echo !template-*.xlsx
echo.
echo # Large binary files
echo laravel
echo laravel.local*
echo.
echo # Node modules and vendor ^(already in .gitignore but ensure^)
echo /node_modules
echo /vendor
echo.
echo # IDE specific files
echo .idea/
echo .vscode/
echo *.sublime-*
echo.
echo # OS specific files
echo Thumbs.db
echo .DS_Store
echo desktop.ini
) >> ".gitignore"

echo    ✅ .gitignore updated with security patterns

echo.
echo 🗑️  Removing cached files from Git...
echo    ⚠️  Note: Files tetap ada di local, hanya dihapus dari Git tracking
echo.

REM Remove cached sensitive files from Git
git rm --cached .env 2>nul
if %errorlevel%==0 (
    echo    ✅ Removed from Git: .env
) else (
    echo    ⏭️  Skip: .env ^(not tracked or already removed^)
)

git rm -r --cached .wwebjs_cache 2>nul
if %errorlevel%==0 (
    echo    ✅ Removed from Git: .wwebjs_cache/
) else (
    echo    ⏭️  Skip: .wwebjs_cache/ ^(not tracked^)
)

git rm -r --cached whatsapp-auth 2>nul
if %errorlevel%==0 (
    echo    ✅ Removed from Git: whatsapp-auth/
) else (
    echo    ⏭️  Skip: whatsapp-auth/ ^(not tracked^)
)

git rm --cached database/database.sqlite 2>nul
if %errorlevel%==0 (
    echo    ✅ Removed from Git: database/database.sqlite
) else (
    echo    ⏭️  Skip: database.sqlite ^(not tracked^)
)

git rm --cached "Teknik Pengambilan keputusan.xlsx" 2>nul
if %errorlevel%==0 (
    echo    ✅ Removed from Git: Teknik Pengambilan keputusan.xlsx
) else (
    echo    ⏭️  Skip: Excel file ^(not tracked^)
)

REM Remove organized files if they were moved
git rm --cached docs/*.md docs/*.txt 2>nul
git rm --cached scripts/*.bat 2>nul

echo.
echo 📊 Check Git status...
echo.

git status --short

echo.
echo ═══════════════════════════════════════════════════════════════
echo.
echo ✅ FIX GITIGNORE SELESAI!
echo.
echo 📋 Summary:
echo    • .gitignore updated dengan security patterns
echo    • Sensitive files removed dari Git tracking
echo    • Files tetap ada di local (aman!)
echo.
echo 🔴 CRITICAL ACTION REQUIRED:
echo.
echo    ⚠️  GOOGLE CLIENT SECRET EXPOSED!
echo    
echo    Lakukan SEKARANG:
echo    1. Buka: https://console.cloud.google.com/
echo    2. Pilih project Anda
echo    3. Credentials → OAuth 2.0 Client IDs
echo    4. REGENERATE secret yang lama
echo    5. Update .env dengan secret yang baru
echo    6. JANGAN commit .env lagi!
echo.
echo 💡 Next steps:
echo    1. git add .gitignore
echo    2. git commit -m "fix: update .gitignore and remove sensitive files"
echo    3. git push
echo.
echo    Setelah push, tim lain akan otomatis ignore file sensitif!
echo.
echo ⚠️  Jika ada masalah, restore dari: .gitignore.backup
echo.
pause
