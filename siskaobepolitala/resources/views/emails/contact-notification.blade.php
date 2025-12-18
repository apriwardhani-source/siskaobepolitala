<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #1e3c72;
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
        }
        .info-label {
            font-weight: bold;
            color: #1e3c72;
            display: inline-block;
            min-width: 80px;
        }
        .message-box {
            background: #fff9e6;
            border: 1px solid #ffe066;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .message-content {
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #e9ecef;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            background: #28a745;
            color: white;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔔 PESAN BARU DARI WEBSITE</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">Politala OBE System</p>
        </div>

        <div class="content">
            <p>Halo Admin,</p>
            <p>Anda menerima pesan baru dari form kontak website <strong>Politala OBE</strong>:</p>

            <div class="info-box">
                <div style="margin-bottom: 10px;">
                    <span class="info-label">👤 Nama:</span>
                    <span>{{ $contactData['name'] }}</span>
                </div>
                <div style="margin-bottom: 10px;">
                    <span class="info-label">📧 Email:</span>
                    <span>{{ $contactData['email'] }}</span>
                </div>
                <div>
                    <span class="info-label">📅 Waktu:</span>
                    <span>{{ date('d F Y, H:i') }} WIB</span>
                </div>
            </div>

            <div class="message-box">
                <strong style="color: #856404; display: block; margin-bottom: 10px;">💬 Pesan:</strong>
                <div class="message-content">{{ $contactData['message'] }}</div>
            </div>

            <div class="badge">✅ Pesan ini otomatis tersimpan di database</div>

            <p style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e9ecef;">
                Silakan membalas via email ke: <strong>{{ $contactData['email'] }}</strong>
            </p>
        </div>

        <div class="footer">
            <p style="margin: 5px 0;">Email ini dikirim otomatis oleh sistem Politala OBE</p>
            <p style="margin: 5px 0; color: #999;">© {{ date('Y') }} Politeknik Negeri Tanah Laut</p>
        </div>
    </div>
</body>
</html>
