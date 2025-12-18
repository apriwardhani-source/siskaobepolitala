@echo off
echo ========================================
echo    SISKAPE DATA SYNC SCRIPT
echo ========================================
echo.
echo Script ini akan sinkronisasi data dari seeder
echo.

echo [1/4] Pulling latest code from Git...
git pull
if %errorlevel% neq 0 (
    echo ERROR: Git pull failed!
    pause
    exit /b 1
)
echo.

echo [2/4] Running migrations...
php artisan migrate
if %errorlevel% neq 0 (
    echo ERROR: Migration failed!
    pause
    exit /b 1
)
echo.

echo [3/4] Importing data from JSON exports...
php artisan db:import
if %errorlevel% neq 0 (
    echo ERROR: Import failed!
    pause
    exit /b 1
)
echo.

echo [4/4] Clearing cache...
php artisan cache:clear
php artisan view:clear
echo.

echo ========================================
echo    SYNC COMPLETED SUCCESSFULLY!
echo ========================================
echo.
echo Data mahasiswa dan lainnya sudah ter-update.
echo Silakan jalankan aplikasi dengan: php artisan serve
echo.
pause
