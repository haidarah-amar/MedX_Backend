<?php

namespace Database\Seeders;

use App\Models\Clinic;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClinicSeeder extends Seeder
{
    public function run(): void
    {
        $clinics = [
            [
                'email' => 'damascus@medx.sy',
                'password' => Hash::make('password'),
                'name_en' => 'MedX Medical Center - Damascus',
                'name_ar' => 'مركز ميد إكس الطبي - دمشق',
                'owner_name' => 'د. سامر الحمصي',
                'owner_idphoto' => 'owners/samer_alhomsi_id.jpg',
                'description_en' => 'A multidisciplinary medical center providing comprehensive healthcare services.',
                'description_ar' => 'مركز طبي متكامل بيقدم خدمات تشخيصية وعلاجية بعدة اختصاصات.',
                'location_ar' => 'دمشق - شارع الثورة',
                'location_en' => 'Damascus - Al-Thawra Street',
                'phone_number' => '0112233445',
                'start_time' => '08:00:00',
                'end_time' => '20:00:00',
                'is_approved' => true,
                'is_active' => true,
                'latitude' => '33.5138',
                'longitude' => '36.2765',
                'logo' => 'logos/medx_damascus.png',
                'percentage' => 12.50,
            ],
            [
                'email' => 'aleppo@medx.sy',
                'password' => Hash::make('password'),
                'name_en' => 'Al-Shifa Specialized Center - Aleppo',
                'name_ar' => 'مركز الشفاء التخصصي - حلب',
                'owner_name' => 'د. فراس الحلبي',
                'owner_idphoto' => 'owners/firas_alhalabi_id.jpg',
                'description_en' => 'A specialized medical center offering advanced outpatient services.',
                'description_ar' => 'مركز تخصصي بيقدم خدمات طبية متقدمة ومعاينات خارجية.',
                'location_ar' => 'حلب - شارع النيل',
                'location_en' => 'Aleppo - Al-Nile Street',
                'phone_number' => '0214455667',
                'start_time' => '08:00:00',
                'end_time' => '19:00:00',
                'is_approved' => true,
                'is_active' => true,
                'latitude' => '36.2021',
                'longitude' => '37.1343',
                'logo' => 'logos/alshifa_aleppo.png',
                'percentage' => 10.00,
            ],
            [
                'email' => 'latakia@medx.sy',
                'password' => Hash::make('password'),
                'name_en' => 'Al-Hayat Medical Center - Latakia',
                'name_ar' => 'مركز الحياة الطبي - اللاذقية',
                'owner_name' => 'د. كنان الساحلي',
                'owner_idphoto' => 'owners/kenan_alsaheli_id.jpg',
                'description_en' => 'A modern healthcare center serving patients with various medical specialties.',
                'description_ar' => 'مركز طبي حديث بيخدم المرضى بعدة اختصاصات وبيوفر رعاية متكاملة.',
                'location_ar' => 'اللاذقية - شارع 8 آذار',
                'location_en' => 'Latakia - 8th of March Street',
                'phone_number' => '0413344556',
                'start_time' => '08:00:00',
                'end_time' => '20:00:00',
                'is_approved' => true,
                'is_active' => true,
                'latitude' => '35.5317',
                'longitude' => '35.7904',
                'logo' => 'logos/alhayat_latakia.png',
                'percentage' => 15.00,
            ],
        ];

        foreach ($clinics as $clinic) {
            Clinic::updateOrCreate(
                ['email' => $clinic['email']],
                $clinic
            );
        }
    }
}
