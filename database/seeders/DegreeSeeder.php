<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\degree;
use function Psy\debug;

class DegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Particular
        degree::class::create([
            'name' => 'Particular',
            'type_degree_id' => 5,
            'faculty_id' => 4,
        ]);
        // Pregrados
        degree::class::create([
            'name' => 'Administración de sistemas informáticos',
            'type_degree_id' => 1,
            'faculty_id' => 2,
        ]);
        degree::class::create([
            'name' => 'Arquitectura',
            'type_degree_id' => 1,
            'faculty_id' => 3,
        ]);
        degree::class::create([
            'name' => 'Ingeniería química',
            'type_degree_id' => 1,
            'faculty_id' => 3,
        ]);
        degree::class::create([
            'name' => 'Ingeniería industrial',
            'type_degree_id' => 1,
            'faculty_id' => 3,
        ]);
        degree::class::create([
            'name' => 'Ingeniería eléctrica',
            'type_degree_id' => 1,
            'faculty_id' => 3,
        ]);
        degree::class::create([
            'name' => 'Ingeniería civil',
            'type_degree_id' => 1,
            'faculty_id' => 3,
        ]);
        degree::class::create([
            'name' => 'Administración de empresas',
            'type_degree_id' => 1,
            'faculty_id' => 2,
        ]);
        degree::class::create([
            'name' => 'Gestión cultural',
            'type_degree_id' => 1,
            'faculty_id' => 2,
        ]);
        degree::class::create([
            'name' => 'Ingeniería física',
            'type_degree_id' => 1,
            'faculty_id' => 1,
        ]);
        degree::class::create([
            'name' => 'Ciencias de la computación',
            'type_degree_id' => 1,
            'faculty_id' => 1,
        ]);
        degree::class::create([
            'name' => 'Matemáticas',
            'type_degree_id' => 1,
            'faculty_id' => 1,
        ]);

        // Especializaciones

        degree::class::create([
            'name' => 'Especialización en Gestión de Redes de Datos',
            'type_degree_id' => 2,
            'faculty_id' => 2,
        ]);
        degree::class::create([
            'name' => 'Especialización en Bionegocios',
            'type_degree_id' => 2,
            'faculty_id' => 1,
        ]);
        degree::class::create([
            'name' => 'Especialización en Alta Gerencia',
            'type_degree_id' => 2,
            'faculty_id' => 2,
        ]);
        degree::class::create([
            'name' => 'Especialización en Auditoria de Sistemas',
            'type_degree_id' => 2,
            'faculty_id' => 2,
        ]);
        degree::class::create([
            'name' => 'Especialización en Dirección de Producción y Operaciones',
            'type_degree_id' => 2,
            'faculty_id' => 2,
        ]);
        degree::class::create([
            'name' => 'Especialización en Estructuras',
            'type_degree_id' => 2,
            'faculty_id' => 3,
        ]);
        degree::class::create([
            'name' => 'Especialización en Finanzas Corporativas',
            'type_degree_id' => 2,
            'faculty_id' => 2,
        ]);
        degree::class::create([
            'name' => 'Especialización en Gerencia Estratégica de Proyectos',
            'type_degree_id' => 2,
            'faculty_id' => 2,
        ]);
        degree::class::create([
            'name' => 'Especialización en Gestión Cultural con Énfasis en Planeación y Políticas Culturales',
            'type_degree_id' => 2,
            'faculty_id' => 2,
        ]);
        degree::class::create([
            'name' => 'Especialización en Ingeniería Ambiental - Área Sanitaria',
            'type_degree_id' => 2,
            'faculty_id' => 3,
        ]);
        degree::class::create([
            'name' => 'Especialización en Ingeniería Hidráulica y Ambiental',
            'type_degree_id' => 2,
            'faculty_id' => 3,
        ]);
        degree::class::create([
            'name' => 'Especialización en Vías y Transporte',
            'type_degree_id' => 2,
            'faculty_id' => 3,
        ]);
        degree::class::create([
            'name' => 'Especialización en Geotecnia',
            'type_degree_id' => 2,
            'faculty_id' => 3,
        ]);

        // Maestrías

        degree::class::create([
            'name' => 'Maestría de Profundización en Ingeniería Industrial',
            'type_degree_id' => 3,
            'faculty_id' => 3,
        ]);
        degree::class::create([
            'name' => 'Maestría en Administración de Sistemas Informáticos Plan de Estudios de Investigación',
            'type_degree_id' => 3,
            'faculty_id' => 2,
        ]);
        degree::class::create([
            'name' => 'Maestría en Administración de Sistemas Informáticos Plan de Estudios de Profundización',
            'type_degree_id' => 3,
            'faculty_id' => 2,
        ]);
        degree::class::create([
            'name' => 'Maestría en Administración Plan de Estudios de Investigación',
            'type_degree_id' => 3,
            'faculty_id' => 2,
        ]);
        degree::class::create([
            'name' => 'Maestría en Administración Plan de Estudios de Profundización',
            'type_degree_id' => 3,
            'faculty_id' => 2,
        ]);
        degree::class::create([
            'name' => 'Maestría en Arquitectura',
            'type_degree_id' => 3,
            'faculty_id' => 3,
        ]);
        degree::class::create([
            'name' => 'Maestría en Ciencias - Física',
            'type_degree_id' => 3,
            'faculty_id' => 1,
        ]);
        degree::class::create([
            'name' => 'Maestría en Ciencias - Matemática Aplicada',
            'type_degree_id' => 3,
            'faculty_id' => 1,
        ]);
        degree::class::create([
            'name' => 'Maestria en Enseñanza de las Ciencias Exactas y Naturales',
            'type_degree_id' => 3,
            'faculty_id' => 1,
        ]);
        degree::class::create([
            'name' => 'Maestría en Gestión Cultural Plan de Estudios de Investigación',
            'type_degree_id' => 3,
            'faculty_id' => 2,
        ]);
        degree::class::create([
            'name' => 'Maestría en Gestión Cultural Plan de Estudios de Profundización',
            'type_degree_id' => 3,
            'faculty_id' => 2,
        ]);
        degree::class::create([
            'name' => 'Maestría en Hábitat',
            'type_degree_id' => 3,
            'faculty_id' => 3,
        ]);
        degree::class::create([
            'name' => 'Maestría en Ingeniería - Automatización Industrial',
            'type_degree_id' => 3,
            'faculty_id' => 3,
        ]);
        degree::class::create([
            'name' => 'Maestría en Ingeniería - Estructuras',
            'type_degree_id' => 3,
            'faculty_id' => 3,
        ]);
        degree::class::create([
            'name' => 'Maestría en Ingeniería - Infraestructuras y Sistemas de Transporte',
            'type_degree_id' => 3,
            'faculty_id' => 3,
        ]);
        degree::class::create([
            'name' => 'Maestría en Ingeniería - Ingeniería Ambiental',
            'type_degree_id' => 3,
            'faculty_id' => 3,
        ]);
        degree::class::create([
            'name' => 'Maestria en Ingeniería - Ingeniería Eléctrica',
            'type_degree_id' => 3,
            'faculty_id' => 3,
        ]);
        degree::class::create([
            'name' => 'Maestría en Ingeniería - Ingeniería Química',
            'type_degree_id' => 3,
            'faculty_id' => 3,
        ]);
        degree::class::create([
            'name' => 'Maestría en Ingeniería - Recursos Hidráulicos',
            'type_degree_id' => 3,
            'faculty_id' => 3,
        ]);
        degree::class::create([
            'name' => 'Maestría en Medio Ambiente y Desarrollo',
            'type_degree_id' => 3,
            'faculty_id' => 1,
        ]);
        degree::class::create([
            'name' => 'Maestría Investigativa en Ingeniería Industrial',
            'type_degree_id' => 3,
            'faculty_id' => 3,
        ]);

        // Doctorados

        degree::class::create([
            'name' => 'Doctorado en Administración',
            'type_degree_id' => 4,
            'faculty_id' => 2,
        ]);
        degree::class::create([
            'name' => 'Doctorado en Ingeniería – Industria y Organizaciones',
            'type_degree_id' => 4,
            'faculty_id' => 3,
        ]);
        degree::class::create([
            'name' => 'Doctorado en Ingeniería (Línea de Investigación en Automática)',
            'type_degree_id' => 4,
            'faculty_id' => 3,
        ]);
        degree::class::create([
            'name' => 'Doctorado en Ingeniería - Ingeniería Química',
            'type_degree_id' => 4,
            'faculty_id' => 3,
        ]);
    }
}
