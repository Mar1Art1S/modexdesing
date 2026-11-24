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
                'title_ua' => '10kV Substation Busbar & Modular Insulator',
                'title_en' => '10kV Substation Busbar & Modular Insulator',
                'category' => ProjectCategory::Industrial,
                'description_ua' => 'Flame-retardant high-voltage dielectric busbar supports with internal aerodynamic ribbing to eliminate arc discharge under 10,000V live load.',
                'description_en' => 'Flame-retardant high-voltage dielectric busbar supports with internal aerodynamic ribbing to eliminate arc discharge under 10,000V live load.',
                'image' => 'images/zas.jpg',
                'order_column' => 1,
                'is_active' => true,
            ],
            [
                'title_ua' => 'Autonomous Tracked Rover with Robotic Manipulator',
                'title_en' => 'Autonomous Tracked Rover with Robotic Manipulator',
                'category' => ProjectCategory::Robotics,
                'description_ua' => 'End-to-end design from engineering sketch to functioning prototype: reinforced tracked chassis, 6-axis 3D-printed manipulator arm, custom gripper, and sensor payload.',
                'description_en' => 'End-to-end design from engineering sketch to functioning prototype: reinforced tracked chassis, 6-axis 3D-printed manipulator arm, custom gripper, and sensor payload.',
                'image' => 'images/zas2.jpg',
                'order_column' => 2,
                'is_active' => true,
            ],
            [
                'title_ua' => 'Full-Cycle Walking Robot (Draft to Assembly)',
                'title_en' => 'Full-Cycle Walking Robot (Draft to Assembly)',
                'category' => ProjectCategory::Mechatronics,
                'description_ua' => 'Modex 4-stage turnkey development: engineering math and hand drafting, parametric 3D CAD simulation, FDM 3D printing of joints, and electromechanical assembly.',
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
