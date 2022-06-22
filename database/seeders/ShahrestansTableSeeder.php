<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Kdabrow\SeederOnce\SeederOnce;

class ShahrestansTableSeeder extends Seeder
{
    use SeederOnce;

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('shahrestans')->delete();
        
        \DB::table('shahrestans')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'آبادان',
                'ostan_id' => 13,
                'amar_code' => '601',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'آباده',
                'ostan_id' => 17,
                'amar_code' => '701',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'آبدانان',
                'ostan_id' => 6,
                'amar_code' => '1606',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'آبیک',
                'ostan_id' => 18,
                'amar_code' => '2604',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'آذرشهر',
                'ostan_id' => 1,
                'amar_code' => '321',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'آرادان',
                'ostan_id' => 15,
                'amar_code' => '2006',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'آران وبیدگل',
                'ostan_id' => 4,
                'amar_code' => '1018',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'آزادشهر',
                'ostan_id' => 24,
                'amar_code' => '2710',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'آستارا',
                'ostan_id' => 25,
                'amar_code' => '101',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'آستانه اشرفیه',
                'ostan_id' => 25,
                'amar_code' => '102',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'آشتیان',
                'ostan_id' => 28,
                'amar_code' => '2',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'آغاجاری',
                'ostan_id' => 13,
                'amar_code' => '626',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'آق قلا',
                'ostan_id' => 24,
                'amar_code' => '2708',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'آمل',
                'ostan_id' => 27,
                'amar_code' => '201',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'آوج',
                'ostan_id' => 18,
                'amar_code' => '2606',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'ابرکوه',
                'ostan_id' => 31,
                'amar_code' => '2107',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'ابوموسی',
                'ostan_id' => 29,
                'amar_code' => '2201',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'ابهر',
                'ostan_id' => 14,
                'amar_code' => '1901',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'اراک',
                'ostan_id' => 28,
                'amar_code' => '1',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'اردبیل',
                'ostan_id' => 3,
                'amar_code' => '2401',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'اردستان',
                'ostan_id' => 4,
                'amar_code' => '1001',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'اردکان',
                'ostan_id' => 31,
                'amar_code' => '2101',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'اردل',
                'ostan_id' => 9,
                'amar_code' => '1405',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'ارزوییه',
                'ostan_id' => 21,
                'amar_code' => '823',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'ارسنجان',
                'ostan_id' => 17,
                'amar_code' => '717',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'ارومیه',
                'ostan_id' => 2,
                'amar_code' => '401',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'ازنا',
                'ostan_id' => 26,
                'amar_code' => '1507',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'استهبان',
                'ostan_id' => 17,
                'amar_code' => '702',
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'اسدآباد',
                'ostan_id' => 30,
                'amar_code' => '1306',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'اسفراین',
                'ostan_id' => 12,
                'amar_code' => '2801',
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'اسکو',
                'ostan_id' => 1,
                'amar_code' => '322',
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'اسلام آبادغرب',
                'ostan_id' => 22,
                'amar_code' => '501',
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'اسلامشهر',
                'ostan_id' => 8,
                'amar_code' => '2310',
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'اشتهارد',
                'ostan_id' => 5,
                'amar_code' => '3005',
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'اشکذر',
                'ostan_id' => 31,
                'amar_code' => '2108',
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'اشنویه',
                'ostan_id' => 2,
                'amar_code' => '413',
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'اصفهان',
                'ostan_id' => 4,
                'amar_code' => '1002',
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'اصلاندوز',
                'ostan_id' => 3,
                'amar_code' => '2411',
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'اقلید',
                'ostan_id' => 17,
                'amar_code' => '703',
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'البرز',
                'ostan_id' => 18,
                'amar_code' => '2605',
            ),
            40 => 
            array (
                'id' => 41,
                'name' => 'الیگودرز',
                'ostan_id' => 26,
                'amar_code' => '1501',
            ),
            41 => 
            array (
                'id' => 42,
                'name' => 'املش',
                'ostan_id' => 25,
                'amar_code' => '113',
            ),
            42 => 
            array (
                'id' => 43,
                'name' => 'امیدیه',
                'ostan_id' => 13,
                'amar_code' => '616',
            ),
            43 => 
            array (
                'id' => 44,
                'name' => 'انار',
                'ostan_id' => 21,
                'amar_code' => '820',
            ),
            44 => 
            array (
                'id' => 45,
                'name' => 'اندیکا',
                'ostan_id' => 13,
                'amar_code' => '621',
            ),
            45 => 
            array (
                'id' => 46,
                'name' => 'اندیمشک',
                'ostan_id' => 13,
                'amar_code' => '602',
            ),
            46 => 
            array (
                'id' => 47,
                'name' => 'اوز',
                'ostan_id' => 17,
                'amar_code' => '736',
            ),
            47 => 
            array (
                'id' => 48,
                'name' => 'اهر',
                'ostan_id' => 1,
                'amar_code' => '302',
            ),
            48 => 
            array (
                'id' => 49,
                'name' => 'اهواز',
                'ostan_id' => 13,
                'amar_code' => '603',
            ),
            49 => 
            array (
                'id' => 50,
                'name' => 'ایجرود',
                'ostan_id' => 14,
                'amar_code' => '1906',
            ),
            50 => 
            array (
                'id' => 51,
                'name' => 'ایذه',
                'ostan_id' => 13,
                'amar_code' => '604',
            ),
            51 => 
            array (
                'id' => 52,
                'name' => 'ایرانشهر',
                'ostan_id' => 16,
                'amar_code' => '1101',
            ),
            52 => 
            array (
                'id' => 53,
                'name' => 'ایلام',
                'ostan_id' => 6,
                'amar_code' => '1601',
            ),
            53 => 
            array (
                'id' => 54,
                'name' => 'ایوان',
                'ostan_id' => 6,
                'amar_code' => '1607',
            ),
            54 => 
            array (
                'id' => 55,
                'name' => 'بابل',
                'ostan_id' => 27,
                'amar_code' => '202',
            ),
            55 => 
            array (
                'id' => 56,
                'name' => 'بابلسر',
                'ostan_id' => 27,
                'amar_code' => '216',
            ),
            56 => 
            array (
                'id' => 57,
                'name' => 'باخرز',
                'ostan_id' => 11,
                'amar_code' => '937',
            ),
            57 => 
            array (
                'id' => 58,
                'name' => 'باشت',
                'ostan_id' => 23,
                'amar_code' => '1707',
            ),
            58 => 
            array (
                'id' => 59,
                'name' => 'باغ ملک',
                'ostan_id' => 13,
                'amar_code' => '615',
            ),
            59 => 
            array (
                'id' => 60,
                'name' => 'بافت',
                'ostan_id' => 21,
                'amar_code' => '801',
            ),
            60 => 
            array (
                'id' => 61,
                'name' => 'بافق',
                'ostan_id' => 31,
                'amar_code' => '2102',
            ),
            61 => 
            array (
                'id' => 62,
                'name' => 'بانه',
                'ostan_id' => 20,
                'amar_code' => '1201',
            ),
            62 => 
            array (
                'id' => 63,
                'name' => 'باوی',
                'ostan_id' => 13,
                'amar_code' => '624',
            ),
            63 => 
            array (
                'id' => 64,
                'name' => 'بجستان',
                'ostan_id' => 11,
                'amar_code' => '931',
            ),
            64 => 
            array (
                'id' => 65,
                'name' => 'بجنورد',
                'ostan_id' => 12,
                'amar_code' => '2802',
            ),
            65 => 
            array (
                'id' => 66,
                'name' => 'بختگان',
                'ostan_id' => 17,
                'amar_code' => '735',
            ),
            66 => 
            array (
                'id' => 67,
                'name' => 'بدره',
                'ostan_id' => 6,
                'amar_code' => '1610',
            ),
            67 => 
            array (
                'id' => 68,
                'name' => 'برخوار',
                'ostan_id' => 4,
                'amar_code' => '1022',
            ),
            68 => 
            array (
                'id' => 69,
                'name' => 'بردسکن',
                'ostan_id' => 11,
                'amar_code' => '923',
            ),
            69 => 
            array (
                'id' => 70,
                'name' => 'بردسیر',
                'ostan_id' => 21,
                'amar_code' => '810',
            ),
            70 => 
            array (
                'id' => 71,
                'name' => 'بروجرد',
                'ostan_id' => 26,
                'amar_code' => '1502',
            ),
            71 => 
            array (
                'id' => 72,
                'name' => 'بروجن',
                'ostan_id' => 9,
                'amar_code' => '1401',
            ),
            72 => 
            array (
                'id' => 73,
                'name' => 'بستان آباد',
                'ostan_id' => 1,
                'amar_code' => '313',
            ),
            73 => 
            array (
                'id' => 74,
                'name' => 'بستک',
                'ostan_id' => 29,
                'amar_code' => '2209',
            ),
            74 => 
            array (
                'id' => 75,
                'name' => 'بشاگرد',
                'ostan_id' => 29,
                'amar_code' => '2213',
            ),
            75 => 
            array (
                'id' => 76,
                'name' => 'بشرویه',
                'ostan_id' => 10,
                'amar_code' => '2908',
            ),
            76 => 
            array (
                'id' => 77,
                'name' => 'بم',
                'ostan_id' => 21,
                'amar_code' => '802',
            ),
            77 => 
            array (
                'id' => 78,
                'name' => 'بمپور',
                'ostan_id' => 16,
                'amar_code' => '1120',
            ),
            78 => 
            array (
                'id' => 79,
                'name' => 'بن',
                'ostan_id' => 9,
                'amar_code' => '1409',
            ),
            79 => 
            array (
                'id' => 80,
                'name' => 'بناب',
                'ostan_id' => 1,
                'amar_code' => '312',
            ),
            80 => 
            array (
                'id' => 81,
                'name' => 'بندرانزلی',
                'ostan_id' => 25,
                'amar_code' => '103',
            ),
            81 => 
            array (
                'id' => 82,
                'name' => 'بندرعباس',
                'ostan_id' => 29,
                'amar_code' => '2202',
            ),
            82 => 
            array (
                'id' => 83,
                'name' => 'بندرگز',
                'ostan_id' => 24,
                'amar_code' => '2701',
            ),
            83 => 
            array (
                'id' => 84,
                'name' => 'بندرلنگه',
                'ostan_id' => 29,
                'amar_code' => '2203',
            ),
            84 => 
            array (
                'id' => 85,
                'name' => 'بندرماهشهر',
                'ostan_id' => 13,
                'amar_code' => '605',
            ),
            85 => 
            array (
                'id' => 86,
                'name' => 'بو یین و میاندشت',
                'ostan_id' => 4,
                'amar_code' => '1024',
            ),
            86 => 
            array (
                'id' => 87,
                'name' => 'بوانات',
                'ostan_id' => 17,
                'amar_code' => '716',
            ),
            87 => 
            array (
                'id' => 88,
                'name' => 'بوشهر',
                'ostan_id' => 7,
                'amar_code' => '1801',
            ),
            88 => 
            array (
                'id' => 89,
                'name' => 'بوکان',
                'ostan_id' => 2,
                'amar_code' => '410',
            ),
            89 => 
            array (
                'id' => 90,
                'name' => 'بویراحمد',
                'ostan_id' => 23,
                'amar_code' => '1701',
            ),
            90 => 
            array (
                'id' => 91,
                'name' => 'بویین زهرا',
                'ostan_id' => 18,
                'amar_code' => '2601',
            ),
            91 => 
            array (
                'id' => 92,
                'name' => 'بهاباد',
                'ostan_id' => 31,
                'amar_code' => '2111',
            ),
            92 => 
            array (
                'id' => 93,
                'name' => 'بهار',
                'ostan_id' => 30,
                'amar_code' => '1307',
            ),
            93 => 
            array (
                'id' => 94,
                'name' => 'بهارستان',
                'ostan_id' => 8,
                'amar_code' => '2319',
            ),
            94 => 
            array (
                'id' => 95,
                'name' => 'بهبهان',
                'ostan_id' => 13,
                'amar_code' => '606',
            ),
            95 => 
            array (
                'id' => 96,
                'name' => 'بهشهر',
                'ostan_id' => 27,
                'amar_code' => '204',
            ),
            96 => 
            array (
                'id' => 97,
                'name' => 'بهمیی',
                'ostan_id' => 23,
                'amar_code' => '1705',
            ),
            97 => 
            array (
                'id' => 98,
                'name' => 'بیجار',
                'ostan_id' => 20,
                'amar_code' => '1202',
            ),
            98 => 
            array (
                'id' => 99,
                'name' => 'بیرجند',
                'ostan_id' => 10,
                'amar_code' => '2901',
            ),
            99 => 
            array (
                'id' => 100,
                'name' => 'بیضا',
                'ostan_id' => 17,
                'amar_code' => '731',
            ),
            100 => 
            array (
                'id' => 101,
                'name' => 'بیله سوار',
                'ostan_id' => 3,
                'amar_code' => '2402',
            ),
            101 => 
            array (
                'id' => 102,
                'name' => 'بینالود',
                'ostan_id' => 11,
                'amar_code' => '932',
            ),
            102 => 
            array (
                'id' => 103,
                'name' => 'پارس آباد',
                'ostan_id' => 3,
                'amar_code' => '2406',
            ),
            103 => 
            array (
                'id' => 104,
                'name' => 'پارسیان',
                'ostan_id' => 29,
                'amar_code' => '2211',
            ),
            104 => 
            array (
                'id' => 105,
                'name' => 'پاسارگاد',
                'ostan_id' => 17,
                'amar_code' => '723',
            ),
            105 => 
            array (
                'id' => 106,
                'name' => 'پاکدشت',
                'ostan_id' => 8,
                'amar_code' => '2313',
            ),
            106 => 
            array (
                'id' => 107,
                'name' => 'پاوه',
                'ostan_id' => 22,
                'amar_code' => '503',
            ),
            107 => 
            array (
                'id' => 108,
                'name' => 'پردیس',
                'ostan_id' => 8,
                'amar_code' => '2320',
            ),
            108 => 
            array (
                'id' => 109,
                'name' => 'پلدختر',
                'ostan_id' => 26,
                'amar_code' => '1508',
            ),
            109 => 
            array (
                'id' => 110,
                'name' => 'پلدشت',
                'ostan_id' => 2,
                'amar_code' => '415',
            ),
            110 => 
            array (
                'id' => 111,
                'name' => 'پیرانشهر',
                'ostan_id' => 2,
                'amar_code' => '402',
            ),
            111 => 
            array (
                'id' => 112,
                'name' => 'پیشوا',
                'ostan_id' => 8,
                'amar_code' => '2318',
            ),
            112 => 
            array (
                'id' => 113,
                'name' => 'تاکستان',
                'ostan_id' => 18,
                'amar_code' => '2602',
            ),
            113 => 
            array (
                'id' => 114,
                'name' => 'تایباد',
                'ostan_id' => 11,
                'amar_code' => '904',
            ),
            114 => 
            array (
                'id' => 115,
                'name' => 'تبریز',
                'ostan_id' => 1,
                'amar_code' => '303',
            ),
            115 => 
            array (
                'id' => 116,
                'name' => 'تربت جام',
                'ostan_id' => 11,
                'amar_code' => '906',
            ),
            116 => 
            array (
                'id' => 117,
                'name' => 'تربت حیدریه',
                'ostan_id' => 11,
                'amar_code' => '905',
            ),
            117 => 
            array (
                'id' => 118,
                'name' => 'ترکمن',
                'ostan_id' => 24,
                'amar_code' => '2702',
            ),
            118 => 
            array (
                'id' => 119,
                'name' => 'تفت',
                'ostan_id' => 31,
                'amar_code' => '2103',
            ),
            119 => 
            array (
                'id' => 120,
                'name' => 'تفتان',
                'ostan_id' => 16,
                'amar_code' => '1121',
            ),
            120 => 
            array (
                'id' => 121,
                'name' => 'تفرش',
                'ostan_id' => 28,
                'amar_code' => '3',
            ),
            121 => 
            array (
                'id' => 122,
                'name' => 'تکاب',
                'ostan_id' => 2,
                'amar_code' => '412',
            ),
            122 => 
            array (
                'id' => 123,
                'name' => 'تنکابن',
                'ostan_id' => 27,
                'amar_code' => '205',
            ),
            123 => 
            array (
                'id' => 124,
                'name' => 'تنگستان',
                'ostan_id' => 7,
                'amar_code' => '1802',
            ),
            124 => 
            array (
                'id' => 125,
                'name' => 'تویسرکان',
                'ostan_id' => 30,
                'amar_code' => '1301',
            ),
            125 => 
            array (
                'id' => 126,
                'name' => 'تهران',
                'ostan_id' => 8,
                'amar_code' => '2301',
            ),
            126 => 
            array (
                'id' => 127,
                'name' => 'تیران وکرون',
                'ostan_id' => 4,
                'amar_code' => '1019',
            ),
            127 => 
            array (
                'id' => 128,
                'name' => 'ثلاث باباجانی',
                'ostan_id' => 22,
                'amar_code' => '512',
            ),
            128 => 
            array (
                'id' => 129,
                'name' => 'جاجرم',
                'ostan_id' => 12,
                'amar_code' => '2803',
            ),
            129 => 
            array (
                'id' => 130,
                'name' => 'جاسک',
                'ostan_id' => 29,
                'amar_code' => '2206',
            ),
            130 => 
            array (
                'id' => 131,
                'name' => 'جغتای',
                'ostan_id' => 11,
                'amar_code' => '934',
            ),
            131 => 
            array (
                'id' => 132,
                'name' => 'جلفا',
                'ostan_id' => 1,
                'amar_code' => '319',
            ),
            132 => 
            array (
                'id' => 133,
                'name' => 'جم',
                'ostan_id' => 7,
                'amar_code' => '1809',
            ),
            133 => 
            array (
                'id' => 134,
                'name' => 'جوانرود',
                'ostan_id' => 22,
                'amar_code' => '509',
            ),
            134 => 
            array (
                'id' => 135,
                'name' => 'جویبار',
                'ostan_id' => 27,
                'amar_code' => '221',
            ),
            135 => 
            array (
                'id' => 136,
                'name' => 'جوین',
                'ostan_id' => 11,
                'amar_code' => '936',
            ),
            136 => 
            array (
                'id' => 137,
                'name' => 'جهرم',
                'ostan_id' => 17,
                'amar_code' => '704',
            ),
            137 => 
            array (
                'id' => 138,
                'name' => 'جیرفت',
                'ostan_id' => 21,
                'amar_code' => '803',
            ),
            138 => 
            array (
                'id' => 139,
                'name' => 'چادگان',
                'ostan_id' => 4,
                'amar_code' => '1020',
            ),
            139 => 
            array (
                'id' => 140,
                'name' => 'چاراویماق',
                'ostan_id' => 1,
                'amar_code' => '323',
            ),
            140 => 
            array (
                'id' => 141,
                'name' => 'چالدران',
                'ostan_id' => 2,
                'amar_code' => '414',
            ),
            141 => 
            array (
                'id' => 142,
                'name' => 'چالوس',
                'ostan_id' => 27,
                'amar_code' => '220',
            ),
            142 => 
            array (
                'id' => 143,
                'name' => 'چاه بهار',
                'ostan_id' => 16,
                'amar_code' => '1102',
            ),
            143 => 
            array (
                'id' => 144,
                'name' => 'چایپاره',
                'ostan_id' => 2,
                'amar_code' => '416',
            ),
            144 => 
            array (
                'id' => 145,
                'name' => 'چرام',
                'ostan_id' => 23,
                'amar_code' => '1706',
            ),
            145 => 
            array (
                'id' => 146,
                'name' => 'چرداول',
                'ostan_id' => 6,
                'amar_code' => '1604',
            ),
            146 => 
            array (
                'id' => 147,
                'name' => 'چگنی',
                'ostan_id' => 26,
                'amar_code' => '1510',
            ),
            147 => 
            array (
                'id' => 148,
                'name' => 'چناران',
                'ostan_id' => 11,
                'amar_code' => '918',
            ),
            148 => 
            array (
                'id' => 149,
                'name' => 'حاجی اباد',
                'ostan_id' => 29,
                'amar_code' => '2208',
            ),
            149 => 
            array (
                'id' => 150,
                'name' => 'حمیدیه',
                'ostan_id' => 13,
                'amar_code' => '625',
            ),
            150 => 
            array (
                'id' => 151,
                'name' => 'خاتم',
                'ostan_id' => 31,
                'amar_code' => '2109',
            ),
            151 => 
            array (
                'id' => 152,
                'name' => 'خاش',
                'ostan_id' => 16,
                'amar_code' => '1103',
            ),
            152 => 
            array (
                'id' => 153,
                'name' => 'خانمیرزا',
                'ostan_id' => 9,
                'amar_code' => '1410',
            ),
            153 => 
            array (
                'id' => 154,
                'name' => 'خداآفرین',
                'ostan_id' => 1,
                'amar_code' => '326',
            ),
            154 => 
            array (
                'id' => 155,
                'name' => 'خدابنده',
                'ostan_id' => 14,
                'amar_code' => '1903',
            ),
            155 => 
            array (
                'id' => 156,
                'name' => 'خرامه',
                'ostan_id' => 17,
                'amar_code' => '729',
            ),
            156 => 
            array (
                'id' => 157,
                'name' => 'خرم آباد',
                'ostan_id' => 26,
                'amar_code' => '1503',
            ),
            157 => 
            array (
                'id' => 158,
                'name' => 'خرم بید',
                'ostan_id' => 17,
                'amar_code' => '718',
            ),
            158 => 
            array (
                'id' => 159,
                'name' => 'خرمدره',
                'ostan_id' => 14,
                'amar_code' => '1907',
            ),
            159 => 
            array (
                'id' => 160,
                'name' => 'خرمشهر',
                'ostan_id' => 13,
                'amar_code' => '607',
            ),
            160 => 
            array (
                'id' => 161,
                'name' => 'خفر',
                'ostan_id' => 17,
                'amar_code' => '734',
            ),
            161 => 
            array (
                'id' => 162,
                'name' => 'خلخال',
                'ostan_id' => 3,
                'amar_code' => '2403',
            ),
            162 => 
            array (
                'id' => 163,
                'name' => 'خلیل آباد',
                'ostan_id' => 11,
                'amar_code' => '929',
            ),
            163 => 
            array (
                'id' => 164,
                'name' => 'خمیر',
                'ostan_id' => 29,
                'amar_code' => '2210',
            ),
            164 => 
            array (
                'id' => 165,
                'name' => 'خمین',
                'ostan_id' => 28,
                'amar_code' => '4',
            ),
            165 => 
            array (
                'id' => 166,
                'name' => 'خمینی شهر',
                'ostan_id' => 4,
                'amar_code' => '1003',
            ),
            166 => 
            array (
                'id' => 167,
                'name' => 'خنج',
                'ostan_id' => 17,
                'amar_code' => '724',
            ),
            167 => 
            array (
                'id' => 168,
                'name' => 'خنداب',
                'ostan_id' => 28,
                'amar_code' => '12',
            ),
            168 => 
            array (
                'id' => 169,
                'name' => 'خواف',
                'ostan_id' => 11,
                'amar_code' => '919',
            ),
            169 => 
            array (
                'id' => 170,
                'name' => 'خوانسار',
                'ostan_id' => 4,
                'amar_code' => '1004',
            ),
            170 => 
            array (
                'id' => 171,
                'name' => 'خور و بیابانک',
                'ostan_id' => 4,
                'amar_code' => '1023',
            ),
            171 => 
            array (
                'id' => 172,
                'name' => 'خوسف',
                'ostan_id' => 10,
                'amar_code' => '2910',
            ),
            172 => 
            array (
                'id' => 173,
                'name' => 'خوشاب',
                'ostan_id' => 11,
                'amar_code' => '938',
            ),
            173 => 
            array (
                'id' => 174,
                'name' => 'خوی',
                'ostan_id' => 2,
                'amar_code' => '403',
            ),
            174 => 
            array (
                'id' => 175,
                'name' => 'داراب',
                'ostan_id' => 17,
                'amar_code' => '705',
            ),
            175 => 
            array (
                'id' => 176,
                'name' => 'دالاهو',
                'ostan_id' => 22,
                'amar_code' => '513',
            ),
            176 => 
            array (
                'id' => 177,
                'name' => 'دامغان',
                'ostan_id' => 15,
                'amar_code' => '2001',
            ),
            177 => 
            array (
                'id' => 178,
                'name' => 'داورزن',
                'ostan_id' => 11,
                'amar_code' => '939',
            ),
            178 => 
            array (
                'id' => 179,
                'name' => 'درگز',
                'ostan_id' => 11,
                'amar_code' => '907',
            ),
            179 => 
            array (
                'id' => 180,
                'name' => 'درگزین',
                'ostan_id' => 30,
                'amar_code' => '1310',
            ),
            180 => 
            array (
                'id' => 181,
                'name' => 'درمیان',
                'ostan_id' => 10,
                'amar_code' => '2902',
            ),
            181 => 
            array (
                'id' => 182,
                'name' => 'دره شهر',
                'ostan_id' => 6,
                'amar_code' => '1602',
            ),
            182 => 
            array (
                'id' => 183,
                'name' => 'دزفول',
                'ostan_id' => 13,
                'amar_code' => '608',
            ),
            183 => 
            array (
                'id' => 184,
                'name' => 'دشت آزادگان',
                'ostan_id' => 13,
                'amar_code' => '609',
            ),
            184 => 
            array (
                'id' => 185,
                'name' => 'دشتستان',
                'ostan_id' => 7,
                'amar_code' => '1803',
            ),
            185 => 
            array (
                'id' => 186,
                'name' => 'دشتی',
                'ostan_id' => 7,
                'amar_code' => '1804',
            ),
            186 => 
            array (
                'id' => 187,
                'name' => 'دشتیاری',
                'ostan_id' => 16,
                'amar_code' => '1122',
            ),
            187 => 
            array (
                'id' => 188,
                'name' => 'دلفان',
                'ostan_id' => 26,
                'amar_code' => '1504',
            ),
            188 => 
            array (
                'id' => 189,
                'name' => 'دلگان',
                'ostan_id' => 16,
                'amar_code' => '1112',
            ),
            189 => 
            array (
                'id' => 190,
                'name' => 'دلیجان',
                'ostan_id' => 28,
                'amar_code' => '5',
            ),
            190 => 
            array (
                'id' => 191,
                'name' => 'دماوند',
                'ostan_id' => 8,
                'amar_code' => '2302',
            ),
            191 => 
            array (
                'id' => 192,
                'name' => 'دنا',
                'ostan_id' => 23,
                'amar_code' => '1704',
            ),
            192 => 
            array (
                'id' => 193,
                'name' => 'دورود',
                'ostan_id' => 26,
                'amar_code' => '1505',
            ),
            193 => 
            array (
                'id' => 194,
                'name' => 'دهاقان',
                'ostan_id' => 4,
                'amar_code' => '1021',
            ),
            194 => 
            array (
                'id' => 195,
                'name' => 'دهگلان',
                'ostan_id' => 20,
                'amar_code' => '1210',
            ),
            195 => 
            array (
                'id' => 196,
                'name' => 'دهلران',
                'ostan_id' => 6,
                'amar_code' => '1603',
            ),
            196 => 
            array (
                'id' => 197,
                'name' => 'دیر',
                'ostan_id' => 7,
                'amar_code' => '1805',
            ),
            197 => 
            array (
                'id' => 198,
                'name' => 'دیلم',
                'ostan_id' => 7,
                'amar_code' => '1808',
            ),
            198 => 
            array (
                'id' => 199,
                'name' => 'دیواندره',
                'ostan_id' => 20,
                'amar_code' => '1207',
            ),
            199 => 
            array (
                'id' => 200,
                'name' => 'رابر',
                'ostan_id' => 21,
                'amar_code' => '818',
            ),
            200 => 
            array (
                'id' => 201,
                'name' => 'راز و جرگلان',
                'ostan_id' => 12,
                'amar_code' => '2808',
            ),
            201 => 
            array (
                'id' => 202,
                'name' => 'راسک',
                'ostan_id' => 16,
                'amar_code' => '1108',
            ),
            202 => 
            array (
                'id' => 203,
                'name' => 'رامسر',
                'ostan_id' => 27,
                'amar_code' => '206',
            ),
            203 => 
            array (
                'id' => 204,
                'name' => 'رامشیر',
                'ostan_id' => 13,
                'amar_code' => '619',
            ),
            204 => 
            array (
                'id' => 205,
                'name' => 'رامهرمز',
                'ostan_id' => 13,
                'amar_code' => '610',
            ),
            205 => 
            array (
                'id' => 206,
                'name' => 'رامیان',
                'ostan_id' => 24,
                'amar_code' => '2711',
            ),
            206 => 
            array (
                'id' => 207,
                'name' => 'راور',
                'ostan_id' => 21,
                'amar_code' => '811',
            ),
            207 => 
            array (
                'id' => 208,
                'name' => 'رباط کریم',
                'ostan_id' => 8,
                'amar_code' => '2312',
            ),
            208 => 
            array (
                'id' => 209,
                'name' => 'رزن',
                'ostan_id' => 30,
                'amar_code' => '1308',
            ),
            209 => 
            array (
                'id' => 210,
                'name' => 'رستم',
                'ostan_id' => 17,
                'amar_code' => '726',
            ),
            210 => 
            array (
                'id' => 211,
                'name' => 'رشت',
                'ostan_id' => 25,
                'amar_code' => '105',
            ),
            211 => 
            array (
                'id' => 212,
                'name' => 'رشتخوار',
                'ostan_id' => 11,
                'amar_code' => '927',
            ),
            212 => 
            array (
                'id' => 213,
                'name' => 'رضوانشهر',
                'ostan_id' => 25,
                'amar_code' => '114',
            ),
            213 => 
            array (
                'id' => 214,
                'name' => 'رفسنجان',
                'ostan_id' => 21,
                'amar_code' => '804',
            ),
            214 => 
            array (
                'id' => 215,
                'name' => 'روانسر',
                'ostan_id' => 22,
                'amar_code' => '514',
            ),
            215 => 
            array (
                'id' => 216,
                'name' => 'رودان',
                'ostan_id' => 29,
                'amar_code' => '2207',
            ),
            216 => 
            array (
                'id' => 217,
                'name' => 'رودبار',
                'ostan_id' => 25,
                'amar_code' => '106',
            ),
            217 => 
            array (
                'id' => 218,
                'name' => 'رودبارجنوب',
                'ostan_id' => 21,
                'amar_code' => '815',
            ),
            218 => 
            array (
                'id' => 219,
                'name' => 'رودسر',
                'ostan_id' => 25,
                'amar_code' => '107',
            ),
            219 => 
            array (
                'id' => 220,
                'name' => 'رومشکان',
                'ostan_id' => 26,
                'amar_code' => '1511',
            ),
            220 => 
            array (
                'id' => 221,
                'name' => 'ری',
                'ostan_id' => 8,
                'amar_code' => '2303',
            ),
            221 => 
            array (
                'id' => 222,
                'name' => 'ریگان',
                'ostan_id' => 21,
                'amar_code' => '817',
            ),
            222 => 
            array (
                'id' => 223,
                'name' => 'زابل',
                'ostan_id' => 16,
                'amar_code' => '1104',
            ),
            223 => 
            array (
                'id' => 224,
                'name' => 'زاوه',
                'ostan_id' => 11,
                'amar_code' => '935',
            ),
            224 => 
            array (
                'id' => 225,
                'name' => 'زاهدان',
                'ostan_id' => 16,
                'amar_code' => '1105',
            ),
            225 => 
            array (
                'id' => 226,
                'name' => 'زرقان',
                'ostan_id' => 17,
                'amar_code' => '730',
            ),
            226 => 
            array (
                'id' => 227,
                'name' => 'زرند',
                'ostan_id' => 21,
                'amar_code' => '805',
            ),
            227 => 
            array (
                'id' => 228,
                'name' => 'زرندیه',
                'ostan_id' => 28,
                'amar_code' => '10',
            ),
            228 => 
            array (
                'id' => 229,
                'name' => 'زرین دشت',
                'ostan_id' => 17,
                'amar_code' => '719',
            ),
            229 => 
            array (
                'id' => 230,
                'name' => 'زنجان',
                'ostan_id' => 14,
                'amar_code' => '1904',
            ),
            230 => 
            array (
                'id' => 231,
                'name' => 'زهک',
                'ostan_id' => 16,
                'amar_code' => '1110',
            ),
            231 => 
            array (
                'id' => 232,
                'name' => 'زیرکوه',
                'ostan_id' => 10,
                'amar_code' => '2909',
            ),
            232 => 
            array (
                'id' => 233,
                'name' => 'ساری',
                'ostan_id' => 27,
                'amar_code' => '207',
            ),
            233 => 
            array (
                'id' => 234,
                'name' => 'سامان',
                'ostan_id' => 9,
                'amar_code' => '1408',
            ),
            234 => 
            array (
                'id' => 235,
                'name' => 'ساوجبلاغ',
                'ostan_id' => 5,
                'amar_code' => '3002',
            ),
            235 => 
            array (
                'id' => 236,
                'name' => 'ساوه',
                'ostan_id' => 28,
                'amar_code' => '6',
            ),
            236 => 
            array (
                'id' => 237,
                'name' => 'سبزوار',
                'ostan_id' => 11,
                'amar_code' => '908',
            ),
            237 => 
            array (
                'id' => 238,
                'name' => 'سپیدان',
                'ostan_id' => 17,
                'amar_code' => '706',
            ),
            238 => 
            array (
                'id' => 239,
                'name' => 'سراب',
                'ostan_id' => 1,
                'amar_code' => '305',
            ),
            239 => 
            array (
                'id' => 240,
                'name' => 'سراوان',
                'ostan_id' => 16,
                'amar_code' => '1106',
            ),
            240 => 
            array (
                'id' => 241,
                'name' => 'سرایان',
                'ostan_id' => 10,
                'amar_code' => '2906',
            ),
            241 => 
            array (
                'id' => 242,
                'name' => 'سرباز',
                'ostan_id' => 16,
                'amar_code' => '1123',
            ),
            242 => 
            array (
                'id' => 243,
                'name' => 'سربیشه',
                'ostan_id' => 10,
                'amar_code' => '2903',
            ),
            243 => 
            array (
                'id' => 244,
                'name' => 'سرپل ذهاب',
                'ostan_id' => 22,
                'amar_code' => '504',
            ),
            244 => 
            array (
                'id' => 245,
                'name' => 'سرچهان',
                'ostan_id' => 17,
                'amar_code' => '732',
            ),
            245 => 
            array (
                'id' => 246,
                'name' => 'سرخس',
                'ostan_id' => 11,
                'amar_code' => '920',
            ),
            246 => 
            array (
                'id' => 247,
                'name' => 'سرخه',
                'ostan_id' => 15,
                'amar_code' => '2008',
            ),
            247 => 
            array (
                'id' => 248,
                'name' => 'سردشت',
                'ostan_id' => 2,
                'amar_code' => '404',
            ),
            248 => 
            array (
                'id' => 249,
                'name' => 'سرعین',
                'ostan_id' => 3,
                'amar_code' => '2410',
            ),
            249 => 
            array (
                'id' => 250,
                'name' => 'سروآباد',
                'ostan_id' => 20,
                'amar_code' => '1209',
            ),
            250 => 
            array (
                'id' => 251,
                'name' => 'سروستان',
                'ostan_id' => 17,
                'amar_code' => '725',
            ),
            251 => 
            array (
                'id' => 252,
                'name' => 'سقز',
                'ostan_id' => 20,
                'amar_code' => '1203',
            ),
            252 => 
            array (
                'id' => 253,
                'name' => 'سلسله',
                'ostan_id' => 26,
                'amar_code' => '1509',
            ),
            253 => 
            array (
                'id' => 254,
                'name' => 'سلطانیه',
                'ostan_id' => 14,
                'amar_code' => '1910',
            ),
            254 => 
            array (
                'id' => 255,
                'name' => 'سلماس',
                'ostan_id' => 2,
                'amar_code' => '405',
            ),
            255 => 
            array (
                'id' => 256,
                'name' => 'سمنان',
                'ostan_id' => 15,
                'amar_code' => '2002',
            ),
            256 => 
            array (
                'id' => 257,
                'name' => 'سمیرم',
                'ostan_id' => 4,
                'amar_code' => '1005',
            ),
            257 => 
            array (
                'id' => 258,
                'name' => 'سنقر',
                'ostan_id' => 22,
                'amar_code' => '505',
            ),
            258 => 
            array (
                'id' => 259,
                'name' => 'سنندج',
                'ostan_id' => 20,
                'amar_code' => '1204',
            ),
            259 => 
            array (
                'id' => 260,
                'name' => 'سوادکوه',
                'ostan_id' => 27,
                'amar_code' => '208',
            ),
            260 => 
            array (
                'id' => 261,
                'name' => 'سوادکوه شمالی',
                'ostan_id' => 27,
                'amar_code' => '227',
            ),
            261 => 
            array (
                'id' => 262,
                'name' => 'سیاهکل',
                'ostan_id' => 25,
                'amar_code' => '115',
            ),
            262 => 
            array (
                'id' => 263,
                'name' => 'سیب و سوران',
                'ostan_id' => 16,
                'amar_code' => '1114',
            ),
            263 => 
            array (
                'id' => 264,
                'name' => 'سیرجان',
                'ostan_id' => 21,
                'amar_code' => '806',
            ),
            264 => 
            array (
                'id' => 265,
                'name' => 'سیروان',
                'ostan_id' => 6,
                'amar_code' => '1609',
            ),
            265 => 
            array (
                'id' => 266,
                'name' => 'سیریک',
                'ostan_id' => 29,
                'amar_code' => '2212',
            ),
            266 => 
            array (
                'id' => 267,
                'name' => 'سیمرغ',
                'ostan_id' => 27,
                'amar_code' => '226',
            ),
            267 => 
            array (
                'id' => 268,
                'name' => 'شادگان',
                'ostan_id' => 13,
                'amar_code' => '611',
            ),
            268 => 
            array (
                'id' => 269,
                'name' => 'شازند',
                'ostan_id' => 28,
                'amar_code' => '7',
            ),
            269 => 
            array (
                'id' => 270,
                'name' => 'شاهرود',
                'ostan_id' => 15,
                'amar_code' => '2003',
            ),
            270 => 
            array (
                'id' => 271,
                'name' => 'شاهین دژ',
                'ostan_id' => 2,
                'amar_code' => '411',
            ),
            271 => 
            array (
                'id' => 272,
                'name' => 'شاهین شهرومیمه',
                'ostan_id' => 4,
                'amar_code' => '1016',
            ),
            272 => 
            array (
                'id' => 273,
                'name' => 'شبستر',
                'ostan_id' => 1,
                'amar_code' => '314',
            ),
            273 => 
            array (
                'id' => 274,
                'name' => 'شفت',
                'ostan_id' => 25,
                'amar_code' => '112',
            ),
            274 => 
            array (
                'id' => 275,
                'name' => 'شمیرانات',
                'ostan_id' => 8,
                'amar_code' => '2304',
            ),
            275 => 
            array (
                'id' => 276,
                'name' => 'شوش',
                'ostan_id' => 13,
                'amar_code' => '614',
            ),
            276 => 
            array (
                'id' => 277,
                'name' => 'شوشتر',
                'ostan_id' => 13,
                'amar_code' => '612',
            ),
            277 => 
            array (
                'id' => 278,
                'name' => 'شوط',
                'ostan_id' => 2,
                'amar_code' => '417',
            ),
            278 => 
            array (
                'id' => 279,
                'name' => 'شهربابک',
                'ostan_id' => 21,
                'amar_code' => '807',
            ),
            279 => 
            array (
                'id' => 280,
                'name' => 'شهرضا',
                'ostan_id' => 4,
                'amar_code' => '1009',
            ),
            280 => 
            array (
                'id' => 281,
                'name' => 'شهرکرد',
                'ostan_id' => 9,
                'amar_code' => '1402',
            ),
            281 => 
            array (
                'id' => 282,
                'name' => 'شهریار',
                'ostan_id' => 8,
                'amar_code' => '2309',
            ),
            282 => 
            array (
                'id' => 283,
                'name' => 'شیراز',
                'ostan_id' => 17,
                'amar_code' => '707',
            ),
            283 => 
            array (
                'id' => 284,
                'name' => 'شیروان',
                'ostan_id' => 12,
                'amar_code' => '2804',
            ),
            284 => 
            array (
                'id' => 285,
                'name' => 'صالح آباد',
                'ostan_id' => 11,
                'amar_code' => '940',
            ),
            285 => 
            array (
                'id' => 286,
                'name' => 'صحنه',
                'ostan_id' => 22,
                'amar_code' => '510',
            ),
            286 => 
            array (
                'id' => 287,
                'name' => 'صومعه سرا',
                'ostan_id' => 25,
                'amar_code' => '108',
            ),
            287 => 
            array (
                'id' => 288,
                'name' => 'طارم',
                'ostan_id' => 14,
                'amar_code' => '1908',
            ),
            288 => 
            array (
                'id' => 289,
                'name' => 'طالقان',
                'ostan_id' => 5,
                'amar_code' => '3004',
            ),
            289 => 
            array (
                'id' => 290,
                'name' => 'طبس',
                'ostan_id' => 10,
                'amar_code' => '2911',
            ),
            290 => 
            array (
                'id' => 291,
                'name' => 'طوالش',
                'ostan_id' => 25,
                'amar_code' => '104',
            ),
            291 => 
            array (
                'id' => 292,
                'name' => 'عباس آباد',
                'ostan_id' => 27,
                'amar_code' => '224',
            ),
            292 => 
            array (
                'id' => 293,
                'name' => 'عجب شیر',
                'ostan_id' => 1,
                'amar_code' => '325',
            ),
            293 => 
            array (
                'id' => 294,
                'name' => 'عسلویه',
                'ostan_id' => 7,
                'amar_code' => '1810',
            ),
            294 => 
            array (
                'id' => 295,
                'name' => 'علی آباد کتول',
                'ostan_id' => 24,
                'amar_code' => '2703',
            ),
            295 => 
            array (
                'id' => 296,
                'name' => 'عنبرآباد',
                'ostan_id' => 21,
                'amar_code' => '812',
            ),
            296 => 
            array (
                'id' => 297,
                'name' => 'فارسان',
                'ostan_id' => 9,
                'amar_code' => '1403',
            ),
            297 => 
            array (
                'id' => 298,
                'name' => 'فاروج',
                'ostan_id' => 12,
                'amar_code' => '2805',
            ),
            298 => 
            array (
                'id' => 299,
                'name' => 'فاریاب',
                'ostan_id' => 21,
                'amar_code' => '822',
            ),
            299 => 
            array (
                'id' => 300,
                'name' => 'فامنین',
                'ostan_id' => 30,
                'amar_code' => '1309',
            ),
            300 => 
            array (
                'id' => 301,
                'name' => 'فراشبند',
                'ostan_id' => 17,
                'amar_code' => '722',
            ),
            301 => 
            array (
                'id' => 302,
                'name' => 'فراهان',
                'ostan_id' => 28,
                'amar_code' => '13',
            ),
            302 => 
            array (
                'id' => 303,
                'name' => 'فردوس',
                'ostan_id' => 10,
                'amar_code' => '2907',
            ),
            303 => 
            array (
                'id' => 304,
                'name' => 'فردیس',
                'ostan_id' => 5,
                'amar_code' => '3006',
            ),
            304 => 
            array (
                'id' => 305,
                'name' => 'فریدن',
                'ostan_id' => 4,
                'amar_code' => '1006',
            ),
            305 => 
            array (
                'id' => 306,
                'name' => 'فریدونشهر',
                'ostan_id' => 4,
                'amar_code' => '1007',
            ),
            306 => 
            array (
                'id' => 307,
                'name' => 'فریدونکنار',
                'ostan_id' => 27,
                'amar_code' => '223',
            ),
            307 => 
            array (
                'id' => 308,
                'name' => 'فریمان',
                'ostan_id' => 11,
                'amar_code' => '922',
            ),
            308 => 
            array (
                'id' => 309,
                'name' => 'فسا',
                'ostan_id' => 17,
                'amar_code' => '708',
            ),
            309 => 
            array (
                'id' => 310,
                'name' => 'فلاورجان',
                'ostan_id' => 4,
                'amar_code' => '1008',
            ),
            310 => 
            array (
                'id' => 311,
                'name' => 'فنوج',
                'ostan_id' => 16,
                'amar_code' => '1119',
            ),
            311 => 
            array (
                'id' => 312,
                'name' => 'فومن',
                'ostan_id' => 25,
                'amar_code' => '109',
            ),
            312 => 
            array (
                'id' => 313,
                'name' => 'فهرج',
                'ostan_id' => 21,
                'amar_code' => '819',
            ),
            313 => 
            array (
                'id' => 314,
                'name' => 'فیروزآباد',
                'ostan_id' => 17,
                'amar_code' => '709',
            ),
            314 => 
            array (
                'id' => 315,
                'name' => 'فیروزکوه',
                'ostan_id' => 8,
                'amar_code' => '2314',
            ),
            315 => 
            array (
                'id' => 316,
                'name' => 'فیروزه',
                'ostan_id' => 11,
                'amar_code' => '933',
            ),
            316 => 
            array (
                'id' => 317,
                'name' => 'قایم شهر',
                'ostan_id' => 27,
                'amar_code' => '210',
            ),
            317 => 
            array (
                'id' => 318,
                'name' => 'قاینات',
                'ostan_id' => 10,
                'amar_code' => '2904',
            ),
            318 => 
            array (
                'id' => 319,
                'name' => 'قدس',
                'ostan_id' => 8,
                'amar_code' => '2316',
            ),
            319 => 
            array (
                'id' => 320,
                'name' => 'قرچک',
                'ostan_id' => 8,
                'amar_code' => '2321',
            ),
            320 => 
            array (
                'id' => 321,
                'name' => 'قروه',
                'ostan_id' => 20,
                'amar_code' => '1205',
            ),
            321 => 
            array (
                'id' => 322,
                'name' => 'قزوین',
                'ostan_id' => 18,
                'amar_code' => '2603',
            ),
            322 => 
            array (
                'id' => 323,
                'name' => 'قشم',
                'ostan_id' => 29,
                'amar_code' => '2204',
            ),
            323 => 
            array (
                'id' => 324,
                'name' => 'قصرشیرین',
                'ostan_id' => 22,
                'amar_code' => '506',
            ),
            324 => 
            array (
                'id' => 325,
                'name' => 'قصرقند',
                'ostan_id' => 16,
                'amar_code' => '1118',
            ),
            325 => 
            array (
                'id' => 326,
                'name' => 'قلعه گنج',
                'ostan_id' => 21,
                'amar_code' => '816',
            ),
            326 => 
            array (
                'id' => 327,
                'name' => 'قم',
                'ostan_id' => 19,
                'amar_code' => '2501',
            ),
            327 => 
            array (
                'id' => 328,
                'name' => 'قوچان',
                'ostan_id' => 11,
                'amar_code' => '913',
            ),
            328 => 
            array (
                'id' => 329,
                'name' => 'قیروکارزین',
                'ostan_id' => 17,
                'amar_code' => '720',
            ),
            329 => 
            array (
                'id' => 330,
                'name' => 'کارون',
                'ostan_id' => 13,
                'amar_code' => '627',
            ),
            330 => 
            array (
                'id' => 331,
                'name' => 'کازرون',
                'ostan_id' => 17,
                'amar_code' => '710',
            ),
            331 => 
            array (
                'id' => 332,
                'name' => 'کاشان',
                'ostan_id' => 4,
                'amar_code' => '1010',
            ),
            332 => 
            array (
                'id' => 333,
                'name' => 'کاشمر',
                'ostan_id' => 11,
                'amar_code' => '914',
            ),
            333 => 
            array (
                'id' => 334,
                'name' => 'کامیاران',
                'ostan_id' => 20,
                'amar_code' => '1208',
            ),
            334 => 
            array (
                'id' => 335,
                'name' => 'کبودرآهنگ',
                'ostan_id' => 30,
                'amar_code' => '1305',
            ),
            335 => 
            array (
                'id' => 336,
                'name' => 'کرج',
                'ostan_id' => 5,
                'amar_code' => '3001',
            ),
            336 => 
            array (
                'id' => 337,
                'name' => 'کردکوی',
                'ostan_id' => 24,
                'amar_code' => '2704',
            ),
            337 => 
            array (
                'id' => 338,
                'name' => 'کرمان',
                'ostan_id' => 21,
                'amar_code' => '808',
            ),
            338 => 
            array (
                'id' => 339,
                'name' => 'کرمانشاه',
                'ostan_id' => 22,
                'amar_code' => '502',
            ),
            339 => 
            array (
                'id' => 340,
                'name' => 'کلات',
                'ostan_id' => 11,
                'amar_code' => '928',
            ),
            340 => 
            array (
                'id' => 341,
                'name' => 'کلاردشت',
                'ostan_id' => 27,
                'amar_code' => '228',
            ),
            341 => 
            array (
                'id' => 342,
                'name' => 'کلاله',
                'ostan_id' => 24,
                'amar_code' => '2709',
            ),
            342 => 
            array (
                'id' => 343,
                'name' => 'کلیبر',
                'ostan_id' => 1,
                'amar_code' => '315',
            ),
            343 => 
            array (
                'id' => 344,
                'name' => 'کمیجان',
                'ostan_id' => 28,
                'amar_code' => '11',
            ),
            344 => 
            array (
                'id' => 345,
                'name' => 'کنارک',
                'ostan_id' => 16,
                'amar_code' => '1109',
            ),
            345 => 
            array (
                'id' => 346,
                'name' => 'کنگان',
                'ostan_id' => 7,
                'amar_code' => '1806',
            ),
            346 => 
            array (
                'id' => 347,
                'name' => 'کنگاور',
                'ostan_id' => 22,
                'amar_code' => '507',
            ),
            347 => 
            array (
                'id' => 348,
                'name' => 'کوار',
                'ostan_id' => 17,
                'amar_code' => '728',
            ),
            348 => 
            array (
                'id' => 349,
                'name' => 'کوثر',
                'ostan_id' => 3,
                'amar_code' => '2407',
            ),
            349 => 
            array (
                'id' => 350,
                'name' => 'کوه چنار',
                'ostan_id' => 17,
                'amar_code' => '733',
            ),
            350 => 
            array (
                'id' => 351,
                'name' => 'کوهبنان',
                'ostan_id' => 21,
                'amar_code' => '814',
            ),
            351 => 
            array (
                'id' => 352,
                'name' => 'کوهدشت',
                'ostan_id' => 26,
                'amar_code' => '1506',
            ),
            352 => 
            array (
                'id' => 353,
                'name' => 'کوهرنگ',
                'ostan_id' => 9,
                'amar_code' => '1406',
            ),
            353 => 
            array (
                'id' => 354,
                'name' => 'کوهسرخ',
                'ostan_id' => 11,
                'amar_code' => '941',
            ),
            354 => 
            array (
                'id' => 355,
                'name' => 'کهگیلویه',
                'ostan_id' => 23,
                'amar_code' => '1702',
            ),
            355 => 
            array (
                'id' => 356,
                'name' => 'کهنوج',
                'ostan_id' => 21,
                'amar_code' => '809',
            ),
            356 => 
            array (
                'id' => 357,
                'name' => 'کیار',
                'ostan_id' => 9,
                'amar_code' => '1407',
            ),
            357 => 
            array (
                'id' => 358,
                'name' => 'گالیکش',
                'ostan_id' => 24,
                'amar_code' => '2714',
            ),
            358 => 
            array (
                'id' => 359,
                'name' => 'گتوند',
                'ostan_id' => 13,
                'amar_code' => '620',
            ),
            359 => 
            array (
                'id' => 360,
                'name' => 'گچساران',
                'ostan_id' => 23,
                'amar_code' => '1703',
            ),
            360 => 
            array (
                'id' => 361,
                'name' => 'گراش',
                'ostan_id' => 17,
                'amar_code' => '727',
            ),
            361 => 
            array (
                'id' => 362,
                'name' => 'گرگان',
                'ostan_id' => 24,
                'amar_code' => '2705',
            ),
            362 => 
            array (
                'id' => 363,
                'name' => 'گرمسار',
                'ostan_id' => 15,
                'amar_code' => '2004',
            ),
            363 => 
            array (
                'id' => 364,
                'name' => 'گرمه',
                'ostan_id' => 12,
                'amar_code' => '2807',
            ),
            364 => 
            array (
                'id' => 365,
                'name' => 'گرمی',
                'ostan_id' => 3,
                'amar_code' => '2405',
            ),
            365 => 
            array (
                'id' => 366,
                'name' => 'گلپایگان',
                'ostan_id' => 4,
                'amar_code' => '1011',
            ),
            366 => 
            array (
                'id' => 367,
                'name' => 'گلوگاه',
                'ostan_id' => 27,
                'amar_code' => '222',
            ),
            367 => 
            array (
                'id' => 368,
                'name' => 'گمیشان',
                'ostan_id' => 24,
                'amar_code' => '2713',
            ),
            368 => 
            array (
                'id' => 369,
                'name' => 'گناباد',
                'ostan_id' => 11,
                'amar_code' => '915',
            ),
            369 => 
            array (
                'id' => 370,
                'name' => 'گناوه',
                'ostan_id' => 7,
                'amar_code' => '1807',
            ),
            370 => 
            array (
                'id' => 371,
                'name' => 'گنبدکاووس',
                'ostan_id' => 24,
                'amar_code' => '2706',
            ),
            371 => 
            array (
                'id' => 372,
                'name' => 'گیلانغرب',
                'ostan_id' => 22,
                'amar_code' => '508',
            ),
            372 => 
            array (
                'id' => 373,
                'name' => 'لارستان',
                'ostan_id' => 17,
                'amar_code' => '711',
            ),
            373 => 
            array (
                'id' => 374,
                'name' => 'لالی',
                'ostan_id' => 13,
                'amar_code' => '617',
            ),
            374 => 
            array (
                'id' => 375,
                'name' => 'لامرد',
                'ostan_id' => 17,
                'amar_code' => '715',
            ),
            375 => 
            array (
                'id' => 376,
                'name' => 'لاهیجان',
                'ostan_id' => 25,
                'amar_code' => '111',
            ),
            376 => 
            array (
                'id' => 377,
                'name' => 'لردگان',
                'ostan_id' => 9,
                'amar_code' => '1404',
            ),
            377 => 
            array (
                'id' => 378,
                'name' => 'لنجان',
                'ostan_id' => 4,
                'amar_code' => '1012',
            ),
            378 => 
            array (
                'id' => 379,
                'name' => 'لنده',
                'ostan_id' => 23,
                'amar_code' => '1708',
            ),
            379 => 
            array (
                'id' => 380,
                'name' => 'لنگرود',
                'ostan_id' => 25,
                'amar_code' => '110',
            ),
            380 => 
            array (
                'id' => 381,
                'name' => 'مارگون',
                'ostan_id' => 23,
                'amar_code' => '1709',
            ),
            381 => 
            array (
                'id' => 382,
                'name' => 'ماسال',
                'ostan_id' => 25,
                'amar_code' => '116',
            ),
            382 => 
            array (
                'id' => 383,
                'name' => 'ماکو',
                'ostan_id' => 2,
                'amar_code' => '406',
            ),
            383 => 
            array (
                'id' => 384,
                'name' => 'مانه وسملقان',
                'ostan_id' => 12,
                'amar_code' => '2806',
            ),
            384 => 
            array (
                'id' => 385,
                'name' => 'ماهنشان',
                'ostan_id' => 14,
                'amar_code' => '1909',
            ),
            385 => 
            array (
                'id' => 386,
                'name' => 'مبارکه',
                'ostan_id' => 4,
                'amar_code' => '1017',
            ),
            386 => 
            array (
                'id' => 387,
                'name' => 'محلات',
                'ostan_id' => 28,
                'amar_code' => '9',
            ),
            387 => 
            array (
                'id' => 388,
                'name' => 'محمودآباد',
                'ostan_id' => 27,
                'amar_code' => '218',
            ),
            388 => 
            array (
                'id' => 389,
                'name' => 'مراغه',
                'ostan_id' => 1,
                'amar_code' => '306',
            ),
            389 => 
            array (
                'id' => 390,
                'name' => 'مراوه تپه',
                'ostan_id' => 24,
                'amar_code' => '2712',
            ),
            390 => 
            array (
                'id' => 391,
                'name' => 'مرند',
                'ostan_id' => 1,
                'amar_code' => '307',
            ),
            391 => 
            array (
                'id' => 392,
                'name' => 'مرودشت',
                'ostan_id' => 17,
                'amar_code' => '712',
            ),
            392 => 
            array (
                'id' => 393,
                'name' => 'مریوان',
                'ostan_id' => 20,
                'amar_code' => '1206',
            ),
            393 => 
            array (
                'id' => 394,
                'name' => 'مسجدسلیمان',
                'ostan_id' => 13,
                'amar_code' => '613',
            ),
            394 => 
            array (
                'id' => 395,
                'name' => 'مشگین شهر',
                'ostan_id' => 3,
                'amar_code' => '2404',
            ),
            395 => 
            array (
                'id' => 396,
                'name' => 'مشهد',
                'ostan_id' => 11,
                'amar_code' => '916',
            ),
            396 => 
            array (
                'id' => 397,
                'name' => 'ملارد',
                'ostan_id' => 8,
                'amar_code' => '2317',
            ),
            397 => 
            array (
                'id' => 398,
                'name' => 'ملایر',
                'ostan_id' => 30,
                'amar_code' => '1302',
            ),
            398 => 
            array (
                'id' => 399,
                'name' => 'ملکان',
                'ostan_id' => 1,
                'amar_code' => '320',
            ),
            399 => 
            array (
                'id' => 400,
                'name' => 'ملکشاهی',
                'ostan_id' => 6,
                'amar_code' => '1608',
            ),
            400 => 
            array (
                'id' => 401,
                'name' => 'ممسنی',
                'ostan_id' => 17,
                'amar_code' => '713',
            ),
            401 => 
            array (
                'id' => 402,
                'name' => 'منوجان',
                'ostan_id' => 21,
                'amar_code' => '813',
            ),
            402 => 
            array (
                'id' => 403,
                'name' => 'مه ولات',
                'ostan_id' => 11,
                'amar_code' => '930',
            ),
            403 => 
            array (
                'id' => 404,
                'name' => 'مهاباد',
                'ostan_id' => 2,
                'amar_code' => '407',
            ),
            404 => 
            array (
                'id' => 405,
                'name' => 'مهدی شهر',
                'ostan_id' => 15,
                'amar_code' => '2005',
            ),
            405 => 
            array (
                'id' => 406,
                'name' => 'مهر',
                'ostan_id' => 17,
                'amar_code' => '721',
            ),
            406 => 
            array (
                'id' => 407,
                'name' => 'مهران',
                'ostan_id' => 6,
                'amar_code' => '1605',
            ),
            407 => 
            array (
                'id' => 408,
                'name' => 'مهرستان',
                'ostan_id' => 16,
                'amar_code' => '1113',
            ),
            408 => 
            array (
                'id' => 409,
                'name' => 'مهریز',
                'ostan_id' => 31,
                'amar_code' => '2104',
            ),
            409 => 
            array (
                'id' => 410,
                'name' => 'میامی',
                'ostan_id' => 15,
                'amar_code' => '2007',
            ),
            410 => 
            array (
                'id' => 411,
                'name' => 'میاندوآب',
                'ostan_id' => 2,
                'amar_code' => '408',
            ),
            411 => 
            array (
                'id' => 412,
                'name' => 'میاندورود',
                'ostan_id' => 27,
                'amar_code' => '225',
            ),
            412 => 
            array (
                'id' => 413,
                'name' => 'میانه',
                'ostan_id' => 1,
                'amar_code' => '310',
            ),
            413 => 
            array (
                'id' => 414,
                'name' => 'میبد',
                'ostan_id' => 31,
                'amar_code' => '2106',
            ),
            414 => 
            array (
                'id' => 415,
                'name' => 'میرجاوه',
                'ostan_id' => 16,
                'amar_code' => '1117',
            ),
            415 => 
            array (
                'id' => 416,
                'name' => 'میناب',
                'ostan_id' => 29,
                'amar_code' => '2205',
            ),
            416 => 
            array (
                'id' => 417,
                'name' => 'مینودشت',
                'ostan_id' => 24,
                'amar_code' => '2707',
            ),
            417 => 
            array (
                'id' => 418,
                'name' => 'نایین',
                'ostan_id' => 4,
                'amar_code' => '1013',
            ),
            418 => 
            array (
                'id' => 419,
                'name' => 'نجف آباد',
                'ostan_id' => 4,
                'amar_code' => '1014',
            ),
            419 => 
            array (
                'id' => 420,
                'name' => 'نرماشیر',
                'ostan_id' => 21,
                'amar_code' => '821',
            ),
            420 => 
            array (
                'id' => 421,
                'name' => 'نطنز',
                'ostan_id' => 4,
                'amar_code' => '1015',
            ),
            421 => 
            array (
                'id' => 422,
                'name' => 'نظرآباد',
                'ostan_id' => 5,
                'amar_code' => '3003',
            ),
            422 => 
            array (
                'id' => 423,
                'name' => 'نقده',
                'ostan_id' => 2,
                'amar_code' => '409',
            ),
            423 => 
            array (
                'id' => 424,
                'name' => 'نکا',
                'ostan_id' => 27,
                'amar_code' => '219',
            ),
            424 => 
            array (
                'id' => 425,
                'name' => 'نمین',
                'ostan_id' => 3,
                'amar_code' => '2408',
            ),
            425 => 
            array (
                'id' => 426,
                'name' => 'نور',
                'ostan_id' => 27,
                'amar_code' => '214',
            ),
            426 => 
            array (
                'id' => 427,
                'name' => 'نوشهر',
                'ostan_id' => 27,
                'amar_code' => '215',
            ),
            427 => 
            array (
                'id' => 428,
                'name' => 'نهاوند',
                'ostan_id' => 30,
                'amar_code' => '1303',
            ),
            428 => 
            array (
                'id' => 429,
                'name' => 'نهبندان',
                'ostan_id' => 10,
                'amar_code' => '2905',
            ),
            429 => 
            array (
                'id' => 430,
                'name' => 'نی ریز',
                'ostan_id' => 17,
                'amar_code' => '714',
            ),
            430 => 
            array (
                'id' => 431,
                'name' => 'نیر',
                'ostan_id' => 3,
                'amar_code' => '2409',
            ),
            431 => 
            array (
                'id' => 432,
                'name' => 'نیشابور',
                'ostan_id' => 11,
                'amar_code' => '917',
            ),
            432 => 
            array (
                'id' => 433,
                'name' => 'نیک شهر',
                'ostan_id' => 16,
                'amar_code' => '1107',
            ),
            433 => 
            array (
                'id' => 434,
                'name' => 'نیمروز',
                'ostan_id' => 16,
                'amar_code' => '1115',
            ),
            434 => 
            array (
                'id' => 435,
                'name' => 'ورامین',
                'ostan_id' => 8,
                'amar_code' => '2306',
            ),
            435 => 
            array (
                'id' => 436,
                'name' => 'ورزقان',
                'ostan_id' => 1,
                'amar_code' => '324',
            ),
            436 => 
            array (
                'id' => 437,
                'name' => 'هامون',
                'ostan_id' => 16,
                'amar_code' => '1116',
            ),
            437 => 
            array (
                'id' => 438,
                'name' => 'هرسین',
                'ostan_id' => 22,
                'amar_code' => '511',
            ),
            438 => 
            array (
                'id' => 439,
                'name' => 'هریس',
                'ostan_id' => 1,
                'amar_code' => '316',
            ),
            439 => 
            array (
                'id' => 440,
                'name' => 'هشترود',
                'ostan_id' => 1,
                'amar_code' => '311',
            ),
            440 => 
            array (
                'id' => 441,
                'name' => 'هفتکل',
                'ostan_id' => 13,
                'amar_code' => '622',
            ),
            441 => 
            array (
                'id' => 442,
                'name' => 'هلیلان',
                'ostan_id' => 6,
                'amar_code' => '1611',
            ),
            442 => 
            array (
                'id' => 443,
                'name' => 'همدان',
                'ostan_id' => 30,
                'amar_code' => '1304',
            ),
            443 => 
            array (
                'id' => 444,
                'name' => 'هندیجان',
                'ostan_id' => 13,
                'amar_code' => '618',
            ),
            444 => 
            array (
                'id' => 445,
                'name' => 'هوراند',
                'ostan_id' => 1,
                'amar_code' => '327',
            ),
            445 => 
            array (
                'id' => 446,
                'name' => 'هویزه',
                'ostan_id' => 13,
                'amar_code' => '623',
            ),
            446 => 
            array (
                'id' => 447,
                'name' => 'هیرمند',
                'ostan_id' => 16,
                'amar_code' => '1111',
            ),
            447 => 
            array (
                'id' => 448,
                'name' => 'یزد',
                'ostan_id' => 31,
                'amar_code' => '2105',
            ),
        ));
        
        
    }
}