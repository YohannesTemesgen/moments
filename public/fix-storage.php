<?php
/**
 * cPanel Storage Fix Script
 * Upload this file to your public_html folder and run it once
 * Then DELETE this file for security
 * 
 * Access via: https://birthday.meraix.com/fix-storage.php
 * 
 * This script works for both local (XAMPP) and cPanel environments
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>";
echo "=== STORAGE FIX SCRIPT (Local + cPanel) ===\n\n";

// Define paths - works for both local and cPanel
$publicPath = __DIR__;
$basePath = dirname(__DIR__);

// Detect environment
$isCpanel = strpos($publicPath, 'public_html') !== false;
$isXampp = strpos($publicPath, 'xampp') !== false || strpos($publicPath, 'htdocs') !== false;

echo "Environment: " . ($isCpanel ? 'cPanel' : ($isXampp ? 'XAMPP/Local' : 'Unknown')) . "\n\n";

$storagePath = $basePath . '/storage/app/public';
$linkPath = $publicPath . '/storage';

echo "1. PATH INFORMATION:\n";
echo "   Public path: $publicPath\n";
echo "   Storage path: $storagePath\n";
echo "   Link path: $linkPath\n\n";

// Check if storage source exists
echo "2. CHECKING SOURCE DIRECTORY:\n";
if (is_dir($storagePath)) {
    echo "   ✅ Storage source exists: $storagePath\n";
    
    // List files in storage
    $files = scandir($storagePath);
    echo "   Files in storage/app/public:\n";
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $fullPath = $storagePath . '/' . $file;
            if (is_dir($fullPath)) {
                $subFiles = scandir($fullPath);
                $count = count($subFiles) - 2;
                echo "      📁 $file/ ($count files)\n";
            } else {
                echo "      📄 $file\n";
            }
        }
    }
} else {
    echo "   ❌ Storage source NOT found: $storagePath\n";
    echo "   Creating directory...\n";
    if (mkdir($storagePath, 0755, true)) {
        echo "   ✅ Directory created\n";
    } else {
        echo "   ❌ Failed to create directory\n";
    }
}
echo "\n";

// Check current state of public/storage
echo "3. CHECKING PUBLIC/STORAGE:\n";
if (is_link($linkPath)) {
    echo "   ✅ Symlink exists\n";
    echo "   Target: " . readlink($linkPath) . "\n";
    if (file_exists($linkPath)) {
        echo "   ✅ Symlink is valid\n";
    } else {
        echo "   ❌ Symlink is broken - removing...\n";
        unlink($linkPath);
    }
} elseif (is_dir($linkPath)) {
    echo "   ⚠️ Regular directory exists (not a symlink)\n";
    echo "   This may be causing issues. Consider removing and creating symlink.\n";
} else {
    echo "   ❌ public/storage does not exist\n";
}
echo "\n";

// Try to create symlink
echo "4. CREATING STORAGE LINK:\n";
if (!file_exists($linkPath)) {
    // Try relative path first (works better on some hosts)
    $relativePath = '../storage/app/public';
    
    echo "   Attempting to create symlink...\n";
    echo "   From: $linkPath\n";
    echo "   To: $relativePath\n";
    
    // Try symlink
    if (@symlink($relativePath, $linkPath)) {
        echo "   ✅ Symlink created successfully!\n";
    } else {
        echo "   ⚠️ Symlink failed (common on shared hosting)\n";
        echo "   Trying alternative: copying files...\n";
        
        // Alternative: Copy files instead of symlink
        if (!is_dir($linkPath)) {
            mkdir($linkPath, 0755, true);
        }
        
        // Copy the moments folder
        $sourceDir = $storagePath . '/moments';
        $destDir = $linkPath . '/moments';
        
        if (is_dir($sourceDir)) {
            if (!is_dir($destDir)) {
                mkdir($destDir, 0755, true);
            }
            
            $copied = 0;
            $files = scandir($sourceDir);
            foreach ($files as $file) {
                if ($file != '.' && $file != '..') {
                    $src = $sourceDir . '/' . $file;
                    $dst = $destDir . '/' . $file;
                    if (copy($src, $dst)) {
                        chmod($dst, 0644);
                        $copied++;
                    }
                }
            }
            echo "   ✅ Copied $copied files to public/storage/moments/\n";
        } else {
            echo "   ⚠️ No moments folder found in storage\n";
        }
    }
} else {
    echo "   Storage link already exists\n";
}
echo "\n";

// Verify the fix
echo "5. VERIFICATION:\n";
$testFile = $linkPath . '/moments';
if (is_dir($testFile)) {
    $files = scandir($testFile);
    $count = count($files) - 2;
    echo "   ✅ public/storage/moments exists with $count files\n";
    
    // List first 5 files
    $shown = 0;
    foreach ($files as $file) {
        if ($file != '.' && $file != '..' && $shown < 5) {
            echo "      - $file\n";
            $shown++;
        }
    }
    if ($count > 5) {
        echo "      ... and " . ($count - 5) . " more\n";
    }
} else {
    echo "   ❌ public/storage/moments still not accessible\n";
}
echo "\n";

// Test image access
echo "6. TESTING IMAGE ACCESS:\n";
$momentsPath = $linkPath . '/moments';

// Get APP_URL from .env if available
$appUrl = 'https://birthday.meraix.com';
$envFile = $basePath . '/.env';
if (file_exists($envFile)) {
    $envContent = file_get_contents($envFile);
    if (preg_match('/^APP_URL=(.+)$/m', $envContent, $matches)) {
        $appUrl = trim($matches[1]);
    }
}

if (is_dir($momentsPath)) {
    $files = scandir($momentsPath);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..' && preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file)) {
            $filePath = $momentsPath . '/' . $file;
            $url = rtrim($appUrl, '/') . "/storage/moments/$file";
            echo "   File: $file\n";
            echo "   Exists: " . (file_exists($filePath) ? 'YES' : 'NO') . "\n";
            echo "   Readable: " . (is_readable($filePath) ? 'YES' : 'NO') . "\n";
            echo "   URL: $url\n\n";
            break; // Just test first one
        }
    }
}

echo "=== DONE ===\n";
echo "\n⚠️ SECURITY: Delete this file after use!\n";
echo "</pre>";
