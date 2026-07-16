<?php

namespace Modules\TraficPermit\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Kdabrow\SeederOnce\SeederOnce;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;

class CountriesTableSeeder extends Seeder
{
    use SeederOnce;

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        DB::table('countries')->delete();
        
        DB::table('countries')->insertOrIgnore(array (
            0 => 
            array (
                'en_name' => 'Aruba',
                'fa_name' => 'آروبا',
                'fips' => 'AA',
                'iso' => 'AW',
            ),
            1 => 
            array (
                'en_name' => 'Antigua and Barbuda',
                'fa_name' => 'آنتیگوا و باربودا',
                'fips' => 'AC',
                'iso' => 'AG',
            ),
            2 => 
            array (
                'en_name' => 'United Arab Emirates',
                'fa_name' => 'امارات متحده عربی',
                'fips' => 'AE',
                'iso' => 'AE',
            ),
            3 => 
            array (
                'en_name' => 'Afghanistan',
                'fa_name' => 'افغانستان',
                'fips' => 'AF',
                'iso' => 'AF',
            ),
            4 => 
            array (
                'en_name' => 'Algeria',
                'fa_name' => 'الجزایر',
                'fips' => 'AG',
                'iso' => 'DZ',
            ),
            5 => 
            array (
                'en_name' => 'Azerbaijan',
                'fa_name' => 'آذربایجان',
                'fips' => 'AJ',
                'iso' => 'AZ',
            ),
            6 => 
            array (
                'en_name' => 'Albania',
                'fa_name' => 'آلبانی',
                'fips' => 'AL',
                'iso' => 'AL',
            ),
            7 => 
            array (
                'en_name' => 'Armenia',
                'fa_name' => 'ارمنستان',
                'fips' => 'AM',
                'iso' => 'AM',
            ),
            8 => 
            array (
                'en_name' => 'Andorra',
                'fa_name' => 'آندورا',
                'fips' => 'AN',
                'iso' => 'AD',
            ),
            9 => 
            array (
                'en_name' => 'Angola',
                'fa_name' => 'آنگولا',
                'fips' => 'AO',
                'iso' => 'AO',
            ),
            10 => 
            array (
                'en_name' => 'American Samoa',
                'fa_name' => 'ساموای آمریکایی',
                'fips' => 'AQ',
                'iso' => 'AS',
            ),
            11 => 
            array (
                'en_name' => 'Argentina',
                'fa_name' => 'آرژانتین',
                'fips' => 'AR',
                'iso' => 'AR',
            ),
            12 => 
            array (
                'en_name' => 'Australia',
                'fa_name' => 'استرالیا',
                'fips' => 'AS',
                'iso' => 'AU',
            ),
            13 => 
            array (
                'en_name' => 'Ashmore and Cartier Islands',
                'fa_name' => 'اشکمور و جزایر کارتیه',
                'fips' => 'AT',
                'iso' => '-',
            ),
            14 => 
            array (
                'en_name' => 'Austria',
                'fa_name' => 'اتریش',
                'fips' => 'AU',
                'iso' => 'AT',
            ),
            15 => 
            array (
                'en_name' => 'Anguilla',
                'fa_name' => 'آنگویلا',
                'fips' => 'AV',
                'iso' => 'AI',
            ),
            16 => 
            array (
                'en_name' => 'Åland Islands',
                'fa_name' => 'جزایر الند',
                'fips' => 'AX',
                'iso' => 'AX',
            ),
            17 => 
            array (
                'en_name' => 'Antarctica',
                'fa_name' => 'قطب جنوب',
                'fips' => 'AY',
                'iso' => 'AQ',
            ),
            18 => 
            array (
                'en_name' => 'Bahrain',
                'fa_name' => 'بحرین',
                'fips' => 'BA',
                'iso' => 'BH',
            ),
            19 => 
            array (
                'en_name' => 'Barbados',
                'fa_name' => 'باربادوس',
                'fips' => 'BB',
                'iso' => 'BB',
            ),
            20 => 
            array (
                'en_name' => 'Botswana',
                'fa_name' => 'بوتسوانا',
                'fips' => 'BC',
                'iso' => 'BW',
            ),
            21 => 
            array (
                'en_name' => 'Bermuda',
                'fa_name' => 'برمودا',
                'fips' => 'BD',
                'iso' => 'BM',
            ),
            22 => 
            array (
                'en_name' => 'Belgium',
                'fa_name' => 'بلژیک',
                'fips' => 'BE',
                'iso' => 'BE',
            ),
            23 => 
            array (
                'en_name' => 'Bahamas, The',
                'fa_name' => 'باهاما، The',
                'fips' => 'BF',
                'iso' => 'BS',
            ),
            24 => 
            array (
                'en_name' => 'Bangladesh',
                'fa_name' => 'بنگلادش',
                'fips' => 'BG',
                'iso' => 'BD',
            ),
            25 => 
            array (
                'en_name' => 'Belize',
                'fa_name' => 'بلیز',
                'fips' => 'BH',
                'iso' => 'BZ',
            ),
            26 => 
            array (
                'en_name' => 'Bosnia and Herzegovina',
                'fa_name' => 'بوسنی و هرزگوین',
                'fips' => 'BK',
                'iso' => 'BA',
            ),
            27 => 
            array (
                'en_name' => 'Bolivia',
                'fa_name' => 'بولیوی',
                'fips' => 'BL',
                'iso' => 'BO',
            ),
            28 => 
            array (
                'en_name' => 'Myanmar',
                'fa_name' => 'میانمار',
                'fips' => 'BM',
                'iso' => 'MM',
            ),
            29 => 
            array (
                'en_name' => 'Benin',
                'fa_name' => 'بنین',
                'fips' => 'BN',
                'iso' => 'BJ',
            ),
            30 => 
            array (
                'en_name' => 'Belarus',
                'fa_name' => 'بلاروس',
                'fips' => 'BO',
                'iso' => 'BY',
            ),
            31 => 
            array (
                'en_name' => 'Solomon Islands',
                'fa_name' => 'جزایر سلیمان',
                'fips' => 'BP',
                'iso' => 'SB',
            ),
            32 => 
            array (
                'en_name' => 'Navassa Island',
                'fa_name' => 'جزیره ناواسا',
                'fips' => 'BQ',
                'iso' => '-',
            ),
            33 => 
            array (
                'en_name' => 'Brazil',
                'fa_name' => 'برزیل',
                'fips' => 'BR',
                'iso' => 'BR',
            ),
            34 => 
            array (
                'en_name' => 'Bassas da India',
                'fa_name' => 'باساس دا هند',
                'fips' => 'BS',
                'iso' => '-',
            ),
            35 => 
            array (
                'en_name' => 'Bhutan',
                'fa_name' => 'بوتان',
                'fips' => 'BT',
                'iso' => 'BT',
            ),
            36 => 
            array (
                'en_name' => 'Bulgaria',
                'fa_name' => 'بلغارستان',
                'fips' => 'BU',
                'iso' => 'BG',
            ),
            37 => 
            array (
                'en_name' => 'Bouvet Island',
                'fa_name' => 'جزیره Bouvet',
                'fips' => 'BV',
                'iso' => 'BV',
            ),
            38 => 
            array (
                'en_name' => 'Brunei',
                'fa_name' => 'برونئی',
                'fips' => 'BX',
                'iso' => 'BN',
            ),
            39 => 
            array (
                'en_name' => 'Burundi',
                'fa_name' => 'بوروندی',
                'fips' => 'BY',
                'iso' => 'BI',
            ),
            40 => 
            array (
                'en_name' => 'Canada',
                'fa_name' => 'کانادا',
                'fips' => 'CA',
                'iso' => 'CA',
            ),
            41 => 
            array (
                'en_name' => 'Cambodia',
                'fa_name' => 'کامبوج',
                'fips' => 'CB',
                'iso' => 'KH',
            ),
            42 => 
            array (
                'en_name' => 'Chad',
                'fa_name' => 'چاد',
                'fips' => 'CD',
                'iso' => 'TD',
            ),
            43 => 
            array (
                'en_name' => 'Sri Lanka',
                'fa_name' => 'سری لانکا',
                'fips' => 'CE',
                'iso' => 'LK',
            ),
            44 => 
            array (
                'en_name' => 'Congo, Republic of the',
                'fa_name' => 'کنگو، جمهوری',
                'fips' => 'CF',
                'iso' => 'CG',
            ),
            45 => 
            array (
                'en_name' => 'Congo, Democratic Republic of the',
                'fa_name' => 'کنگو، جمهوری دموکراتیک',
                'fips' => 'CG',
                'iso' => 'CD',
            ),
            46 => 
            array (
                'en_name' => 'China',
                'fa_name' => 'چين',
                'fips' => 'CH',
                'iso' => 'CN',
            ),
            47 => 
            array (
                'en_name' => 'Chile',
                'fa_name' => 'شیلی',
                'fips' => 'CI',
                'iso' => 'CL',
            ),
            48 => 
            array (
                'en_name' => 'Cayman Islands',
                'fa_name' => 'جزایر کیمن',
                'fips' => 'CJ',
                'iso' => 'KY',
            ),
            49 => 
            array (
                'en_name' => 'Cocos (Keeling) Islands',
                'fa_name' => 'جزایر کوکوس (کایلینگ)',
                'fips' => 'CK',
                'iso' => 'CC',
            ),
            50 => 
            array (
                'en_name' => 'Cameroon',
                'fa_name' => 'کامرون',
                'fips' => 'CM',
                'iso' => 'CM',
            ),
            51 => 
            array (
                'en_name' => 'Comoros',
                'fa_name' => 'کومور',
                'fips' => 'CN',
                'iso' => 'KM',
            ),
            52 => 
            array (
                'en_name' => 'Colombia',
                'fa_name' => 'کلمبیا',
                'fips' => 'CO',
                'iso' => 'CO',
            ),
            53 => 
            array (
                'en_name' => 'Northern Mariana Islands',
                'fa_name' => 'جزایر ماریانای شمالی',
                'fips' => 'CQ',
                'iso' => 'MP',
            ),
            54 => 
            array (
                'en_name' => 'Coral Sea Islands',
                'fa_name' => 'جزایر دریای مرجانی',
                'fips' => 'CR',
                'iso' => '-',
            ),
            55 => 
            array (
                'en_name' => 'Costa Rica',
                'fa_name' => 'کاستاریکا',
                'fips' => 'CS',
                'iso' => 'CR',
            ),
            56 => 
            array (
                'en_name' => 'Central African Republic',
                'fa_name' => 'جمهوری آفریقای مرکزی',
                'fips' => 'CT',
                'iso' => 'CF',
            ),
            57 => 
            array (
                'en_name' => 'Cuba',
                'fa_name' => 'کوبا',
                'fips' => 'CU',
                'iso' => 'CU',
            ),
            58 => 
            array (
                'en_name' => 'Cape Verde',
                'fa_name' => 'کیپ ورد',
                'fips' => 'CV',
                'iso' => 'CV',
            ),
            59 => 
            array (
                'en_name' => 'Cook Islands',
                'fa_name' => 'جزایر کوک',
                'fips' => 'CW',
                'iso' => 'CK',
            ),
            60 => 
            array (
                'en_name' => 'Cyprus',
                'fa_name' => 'قبرس',
                'fips' => 'CY',
                'iso' => 'CY',
            ),
            61 => 
            array (
                'en_name' => 'Denmark',
                'fa_name' => 'دانمارک',
                'fips' => 'DA',
                'iso' => 'DK',
            ),
            62 => 
            array (
                'en_name' => 'Djibouti',
                'fa_name' => 'جیبوتی',
                'fips' => 'DJ',
                'iso' => 'DJ',
            ),
            63 => 
            array (
                'en_name' => 'Dominica',
                'fa_name' => 'دومینیکا',
                'fips' => 'DO',
                'iso' => 'DM',
            ),
            64 => 
            array (
                'en_name' => 'Jarvis Island',
                'fa_name' => 'جزیره جارویس',
                'fips' => 'DQ',
                'iso' => 'UM',
            ),
            65 => 
            array (
                'en_name' => 'Dominican Republic',
                'fa_name' => 'جمهوری دومینیکن',
                'fips' => 'DR',
                'iso' => 'DO',
            ),
            66 => 
            array (
                'en_name' => 'Dhekelia Sovereign Base Area',
                'fa_name' => 'منطقه ممنوعه Dhekelia',
                'fips' => 'DX',
                'iso' => '-',
            ),
            67 => 
            array (
                'en_name' => 'Ecuador',
                'fa_name' => 'اکوادور',
                'fips' => 'EC',
                'iso' => 'EC',
            ),
            68 => 
            array (
                'en_name' => 'Egypt',
                'fa_name' => 'مصر',
                'fips' => 'EG',
                'iso' => 'EG',
            ),
            69 => 
            array (
                'en_name' => 'Ireland',
                'fa_name' => 'ایرلند',
                'fips' => 'EI',
                'iso' => 'IE',
            ),
            70 => 
            array (
                'en_name' => 'Equatorial Guinea',
                'fa_name' => 'گینه استوایی',
                'fips' => 'EK',
                'iso' => 'GQ',
            ),
            71 => 
            array (
                'en_name' => 'Estonia',
                'fa_name' => 'استونی',
                'fips' => 'EN',
                'iso' => 'EE',
            ),
            72 => 
            array (
                'en_name' => 'Eritrea',
                'fa_name' => 'اریتره',
                'fips' => 'ER',
                'iso' => 'ER',
            ),
            73 => 
            array (
                'en_name' => 'El Salvador',
                'fa_name' => 'السالوادور',
                'fips' => 'ES',
                'iso' => 'SV',
            ),
            74 => 
            array (
                'en_name' => 'Ethiopia',
                'fa_name' => 'اتیوپی',
                'fips' => 'ET',
                'iso' => 'ET',
            ),
            75 => 
            array (
                'en_name' => 'Europa Island',
                'fa_name' => 'جزیره اروپا',
                'fips' => 'EU',
                'iso' => '-',
            ),
            76 => 
            array (
                'en_name' => 'Czech Republic',
                'fa_name' => 'جمهوری چک',
                'fips' => 'EZ',
                'iso' => 'CZ',
            ),
            77 => 
            array (
                'en_name' => 'French Guiana',
                'fa_name' => 'گویان فرانسه',
                'fips' => 'FG',
                'iso' => 'GF',
            ),
            78 => 
            array (
                'en_name' => 'Finland',
                'fa_name' => 'فنلاند',
                'fips' => 'FI',
                'iso' => 'FI',
            ),
            79 => 
            array (
                'en_name' => 'Fiji',
                'fa_name' => 'فیجی',
                'fips' => 'FJ',
                'iso' => 'FJ',
            ),
            80 => 
            array (
                'en_name' => 'Falkland Islands (Islas Malvinas)',
                'fa_name' => 'جزایر فالکلند (جزایر مالویناس)',
                'fips' => 'FK',
                'iso' => 'FK',
            ),
            81 => 
            array (
                'en_name' => 'Micronesia, Federated States of',
                'fa_name' => 'میکرونزی، ایالات فدرال',
                'fips' => 'FM',
                'iso' => 'FM',
            ),
            82 => 
            array (
                'en_name' => 'Faroe Islands',
                'fa_name' => 'جزایر فارو',
                'fips' => 'FO',
                'iso' => 'FO',
            ),
            83 => 
            array (
                'en_name' => 'French Polynesia',
                'fa_name' => 'پلینزی فرانسه',
                'fips' => 'FP',
                'iso' => 'PF',
            ),
            84 => 
            array (
                'en_name' => 'Baker Island',
                'fa_name' => 'جزیره بیکر',
                'fips' => 'FQ',
                'iso' => 'UM',
            ),
            85 => 
            array (
                'en_name' => 'France',
                'fa_name' => 'فرانسه',
                'fips' => 'FR',
                'iso' => 'FR',
            ),
            86 => 
            array (
                'en_name' => 'French Southern and Antarctic Lands',
                'fa_name' => 'زمینهای جنوب و جنوب قطب جنوب فرانسه',
                'fips' => 'FS',
                'iso' => 'TF',
            ),
            87 => 
            array (
                'en_name' => 'Gambia, The',
                'fa_name' => 'گامبیا، The',
                'fips' => 'GA',
                'iso' => 'GM',
            ),
            88 => 
            array (
                'en_name' => 'Gabon',
                'fa_name' => 'گابن',
                'fips' => 'GB',
                'iso' => 'GA',
            ),
            89 => 
            array (
                'en_name' => 'Georgia',
                'fa_name' => 'جورجیا',
                'fips' => 'GG',
                'iso' => 'GE',
            ),
            90 => 
            array (
                'en_name' => 'Ghana',
                'fa_name' => 'غنا',
                'fips' => 'GH',
                'iso' => 'GH',
            ),
            91 => 
            array (
                'en_name' => 'Gibraltar',
                'fa_name' => 'جبل الطارق',
                'fips' => 'GI',
                'iso' => 'GI',
            ),
            92 => 
            array (
                'en_name' => 'Grenada',
                'fa_name' => 'گرانادا',
                'fips' => 'GJ',
                'iso' => 'GD',
            ),
            93 => 
            array (
                'en_name' => 'Guernsey',
                'fa_name' => 'گورنسی',
                'fips' => 'GK',
                'iso' => '-',
            ),
            94 => 
            array (
                'en_name' => 'Greenland',
                'fa_name' => 'گرینلند',
                'fips' => 'GL',
                'iso' => 'GL',
            ),
            95 => 
            array (
                'en_name' => 'Germany',
                'fa_name' => 'آلمان',
                'fips' => 'GM',
                'iso' => 'DE',
            ),
            96 => 
            array (
                'en_name' => 'Glorioso Islands',
                'fa_name' => 'جزایر گلوریوزو',
                'fips' => 'GO',
                'iso' => '-',
            ),
            97 => 
            array (
                'en_name' => 'Guadeloupe',
                'fa_name' => 'گوادلوپ',
                'fips' => 'GP',
                'iso' => 'GP',
            ),
            98 => 
            array (
                'en_name' => 'Guam',
                'fa_name' => 'گوام',
                'fips' => 'GQ',
                'iso' => 'GU',
            ),
            99 => 
            array (
                'en_name' => 'Greece',
                'fa_name' => 'یونان',
                'fips' => 'GR',
                'iso' => 'GR',
            ),
            100 => 
            array (
                'en_name' => 'Guatemala',
                'fa_name' => 'گواتمالا',
                'fips' => 'GT',
                'iso' => 'GT',
            ),
            101 => 
            array (
                'en_name' => 'Guinea',
                'fa_name' => 'گینه',
                'fips' => 'GV',
                'iso' => 'GN',
            ),
            102 => 
            array (
                'en_name' => 'Guyana',
                'fa_name' => 'گایانا',
                'fips' => 'GY',
                'iso' => 'GY',
            ),
            103 => 
            array (
                'en_name' => 'Gaza Strip',
                'fa_name' => 'نوار غزه',
                'fips' => 'GZ',
                'iso' => '-',
            ),
            104 => 
            array (
                'en_name' => 'Haiti',
                'fa_name' => 'هائیتی',
                'fips' => 'HA',
                'iso' => 'HT',
            ),
            105 => 
            array (
                'en_name' => 'Hong Kong',
                'fa_name' => 'هنگ کنگ',
                'fips' => 'HK',
                'iso' => 'HK',
            ),
            106 => 
            array (
                'en_name' => 'Heard Island and McDonald Islands',
                'fa_name' => 'جزایر هرد و جزایر مک دونالد',
                'fips' => 'HM',
                'iso' => 'HM',
            ),
            107 => 
            array (
                'en_name' => 'Honduras',
                'fa_name' => 'هندوراس',
                'fips' => 'HO',
                'iso' => 'HN',
            ),
            108 => 
            array (
                'en_name' => 'Howland Island',
                'fa_name' => 'جزیره Howland',
                'fips' => 'HQ',
                'iso' => 'UM',
            ),
            109 => 
            array (
                'en_name' => 'Croatia',
                'fa_name' => 'کرواسی',
                'fips' => 'HR',
                'iso' => 'HR',
            ),
            110 => 
            array (
                'en_name' => 'Hungary',
                'fa_name' => 'مجارستان',
                'fips' => 'HU',
                'iso' => 'HU',
            ),
            111 => 
            array (
                'en_name' => 'Iceland',
                'fa_name' => 'ایسلند',
                'fips' => 'IC',
                'iso' => 'IS',
            ),
            112 => 
            array (
                'en_name' => 'Indonesia',
                'fa_name' => 'اندونزی',
                'fips' => 'ID',
                'iso' => 'ID',
            ),
            113 => 
            array (
                'en_name' => 'Isle of Man',
                'fa_name' => 'جزیره من',
                'fips' => 'IM',
                'iso' => 'IM',
            ),
            114 => 
            array (
                'en_name' => 'India',
                'fa_name' => 'هندوستان',
                'fips' => 'IN',
                'iso' => 'IN',
            ),
            115 => 
            array (
                'en_name' => 'British Indian Ocean Territory',
                'fa_name' => 'قلمرو اقیانوس هند بریتانیا',
                'fips' => 'IO',
                'iso' => 'IO',
            ),
            116 => 
            array (
                'en_name' => 'Clipperton Island',
                'fa_name' => 'جزیره Clipperton',
                'fips' => 'IP',
                'iso' => '-',
            ),
            117 => 
            array (
                'en_name' => 'Iran',
                'fa_name' => 'ایران',
                'fips' => 'IR',
                'iso' => 'IR',
            ),
            118 => 
            array (
                'en_name' => 'Israel',
                'fa_name' => 'اسرائيل',
                'fips' => 'IS',
                'iso' => 'IL',
            ),
            119 => 
            array (
                'en_name' => 'Italy',
                'fa_name' => 'ایتالیا',
                'fips' => 'IT',
                'iso' => 'IT',
            ),
            120 => 
            array (
                'en_name' => 'Cote d\'Ivoire',
                'fa_name' => 'ساحل عاج',
                'fips' => 'IV',
                'iso' => 'CI',
            ),
            121 => 
            array (
                'en_name' => 'Iraq',
                'fa_name' => 'عراق',
                'fips' => 'IZ',
                'iso' => 'IQ',
            ),
            122 => 
            array (
                'en_name' => 'Japan',
                'fa_name' => 'ژاپن',
                'fips' => 'JA',
                'iso' => 'JP',
            ),
            123 => 
            array (
                'en_name' => 'Jersey',
                'fa_name' => 'جرسی',
                'fips' => 'JE',
                'iso' => 'JE',
            ),
            124 => 
            array (
                'en_name' => 'Jamaica',
                'fa_name' => 'جامائیکا',
                'fips' => 'JM',
                'iso' => 'JM',
            ),
            125 => 
            array (
                'en_name' => 'Jan Mayen',
                'fa_name' => 'Jan Mayen',
                'fips' => 'JN',
                'iso' => 'SJ',
            ),
            126 => 
            array (
                'en_name' => 'Jordan',
                'fa_name' => 'اردن',
                'fips' => 'JO',
                'iso' => 'JO',
            ),
            127 => 
            array (
                'en_name' => 'Johnston Atoll',
                'fa_name' => 'جانستون اتول',
                'fips' => 'JQ',
                'iso' => 'UM',
            ),
            128 => 
            array (
                'en_name' => 'Juan de Nova Island',
                'fa_name' => 'جزیره خوان جزیره نوا',
                'fips' => 'JU',
                'iso' => '-',
            ),
            129 => 
            array (
                'en_name' => 'Kenya',
                'fa_name' => 'کنیا',
                'fips' => 'KE',
                'iso' => 'KE',
            ),
            130 => 
            array (
                'en_name' => 'Kyrgyzstan',
                'fa_name' => 'قرقیزستان',
                'fips' => 'KG',
                'iso' => 'KG',
            ),
            131 => 
            array (
                'en_name' => 'Korea, North',
                'fa_name' => 'کره شمالی',
                'fips' => 'KN',
                'iso' => 'KP',
            ),
            132 => 
            array (
                'en_name' => 'Kingman Reef',
                'fa_name' => 'کینگمن ریف',
                'fips' => 'KQ',
                'iso' => 'UM',
            ),
            133 => 
            array (
                'en_name' => 'Kiribati',
                'fa_name' => 'کیریباتی',
                'fips' => 'KR',
                'iso' => 'KI',
            ),
            134 => 
            array (
                'en_name' => 'Korea, South',
                'fa_name' => 'کره جنوبی',
                'fips' => 'KS',
                'iso' => 'KR',
            ),
            135 => 
            array (
                'en_name' => 'Christmas Island',
                'fa_name' => 'جزیره کریسمس',
                'fips' => 'KT',
                'iso' => 'CX',
            ),
            136 => 
            array (
                'en_name' => 'Kuwait',
                'fa_name' => 'کویت',
                'fips' => 'KU',
                'iso' => 'KW',
            ),
            137 => 
            array (
                'en_name' => 'Kosovo',
                'fa_name' => 'کوزوو',
                'fips' => 'KV',
                'iso' => 'KV',
            ),
            138 => 
            array (
                'en_name' => 'Kazakhstan',
                'fa_name' => 'قزاقستان',
                'fips' => 'KZ',
                'iso' => 'KZ',
            ),
            139 => 
            array (
                'en_name' => 'Laos',
                'fa_name' => 'لائوس',
                'fips' => 'LA',
                'iso' => 'LA',
            ),
            140 => 
            array (
                'en_name' => 'Lebanon',
                'fa_name' => 'لبنان',
                'fips' => 'LE',
                'iso' => 'LB',
            ),
            141 => 
            array (
                'en_name' => 'Latvia',
                'fa_name' => 'لتونی',
                'fips' => 'LG',
                'iso' => 'LV',
            ),
            142 => 
            array (
                'en_name' => 'Lithuania',
                'fa_name' => 'لیتوانی',
                'fips' => 'LH',
                'iso' => 'LT',
            ),
            143 => 
            array (
                'en_name' => 'Liberia',
                'fa_name' => 'لیبریا',
                'fips' => 'LI',
                'iso' => 'LR',
            ),
            144 => 
            array (
                'en_name' => 'Slovakia',
                'fa_name' => 'اسلواکی',
                'fips' => 'LO',
                'iso' => 'SK',
            ),
            145 => 
            array (
                'en_name' => 'Palmyra Atoll',
                'fa_name' => 'پالمیرا اتل',
                'fips' => 'LQ',
                'iso' => 'UM',
            ),
            146 => 
            array (
                'en_name' => 'Liechtenstein',
                'fa_name' => 'لیختن اشتاین',
                'fips' => 'LS',
                'iso' => 'LI',
            ),
            147 => 
            array (
                'en_name' => 'Lesotho',
                'fa_name' => 'لسوتو',
                'fips' => 'LT',
                'iso' => 'LS',
            ),
            148 => 
            array (
                'en_name' => 'Luxembourg',
                'fa_name' => 'لوکزامبورگ',
                'fips' => 'LU',
                'iso' => 'LU',
            ),
            149 => 
            array (
                'en_name' => 'Libyan Arab',
                'fa_name' => 'عرب لیبی',
                'fips' => 'LY',
                'iso' => 'LY',
            ),
            150 => 
            array (
                'en_name' => 'Madagascar',
                'fa_name' => 'ماداگاسکار',
                'fips' => 'MA',
                'iso' => 'MG',
            ),
            151 => 
            array (
                'en_name' => 'Martinique',
                'fa_name' => 'مارتینیک',
                'fips' => 'MB',
                'iso' => 'MQ',
            ),
            152 => 
            array (
                'en_name' => 'Macau',
                'fa_name' => 'ماکائو',
                'fips' => 'MC',
                'iso' => 'MO',
            ),
            153 => 
            array (
                'en_name' => 'Moldova, Republic of',
                'fa_name' => 'مولداوی، جمهوری',
                'fips' => 'MD',
                'iso' => 'MD',
            ),
            154 => 
            array (
                'en_name' => 'Mayotte',
                'fa_name' => 'مایوت',
                'fips' => 'MF',
                'iso' => 'YT',
            ),
            155 => 
            array (
                'en_name' => 'Mongolia',
                'fa_name' => 'مغولستان',
                'fips' => 'MG',
                'iso' => 'MN',
            ),
            156 => 
            array (
                'en_name' => 'Montserrat',
                'fa_name' => 'مونتسرات',
                'fips' => 'MH',
                'iso' => 'MS',
            ),
            157 => 
            array (
                'en_name' => 'Malawi',
                'fa_name' => 'مالاوی',
                'fips' => 'MI',
                'iso' => 'MW',
            ),
            158 => 
            array (
                'en_name' => 'Montenegro',
                'fa_name' => 'مونته نگرو',
                'fips' => 'MJ',
                'iso' => 'ME',
            ),
            159 => 
            array (
                'en_name' => 'The Former Yugoslav Republic of Macedonia',
                'fa_name' => 'جمهوری مقدونیه یوگسلاوی سابق',
                'fips' => 'MK',
                'iso' => 'MK',
            ),
            160 => 
            array (
                'en_name' => 'Mali',
                'fa_name' => 'مالزی',
                'fips' => 'ML',
                'iso' => 'ML',
            ),
            161 => 
            array (
                'en_name' => 'Monaco',
                'fa_name' => 'موناکو',
                'fips' => 'MN',
                'iso' => 'MC',
            ),
            162 => 
            array (
                'en_name' => 'Morocco',
                'fa_name' => 'مراکش',
                'fips' => 'MO',
                'iso' => 'MA',
            ),
            163 => 
            array (
                'en_name' => 'Mauritius',
                'fa_name' => 'موریس',
                'fips' => 'MP',
                'iso' => 'MU',
            ),
            164 => 
            array (
                'en_name' => 'Midway Islands',
                'fa_name' => 'جزایر میدوی',
                'fips' => 'MQ',
                'iso' => 'UM',
            ),
            165 => 
            array (
                'en_name' => 'Mauritania',
                'fa_name' => 'موریتانی',
                'fips' => 'MR',
                'iso' => 'MR',
            ),
            166 => 
            array (
                'en_name' => 'Malta',
                'fa_name' => 'مالت',
                'fips' => 'MT',
                'iso' => 'MT',
            ),
            167 => 
            array (
                'en_name' => 'Oman',
                'fa_name' => 'عمان',
                'fips' => 'MU',
                'iso' => 'OM',
            ),
            168 => 
            array (
                'en_name' => 'Maldives',
                'fa_name' => 'مالدیو',
                'fips' => 'MV',
                'iso' => 'MV',
            ),
            169 => 
            array (
                'en_name' => 'Mexico',
                'fa_name' => 'مکزیک',
                'fips' => 'MX',
                'iso' => 'MX',
            ),
            170 => 
            array (
                'en_name' => 'Malaysia',
                'fa_name' => 'مالزی',
                'fips' => 'MY',
                'iso' => 'MY',
            ),
            171 => 
            array (
                'en_name' => 'Mozambique',
                'fa_name' => 'موزامبیک',
                'fips' => 'MZ',
                'iso' => 'MZ',
            ),
            172 => 
            array (
                'en_name' => 'New Caledonia',
                'fa_name' => 'کالدونیای جدید',
                'fips' => 'NC',
                'iso' => 'NC',
            ),
            173 => 
            array (
                'en_name' => 'Niue',
                'fa_name' => 'نیو',
                'fips' => 'NE',
                'iso' => 'NU',
            ),
            174 => 
            array (
                'en_name' => 'Norfolk Island',
                'fa_name' => 'جزیره نورفولک',
                'fips' => 'NF',
                'iso' => 'NF',
            ),
            175 => 
            array (
                'en_name' => 'Niger',
                'fa_name' => 'نیجر',
                'fips' => 'NG',
                'iso' => 'NE',
            ),
            176 => 
            array (
                'en_name' => 'Vanuatu',
                'fa_name' => 'وانواتو',
                'fips' => 'NH',
                'iso' => 'VU',
            ),
            177 => 
            array (
                'en_name' => 'Nigeria',
                'fa_name' => 'نیجریه',
                'fips' => 'NI',
                'iso' => 'NG',
            ),
            178 => 
            array (
                'en_name' => 'Netherlands',
                'fa_name' => 'هلند',
                'fips' => 'NL',
                'iso' => 'NL',
            ),
            179 => 
            array (
                'en_name' => 'No Man\'s Land',
                'fa_name' => 'هیچ مردی زمین نیست',
                'fips' => 'NM',
                'iso' => '',
            ),
            180 => 
            array (
                'en_name' => 'Norway',
                'fa_name' => 'نروژ',
                'fips' => 'NO',
                'iso' => 'NO',
            ),
            181 => 
            array (
                'en_name' => 'Nepal',
                'fa_name' => 'نپال',
                'fips' => 'NP',
                'iso' => 'NP',
            ),
            182 => 
            array (
                'en_name' => 'Nauru',
                'fa_name' => 'نائورو',
                'fips' => 'NR',
                'iso' => 'NR',
            ),
            183 => 
            array (
                'en_name' => 'Suriname',
                'fa_name' => 'سورینام',
                'fips' => 'NS',
                'iso' => 'SR',
            ),
            184 => 
            array (
                'en_name' => 'Netherlands Antilles',
                'fa_name' => 'آنتیل هلند',
                'fips' => 'NT',
                'iso' => 'AN',
            ),
            185 => 
            array (
                'en_name' => 'Nicaragua',
                'fa_name' => 'نیکاراگوئه',
                'fips' => 'NU',
                'iso' => 'NI',
            ),
            186 => 
            array (
                'en_name' => 'New Zealand',
                'fa_name' => 'نیوزلند',
                'fips' => 'NZ',
                'iso' => 'NZ',
            ),
            187 => 
            array (
                'en_name' => 'Paraguay',
                'fa_name' => 'پاراگوئه',
                'fips' => 'PA',
                'iso' => 'PY',
            ),
            188 => 
            array (
                'en_name' => 'Pitcairn Islands',
                'fa_name' => 'جزایر پیتکرن',
                'fips' => 'PC',
                'iso' => 'PN',
            ),
            189 => 
            array (
                'en_name' => 'Peru',
                'fa_name' => 'پرو',
                'fips' => 'PE',
                'iso' => 'PE',
            ),
            190 => 
            array (
                'en_name' => 'Paracel Islands',
                'fa_name' => 'جزایر پاراسل',
                'fips' => 'PF',
                'iso' => '-',
            ),
            191 => 
            array (
                'en_name' => 'Spratly Islands',
                'fa_name' => 'جزایر اسپارتلی',
                'fips' => 'PG',
                'iso' => '-',
            ),
            192 => 
            array (
                'en_name' => 'Pakistan',
                'fa_name' => 'پاکستان',
                'fips' => 'PK',
                'iso' => 'PK',
            ),
            193 => 
            array (
                'en_name' => 'Poland',
                'fa_name' => 'لهستان',
                'fips' => 'PL',
                'iso' => 'PL',
            ),
            194 => 
            array (
                'en_name' => 'Panama',
                'fa_name' => 'پاناما',
                'fips' => 'PM',
                'iso' => 'PA',
            ),
            195 => 
            array (
                'en_name' => 'Portugal',
                'fa_name' => 'کشور پرتغال',
                'fips' => 'PO',
                'iso' => 'PT',
            ),
            196 => 
            array (
                'en_name' => 'Papua New Guinea',
                'fa_name' => 'پاپوآ گینه نو',
                'fips' => 'PP',
                'iso' => 'PG',
            ),
            197 => 
            array (
                'en_name' => 'Palau',
                'fa_name' => 'پالائو',
                'fips' => 'PS',
                'iso' => 'PW',
            ),
            198 => 
            array (
                'en_name' => 'Guinea-Bissau',
                'fa_name' => 'گینه بیسائو',
                'fips' => 'PU',
                'iso' => 'GW',
            ),
            199 => 
            array (
                'en_name' => 'Qatar',
                'fa_name' => 'قطر',
                'fips' => 'QA',
                'iso' => 'QA',
            ),
            200 => 
            array (
                'en_name' => 'Reunion',
                'fa_name' => 'تجدید دیدار',
                'fips' => 'RE',
                'iso' => 'RE',
            ),
            201 => 
            array (
                'en_name' => 'Serbia',
                'fa_name' => 'صربستان',
                'fips' => 'RI',
                'iso' => 'RS',
            ),
            202 => 
            array (
                'en_name' => 'Marshall Islands',
                'fa_name' => 'جزایر مارشال',
                'fips' => 'RM',
                'iso' => 'MH',
            ),
            203 => 
            array (
                'en_name' => 'Saint Martin',
                'fa_name' => 'سنت مارتین',
                'fips' => 'RN',
                'iso' => 'MF',
            ),
            204 => 
            array (
                'en_name' => 'Romania',
                'fa_name' => 'رومانی',
                'fips' => 'RO',
                'iso' => 'RO',
            ),
            205 => 
            array (
                'en_name' => 'Philippines',
                'fa_name' => 'فیلیپین',
                'fips' => 'RP',
                'iso' => 'PH',
            ),
            206 => 
            array (
                'en_name' => 'Puerto Rico',
                'fa_name' => 'پورتوریکو',
                'fips' => 'RQ',
                'iso' => 'PR',
            ),
            207 => 
            array (
                'en_name' => 'Russia',
                'fa_name' => 'روسیه',
                'fips' => 'RS',
                'iso' => 'RU',
            ),
            208 => 
            array (
                'en_name' => 'Rwanda',
                'fa_name' => 'رواندا',
                'fips' => 'RW',
                'iso' => 'RW',
            ),
            209 => 
            array (
                'en_name' => 'Saudi Arabia',
                'fa_name' => 'عربستان سعودی',
                'fips' => 'SA',
                'iso' => 'SA',
            ),
            210 => 
            array (
                'en_name' => 'Saint Pierre and Miquelon',
                'fa_name' => 'سنت پیر و میکلون',
                'fips' => 'SB',
                'iso' => 'PM',
            ),
            211 => 
            array (
                'en_name' => 'Saint Kitts and Nevis',
                'fa_name' => 'سنت کیتس و نویس',
                'fips' => 'SC',
                'iso' => 'KN',
            ),
            212 => 
            array (
                'en_name' => 'Seychelles',
                'fa_name' => 'سیشل',
                'fips' => 'SE',
                'iso' => 'SC',
            ),
            213 => 
            array (
                'en_name' => 'South Africa',
                'fa_name' => 'آفریقای جنوبی',
                'fips' => 'SF',
                'iso' => 'ZA',
            ),
            214 => 
            array (
                'en_name' => 'Senegal',
                'fa_name' => 'سنگال',
                'fips' => 'SG',
                'iso' => 'SN',
            ),
            215 => 
            array (
                'en_name' => 'Saint Helena',
                'fa_name' => 'سنت هلن',
                'fips' => 'SH',
                'iso' => 'SH',
            ),
            216 => 
            array (
                'en_name' => 'Slovenia',
                'fa_name' => 'اسلوونی',
                'fips' => 'SI',
                'iso' => 'SI',
            ),
            217 => 
            array (
                'en_name' => 'Sierra Leone',
                'fa_name' => 'سیرا لئون',
                'fips' => 'SL',
                'iso' => 'SL',
            ),
            218 => 
            array (
                'en_name' => 'San Marino',
                'fa_name' => 'سان مارینو',
                'fips' => 'SM',
                'iso' => 'SM',
            ),
            219 => 
            array (
                'en_name' => 'Singapore',
                'fa_name' => 'سنگاپور',
                'fips' => 'SN',
                'iso' => 'SG',
            ),
            220 => 
            array (
                'en_name' => 'Somalia',
                'fa_name' => 'سومالی',
                'fips' => 'SO',
                'iso' => 'SO',
            ),
            221 => 
            array (
                'en_name' => 'Spain',
                'fa_name' => 'اسپانیا',
                'fips' => 'SP',
                'iso' => 'ES',
            ),
            222 => 
            array (
                'en_name' => 'Saint Lucia',
                'fa_name' => 'سنت لوسیا',
                'fips' => 'ST',
                'iso' => 'LC',
            ),
            223 => 
            array (
                'en_name' => 'Sudan',
                'fa_name' => 'سودان',
                'fips' => 'SU',
                'iso' => 'SD',
            ),
            224 => 
            array (
                'en_name' => 'Svalbard',
                'fa_name' => 'اسباب بازی',
                'fips' => 'SV',
                'iso' => 'SJ',
            ),
            225 => 
            array (
                'en_name' => 'Sweden',
                'fa_name' => 'سوئد',
                'fips' => 'SW',
                'iso' => 'SE',
            ),
            226 => 
            array (
                'en_name' => 'South Georgia and the Islands',
                'fa_name' => 'جنوب گرجستان و جزایر',
                'fips' => 'SX',
                'iso' => 'GS',
            ),
            227 => 
            array (
                'en_name' => 'Syrian Arab Republic',
                'fa_name' => 'جمهوری عربی سوریه',
                'fips' => 'SY',
                'iso' => 'SY',
            ),
            228 => 
            array (
                'en_name' => 'Switzerland',
                'fa_name' => 'سوئیس',
                'fips' => 'SZ',
                'iso' => 'CH',
            ),
            229 => 
            array (
                'en_name' => 'Trinidad and Tobago',
                'fa_name' => 'ترینیداد و توباگو',
                'fips' => 'TD',
                'iso' => 'TT',
            ),
            230 => 
            array (
                'en_name' => 'Tromelin Island',
                'fa_name' => 'جزیره ترولین',
                'fips' => 'TE',
                'iso' => '-',
            ),
            231 => 
            array (
                'en_name' => 'Thailand',
                'fa_name' => 'تایلند',
                'fips' => 'TH',
                'iso' => 'TH',
            ),
            232 => 
            array (
                'en_name' => 'Tajikistan',
                'fa_name' => 'تاجیکستان',
                'fips' => 'TI',
                'iso' => 'TJ',
            ),
            233 => 
            array (
                'en_name' => 'Turks and Caicos Islands',
                'fa_name' => 'جزایر ترکس و کایکوس',
                'fips' => 'TK',
                'iso' => 'TC',
            ),
            234 => 
            array (
                'en_name' => 'Tokelau',
                'fa_name' => 'توکلو',
                'fips' => 'TL',
                'iso' => 'TK',
            ),
            235 => 
            array (
                'en_name' => 'Tonga',
                'fa_name' => 'تونگا',
                'fips' => 'TN',
                'iso' => 'TO',
            ),
            236 => 
            array (
                'en_name' => 'Togo',
                'fa_name' => 'رفتن',
                'fips' => 'TO',
                'iso' => 'TG',
            ),
            237 => 
            array (
                'en_name' => 'Sao Tome and Principe',
                'fa_name' => 'سائوتومه و پرنسیپه',
                'fips' => 'TP',
                'iso' => 'ST',
            ),
            238 => 
            array (
                'en_name' => 'Tunisia',
                'fa_name' => 'تونس',
                'fips' => 'TS',
                'iso' => 'TN',
            ),
            239 => 
            array (
                'en_name' => 'East Timor',
                'fa_name' => 'تیمور شرقی',
                'fips' => 'TT',
                'iso' => 'TL',
            ),
            240 => 
            array (
                'en_name' => 'Turkey',
                'fa_name' => 'ترکیه',
                'fips' => 'TU',
                'iso' => 'TR',
            ),
            241 => 
            array (
                'en_name' => 'Tuvalu',
                'fa_name' => 'توووالو',
                'fips' => 'TV',
                'iso' => 'TV',
            ),
            242 => 
            array (
                'en_name' => 'Taiwan',
                'fa_name' => 'تایوان',
                'fips' => 'TW',
                'iso' => 'TW',
            ),
            243 => 
            array (
                'en_name' => 'Turkmenistan',
                'fa_name' => 'ترکمنستان',
                'fips' => 'TX',
                'iso' => 'TM',
            ),
            244 => 
            array (
                'en_name' => 'Tanzania, United Republic of',
                'fa_name' => 'تانزانیا، جمهوری متحده',
                'fips' => 'TZ',
                'iso' => 'TZ',
            ),
            245 => 
            array (
                'en_name' => 'Uganda',
                'fa_name' => 'اوگاندا',
                'fips' => 'UG',
                'iso' => 'UG',
            ),
            246 => 
            array (
                'en_name' => 'United Kingdom',
                'fa_name' => 'انگلستان',
                'fips' => 'UK',
                'iso' => 'GB',
            ),
            247 => 
            array (
                'en_name' => 'Ukraine',
                'fa_name' => 'اوکراین',
                'fips' => 'UP',
                'iso' => 'UA',
            ),
            248 => 
            array (
                'en_name' => 'United States',
                'fa_name' => 'ایالات متحده',
                'fips' => 'US',
                'iso' => 'US',
            ),
            249 => 
            array (
                'en_name' => 'Burkina Faso',
                'fa_name' => 'بورکینافاسو',
                'fips' => 'UV',
                'iso' => 'BF',
            ),
            250 => 
            array (
                'en_name' => 'Uruguay',
                'fa_name' => 'اروگوئه',
                'fips' => 'UY',
                'iso' => 'UY',
            ),
            251 => 
            array (
                'en_name' => 'Uzbekistan',
                'fa_name' => 'ازبکستان',
                'fips' => 'UZ',
                'iso' => 'UZ',
            ),
            252 => 
            array (
                'en_name' => 'Saint Vincent and the Grenadines',
                'fa_name' => 'سنت وینسنت و گرنادین',
                'fips' => 'VC',
                'iso' => 'VC',
            ),
            253 => 
            array (
                'en_name' => 'Venezuela',
                'fa_name' => 'ونزوئلا',
                'fips' => 'VE',
                'iso' => 'VE',
            ),
            254 => 
            array (
                'en_name' => 'British Virgin Islands',
                'fa_name' => 'جزایر ویرجین بریتانیا',
                'fips' => 'VI',
                'iso' => 'VG',
            ),
            255 => 
            array (
                'en_name' => 'Vietnam',
                'fa_name' => 'ویتنام',
                'fips' => 'VM',
                'iso' => 'VN',
            ),
            256 => 
            array (
                'en_name' => 'Virgin Islands (US)',
                'fa_name' => 'جزایر ویرجین (ایالات متحده)',
                'fips' => 'VQ',
                'iso' => 'VI',
            ),
            257 => 
            array (
                'en_name' => 'Holy See (Vatican City)',
                'fa_name' => 'مقدس (واتیکان)',
                'fips' => 'VT',
                'iso' => 'VA',
            ),
            258 => 
            array (
                'en_name' => 'Namibia',
                'fa_name' => 'نامیبیا',
                'fips' => 'WA',
                'iso' => 'NA',
            ),
            259 => 
            array (
                'en_name' => 'West Bank',
                'fa_name' => 'بانک غرب',
                'fips' => 'WE',
                'iso' => '-',
            ),
            260 => 
            array (
                'en_name' => 'Wallis and Futuna',
                'fa_name' => 'والیس و فوتونا',
                'fips' => 'WF',
                'iso' => 'WF',
            ),
            261 => 
            array (
                'en_name' => 'Western Sahara',
                'fa_name' => 'صحرای غربی',
                'fips' => 'WI',
                'iso' => 'EH',
            ),
            262 => 
            array (
                'en_name' => 'Wake Island',
                'fa_name' => 'جزیره ویک',
                'fips' => 'WQ',
                'iso' => 'UM',
            ),
            263 => 
            array (
                'en_name' => 'Samoa',
                'fa_name' => 'ساموآ',
                'fips' => 'WS',
                'iso' => 'WS',
            ),
            264 => 
            array (
                'en_name' => 'Swaziland',
                'fa_name' => 'سوازیلند',
                'fips' => 'WZ',
                'iso' => 'SZ',
            ),
            265 => 
            array (
                'en_name' => 'Serbia and Montenegro',
                'fa_name' => 'صربستان و مونته نگرو',
                'fips' => 'YI',
                'iso' => 'CS',
            ),
            266 => 
            array (
                'en_name' => 'Yemen',
                'fa_name' => 'یمن',
                'fips' => 'YM',
                'iso' => 'YE',
            ),
            267 => 
            array (
                'en_name' => 'Zambia',
                'fa_name' => 'زامبیا',
                'fips' => 'ZA',
                'iso' => 'ZM',
            ),
            268 => 
            array (
                'en_name' => 'Zimbabwe',
                'fa_name' => 'زیمبابوه',
                'fips' => 'ZI',
                'iso' => 'ZW',
            ),
        ));

    }
}