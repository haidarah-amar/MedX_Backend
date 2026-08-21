<?php

namespace Database\Seeders;

use App\Models\Clinic;
use App\Models\Department;
use App\Models\DepartmentCategory;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            [
                'clinic_email' => 'damascus@medx.sy',
                'category' => 'internal_medicine',

                'name_en' => 'Internal Medicine',
                'name_ar' => 'الباطنية',

                'description_en' =>
                    'The Internal Medicine Department provides diagnosis and follow-up for common adult medical conditions.',

                'description_ar' =>
                    'قسم الباطنية بيقدم معاينات وتشخيص ومتابعة للأمراض الشائعة عند البالغين.',

                'location_ar' =>
                    'الطابق الأول - الغرفة 101',

                'location_en' =>
                    'First Floor - Room 101',
            ],

            [
                'clinic_email' => 'damascus@medx.sy',
                'category' => 'pediatrics',

                'name_en' => 'Pediatrics',
                'name_ar' => 'الأطفال',

                'description_en' =>
                    'The Pediatrics Department provides medical care and follow-up for infants, children, and adolescents.',

                'description_ar' =>
                    'قسم الأطفال بيقدم معاينات ومتابعة صحية للأطفال والرضع واليافعين.',

                'location_ar' =>
                    'الطابق الثاني - الغرفة 203',

                'location_en' =>
                    'Second Floor - Room 203',
            ],

            [
                'clinic_email' => 'damascus@medx.sy',
                'category' => 'dermatology',

                'name_en' => 'Dermatology',
                'name_ar' => 'الجلدية',

                'description_en' =>
                    'The Dermatology Department diagnoses and treats common skin, hair, and nail conditions.',

                'description_ar' =>
                    'قسم الجلدية بيقدم تشخيص وعلاج لمشاكل الجلد والشعر والأظافر.',

                'location_ar' =>
                    'الطابق الثالث - الغرفة 305',

                'location_en' =>
                    'Third Floor - Room 305',
            ],

            // مركز الشفاء - حلب

            [
                'clinic_email' => 'aleppo@medx.sy',
                'category' => 'cardiology',

                'name_en' => 'Cardiology',
                'name_ar' => 'القلبية',

                'description_en' =>
                    'The Cardiology Department provides evaluation and follow-up for heart and blood vessel conditions.',

                'description_ar' =>
                    'قسم القلبية بيقدم فحوصات وتشخيص ومتابعة لأمراض القلب والأوعية.',

                'location_ar' =>
                    'الطابق الأول - الغرفة 105',

                'location_en' =>
                    'First Floor - Room 105',
            ],

            [
                'clinic_email' => 'aleppo@medx.sy',
                'category' => 'orthopedics',

                'name_en' => 'Orthopedics',
                'name_ar' => 'العظام',

                'description_en' =>
                    'The Orthopedics Department treats bone, joint, muscle, and movement-related conditions.',

                'description_ar' =>
                    'قسم العظام بيقدم تشخيص وعلاج لمشاكل العظام والمفاصل والعضلات.',

                'location_ar' =>
                    'الطابق الثاني - الغرفة 208',

                'location_en' =>
                    'Second Floor - Room 208',
            ],

            [
                'clinic_email' => 'aleppo@medx.sy',
                'category' => 'ent',

            'name_en' => 'ENT',
                'name_ar' => 'الأنف والأذن والحنجرة',
                'description_en' =>
                    'The ENT Department provides diagnosis and treatment for ear, nose, and throat conditions.',

                'description_ar' =>
                    'قسم الأنف والأذن والحنجرة بيقدم تشخيص وعلاج للمشاكل المتعلقة بالأذن والأنف والحنجرة.',

                'location_ar' =>
                    'الطابق الثالث - الغرفة 310',

                'location_en' =>
                    'Third Floor - Room 310',
            ],

            // مركز الحياة - اللاذقية

            [
                'clinic_email' => 'latakia@medx.sy',
                'category' => 'gynecology',
                'name_en' => 'Gynecology',
                'name_ar' => 'النسائية',

                'description_en' =>
                    'The Gynecology Department provides consultation and follow-up for women’s health conditions.',

                'description_ar' =>
                    'قسم النسائية بيقدم معاينات ومتابعة للحالات الصحية الخاصة بالنساء.',

                'location_ar' =>
                    'الطابق الأول - الغرفة 102',

                'location_en' =>
                    'First Floor - Room 102',
            ],

            [
                'clinic_email' => 'latakia@medx.sy',
                'category' => 'ophthalmology',

                'name_en' => 'Ophthalmology',
                'name_ar' => 'العيون',

                'description_en' =>
                    'The Ophthalmology Department provides eye examinations and treatment for common vision conditions.',

                'description_ar' =>
                    'قسم العيون بيقدم فحوصات وتشخيص وعلاج لمشاكل النظر وأمراض العين.',

                'location_ar' =>
                    'الطابق الثاني - الغرفة 206',

                'location_en' =>
                    'Second Floor - Room 206',
            ],

            [
                'clinic_email' => 'latakia@medx.sy',
                'category' => 'dentistry_general',

                'name_en' => 'General Dentistry',
                'name_ar' => 'الأسنان العامة',

                'description_en' =>
                    'The General Dentistry Department provides preventive care, examinations, and treatment for common dental conditions.',

                'description_ar' =>
                    'قسم الأسنان العامة بيقدم فحوصات وعلاج ومتابعة لمشاكل الأسنان واللثة.',

                'location_ar' =>
                    'الطابق الثالث - الغرفة 312',

                'location_en' =>
                    'Third Floor - Room 312',
            ],
        ];

        foreach ($departments as $data) {
            $clinic = Clinic::where(
                'email',
                $data['clinic_email']
            )->firstOrFail();

            $category = DepartmentCategory::where(
                'category',
                $data['category']
            )->firstOrFail();

            Department::updateOrCreate(
                [
                    'clinic_id' => $clinic->id,
                    'category_id' => $category->id,
                ],
                [
                    'name_en' => $data['name_en'],
                    'name_ar' => $data['name_ar'],
                    'description_en' => $data['description_en'],
                    'description_ar' => $data['description_ar'],
                    'location_ar' => $data['location_ar'],
                    'location_en' => $data['location_en'],
                ]
            );
        }
    }
}