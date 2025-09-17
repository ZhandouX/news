<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'cover_image',
        'news_date',
        'content',
        'category',
        'user_id',
        'office',
        'sumber',
        'link_sumber',
        'link_berita'
    ];

    protected $dates = [
        'news_date'
    ];

    protected $casts = [
        'news_date' => 'date',
    ];

    /**
     * Get news by month and year
     */
    public static function getByMonth($month, $year)
    {
        return self::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    // Kategori Berita
    public static function getCategories()
    {
        return [
            'Berita Daerah',
            'Berita Umum'
        ];
    }

    // Kategori Kantor
    public static function getOfficeCategories()
    {
        return [
            'Sekretarial Jenderal',
            'Inspektorat Jenderal',
            'Ditjen Peraturan Perundang undangan',
            'Ditjen Administrasi Hukum Umum',
            'Ditjen Kekayaan Intelektual',
            'Badan Pembinaan Hukum Nasional',
            'Badan Strategi Kebijakan Hukum',
            'BPSDM Hukum',
            'Other'
        ];
    }

    // Kategori Sumber
    public static function getSumberCategories()
    {
        return [
            'Maluku Terkini',
            'RRI Ambon',
            'Tribun Ambon',
            'Siwa Lima',
            'Ambon Ekspres',
            'Teras Maluku',
            'Antara News Ambon',
            'Berita Satu',
            'Other'
        ];
    }

    // MAPPING LINK SUMBER DEFAULT
    public static function getSumberLinks()
    {
        return [
            'Maluku Terkini' => 'https://www.malukuterkini.com/',
            'RRI Ambon' => 'https://rri.co.id/ambon',
            'Tribun Ambon' => 'https://ambon.tribunnews.com',
            'Siwa Lima' => 'https://siwalimanews.com/',
            'Ambon Ekspres' => 'https://ambonekspres.com',
            'Teras Maluku' => 'https://terasmaluku.com/',
            'Antara News Ambon' => 'https://ambon.antaranews.com/',
            'Berita Satu' => 'https://www.beritasatu.com/',
        ];
    }

    /**
     * Format tanggal berita
     */
    public function getFormattedNewsDateAttribute()
    {
        return Carbon::parse($this->news_date)->format('d F Y');
    }

    /**
     * Format tanggal ditambahkan
     */
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d F Y H:i');
    }
}