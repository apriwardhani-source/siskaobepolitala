/**
 * WhatsApp Broadcast Script (from file)
 * Kirim pesan ke banyak nomor dari file numbers.txt
 * 
 * Usage:
 * 1. Buat file numbers.txt, isi dengan nomor (satu nomor per baris)
 * 2. node broadcast-wa-file.cjs "Pesan yang mau dikirim"
 */

const fs = require('fs');

// Function to send message
async function sendMessage(number, message) {
    try {
        const response = await fetch('http://localhost:3001/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ number, message })
        });

        const result = await response.json();
        return result;
    } catch (error) {
        return { success: false, error: error.message };
    }
}

// Function to check service status
async function checkStatus() {
    try {
        const response = await fetch('http://localhost:3001/status');
        const status = await response.json();
        return status;
    } catch (error) {
        console.error('❌ WhatsApp service tidak berjalan! Jalankan dulu: npm run wa');
        process.exit(1);
    }
}

// Main function
async function main() {
    console.log('📱 WhatsApp Broadcast Tool (File Mode)\n');

    // Check if message provided
    const message = process.argv[2];
    if (!message) {
        console.error('❌ Pesan tidak diberikan!');
        console.log('\nUsage:');
        console.log('node broadcast-wa-file.cjs "Pesan yang mau dikirim"\n');
        process.exit(1);
    }

    // Check if numbers.txt exists
    if (!fs.existsSync('numbers.txt')) {
        console.error('❌ File numbers.txt tidak ditemukan!');
        console.log('\nBuat file numbers.txt dengan format:');
        console.log('08123456789');
        console.log('08234567890');
        console.log('628345678901\n');
        process.exit(1);
    }

    // Read numbers from file
    const numbersContent = fs.readFileSync('numbers.txt', 'utf-8');
    const numbers = numbersContent
        .split('\n')
        .map(n => n.trim())
        .filter(n => n && !n.startsWith('#')); // Skip empty lines and comments

    if (numbers.length === 0) {
        console.error('❌ Tidak ada nomor di file numbers.txt!');
        process.exit(1);
    }

    // Check service status
    const status = await checkStatus();
    if (status.status !== 'connected') {
        console.error('❌ WhatsApp belum connected! Scan QR code dulu: http://localhost:3001/qr');
        process.exit(1);
    }

    console.log('✅ WhatsApp Connected!');
    console.log(`📋 Total ${numbers.length} nomor akan dikirim pesan`);
    console.log(`📝 Pesan: "${message}"\n`);

    let successCount = 0;
    let failedCount = 0;

    // Send messages with delay to avoid spam
    for (let i = 0; i < numbers.length; i++) {
        const number = numbers[i];
        console.log(`[${i + 1}/${numbers.length}] Mengirim ke ${number}...`);

        const result = await sendMessage(number, message);

        if (result.success) {
            console.log(`✅ Berhasil ke ${number}`);
            successCount++;
        } else {
            console.log(`❌ Gagal ke ${number}: ${result.message || result.error}`);
            failedCount++;
        }

        // Delay 2 seconds between messages to avoid spam
        if (i < numbers.length - 1) {
            await new Promise(resolve => setTimeout(resolve, 2000));
        }
    }

    console.log('\n📊 Summary:');
    console.log(`✅ Berhasil: ${successCount}`);
    console.log(`❌ Gagal: ${failedCount}`);
    console.log(`📋 Total: ${numbers.length}\n`);
}

main();
