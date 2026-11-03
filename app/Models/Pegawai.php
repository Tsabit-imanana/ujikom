<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\PegawaiFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    /** @use HasFactory<PegawaiFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pegawais';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nip',
        'nama',
        'jenis_kelamin',
        'pendidikan_terakhir',
        'tanggal_lahir',
        'jabatan',
        'email',
        'telepon',
        'alamat',
        'foto',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Get the employee's current age.
     */
    public function getUsiaAttribute(): int
    {
        return $this->tanggal_lahir ? Carbon::parse($this->tanggal_lahir)->age : 0;
    }

    /**
     * Get employee initials for avatar.
     */
    public function getInisialAttribute(): string
    {
        $words = explode(' ', trim($this->nama));
        $initials = '';
        foreach (array_slice($words, 0, 2) as $w) {
            $initials .= strtoupper(substr($w, 0, 1));
        }

        return $initials ?: 'P';
    }

    /**
     * Format tanggal lahir ke bahasa Indonesia.
     */
    public function getFormattedTanggalLahirAttribute(): string
    {
        return $this->tanggal_lahir ? Carbon::parse($this->tanggal_lahir)->translatedFormat('d F Y') : '-';
    }

    /**
     * Kategorisasi rentang usia.
     */
    public function getKelompokUsiaAttribute(): string
    {
        $usia = $this->usia;

        if ($usia < 25) {
            return '< 25 Tahun';
        }
        if ($usia <= 34) {
            return '25 - 34 Tahun';
        }
        if ($usia <= 44) {
            return '35 - 44 Tahun';
        }
        if ($usia <= 54) {
            return '45 - 54 Tahun';
        }

        return '≥ 55 Tahun';
    }
}
