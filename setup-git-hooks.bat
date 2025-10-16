@echo off
echo ========================================
echo   Setup Git Hooks for Auto-Sync
echo ========================================
echo.

REM Copy post-merge hook
copy /Y ".git\hooks\post-merge.bat" ".git\hooks\post-merge" >nul

echo [32m✅ Git hooks installed successfully![0m
echo.
echo What this does:
echo - After every 'git pull', cache will auto-clear
echo - Database changes will be immediately detected
echo - Your team's data will auto-sync
echo.
echo [36mℹ️  Tell your teammates to run this script too:[0m
echo    setup-git-hooks.bat
echo.
pause
