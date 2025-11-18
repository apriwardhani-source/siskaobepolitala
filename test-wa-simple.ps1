# Quick WhatsApp Test
# Ganti nomor di bawah dengan nomor HP kamu

$phoneNumber = "0895414819763"  # <<< GANTI INI dengan nomor kamu
$message = "Test WhatsApp Service - Jika terima pesan ini berarti berhasil!"

Write-Host "Testing WhatsApp to: $phoneNumber" -ForegroundColor Cyan

$body = @{
    number = $phoneNumber
    message = $message
} | ConvertTo-Json

$response = Invoke-RestMethod -Uri "http://localhost:3001/send" `
    -Method POST `
    -ContentType "application/json" `
    -Body $body

if ($response.success) {
    Write-Host "SUCCESS! Check your WhatsApp now!" -ForegroundColor Green
    Write-Host "Sent to: $($response.to)" -ForegroundColor Gray
} else {
    Write-Host "FAILED: $($response.message)" -ForegroundColor Red
}
