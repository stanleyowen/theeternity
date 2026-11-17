<?php
declare(strict_types=1);

/**
 * Shared UI strings for both languages (EN / ID). Page-specific copy stays in
 * the per-language page files, exactly as it was written in 2020.
 */

const LANG_DIRS = ['en' => 'en-us', 'id' => 'id'];

function set_lang(string $lang): void
{
    $lang = array_key_exists($lang, LANG_DIRS) ? $lang : 'en';
    $GLOBALS['__lang'] = $lang;
    $_SESSION['language'] = $lang;
}

function current_lang(): string
{
    $lang = $GLOBALS['__lang'] ?? ($_SESSION['language'] ?? 'en');
    return array_key_exists($lang, LANG_DIRS) ? $lang : 'en';
}

function lang_dir(string $lang): string
{
    return LANG_DIRS[$lang] ?? 'en-us';
}

function t(string $key): string
{
    static $strings = [
        'en' => [
            'menus'          => 'Menus',
            'languages'      => 'Languages',
            'home'           => 'Home',
            'event'          => 'Event',
            'gallery'        => 'Gallery',
            'contact'        => 'Contact Us',
            'login'          => 'Login',
            'register'       => 'Register',
            'dashboard'      => 'Dashboard',
            'logout'         => 'Logout',
            'copyright'      => 'Copyright',
            'designed_by'    => 'Designed by',
            'click_here'     => 'Click here',
            'contact_title'  => 'Contact Us',
            'follow_title'   => 'Follow Us On',
            'mail_title'     => 'Mail Us',
            'welcome_back'   => 'Welcome Back',
            'online'         => 'Online',
            'archive_label'  => 'Archived',
            'archive_alert'  => 'This website is archived. Eternity Esports is no longer running scrims; the site is preserved in read-only mode so its story stays online.',
            'archive_link'   => 'Read the archive notes',
            'archive_dash'   => 'You are exploring an archived demo. Everything is visible, but changes are disabled.',
            'archive_write'  => 'This website is archived (read-only). Submissions and changes are disabled.',
            'demo_title'     => 'Explore the archive',
            'demo_intro'     => 'Accounts are closed, but you can still look around the original dashboards.',
            'demo_player'    => 'View as Player',
            'demo_admin'     => 'View as Administrator',
            'csrf_failed'    => 'Your session expired or the form was tampered with. Please try again.',
            'need_participation' => 'Please Participate in a Scrim in order to Access this Feature',
            'already_joined' => 'Each User can only participate in one scrim at a time. You can join another scrim after the current event has ended.',
            'gallery_empty'  => 'No photos have been published yet.',
            'events_empty'   => 'No events have been published yet.',
        ],
        'id' => [
            'menus'          => 'Menu',
            'languages'      => 'Bahasa',
            'home'           => 'Beranda',
            'event'          => 'Info',
            'gallery'        => 'Galeri',
            'contact'        => 'Hubungi Kami',
            'login'          => 'Masuk',
            'register'       => 'Daftar',
            'dashboard'      => 'Dashboard',
            'logout'         => 'Keluar',
            'copyright'      => 'Hak Cipta',
            'designed_by'    => 'Dirancang oleh',
            'click_here'     => 'Klik di sini',
            'contact_title'  => 'Hubungi Kami',
            'follow_title'   => 'Ikuti Kami',
            'mail_title'     => 'Kirim Email',
            'welcome_back'   => 'Selamat Datang',
            'online'         => 'Online',
            'archive_label'  => 'Diarsipkan',
            'archive_alert'  => 'Situs ini telah diarsipkan. Eternity Esports tidak lagi mengadakan scrim; situs ini dipertahankan dalam mode baca-saja agar kisahnya tetap dapat dilihat.',
            'archive_link'   => 'Baca catatan arsip',
            'archive_dash'   => 'Anda sedang menjelajahi demo arsip. Semua dapat dilihat, tetapi perubahan dinonaktifkan.',
            'archive_write'  => 'Situs ini telah diarsipkan (baca-saja). Pengiriman dan perubahan dinonaktifkan.',
            'demo_title'     => 'Jelajahi arsip',
            'demo_intro'     => 'Pendaftaran akun telah ditutup, tetapi Anda masih dapat melihat dashboard aslinya.',
            'demo_player'    => 'Lihat sebagai Pemain',
            'demo_admin'     => 'Lihat sebagai Administrator',
            'csrf_failed'    => 'Sesi Anda telah berakhir atau formulir tidak valid. Silakan coba lagi.',
            'need_participation' => 'Silakan Berpartisipasi Dalam Scrim untuk mengakses fitur ini',
            'already_joined' => 'User hanya dapat mengikuti 1 scrim dalam satu waktu. Anda dapat mengikuti scrim lain setelah event berakhir.',
            'gallery_empty'  => 'Belum ada foto yang dipublikasikan.',
            'events_empty'   => 'Belum ada info yang dipublikasikan.',
        ],
    ];
    $lang = current_lang();
    return $strings[$lang][$key] ?? $strings['en'][$key] ?? $key;
}
