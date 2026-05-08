<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\DepartmentCategory;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            
            ['category' => 'general', 'name_en' => 'General Medicine', 'name_ar' => 'طب عام'],
            ['category' => 'internal_medicine', 'name_en' => 'Internal Medicine', 'name_ar' => 'باطنية'],
            ['category' => 'family_medicine', 'name_en' => 'Family Medicine', 'name_ar' => 'طب الأسرة'],

            ['category' => 'cardiology', 'name_en' => 'Cardiology', 'name_ar' => 'قلبية'],
            ['category' => 'pulmonology', 'name_en' => 'Pulmonology', 'name_ar' => 'صدرية'],
            ['category' => 'thoracic', 'name_en' => 'Thoracic Surgery', 'name_ar' => 'جراحة صدر'],
            ['category' => 'vascular', 'name_en' => 'Vascular Surgery', 'name_ar' => 'جراحة أوعية'],

            ['category' => 'neurology', 'name_en' => 'Neurology', 'name_ar' => 'أعصاب'],
            ['category' => 'neurosurgery', 'name_en' => 'Neurosurgery', 'name_ar' => 'جراحة أعصاب'],
            ['category' => 'psychiatry', 'name_en' => 'Psychiatry', 'name_ar' => 'طب نفسي'],

            ['category' => 'ophthalmology', 'name_en' => 'Ophthalmology', 'name_ar' => 'عيون'],
            ['category' => 'ent', 'name_en' => 'ENT', 'name_ar' => 'أنف أذن حنجرة'],

            ['category' => 'orthopedics', 'name_en' => 'Orthopedics', 'name_ar' => 'عظام'],
            ['category' => 'rheumatology', 'name_en' => 'Rheumatology', 'name_ar' => 'روماتيزم'],

            ['category' => 'pediatrics', 'name_en' => 'Pediatrics', 'name_ar' => 'أطفال'],
            ['category' => 'gynecology', 'name_en' => 'Gynecology', 'name_ar' => 'نسائية'],
            ['category' => 'obstetrics', 'name_en' => 'Obstetrics', 'name_ar' => 'توليد'],

            ['category' => 'dentistry_general', 'name_en' => 'General Dentistry', 'name_ar' => 'أسنان عامة'],
            ['category' => 'dentistry_orthodontics', 'name_en' => 'Orthodontics', 'name_ar' => 'تقويم أسنان'],
            ['category' => 'dentistry_surgery', 'name_en' => 'Dental Surgery', 'name_ar' => 'جراحة أسنان'],
            ['category' => 'dentistry_cosmetic', 'name_en' => 'Cosmetic Dentistry', 'name_ar' => 'تجميل أسنان'],
            ['category' => 'dentistry_implants', 'name_en' => 'Dental Implants', 'name_ar' => 'زراعة أسنان'],

            ['category' => 'dermatology', 'name_en' => 'Dermatology', 'name_ar' => 'جلدية'],
            ['category' => 'cosmetic_dermatology', 'name_en' => 'Cosmetic Dermatology', 'name_ar' => 'تجميل جلدية'],
            ['category' => 'plastic_surgery', 'name_en' => 'Plastic Surgery', 'name_ar' => 'جراحة تجميل'],
            ['category' => 'aesthetic_medicine', 'name_en' => 'Aesthetic Medicine', 'name_ar' => 'طب تجميلي'],

            ['category' => 'endocrinology', 'name_en' => 'Endocrinology', 'name_ar' => 'غدد'],
            ['category' => 'nephrology', 'name_en' => 'Nephrology', 'name_ar' => 'كلى'],
            ['category' => 'gastroenterology', 'name_en' => 'Gastroenterology', 'name_ar' => 'جهاز هضمي'],
            ['category' => 'hematology', 'name_en' => 'Hematology', 'name_ar' => 'دمويات'],
            ['category' => 'oncology', 'name_en' => 'Oncology', 'name_ar' => 'أورام'],
            ['category' => 'infectious_disease', 'name_en' => 'Infectious Disease', 'name_ar' => 'أمراض معدية'],
            ['category' => 'allergy', 'name_en' => 'Allergy & Immunology', 'name_ar' => 'حساسية ومناعة'],

            ['category' => 'general_surgery', 'name_en' => 'General Surgery', 'name_ar' => 'جراحة عامة'],
            ['category' => 'laparoscopic_surgery', 'name_en' => 'Laparoscopic Surgery', 'name_ar' => 'جراحة تنظيرية'],
            ['category' => 'emergency', 'name_en' => 'Emergency', 'name_ar' => 'طوارئ'],

            ['category' => 'radiology', 'name_en' => 'Radiology', 'name_ar' => 'أشعة'],
            ['category' => 'laboratory', 'name_en' => 'Laboratory', 'name_ar' => 'تحاليل'],
            ['category' => 'pathology', 'name_en' => 'Pathology', 'name_ar' => 'أمراض أنسجة'],

            ['category' => 'rehabilitation', 'name_en' => 'Rehabilitation', 'name_ar' => 'إعادة تأهيل'],
        ];

        foreach ($departments as $dept) {
            DepartmentCategory::create($dept);
        }
    }
}