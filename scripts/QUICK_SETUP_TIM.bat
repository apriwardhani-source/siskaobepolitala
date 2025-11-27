@echo off
color 0A
echo.
echo ========================================
echo    QUICK SETUP - AUTO SYNC DATA
echo ========================================
echo.
echo Script ini akan:
echo 1. Install Git Hooks
echo 2. Import data yang sudah ada
echo 3. Test hooks
echo.
pause
echo.

echo [1/3] Installing Git Hooks...
call setup-auto-sync.bat

echo.
echo [2/3] Importing existing data...
php artisan db:import

echo.
echo [3/3] Testing hooks...
echo Running: git push --dry-run
git push --dry-run 2>&1 | findstr /C:"Auto-exporting" >nul
if %errorlevel% equ 0 (
    echo ✅ Hooks working perfectly!
) else (
    echo ⚠️  Hook might not be working, but files are installed
)

echo.
echo ========================================
echo    SETUP COMPLETED!
echo ========================================
echo.
echo Next steps:
echo - Setiap git pull → Data otomatis sync!
echo - Setiap git push → Data otomatis export!
echo.
echo Happy coding! 🚀
echo.
pause
