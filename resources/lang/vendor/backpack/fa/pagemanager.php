<?php

// --------------------------------------------------------
// This is only a pointer file, not an actual language file
// --------------------------------------------------------
//
// If you've copied this file to your /resources/lang/vendor/backpack/
// folder, please delete it, it's no use there. You need to copy/publish the
// actual language file, from the package.

// If a langfile with the same name exists in the package, load that one
if (file_exists(__DIR__.'/../../../../../pagemanager/src/resources/lang/'.basename(__DIR__).'/'.basename(__FILE__))) {
    return include __DIR__.'/../../../../../pagemanager/src/resources/lang/'.basename(__DIR__).'/'.basename(__FILE__);
}

return [
    'change_template_confirmation' => 'آیا مطمئن هستید که می خواهید الگوی صفحه را تغییر دهید؟ شما اصلاحات ذخیره نشده برای این صفحه را از دست خواهید داد.',
    'content' => 'محتوا',
    'content_placeholder' => 'محتوای شما اینجاست',
    'meta_description' => 'فرا توضیحات',
    'meta_keywords' => 'فرا کلمات کلیدی',
    'meta_title' => 'فرا عنوان',
    'metas' => 'فراها',
    'name' => 'نام',
    'open' => 'باز',
    'page' => 'صفحه',
    'page_name' => 'عنوان صفحه (فقط برای مدیران دیده می‌شود)',
    'page_slug' => 'آدرس صفحه',
    'page_slug_hint' => 'در صورت خالی ماندن ، به طور خودکار از عنوان شما تولید می شود.',
    'page_title' => 'عنوان صفحه',
    'pages' => 'صفحات',
    'slug' => 'آدرس صفحه',
    'template' => 'الگو',
    'template_not_found' => 'الگو یافت نشد. ممکن است در حین ایجاد این صفحه حذف شده باشد. برای ادامه ، لطفاً از مدیر وب سایت یا تیم توسعه خود بخواهید که این مشکل را برطرف کند.',
    'function_name' => [
        "text" => "محتوایی",
        "shop" => "فروشگاهی",
        "blog" => "وبلاگی",
        "link" => "لینک",
        "gallery" => "گالری",
        "form" => "فرم",
    ]
];
