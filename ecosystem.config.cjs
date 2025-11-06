// PM2 Configuration untuk WhatsApp Service
module.exports = {
  apps: [{
    name: 'whatsapp-service',
    script: './whatsapp-service.cjs',
    instances: 1,
    autorestart: true,
    watch: false,
    max_memory_restart: '500M',
    env: {
      NODE_ENV: 'production'
    },
    error_file: './storage/logs/whatsapp-error.log',
    out_file: './storage/logs/whatsapp-out.log',
    log_file: './storage/logs/whatsapp-combined.log',
    time: true
  }]
};
