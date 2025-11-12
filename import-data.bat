@echo off
echo ========================================
echo    IMPORT DATABASE FROM JSON
echo ========================================
echo.
echo Script ini akan import data dari JSON files
echo.

php artisan db:import

echo.
echo ========================================
echo    IMPORT COMPLETED!
echo ========================================
echo.
echo Database sudah ter-update dengan data terbaru!
echo.
pause
