<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['first_name' => 'محمد', 'last_name' => 'العلي', 'email' => 'mohammad.ali@medx.test', 'phone_number' => '0935123456', 'gender' => 'male', 'birthdate' => '1994-03-18', 'address' => 'دمشق - المزة', 'id_passport' => '01020304050'],
            ['first_name' => 'سارة', 'last_name' => 'الحسن', 'email' => 'sara.alhassan@medx.test', 'phone_number' => '0945123456', 'gender' => 'female', 'birthdate' => '1997-07-12', 'address' => 'دمشق - أبو رمانة', 'id_passport' => '01020304051'],
            ['first_name' => 'أحمد', 'last_name' => 'الخطيب', 'email' => 'ahmad.alkhatib@medx.test', 'phone_number' => '0955123456', 'gender' => 'male', 'birthdate' => '1988-11-04', 'address' => 'دمشق - جرمانا', 'id_passport' => '01020304052'],
            ['first_name' => 'نور', 'last_name' => 'المصري', 'email' => 'nour.almasri@medx.test', 'phone_number' => '0965123456', 'gender' => 'female', 'birthdate' => '1999-01-21', 'address' => 'دمشق - كفرسوسة', 'id_passport' => '01020304053'],
            ['first_name' => 'خالد', 'last_name' => 'حمود', 'email' => 'khaled.hamoud@medx.test', 'phone_number' => '0936123456', 'gender' => 'male', 'birthdate' => '1983-05-09', 'address' => 'دمشق - مشروع دمر', 'id_passport' => '01020304054'],
            ['first_name' => 'ريم', 'last_name' => 'عثمان', 'email' => 'reem.othman@medx.test', 'phone_number' => '0946123456', 'gender' => 'female', 'birthdate' => '1992-09-16', 'address' => 'دمشق - الميدان', 'id_passport' => '01020304055'],
            ['first_name' => 'يزن', 'last_name' => 'السالم', 'email' => 'yazan.alsalem@medx.test', 'phone_number' => '0956123456', 'gender' => 'male', 'birthdate' => '1990-02-25', 'address' => 'دمشق - باب توما', 'id_passport' => '01020304056'],
            ['first_name' => 'لينا', 'last_name' => 'إبراهيم', 'email' => 'lina.ibrahim@medx.test', 'phone_number' => '0966123456', 'gender' => 'female', 'birthdate' => '1995-12-08', 'address' => 'دمشق - الشعلان', 'id_passport' => '01020304057'],
            ['first_name' => 'عمر', 'last_name' => 'الدروبي', 'email' => 'omar.aldroubi@medx.test', 'phone_number' => '0937123456', 'gender' => 'male', 'birthdate' => '1985-04-11', 'address' => 'حلب - الفرقان', 'id_passport' => '01020304058'],
            ['first_name' => 'هبة', 'last_name' => 'الحلبي', 'email' => 'hiba.alhalabi@medx.test', 'phone_number' => '0947123456', 'gender' => 'female', 'birthdate' => '1996-06-28', 'address' => 'حلب - الحمدانية', 'id_passport' => '01020304059'],
            ['first_name' => 'رامي', 'last_name' => 'الرفاعي', 'email' => 'rami.alrifai@medx.test', 'phone_number' => '0957123456', 'gender' => 'male', 'birthdate' => '1987-08-19', 'address' => 'حلب - الجميلية', 'id_passport' => '01020304060'],
            ['first_name' => 'ديما', 'last_name' => 'عباس', 'email' => 'dima.abbas@medx.test', 'phone_number' => '0967123456', 'gender' => 'female', 'birthdate' => '1993-10-05', 'address' => 'حلب - السليمانية', 'id_passport' => '01020304061'],
            ['first_name' => 'فراس', 'last_name' => 'الحمصي', 'email' => 'firas.alhomsi@medx.test', 'phone_number' => '0938123456', 'gender' => 'male', 'birthdate' => '1981-03-14', 'address' => 'حمص - الإنشاءات', 'id_passport' => '01020304062'],
            ['first_name' => 'رنا', 'last_name' => 'الصالح', 'email' => 'rana.alsaleh@medx.test', 'phone_number' => '0948123456', 'gender' => 'female', 'birthdate' => '1998-02-07', 'address' => 'حمص - عكرمة', 'id_passport' => '01020304063'],
            ['first_name' => 'مازن', 'last_name' => 'الحوراني', 'email' => 'mazen.alhourani@medx.test', 'phone_number' => '0958123456', 'gender' => 'male', 'birthdate' => '1984-07-23', 'address' => 'حمص - بابا عمرو', 'id_passport' => '01020304064'],
            ['first_name' => 'سمر', 'last_name' => 'الجابري', 'email' => 'samar.aljabri@medx.test', 'phone_number' => '0968123456', 'gender' => 'female', 'birthdate' => '1991-11-30', 'address' => 'حمص - الزهراء', 'id_passport' => '01020304065'],
            ['first_name' => 'كرم', 'last_name' => 'النجار', 'email' => 'karam.alnajjar@medx.test', 'phone_number' => '0939123456', 'gender' => 'male', 'birthdate' => '1996-05-17', 'address' => 'اللاذقية - الرمل الجنوبي', 'id_passport' => '01020304066'],
            ['first_name' => 'جنى', 'last_name' => 'ديوب', 'email' => 'jana.diab@medx.test', 'phone_number' => '0949123456', 'gender' => 'female', 'birthdate' => '2000-08-22', 'address' => 'اللاذقية - الزراعة', 'id_passport' => '01020304067'],
            ['first_name' => 'باسل', 'last_name' => 'الأسعد', 'email' => 'basel.alasad@medx.test', 'phone_number' => '0959123456', 'gender' => 'male', 'birthdate' => '1989-09-10', 'address' => 'اللاذقية - مشروع الصليبة', 'id_passport' => '01020304068'],
            ['first_name' => 'مايا', 'last_name' => 'خليل', 'email' => 'maya.khalil@medx.test', 'phone_number' => '0969123456', 'gender' => 'female', 'birthdate' => '1994-04-02', 'address' => 'اللاذقية - الأميركان', 'id_passport' => '01020304069'],
            ['first_name' => 'سامر', 'last_name' => 'مراد', 'email' => 'samer.murad@medx.test', 'phone_number' => '0930123456', 'gender' => 'male', 'birthdate' => '1982-12-15', 'address' => 'حماة - جنوب الملعب', 'id_passport' => '01020304070'],
            ['first_name' => 'يارا', 'last_name' => 'الشيخ', 'email' => 'yara.alsheikh@medx.test', 'phone_number' => '0940123456', 'gender' => 'female', 'birthdate' => '1997-01-09', 'address' => 'حماة - طريق حلب', 'id_passport' => '01020304071'],
            ['first_name' => 'حسن', 'last_name' => 'محمود', 'email' => 'hassan.mahmoud@medx.test', 'phone_number' => '0950123456', 'gender' => 'male', 'birthdate' => '1986-06-20', 'address' => 'طرطوس - الكورنيش', 'id_passport' => '01020304072'],
            ['first_name' => 'تالا', 'last_name' => 'يوسف', 'email' => 'tala.yousef@medx.test', 'phone_number' => '0960123456', 'gender' => 'female', 'birthdate' => '2001-03-03', 'address' => 'طرطوس - الرمل', 'id_passport' => '01020304073'],
            ['first_name' => 'أنس', 'last_name' => 'سليمان', 'email' => 'anas.suleiman@medx.test', 'phone_number' => '0931123456', 'gender' => 'male', 'birthdate' => '1992-10-24', 'address' => 'درعا - المحطة', 'id_passport' => '01020304074'],
            ['first_name' => 'مرح', 'last_name' => 'عيسى', 'email' => 'marah.issa@medx.test', 'phone_number' => '0941123456', 'gender' => 'female', 'birthdate' => '1999-07-15', 'address' => 'درعا - درعا البلد', 'id_passport' => '01020304075'],
            ['first_name' => 'طارق', 'last_name' => 'الحموي', 'email' => 'tareq.alhamwi@medx.test', 'phone_number' => '0951123456', 'gender' => 'male', 'birthdate' => '1980-02-12', 'address' => 'السويداء - المدينة', 'id_passport' => '01020304076'],
            ['first_name' => 'رؤى', 'last_name' => 'الحسن', 'email' => 'roua.alhassan@medx.test', 'phone_number' => '0961123456', 'gender' => 'female', 'birthdate' => '1995-11-18', 'address' => 'السويداء - المزرعة', 'id_passport' => '01020304077'],
            ['first_name' => 'وليد', 'last_name' => 'العمر', 'email' => 'walid.alomar@medx.test', 'phone_number' => '0932123456', 'gender' => 'male', 'birthdate' => '1983-01-29', 'address' => 'إدلب - المدينة', 'id_passport' => '01020304078'],
            ['first_name' => 'شهد', 'last_name' => 'قاسم', 'email' => 'shahd.qasem@medx.test', 'phone_number' => '0942123456', 'gender' => 'female', 'birthdate' => '1998-05-26', 'address' => 'إدلب - الدانا', 'id_passport' => '01020304079'],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    ...$user,
                    'password' => Hash::make('password'),
                ]
            );
        }
    }
}