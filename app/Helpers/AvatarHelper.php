<?php

namespace App\Helpers;

class AvatarHelper
{
    /**
     * Generate avatar color based on name (consistent color for same name)
     * 
     * @param string $name
     * @return array ['bg' => 'background-color', 'text' => 'text-color']
     */
    public static function getAvatarColor($name)
    {
        // Daftar kombinasi warna yang bagus (Google-style)
        $colors = [
            ['bg' => '#F44336', 'text' => '#FFFFFF'], // Red
            ['bg' => '#E91E63', 'text' => '#FFFFFF'], // Pink
            ['bg' => '#9C27B0', 'text' => '#FFFFFF'], // Purple
            ['bg' => '#673AB7', 'text' => '#FFFFFF'], // Deep Purple
            ['bg' => '#3F51B5', 'text' => '#FFFFFF'], // Indigo
            ['bg' => '#2196F3', 'text' => '#FFFFFF'], // Blue
            ['bg' => '#03A9F4', 'text' => '#FFFFFF'], // Light Blue
            ['bg' => '#00BCD4', 'text' => '#FFFFFF'], // Cyan
            ['bg' => '#009688', 'text' => '#FFFFFF'], // Teal
            ['bg' => '#4CAF50', 'text' => '#FFFFFF'], // Green
            ['bg' => '#8BC34A', 'text' => '#FFFFFF'], // Light Green
            ['bg' => '#FF9800', 'text' => '#FFFFFF'], // Orange
            ['bg' => '#FF5722', 'text' => '#FFFFFF'], // Deep Orange
            ['bg' => '#795548', 'text' => '#FFFFFF'], // Brown
            ['bg' => '#607D8B', 'text' => '#FFFFFF'], // Blue Grey
        ];
        
        // Generate consistent index based on name
        $hash = 0;
        for ($i = 0; $i < strlen($name); $i++) {
            $hash = ord($name[$i]) + (($hash << 5) - $hash);
        }
        $index = abs($hash) % count($colors);
        
        return $colors[$index];
    }
    
    /**
     * Get initials from name (max 2 characters)
     * 
     * @param string $name
     * @return string
     */
    public static function getInitials($name)
    {
        $words = explode(' ', trim($name));
        
        if (count($words) >= 2) {
            // Ambil huruf pertama dari 2 kata pertama
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        } else {
            // Ambil 2 huruf pertama dari nama
            return strtoupper(substr($name, 0, 2));
        }
    }
    
    /**
     * Generate complete avatar HTML
     * 
     * @param string $name
     * @param string $size Size class (w-10, w-16, w-20, etc)
     * @param string $fontSize Font size class (text-sm, text-lg, text-2xl, etc)
     * @return string
     */
    public static function generate($name, $size = 'w-20 h-20', $fontSize = 'text-2xl')
    {
        $color = self::getAvatarColor($name);
        $initials = self::getInitials($name);
        
        return sprintf(
            '<div class="%s rounded-full flex items-center justify-center font-bold shadow-lg" style="background-color: %s; color: %s;">%s</div>',
            $size,
            $color['bg'],
            $color['text'],
            $initials
        );
    }
}
