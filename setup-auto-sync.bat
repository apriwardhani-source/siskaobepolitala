@echo off
echo ========================================
echo    SETUP AUTO DATA SYNC
echo ========================================
echo.
echo Script ini akan mengaktifkan auto-sync data
echo setiap kali push/pull dari Git
echo.

cd .git\hooks

echo Installing Git Hooks...
echo.

REM Windows Git hooks
copy /Y pre-push.bat pre-push >nul 2>&1
copy /Y post-merge.bat post-merge >nul 2>&1

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
