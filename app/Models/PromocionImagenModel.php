<?php
namespace App\Models;
use CodeIgniter\Model;

class PromocionImagenModel extends Model
{
    protected $table         = 'promocion_imagenes';
    protected $allowedFields = ['promocion_id', 'ruta', 'orden', 'created_at'];
    protected $useTimestamps = false;

    public function dePromocion(int $promocionId): array
    {
        return $this->where('promocion_id', $promocionId)->orderBy('orden')->findAll();
    }
}
