<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalChunk extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'medical_document_id',
        'content',
        // 'content_embedding', // Jika nanti Anda akan mengisi ini secara massal
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke dokumen induknya.
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(MedicalDocument::class, 'medical_document_id');
    }
}