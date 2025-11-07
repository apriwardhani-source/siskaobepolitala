<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class WhatsAppServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:service {action : start, stop, restart, status}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage WhatsApp Service (PM2)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');
        
        switch ($action) {
            case 'start':
                return $this->startService();
            case 'stop':
                return $this->stopService();
            case 'restart':
                return $this->restartService();
            case 'status':
                return $this->checkStatus();
            default:
                $this->error('Invalid action! Use: start, stop, restart, or status');
                return 1;
        }
    }
    
    private function startService()
    {
        $this->info('🚀 Starting WhatsApp Service...');
        
        // Check if PM2 is installed
        $pm2Check = shell_exec('pm2 --version 2>&1');
        if (empty($pm2Check)) {
            $this->error('❌ PM2 not installed! Install with: npm install -g pm2');
            return 1;
        }
        
        // Start service with PM2
        $result = shell_exec('pm2 start ecosystem.config.js 2>&1');
        $this->line($result);
        
        if (strpos($result, 'online') !== false || strpos($result, 'already') !== false) {
            $this->info('✅ WhatsApp Service started successfully!');
            $this->info('📱 Scan QR code at: ' . url('/admin/whatsapp/connect'));
            return 0;
        }
        
        $this->error('❌ Failed to start service');
        return 1;
    }
    
    private function stopService()
    {
        $this->info('🛑 Stopping WhatsApp Service...');
        $result = shell_exec('pm2 stop whatsapp-service 2>&1');
        $this->line($result);
        $this->info('✅ Service stopped');
        return 0;
    }
    
    private function restartService()
    {
        $this->info('🔄 Restarting WhatsApp Service...');
        $result = shell_exec('pm2 restart whatsapp-service 2>&1');
        $this->line($result);
        $this->info('✅ Service restarted');
        return 0;
    }
    
    private function checkStatus()
    {
        $this->info('📊 WhatsApp Service Status:');
        $result = shell_exec('pm2 list 2>&1');
        $this->line($result);
        return 0;
    }
}
