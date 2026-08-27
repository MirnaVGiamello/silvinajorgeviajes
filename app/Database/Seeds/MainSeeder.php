<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $this->db->table('usuarios')->insert([
            'usuario'    => 'admin',
            'password'   => password_hash('admin123', PASSWORD_DEFAULT),
            'nombre'     => 'Administrador/a',
            'perfil'     => 'admin',
            'activo'     => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->db->table('usuarios')->insert([
            'usuario'    => 'operador',
            'password'   => password_hash('operador123', PASSWORD_DEFAULT),
            'nombre'     => 'Operador/a',
            'perfil'     => 'operador',
            'activo'     => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->db->table('configuracion')->insert([
            'nombre_agencia' => 'Silvina Jorge Viajes',
            'eslogan'        => 'Sueña · Explora · Descubre',
            'texto_nosotros' => 'Soy agente de viajes y te ayudo a planear las vacaciones que soñás. Trabajo con destinos nacionales e internacionales, ofreciendo asesoramiento personalizado en cada paso.',
            'telefono'       => '',
            'whatsapp'       => '5492215699890',
            'email'          => '',
            'direccion'      => '',
            'instagram'      => '',
            'facebook'       => '',
            'updated_at'     => $now,
        ]);

        $this->db->table('promociones')->insert([
            'titulo'         => 'Escapada a la Costa Amalfitana',
            'destino'        => 'Italia',
            'categoria'      => 'Internacional',
            'descripcion'    => 'Una semana recorriendo Positano, Amalfi y Ravello, con salidas grupales y guía en español. Incluye alojamiento y traslados.',
            'precio'         => 1850,
            'moneda'         => 'USD',
            'fecha_desde'    => date('Y-m-d'),
            'fecha_hasta'    => date('Y-m-d', strtotime('+90 days')),
            'imagen_portada' => null,
            'activa'         => 1,
            'usuario_id'     => 1,
            'created_at'     => $now,
            'updated_at'     => $now,
        ]);

        echo "  Usuarios, configuracion y promocion de ejemplo cargados.\n";
    }
}
