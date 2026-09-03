<?php
namespace App\Models;
use CodeIgniter\Model;

class ConfiguracionModel extends Model
{
    protected $table         = 'configuracion';
    protected $allowedFields = [
        'nombre_agencia', 'eslogan', 'texto_nosotros', 'telefono', 'whatsapp',
        'email', 'direccion', 'instagram', 'facebook', 'tema_home', 'foto_nosotros', 'updated_at',
    ];
    protected $useTimestamps = false;

    public function actual(): array
    {
        return $this->find(1) ?? [];
    }
}
