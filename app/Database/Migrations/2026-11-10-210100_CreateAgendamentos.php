<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateAgendamentos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'usuario_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'coletor_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'data_coleta' => [
                'type' => 'DATE',
            ],
            'turno' => [
                'type'       => 'ENUM',
                'constraint' => ['Manhã', 'Tarde'],
            ],
            'volume_estimado' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'observacoes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Pendente', 'Confirmado', 'Concluído', 'Cancelado'],
                'null'       => true,
                'default'    => 'Pendente',
            ],
            'criado_em' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addPrimaryKey('id');

        $this->forge->addForeignKey('usuario_id', 'usuarios', 'id', 'CASCADE', 'CASCADE', 'fk_agendamento_usuario');

        $this->forge->addForeignKey('coletor_id', 'usuarios', 'id', 'CASCADE', 'SET NULL', 'fk_agendamento_coletor');

        $this->forge->createTable('agendamentos', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('agendamentos', true);
    }
}
