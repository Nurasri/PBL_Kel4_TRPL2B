<?php

namespace App\Helpers;

use App\Models\Notification;
use App\Models\User;
use App\Events\NotificationSent;

class NotificationHelper
{
    public static function create($userId, $title, $message, $type = 'info', $actionUrl = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'action_url' => $actionUrl
        ]);
        event(new NotificationSent($notification));

        return $notification;
    }

    public static function notifyUser($user, $title, $message, $type = 'info', $actionUrl = null)
    {
        if ($user instanceof User) {
            return self::create($user->id, $title, $message, $type, $actionUrl);
        }
        return null;
    }

    public static function notifyAdmins($title, $message, $type = 'info', $actionUrl = null)
    {
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            self::notifyUser($admin, $title, $message, $type, $actionUrl);
        }
    }

    // Notifikasi untuk aktivitas perusahaan
    public static function perusahaanRegistered($perusahaan)
    {
        self::notifyAdmins(
            'Perusahaan Baru Terdaftar',
            "Perusahaan {$perusahaan->nama_perusahaan} telah mendaftar di sistem",
            'info',
            route('perusahaan.show', $perusahaan)
        );
    }

    public static function perusahaanUpdated($perusahaan)
    {
        self::notifyAdmins(
            'Profil Perusahaan Diperbarui',
            "Perusahaan {$perusahaan->nama_perusahaan} telah memperbarui profil mereka",
            'info',
            route('perusahaan.show', $perusahaan)
        );
    }

    // Notifikasi untuk laporan harian
    public static function laporanHarianSubmitted($laporan)
    {
        // Notifikasi ke admin
        self::notifyAdmins(
            'Laporan Harian Baru',
            "Laporan harian dari {$laporan->perusahaan->nama_perusahaan} untuk {$laporan->jenisLimbah->nama} telah disubmit",
            'info',
            route('laporan-harian.show', $laporan)
        );

        // Notifikasi ke perusahaan
        self::notifyUser(
            $laporan->perusahaan->user,
            'Laporan Harian Berhasil Disubmit',
            "Laporan harian untuk {$laporan->jenisLimbah->nama} sebanyak {$laporan->jumlah} {$laporan->satuan} telah berhasil disubmit",
            'success',
            route('laporan-harian.show', $laporan)
        );
    }

    public static function laporanHarianOverdue($perusahaan)
    {
        self::notifyUser(
            $perusahaan->user,
            'Pengingat Laporan Harian',
            'Anda belum mengisi laporan harian hari ini. Silakan lengkapi laporan Anda.',
            'warning',
            route('laporan-harian.create')
        );

        // Notifikasi ke admin juga
        self::notifyAdmins(
            'Perusahaan Belum Laporan Harian',
            "Perusahaan {$perusahaan->nama_perusahaan} belum mengisi laporan harian hari ini",
            'warning',
            route('perusahaan.show', $perusahaan)
        );
    }

    // Notifikasi untuk pengelolaan limbah
    public static function pengelolaanCreated($pengelolaan)
    {
        self::notifyAdmins(
            'Pengelolaan Limbah Baru',
            "Pengelolaan limbah {$pengelolaan->jenisLimbah->nama} oleh {$pengelolaan->perusahaan->nama_perusahaan} telah dibuat",
            'info',
            route('admin.pengelolaan-limbah.show', $pengelolaan)
        );

        self::notifyUser(
            $pengelolaan->perusahaan->user,
            'Pengelolaan Limbah Dibuat',
            "Pengelolaan limbah {$pengelolaan->jenisLimbah->nama} dengan nomor manifest {$pengelolaan->nomor_manifest} telah berhasil dibuat",
            'success',
            route('pengelolaan-limbah.show', $pengelolaan)
        );
    }

    public static function pengelolaanStatusChanged($pengelolaan, $oldStatus)
    {
        $statusText = [
            'menunggu' => 'Menunggu',
            'diproses' => 'Sedang Diproses',
            'dalam_pengangkutan' => 'Dalam Pengangkutan',
            'selesai' => 'Selesai'
        ];

        $message = "Status pengelolaan limbah {$pengelolaan->jenisLimbah->nama} berubah dari {$statusText[$oldStatus]} menjadi {$statusText[$pengelolaan->status]}";

        self::notifyUser(
            $pengelolaan->perusahaan->user,
            'Status Pengelolaan Berubah',
            $message,
            $pengelolaan->status === 'selesai' ? 'success' : 'info',
            route('pengelolaan-limbah.show', $pengelolaan)
        );

        if ($pengelolaan->status === 'selesai') {
            self::notifyUser(
                $pengelolaan->perusahaan->user,
                'Pengelolaan Selesai - Buat Laporan Hasil',
                "Pengelolaan {$pengelolaan->jenisLimbah->nama} telah selesai. Silakan buat laporan hasil pengelolaan.",
                'info',
                route('laporan-hasil-pengelolaan.create', ['pengelolaan' => $pengelolaan->id])
            );
        }
    }

    public static function pengelolaanOverdue($pengelolaan)
    {
        self::notifyUser(
            $pengelolaan->perusahaan->user,
            'Pengelolaan Limbah Terlambat',
            "Pengelolaan {$pengelolaan->jenisLimbah->nama} sudah berjalan lebih dari 30 hari tanpa update status",
            'warning',
            route('pengelolaan-limbah.show', $pengelolaan)
        );

        self::notifyAdmins(
            'Pengelolaan Limbah Terlambat',
            "Pengelolaan limbah {$pengelolaan->jenisLimbah->nama} oleh {$pengelolaan->perusahaan->nama_perusahaan} sudah terlambat",
            'warning',
            route('admin.pengelolaan-limbah.show', $pengelolaan)
        );
    }

    // Notifikasi untuk laporan hasil pengelolaan
    public static function laporanHasilSubmitted($laporanHasil)
    {
        self::notifyAdmins(
            'Laporan Hasil Pengelolaan Baru',
            "Laporan hasil pengelolaan dari {$laporanHasil->perusahaan->nama_perusahaan} telah disubmit",
            'info',
            route('admin.laporan-hasil-pengelolaan.show', $laporanHasil)
        );

        self::notifyUser(
            $laporanHasil->perusahaan->user,
            'Laporan Hasil Berhasil Disubmit',
            "Laporan hasil pengelolaan untuk {$laporanHasil->jenisLimbah->nama} telah berhasil disubmit",
            'success',
            route('laporan-hasil-pengelolaan.show', $laporanHasil)
        );
    }

    // Notifikasi untuk penyimpanan
    public static function penyimpananFull($penyimpanan)
    {
        $percentage = ($penyimpanan->kapasitas_terpakai / $penyimpanan->kapasitas_maksimal) * 100;
        
        self::notifyUser(
            $penyimpanan->perusahaan->user,
            'Penyimpanan Hampir Penuh',
            "Penyimpanan {$penyimpanan->nama_penyimpanan} sudah mencapai {$percentage}% kapasitas. Segera lakukan pengelolaan limbah.",
            'warning',
            route('penyimpanan.show', $penyimpanan)
        );

    }

    // Notifikasi untuk vendor
    public static function vendorRegistered($vendor)
    {
        self::notifyAdmins(
            'Vendor Baru Terdaftar',
            "Vendor {$vendor->nama_vendor} telah terdaftar di sistem",
            'info',
            route('admin.vendor.show', $vendor)
        );
    }

    // Notifikasi untuk artikel
    public static function artikelPublished($artikel)
    {
        // Notifikasi ke semua perusahaan
        $perusahaans = User::where('role', 'perusahaan')->get();
        foreach ($perusahaans as $user) {
            self::notifyUser(
                $user,
                'Artikel Baru Dipublikasikan',
                "Artikel baru '{$artikel->judul}' telah dipublikasikan",
                'info',
                route('frontend.artikel.show', $artikel->slug)
            );
        }
    }

    // Notifikasi sistem
    public static function systemMaintenance($message, $scheduledTime = null)
    {
        $allUsers = User::all();
        $maintenanceMessage = $scheduledTime 
            ? "Sistem akan maintenance pada {$scheduledTime}. {$message}"
            : "Pemberitahuan sistem: {$message}";

        foreach ($allUsers as $user) {
            self::notifyUser(
                $user,
                'Pemberitahuan Sistem',
                $maintenanceMessage,
                'warning'
            );
        }
    }

    public static function welcomeNewUser($user)
    {
        $role = $user->role === 'perusahaan' ? 'Perusahaan' : 'Admin';
        
        self::notifyUser(
            $user,
            "Selamat Datang di EcoCycle",
            "Selamat datang di sistem EcoCycle! Sebagai {$role}, Anda dapat mulai menggunakan fitur-fitur yang tersedia.",
            'success',
            $user->role === 'perusahaan' ? route('perusahaan.dashboard') : route('admin.dashboard')
        );
    }

    // Notifikasi reminder
    public static function monthlyReportReminder($perusahaan)
    {
        self::notifyUser(
            $perusahaan->user,
            'Pengingat Laporan Bulanan',
            'Saatnya untuk membuat laporan bulanan Anda. Pastikan semua data sudah lengkap.',
            'info',
            route('laporan-harian.index')
        );
    }

    public static function complianceReminder($perusahaan, $requirement)
    {
        self::notifyUser(
            $perusahaan->user,
            'Pengingat Kepatuhan',
            "Pengingat: {$requirement}. Pastikan perusahaan Anda tetap mematuhi regulasi yang berlaku.",
            'warning'
        );
    }
}