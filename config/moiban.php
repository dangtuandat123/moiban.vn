<?php

return [
    /*
    |--------------------------------------------------------------------------
    | File Upload Limits
    |--------------------------------------------------------------------------
    |
    | Giới hạn kích thước file upload (KB)
    |
    */
    
    // Kích thước tối đa cho ảnh album (KB) - Default 5MB
    'max_photo_size' => env('MOIBAN_MAX_PHOTO_SIZE', 5120),
    
    // Kích thước tối đa cho file nhạc (KB) - Default 10MB
    'max_music_size' => env('MOIBAN_MAX_MUSIC_SIZE', 10240),
    
    // Số ảnh tối đa mỗi album
    'max_album_photos' => env('MOIBAN_MAX_ALBUM_PHOTOS', 10),
    
    // Tổng dung lượng tối đa cho mỗi thiệp (KB) - Default 50MB
    'max_invitation_storage' => env('MOIBAN_MAX_INVITATION_STORAGE', 51200),
    
    /*
    |--------------------------------------------------------------------------
    | Invitation Settings
    |--------------------------------------------------------------------------
    */
    
    // Thời gian trial (ngày)
    'trial_days' => env('MOIBAN_TRIAL_DAYS', 7),
    
    // Hiển thị watermark cho thiệp trial
    'show_trial_watermark' => env('MOIBAN_SHOW_TRIAL_WATERMARK', true),
];
