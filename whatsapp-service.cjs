/**
 * WhatsApp Service using whatsapp-web.js
 * Simple & Reliable WhatsApp Integration
 */

const { Client, LocalAuth } = require('whatsapp-web.js');
const qrcode = require('qrcode-terminal');
const express = require('express');

const app = express();
app.use(express.json());

// Initialize WhatsApp Client
const client = new Client({
    authStrategy: new LocalAuth({
        dataPath: './whatsapp-auth'
    }),
    puppeteer: {
        args: ['--no-sandbox', '--disable-setuid-sandbox']
    }
});

let isReady = false;
let qrCodeData = null;

// QR Code Event
client.on('qr', (qr) => {
    console.log('\n🔥 QR CODE MUNCUL! Scan dengan WhatsApp di HP kamu:\n');
    qrcode.generate(qr, { small: true });
    console.log('\nAtau buka browser: http://localhost:3000/qr\n');
    qrCodeData = qr;
});

// Ready Event
client.on('ready', () => {
    console.log('✅ WhatsApp Connected & Ready!');
    isReady = true;
    qrCodeData = null;
});

// Authenticated Event
client.on('authenticated', () => {
    console.log('✅ WhatsApp Authenticated!');
});

// Disconnected Event
client.on('disconnected', (reason) => {
    console.log('⚠️ WhatsApp Disconnected:', reason);
    isReady = false;
});

// Initialize Client
console.log('🚀 Starting WhatsApp Service...');
client.initialize();

// API Endpoints
app.get('/status', (req, res) => {
    res.json({
        status: isReady ? 'connected' : 'disconnected',
        hasQR: !!qrCodeData
    });
});

app.get('/qr', (req, res) => {
    if (!qrCodeData) {
        return res.send('<h1>QR Code tidak tersedia. Mungkin sudah connected!</h1>');
    }
    
    const QRCode = require('qrcode');
    QRCode.toDataURL(qrCodeData, (err, url) => {
        if (err) {
            return res.send('<h1>Error generating QR Code</h1>');
        }
        res.send(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>WhatsApp QR Code</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                        min-height: 100vh;
                        margin: 0;
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                        color: white;
                    }
                    .container {
                        text-align: center;
                        background: white;
                        padding: 40px;
                        border-radius: 20px;
                        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
                    }
                    h1 {
                        color: #333;
                        margin-bottom: 20px;
                    }
                    img {
                        max-width: 300px;
                        border: 5px solid #25D366;
                        border-radius: 10px;
                    }
                    .instructions {
                        color: #666;
                        margin-top: 20px;
                        line-height: 1.6;
                    }
                    .step {
                        margin: 10px 0;
                        font-size: 14px;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <h1>📱 Scan QR Code WhatsApp</h1>
                    <img src="${url}" alt="QR Code" />
                    <div class="instructions">
                        <div class="step">1. Buka <strong>WhatsApp</strong> di HP</div>
                        <div class="step">2. Tap <strong>⋮</strong> (3 titik) → <strong>Linked Devices</strong></div>
                        <div class="step">3. Tap <strong>Link a Device</strong></div>
                        <div class="step">4. <strong>Scan</strong> QR code di atas</div>
                    </div>
                </div>
                <script>
                    // Auto refresh every 5 seconds
                    setTimeout(() => location.reload(), 5000);
                </script>
            </body>
            </html>
        `);
    });
});

app.post('/send', async (req, res) => {
    if (!isReady) {
        return res.status(503).json({
            success: false,
            message: 'WhatsApp not connected. Please scan QR code first.'
        });
    }

    const { number, message } = req.body;

    if (!number || !message) {
        return res.status(400).json({
            success: false,
            message: 'Number and message are required'
        });
    }

    try {
        // Format number: remove +, -, spaces
        const formattedNumber = number.replace(/[^\d]/g, '');
        const chatId = formattedNumber + '@c.us';

        await client.sendMessage(chatId, message);

        res.json({
            success: true,
            message: 'Message sent successfully',
            to: formattedNumber
        });
    } catch (error) {
        console.error('Error sending message:', error);
        res.status(500).json({
            success: false,
            message: 'Failed to send message',
            error: error.message
        });
    }
});

// Start Server
const PORT = 3001; // Changed to 3001 to avoid conflict
app.listen(PORT, () => {
    console.log(`\n📡 WhatsApp Service running on http://localhost:${PORT}`);
    console.log(`📱 QR Code URL: http://localhost:${PORT}/qr`);
    console.log(`📊 Status API: http://localhost:${PORT}/status`);
    console.log(`📤 Send API: POST http://localhost:${PORT}/send\n`);
});
