<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = [
            // دمشق - باطنية
            [
                'serial_number' => 'MX-A7K29P',
                'name_en' => 'Dr. Ahmad Al-Hamwi',
                'name_ar' => 'د. أحمد الحموي',
                'specialization_en' => 'Internal Medicine',
                'specialization_ar' => 'الأمراض الداخلية',
                'birthdate' => '1981-05-14',
                'id_passport' => 'SY-10028471',
                'photo' => 'doctors/ahmad_alhamwi.jpg',
                'working_hours' => 6,
            ],
            [
                'serial_number' => 'MX-B4R81N',
                'name_en' => 'Dr. Samer Al-Khatib',
                'name_ar' => 'د. سامر الخطيب',
                'specialization_en' => 'Internal Medicine',
                'specialization_ar' => 'الأمراض الداخلية',
                'birthdate' => '1978-11-22',
                'id_passport' => 'SY-10039284',
                'photo' => 'doctors/samer_alkhatib.jpg',
                'working_hours' => 6,
            ],

            // دمشق - أطفال
            [
                'serial_number' => 'MX-C9M52Q',
                'name_en' => 'Dr. Lina Al-Hourani',
                'name_ar' => 'د. لينا الحوراني',
                'specialization_en' => 'Pediatrics',
                'specialization_ar' => 'طب الأطفال',
                'birthdate' => '1986-03-09',
                'id_passport' => 'SY-10048392',
                'photo' => 'doctors/lina_alhourani.jpg',
                'working_hours' => 6,
            ],
            [
                'serial_number' => 'MX-D6T37W',
                'name_en' => 'Dr. Rami Al-Saleh',
                'name_ar' => 'د. رامي الصالح',
                'specialization_en' => 'Pediatrics',
                'specialization_ar' => 'طب الأطفال',
                'birthdate' => '1983-08-17',
                'id_passport' => 'SY-10057483',
                'photo' => 'doctors/rami_alsaleh.jpg',
                'working_hours' => 6,
            ],

            // دمشق - جلدية
            [
                'serial_number' => 'MX-E2H64L',
                'name_en' => 'Dr. Nour Al-Masri',
                'name_ar' => 'د. نور المصري',
                'specialization_en' => 'Dermatology',
                'specialization_ar' => 'الأمراض الجلدية',
                'birthdate' => '1987-01-28',
                'id_passport' => 'SY-10068574',
                'photo' => 'doctors/nour_almasri.jpg',
                'working_hours' => 5,
            ],
            [
                'serial_number' => 'MX-F8J13S',
                'name_en' => 'Dr. Tareq Al-Ahmad',
                'name_ar' => 'د. طارق الأحمد',
                'specialization_en' => 'Dermatology',
                'specialization_ar' => 'الأمراض الجلدية',
                'birthdate' => '1980-06-12',
                'id_passport' => 'SY-10079685',
                'photo' => 'doctors/tareq_alahmad.jpg',
                'working_hours' => 5,
            ],

            // حلب - قلبية
            [
                'serial_number' => 'MX-G5P48X',
                'name_en' => 'Dr. Firas Al-Halabi',
                'name_ar' => 'د. فراس الحلبي',
                'specialization_en' => 'Cardiology',
                'specialization_ar' => 'أمراض القلب',
                'birthdate' => '1976-04-19',
                'id_passport' => 'SY-10080796',
                'photo' => 'doctors/firas_alhalabi.jpg',
                'working_hours' => 6,
            ],
            [
                'serial_number' => 'MX-H3V72B',
                'name_en' => 'Dr. Hala Al-Jabri',
                'name_ar' => 'د. هالة الجابري',
                'specialization_en' => 'Cardiology',
                'specialization_ar' => 'أمراض القلب',
                'birthdate' => '1982-09-25',
                'id_passport' => 'SY-10091807',
                'photo' => 'doctors/hala_aljabri.jpg',
                'working_hours' => 6,
            ],

            // حلب - عظام
            [
                'serial_number' => 'MX-J7N35C',
                'name_en' => 'Dr. Khaled Al-Hassan',
                'name_ar' => 'د. خالد الحسن',
                'specialization_en' => 'Orthopedics',
                'specialization_ar' => 'جراحة العظام',
                'birthdate' => '1979-02-16',
                'id_passport' => 'SY-10102918',
                'photo' => 'doctors/khaled_alhassan.jpg',
                'working_hours' => 7,
            ],
            [
                'serial_number' => 'MX-K1Q69D',
                'name_en' => 'Dr. Yazan Al-Bitar',
                'name_ar' => 'د. يزن البيطار',
                'specialization_en' => 'Orthopedics',
                'specialization_ar' => 'جراحة العظام',
                'birthdate' => '1984-12-03',
                'id_passport' => 'SY-10113029',
                'photo' => 'doctors/yazan_albitar.jpg',
                'working_hours' => 6,
            ],

            // حلب - أنف أذن حنجرة
            [
                'serial_number' => 'MX-L9S24F',
                'name_en' => 'Dr. Mazen Al-Rifai',
                'name_ar' => 'د. مازن الرفاعي',
                'specialization_en' => 'ENT',
                'specialization_ar' => 'أنف أذن وحنجرة',
                'birthdate' => '1981-07-21',
                'id_passport' => 'SY-10124130',
                'photo' => 'doctors/mazen_alrifai.jpg',
                'working_hours' => 5,
            ],
            [
                'serial_number' => 'MX-M6W83G',
                'name_en' => 'Dr. Reem Al-Ali',
                'name_ar' => 'د. ريم العلي',
                'specialization_en' => 'ENT',
                'specialization_ar' => 'أنف أذن وحنجرة',
                'birthdate' => '1988-10-11',
                'id_passport' => 'SY-10135241',
                'photo' => 'doctors/reem_alali.jpg',
                'working_hours' => 5,
            ],

            // اللاذقية - نسائية
            [
                'serial_number' => 'MX-N4Y17H',
                'name_en' => 'Dr. Rania Al-Saadi',
                'name_ar' => 'د. رانيا السعدي',
                'specialization_en' => 'Gynecology',
                'specialization_ar' => 'أمراض النساء',
                'birthdate' => '1983-05-08',
                'id_passport' => 'SY-10146352',
                'photo' => 'doctors/rania_alsaadi.jpg',
                'working_hours' => 6,
            ],
            [
                'serial_number' => 'MX-P2K56J',
                'name_en' => 'Dr. Dima Al-Khoury',
                'name_ar' => 'د. ديما الخوري',
                'specialization_en' => 'Gynecology',
                'specialization_ar' => 'أمراض النساء',
                'birthdate' => '1986-11-27',
                'id_passport' => 'SY-10157463',
                'photo' => 'doctors/dima_alkhoury.jpg',
                'working_hours' => 6,
            ],

            // اللاذقية - عيون
            [
                'serial_number' => 'MX-Q8R31M',
                'name_en' => 'Dr. Bassam Al-Saleh',
                'name_ar' => 'د. بسام الصالح',
                'specialization_en' => 'Ophthalmology',
                'specialization_ar' => 'طب العيون',
                'birthdate' => '1977-03-30',
                'id_passport' => 'SY-10168574',
                'photo' => 'doctors/bassam_alsaleh.jpg',
                'working_hours' => 5,
            ],
            [
                'serial_number' => 'MX-R5T92N',
                'name_en' => 'Dr. Sawsan Al-Haddad',
                'name_ar' => 'د. سوسن الحداد',
                'specialization_en' => 'Ophthalmology',
                'specialization_ar' => 'طب العيون',
                'birthdate' => '1985-06-18',
                'id_passport' => 'SY-10179685',
                'photo' => 'doctors/sawsan_alhaddad.jpg',
                'working_hours' => 5,
            ],

            // اللاذقية - أسنان
            [
                'serial_number' => 'MX-S3V47P',
                'name_en' => 'Dr. Karim Al-Dandashi',
                'name_ar' => 'د. كريم الدندشي',
                'specialization_en' => 'General Dentistry',
                'specialization_ar' => 'طب الأسنان العام',
                'birthdate' => '1984-01-15',
                'id_passport' => 'SY-10180796',
                'photo' => 'doctors/karim_aldandashi.jpg',
                'working_hours' => 6,
            ],
            [
                'serial_number' => 'MX-T7X18Q',
                'name_en' => 'Dr. Maya Al-Homsi',
                'name_ar' => 'د. مايا الحمصي',
                'specialization_en' => 'General Dentistry',
                'specialization_ar' => 'طب الأسنان العام',
                'birthdate' => '1989-09-04',
                'id_passport' => 'SY-10191807',
                'photo' => 'doctors/maya_alhomsi.jpg',
                'working_hours' => 6,
            ],
        ];

        foreach ($doctors as $doctor) {
            Doctor::updateOrCreate(
                ['serial_number' => $doctor['serial_number']],
                $doctor
            );
        }
    }
}