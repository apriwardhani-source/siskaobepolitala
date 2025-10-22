const puppeteer = require('puppeteer');
const fs = require('fs');
const path = require('path');

(async () => {
  // Buat folder output
  const outputDir = './figma-screenshots';
  if (!fs.existsSync(outputDir)){
    fs.mkdirSync(outputDir);
  }

  const browser = await puppeteer.launch({ 
    headless: false, // Set true kalau ga mau liat browser
    defaultViewport: {
      width: 1440,
      height: 900
    }
  });
  
  const page = await browser.newPage();
  
  // ============================================
  // LOGIN DULU (Sesuaikan kredensial kamu)
  // ============================================
  console.log('🔐 Logging in...');
  await page.goto('http://localhost:8000/login');
  await page.type('input[name=email]', 'admin@gmail.com');
  await page.type('input[name=password]', '123456');
  await page.click('button[type=submit]');
  await page.waitForNavigation();
  console.log('✅ Logged in as Admin');

  // ============================================
  // DAFTAR HALAMAN YANG MAU DI-SCREENSHOT
  // ============================================
  const pages = [
    // Authentication
    { url: '/login', name: '01-login', needLogin: false },
    
    // Admin Screens
    { url: '/admin/dashboard', name: '02-admin-dashboard' },
    { url: '/admin/capaianprofillulusan', name: '03-admin-cpl-list' },
    { url: '/admin/capaianprofillulusan/create', name: '04-admin-cpl-create' },
    { url: '/admin/capaianprofillulusan/import', name: '05-admin-cpl-import' },
    { url: '/admin/matakuliah', name: '06-admin-matakuliah-list' },
    { url: '/admin/users', name: '07-admin-users-list' },
    
    // Tim Screens (Login as Tim dulu kalau perlu)
    { url: '/tim/dashboard', name: '08-tim-dashboard', role: 'tim' },
    { url: '/tim/capaianpembelajaranlulusan', name: '09-tim-cpl-list', role: 'tim' },
    { url: '/tim/capaianpembelajaranlulusan/import', name: '10-tim-cpl-import', role: 'tim' },
    { url: '/tim/capaianpembelajaranmatakuliah', name: '11-tim-cpmk-list', role: 'tim' },
    { url: '/tim/capaianpembelajaranmatakuliah/import', name: '12-tim-cpmk-import', role: 'tim' },
    { url: '/tim/matakuliah', name: '13-tim-matakuliah-list', role: 'tim' },
    
    // Dosen Screens
    { url: '/dosen/dashboard', name: '14-dosen-dashboard', role: 'dosen' },
  ];

  // ============================================
  // SCREENSHOT SEMUA HALAMAN
  // ============================================
  for (const p of pages) {
    try {
      console.log(`📸 Capturing: ${p.name}...`);
      
      // Navigate
      await page.goto(`http://localhost:8000${p.url}`, {
        waitUntil: 'networkidle2',
        timeout: 30000
      });
      
      // Wait for content to load
      await page.waitForTimeout(1000);
      
      // Full page screenshot
      await page.screenshot({ 
        path: path.join(outputDir, `${p.name}.png`),
        fullPage: true 
      });
      
      console.log(`✅ Saved: ${p.name}.png`);
      
    } catch (error) {
      console.error(`❌ Failed to capture ${p.name}:`, error.message);
    }
  }

  console.log('\n🎉 All screenshots saved to:', outputDir);
  await browser.close();
})();
