<?php

namespace Database\Seeders;

use App\Models\Clinic;
use App\Models\Department;
use App\Models\OperationalExpense;
use Illuminate\Database\Seeder;

class OperationalExpenseSeeder extends Seeder
{
    public function run(): void
    {
        $expenses = [
            [
                'clinic' => 'damascus@medx.sy',
                'category' => 'medical_supplies',
                'amount' => 450.00,
                'description' => 'شراء قفازات طبية وكمامات ومواد تعقيم.',
                'date' => '2026-06-02',
            ],
            [
                'clinic' => 'damascus@medx.sy',
                'category' => 'equipment_maintenance',
                'amount' => 320.00,
                'description' => 'صيانة أجهزة قياس الضغط والفحص العام.',
                'date' => '2026-06-12',
            ],
            [
                'clinic' => 'damascus@medx.sy',
                'category' => 'administrative',
                'amount' => 180.00,
                'description' => 'مصاريف قرطاسية وطباعة ملفات المرضى.',
                'date' => '2026-06-20',
            ],
            [
                'clinic' => 'aleppo@medx.sy',
                'category' => 'medical_supplies',
                'amount' => 520.00,
                'description' => 'شراء مستلزمات طبية وأدوات تعقيم.',
                'date' => '2026-06-04',
            ],
            [
                'clinic' => 'aleppo@medx.sy',
                'category' => 'equipment_maintenance',
                'amount' => 650.00,
                'description' => 'صيانة جهاز تخطيط القلب.',
                'date' => '2026-06-15',
            ],
            [
                'clinic' => 'aleppo@medx.sy',
                'category' => 'administrative',
                'amount' => 210.00,
                'description' => 'مصاريف اتصالات وإنترنت للمركز.',
                'date' => '2026-06-24',
            ],
            [
                'clinic' => 'latakia@medx.sy',
                'category' => 'medical_supplies',
                'amount' => 480.00,
                'description' => 'شراء مواد تعقيم ومستلزمات عيادات.',
                'date' => '2026-06-06',
            ],
            [
                'clinic' => 'latakia@medx.sy',
                'category' => 'equipment_maintenance',
                'amount' => 410.00,
                'description' => 'صيانة كرسي الأسنان وأجهزة العيادة.',
                'date' => '2026-06-17',
            ],
            [
                'clinic' => 'latakia@medx.sy',
                'category' => 'administrative',
                'amount' => 195.00,
                'description' => 'مصاريف نظافة وخدمات إدارية.',
                'date' => '2026-06-26',
            ],
        ];

        foreach ($expenses as $expense) {
            $clinic = Clinic::where(
                'email',
                $expense['clinic']
            )->firstOrFail();

            OperationalExpense::updateOrCreate(
                [
                    'clinic_id' => $clinic->id,
                    'description' => $expense['description'],
                    'expense_date' => $expense['date'],
                ],
                [
                    'category' => $expense['category'],
                    'amount' => $expense['amount'],
                    'department_id' => null,
                ]
            );
        }
    }
}