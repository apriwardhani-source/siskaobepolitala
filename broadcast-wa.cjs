/**
 * WhatsApp Broadcast Script
 * Kirim pesan ke banyak nomor sekaligus
 * 
 * Usage:
 * node broadcast-wa.cjs
 */

const readline = require('readline');

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

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
    console.log('📱 WhatsApp Broadcast Tool\n');

    // Check service status
    const status = await checkStatus();
    if (status.status !== 'connected') {
        console.error('❌ WhatsApp belum connected! Scan QR code dulu: http://localhost:3001/qr');
        process.exit(1);
    }

    console.log('✅ WhatsApp Connected!\n');

    // Input numbers
    console.log('Masukkan nomor WhatsApp (pisahkan dengan koma):');
    console.log('Format: 08123456789, 08234567890, 08345678901');
    console.log('Atau format: 628123456789, 628234567890\n');

    rl.question('Nomor: ', async (numbersInput) => {
        const numbers = numbersInput.split(',').map(n => n.trim()).filter(n => n);

        if (numbers.length === 0) {
            console.error('❌ Tidak ada nomor yang diinput!');
            rl.close();
            return;
        }

        console.log(`\n📋 Total ${numbers.length} nomor akan dikirim pesan\n`);

        // Input message
        rl.question('Masukkan pesan yang akan dikirim:\n', async (message) => {
            if (!message.trim()) {
                console.error('❌ Pesan tidak boleh kosong!');
                rl.close();
                return;
            }

            console.log('\n🚀 Mengirim pesan...\n');

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

            rl.close();
        });
    });
}

main();
