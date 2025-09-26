<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KanbanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $project = Project::create(['name' => 'Projeto Interno Ifware']);

        $columnToDo = $project->columns()->create(['name' => 'A Fazer']);
        $columnDoing = $project->columns()->create(['name' => 'Em Andamento']);
        $columnDone = $project->columns()->create(['name' => 'Concluído']);

        $columnToDo->tasks()->create([
            'title' => 'Desenvolver tela de login',
            'description' => 'Criar a interface e a lógica de autenticação.',
            'order' => 1
        ]);
        $columnToDo->tasks()->create([
            'title' => 'Configurar ambiente de produção',
            'description' => 'Preparar o servidor para o deploy da aplicação.',
            'order' => 2
        ]);

        $columnDoing->tasks()->create([
            'title' => 'Modelar banco de dados do Kanban',
            'description' => 'Definir todas as tabelas, colunas e relacionamentos.',
            'order' => 1
        ]);
    }
}