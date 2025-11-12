@echo off
echo ========================================
echo    EXPORT DATABASE TO JSON
echo ========================================
echo.
echo Script ini akan export data ke JSON files
echo yang bisa di-commit ke Git
echo.

php artisan db:export

echo.
echo ========================================
echo    EXPORT COMPLETED!
echo ========================================
echo.
echo Next steps:
echo 1. git add storage/app/database-exports/*.json
echo 2. git commit -m "Update database exports"
echo 3. git push
echo.
pause
