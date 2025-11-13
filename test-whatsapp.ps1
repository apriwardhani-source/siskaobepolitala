# Test WhatsApp Service
# Ganti nomor dengan nomor dosen yang mau di-test

Write-Host "🧪 Testing WhatsApp Service..." -ForegroundColor Cyan
Write-Host ""

# Test 1: Check Status
Write-Host "1️⃣ Checking WhatsApp status..." -ForegroundColor Yellow
try {
    $status = Invoke-RestMethod -Uri "http://localhost:3001/status" -Method GET
    Write-Host "✅ Status: $($status.status)" -ForegroundColor Green
    Write-Host "   Has QR: $($status.hasQR)" -ForegroundColor Gray
} catch {
    Write-Host "❌ Failed to get status: $($_.Exception.Message)" -ForegroundColor Red
    exit 1
}

Write-Host ""

# Test 2: Send Test Message
Write-Host "2️⃣ Sending test message..." -ForegroundColor Yellow
Write-Host "   Enter phone number (format: 08xxx or 628xxx):" -ForegroundColor Cyan
$phoneNumber = Read-Host "   Phone"

if (-not $phoneNumber) {
    Write-Host "❌ Phone number is required!" -ForegroundColor Red
    exit 1
}

$testMessage = "Test dari WhatsApp Service!

Ini test message untuk memastikan notifikasi berfungsi.

Jika terima pesan ini, WhatsApp service BERHASIL!

Waktu: $(Get-Date -Format 'dd MMM yyyy HH:mm')"

$body = @{
    "number" = $phoneNumber
    "message" = $testMessage
} | ConvertTo-Json

Write-Host "   Sending to: $phoneNumber" -ForegroundColor Gray

try {
    $response = Invoke-RestMethod -Uri "http://localhost:3001/send" `
        -Method POST `
        -ContentType "application/json" `
        -Body $body
    
    if ($response.success) {
        Write-Host "✅ Message sent successfully!" -ForegroundColor Green
        Write-Host "   To: $($response.to)" -ForegroundColor Gray
        Write-Host ""
        Write-Host "📱 Check your WhatsApp now!" -ForegroundColor Cyan
    } else {
        Write-Host "❌ Failed: $($response.message)" -ForegroundColor Red
    }
} catch {
    Write-Host "❌ Error: $($_.Exception.Message)" -ForegroundColor Red
    Write-Host ""
    Write-Host "Response:" -ForegroundColor Yellow
    Write-Host $_.ErrorDetails.Message -ForegroundColor Gray
}

Write-Host ""
Write-Host "Test selesai!" -ForegroundColor Cyan
