@echo off
chcp 65001 >nul
echo.
echo ╔══════════════════════════════════════════════════════════════╗
echo ║          🗑️  CLEANUP SCRIPT - SISKAOBE POLITALA              ║
echo ║     Menghapus file testing, debug, dan backup yang           ║
echo ║              tidak diperlukan untuk production               ║
echo ╚══════════════════════════════════════════════════════════════╝
echo.

echo 📋 File yang akan dihapus:
echo.
echo   ❌ Testing/Debug Files:
echo      • read-bobot.php
echo      • read-excel-temp.php
echo      • debug-session.php
echo      • test-wa-simple.ps1
echo      • test-whatsapp.ps1
echo      • screenshot-all-pages.js
echo.
echo   ❌ Backup/Unknown Files:
echo      • laravel.local.bak
echo      • ${DB_DATABASE}
echo      • s (unknown file)
echo.
echo   ⚠️  Optional (akan ditanyakan):
echo      • Teknik Pengambilan keputusan.xlsx
echo.

set /p confirm="Lanjutkan hapus file-file di atas? (Y/N): "
if /i not "%confirm%"=="Y" (
    echo.
    echo ❌ Cleanup dibatalkan.
    pause
    exit /b
)

echo.
echo 🗑️  Menghapus file testing/debug...

REM Testing/Debug Files
if exist "read-bobot.php" (
    del /f "read-bobot.php"
    echo    ✅ Deleted: read-bobot.php
) else (
    echo    ⏭️  Skip: read-bobot.php (not found)
)

if exist "read-excel-temp.php" (
    del /f "read-excel-temp.php"
    echo    ✅ Deleted: read-excel-temp.php
) else (
    echo    ⏭️  Skip: read-excel-temp.php (not found)
)

if exist "debug-session.php" (
    del /f "debug-session.php"
    echo    ✅ Deleted: debug-session.php
) else (
    echo    ⏭️  Skip: debug-session.php (not found)
)

if exist "test-wa-simple.ps1" (
    del /f "test-wa-simple.ps1"
    echo    ✅ Deleted: test-wa-simple.ps1
) else (
    echo    ⏭️  Skip: test-wa-simple.ps1 (not found)
)

if exist "test-whatsapp.ps1" (
    del /f "test-whatsapp.ps1"
    echo    ✅ Deleted: test-whatsapp.ps1
) else (
    echo    ⏭️  Skip: test-whatsapp.ps1 (not found)
)

if exist "screenshot-all-pages.js" (
    del /f "screenshot-all-pages.js"
    echo    ✅ Deleted: screenshot-all-pages.js
) else (
    echo    ⏭️  Skip: screenshot-all-pages.js (not found)
)

echo.
echo 🗑️  Menghapus file backup...

if exist "laravel.local.bak" (
    del /f "laravel.local.bak"
    echo    ✅ Deleted: laravel.local.bak (~180KB freed)
) else (
    echo    ⏭️  Skip: laravel.local.bak (not found)
)

if exist "${DB_DATABASE}" (
    del /f "${DB_DATABASE}"
    echo    ✅ Deleted: ${DB_DATABASE} (~147KB freed)
) else (
    echo    ⏭️  Skip: ${DB_DATABASE} (not found)
)

if exist "s" (
    del /f "s"
    echo    ✅ Deleted: s (unknown file)
) else (
    echo    ⏭️  Skip: s (not found)
)

echo.
set /p delete_excel="Hapus 'Teknik Pengambilan keputusan.xlsx'? (Y/N): "
if /i "%delete_excel%"=="Y" (
    if exist "Teknik Pengambilan keputusan.xlsx" (
        del /f "Teknik Pengambilan keputusan.xlsx"
        echo    ✅ Deleted: Teknik Pengambilan keputusan.xlsx (~22KB freed)
    ) else (
        echo    ⏭️  Skip: File not found
    )
) else (
    echo    ⏭️  Skipped: Teknik Pengambilan keputusan.xlsx
)

echo.
echo ═══════════════════════════════════════════════════════════════
echo.
echo ✅ CLEANUP SELESAI!
echo.
echo 📊 Estimasi space yang dibebaskan: ~350-550KB
echo.
echo 💡 Next steps:
echo    1. Jalankan: organize.bat (pindahkan file ke folder yang sesuai)
echo    2. Jalankan: fix-gitignore.bat (fix security issues)
echo.
pause
