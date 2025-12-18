@echo off
echo ========================================
echo    SETUP AUTO DATA SYNC
echo ========================================
echo.
echo Script ini akan mengaktifkan auto-sync data
echo setiap kali push/pull dari Git
echo.

echo Installing Git Hooks...
echo.

REM Create hooks from .bat files
echo Creating pre-push hook...
(
echo #!/bin/sh
echo echo ""
echo echo "🔄 Auto-exporting database before push..."
echo echo ""
echo php artisan db:export
echo if [ $? -eq 0 ]; then
echo     echo ""
echo     echo "✅ Database exported successfully!"
echo     echo ""
echo else
echo     echo "❌ Database export failed!"
echo fi
echo echo ""
echo exit 0
) > .git\hooks\pre-push

echo Creating post-merge hook...
(
echo #!/bin/sh
echo echo ""
echo echo "🔄 Auto-importing database after pull..."
echo echo ""
echo if [ -d "storage/app/database-exports" ]; then
echo     if ls storage/app/database-exports/*.json 1^> /dev/null 2^>^&1; then
echo         php artisan db:import
echo         if [ $? -eq 0 ]; then
echo             echo ""
echo             echo "✅ Database imported successfully!"
echo             echo "📊 Your data is now synced!"
echo         else
echo             echo "❌ Import failed!"
echo         fi
echo     fi
echo fi
echo echo ""
echo exit 0
) > .git\hooks\post-merge

echo ✅ pre-push hook installed (auto export before push)
echo ✅ post-merge hook installed (auto import after pull)

echo.
echo ========================================
echo    SETUP COMPLETED!
echo ========================================
echo.
echo Sekarang:
echo - Setiap PUSH → Data otomatis di-export
echo - Setiap PULL → Data otomatis di-import
echo.
echo NO MORE MANUAL COMMANDS! 🎉
echo.
pause
