<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SyncStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:sync {--force : Force sync even if symlink exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync storage files to public directory (for cPanel environments where symlinks fail)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sourcePath = storage_path('app/public');
        $destPath = public_path('storage');

        $this->info('Storage Sync for cPanel/Local Environments');
        $this->info('==========================================');
        $this->newLine();

        // Check if symlink exists and works
        if (is_link($destPath) && !$this->option('force')) {
            if (file_exists($destPath)) {
                $this->info('✅ Storage symlink exists and is valid.');
                $this->info('   Use --force to sync files anyway.');
                return 0;
            } else {
                $this->warn('⚠️ Storage symlink exists but is broken. Removing...');
                unlink($destPath);
            }
        }

        // Try to create symlink first
        if (!file_exists($destPath)) {
            $this->info('Attempting to create symlink...');
            
            if (@symlink($sourcePath, $destPath)) {
                $this->info('✅ Symlink created successfully!');
                return 0;
            } else {
                $this->warn('⚠️ Symlink failed (common on shared hosting). Copying files instead...');
            }
        }

        // Fallback: Copy files
        if (!is_dir($destPath)) {
            mkdir($destPath, 0755, true);
        }

        $this->syncDirectory($sourcePath, $destPath);

        $this->newLine();
        $this->info('✅ Storage sync completed!');
        $this->info('   Note: Run this command after uploading new images in cPanel.');

        return 0;
    }

    /**
     * Recursively sync directories
     */
    protected function syncDirectory($source, $dest)
    {
        if (!is_dir($source)) {
            $this->warn("Source directory does not exist: $source");
            return;
        }

        $files = scandir($source);
        $copied = 0;
        $skipped = 0;

        foreach ($files as $file) {
            if ($file === '.' || $file === '..' || $file === '.gitignore') {
                continue;
            }

            $srcPath = $source . '/' . $file;
            $dstPath = $dest . '/' . $file;

            if (is_dir($srcPath)) {
                if (!is_dir($dstPath)) {
                    mkdir($dstPath, 0755, true);
                    $this->line("  📁 Created: $file/");
                }
                $this->syncDirectory($srcPath, $dstPath);
            } else {
                // Only copy if file doesn't exist or is different
                if (!file_exists($dstPath) || filesize($srcPath) !== filesize($dstPath)) {
                    if (copy($srcPath, $dstPath)) {
                        chmod($dstPath, 0644);
                        $copied++;
                        $this->line("  📄 Copied: $file");
                    }
                } else {
                    $skipped++;
                }
            }
        }

        if ($copied > 0 || $skipped > 0) {
            $this->info("  → $copied files copied, $skipped unchanged");
        }
    }
}
