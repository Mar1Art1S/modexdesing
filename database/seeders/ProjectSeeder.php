<?php

namespace Database\Seeders;

use App\Enums\ProjectCategory;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title_ua' => 'Модульна Підстанція 10кВ та Шинопровід',
                'title_en' => '10kV Substation Busbar & Modular Insulator',
                'category' => ProjectCategory::Industrial,
                'description_ua' => 'Вогнестійкі діелектричні опори шинопровід з внутрішнім аеродинамічним ребруванням для запобігання дуговому розряду під робочою напругою 10 000 В.',
                'description_en' => 'Flame-retardant high-voltage dielectric busbar supports with internal aerodynamic ribbing to eliminate arc discharge under 10,000V live load.',
                'image' => 'images/zas.jpg',
                'order_column' => 1,
                'is_active' => true,
            ],
            [
                'title_ua' => 'Гусенична Робоплатформа з Маніпулятором',
                'title_en' => 'Autonomous Tracked Rover with Robotic Manipulator',
                'category' => ProjectCategory::Robotics,
                'description_ua' => 'Проектування від технічного ескізу до робочого зразка: міцне гусеничне шасі, 6-осьова 3D-друкована рука з сервоприводами, ергономічний захват та інтегрований блок датчиків.',
                'description_en' => 'End-to-end design from engineering sketch to functioning prototype: reinforced tracked chassis, 6-axis 3D-printed manipulator arm, custom gripper, and sensor payload.',
                'image' => 'images/zas2.jpg',
                'order_column' => 2,
                'is_active' => true,
            ],
            [
                'title_ua' => 'Крокуючий Робот: Повний Цикл від Ескізу до Складання',
                'title_en' => 'Full-Cycle Walking Robot (Draft to Assembly)',
                'category' => ProjectCategory::Mechatronics,
                'description_ua' => '4 етапи розробки Modex: інженерний розрахунок і ручний ескіз, параметричне 3D CAD-моделювання, FDM-друк рухомих шарнірів та фінальне складання з електронікою.',
                'description_en' => 'Modex 4-stage turnkey development: engineering math and hand drafting, parametric 3D CAD simulation, FDM 3D printing of joints, and electromechanical assembly.',
                'image' => 'images/zas3.jpg',
                'order_column' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($projects as $project) {
            Project::firstOrCreate(['title_en' => $project['title_en']], $project);
        }
    }
}
