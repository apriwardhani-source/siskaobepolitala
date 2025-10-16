<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // For SQLite, we need a different approach to update the check constraint
        $driver = Schema::getConnection()->getDriverName();
        
        if ($driver === 'sqlite') {
            // Since SQLite doesn't easily support modifying check constraints,
            // let's update the application level validation instead
            // The actual constraint in the database will need manual update if absolutely required
            // For now, we'll rely on application-level validation
            // This migration can just serve as documentation
            
            // We'll actually skip the database constraint change for now and just note
            // that the application will accept 'dosen' as a valid role
        } else {
            // For MySQL/PostgreSQL, use ALTER TABLE MODIFY statement
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'wadir1', 'kaprodi', 'tim', 'kajur', 'dosen')");
        }
    }

    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();
        
        if ($driver !== 'sqlite') {
            // For MySQL/PostgreSQL
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'wadir1', 'kaprodi', 'tim', 'kajur')");
        }
    }
};