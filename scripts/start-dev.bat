@echo off
echo.
echo ================================================
echo   STARTING LARAVEL + VITE DEVELOPMENT SERVER
echo ================================================
echo.
echo Server akan berjalan di:
echo   - Laravel: http://127.0.0.1:8000
echo   - Vite:    http://localhost:5173
echo.
echo Press Ctrl+C to stop
echo.
echo ================================================
echo.

start "Laravel Server" cmd /k "php artisan serve"
timeout /t 2 /nobreak >nul
start "Vite Dev Server" cmd /k "npm run dev"

echo.
echo Servers started! Check the new windows.
echo Open browser: http://127.0.0.1:8000
echo.
pause
