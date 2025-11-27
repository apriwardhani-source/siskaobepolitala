@echo off
chcp 65001 >nul
echo.
echo ╔══════════════════════════════════════════════════════════════╗
echo ║         📁 ORGANIZE SCRIPT - SISKAOBE POLITALA               ║
echo ║     Memindahkan file ke folder yang sesuai untuk            ║
echo ║              struktur project yang lebih rapi                ║
echo ╚══════════════════════════════════════════════════════════════╝
echo.

echo 📋 Perubahan yang akan dilakukan:
echo.
echo   📁 Buat folder baru:
echo      • docs/           (untuk dokumentasi)
echo      • scripts/        (untuk batch scripts)
echo.
echo   📄 Pindahkan dokumentasi ke docs/:
echo      • AUTO_SYNC.md
echo      • CHANGELOG_AUTO_SYNC.md
echo      • DATA_SYNC_GUIDE.md
echo      • WHATSAPP_NOTIFICATION_GUIDE.md
echo      • SETUP_TIM.md
echo      • PESAN_UNTUK_TIM.txt
echo      • UPDATE_TIM.txt
echo.
echo   🔧 Pindahkan scripts ke scripts/:
echo      • export-data.bat
echo      • import-data.bat
echo      • sync-data.bat
echo      • setup-auto-sync.bat
echo      • setup-git-hooks.bat
echo      • start-dev.bat
echo      • QUICK_SETUP_TIM.bat
echo.

set /p confirm="Lanjutkan organize files? (Y/N): "
if /i not "%confirm%"=="Y" (
    echo.
    echo ❌ Organize dibatalkan.
    pause
    exit /b
)

echo.
echo 📁 Membuat folder...

if not exist "docs" (
    mkdir "docs"
    echo    ✅ Created: docs/
) else (
    echo    ⏭️  Already exists: docs/
)

if not exist "scripts" (
    mkdir "scripts"
    echo    ✅ Created: scripts/
) else (
    echo    ⏭️  Already exists: scripts/
)

echo.
echo 📄 Memindahkan dokumentasi ke docs/...

if exist "AUTO_SYNC.md" (
    move "AUTO_SYNC.md" "docs\"
    echo    ✅ Moved: AUTO_SYNC.md → docs/
) else (
    echo    ⏭️  Skip: AUTO_SYNC.md (not found)
)

if exist "CHANGELOG_AUTO_SYNC.md" (
    move "CHANGELOG_AUTO_SYNC.md" "docs\"
    echo    ✅ Moved: CHANGELOG_AUTO_SYNC.md → docs/
) else (
    echo    ⏭️  Skip: CHANGELOG_AUTO_SYNC.md (not found)
)

if exist "DATA_SYNC_GUIDE.md" (
    move "DATA_SYNC_GUIDE.md" "docs\"
    echo    ✅ Moved: DATA_SYNC_GUIDE.md → docs/
) else (
    echo    ⏭️  Skip: DATA_SYNC_GUIDE.md (not found)
)

if exist "WHATSAPP_NOTIFICATION_GUIDE.md" (
    move "WHATSAPP_NOTIFICATION_GUIDE.md" "docs\"
    echo    ✅ Moved: WHATSAPP_NOTIFICATION_GUIDE.md → docs/
) else (
    echo    ⏭️  Skip: WHATSAPP_NOTIFICATION_GUIDE.md (not found)
)

if exist "SETUP_TIM.md" (
    move "SETUP_TIM.md" "docs\"
    echo    ✅ Moved: SETUP_TIM.md → docs/
) else (
    echo    ⏭️  Skip: SETUP_TIM.md (not found)
)

if exist "PESAN_UNTUK_TIM.txt" (
    move "PESAN_UNTUK_TIM.txt" "docs\"
    echo    ✅ Moved: PESAN_UNTUK_TIM.txt → docs/
) else (
    echo    ⏭️  Skip: PESAN_UNTUK_TIM.txt (not found)
)

if exist "UPDATE_TIM.txt" (
    move "UPDATE_TIM.txt" "docs\"
    echo    ✅ Moved: UPDATE_TIM.txt → docs/
) else (
    echo    ⏭️  Skip: UPDATE_TIM.txt (not found)
)

echo.
echo 🔧 Memindahkan scripts ke scripts/...

if exist "export-data.bat" (
    move "export-data.bat" "scripts\"
    echo    ✅ Moved: export-data.bat → scripts/
) else (
    echo    ⏭️  Skip: export-data.bat (not found)
)

if exist "import-data.bat" (
    move "import-data.bat" "scripts\"
    echo    ✅ Moved: import-data.bat → scripts/
) else (
    echo    ⏭️  Skip: import-data.bat (not found)
)

if exist "sync-data.bat" (
    move "sync-data.bat" "scripts\"
    echo    ✅ Moved: sync-data.bat → scripts/
) else (
    echo    ⏭️  Skip: sync-data.bat (not found)
)

if exist "setup-auto-sync.bat" (
    move "setup-auto-sync.bat" "scripts\"
    echo    ✅ Moved: setup-auto-sync.bat → scripts/
) else (
    echo    ⏭️  Skip: setup-auto-sync.bat (not found)
)

if exist "setup-git-hooks.bat" (
    move "setup-git-hooks.bat" "scripts\"
    echo    ✅ Moved: setup-git-hooks.bat → scripts/
) else (
    echo    ⏭️  Skip: setup-git-hooks.bat (not found)
)

if exist "start-dev.bat" (
    move "start-dev.bat" "scripts\"
    echo    ✅ Moved: start-dev.bat → scripts/
) else (
    echo    ⏭️  Skip: start-dev.bat (not found)
)

if exist "QUICK_SETUP_TIM.bat" (
    move "QUICK_SETUP_TIM.bat" "scripts\"
    echo    ✅ Moved: QUICK_SETUP_TIM.bat → scripts/
) else (
    echo    ⏭️  Skip: QUICK_SETUP_TIM.bat (not found)
)

echo.
echo 📝 Rename .env.development.example → .env.example...

if exist ".env.development.example" (
    if exist ".env.example" (
        echo    ⚠️  .env.example sudah ada, skip rename
    ) else (
        move ".env.development.example" ".env.example"
        echo    ✅ Renamed: .env.development.example → .env.example
    )
) else (
    echo    ⏭️  Skip: .env.development.example (not found)
)

echo.
echo ═══════════════════════════════════════════════════════════════
echo.
echo ✅ ORGANIZE SELESAI!
echo.
echo 📁 Struktur baru:
echo    • docs/           - Semua dokumentasi MD & TXT
echo    • scripts/        - Semua batch automation scripts
echo    • .env.example    - Template environment
echo.
echo 💡 Next step:
echo    Jalankan: fix-gitignore.bat (fix security issues!)
echo.
echo ⚠️  PENTING:
echo    Jika ada script lain yang reference ke file yang dipindah,
echo    update path-nya ya! (misal di README atau workflow)
echo.
pause
