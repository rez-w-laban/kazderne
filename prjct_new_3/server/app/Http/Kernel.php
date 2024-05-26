<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**

     https://www.dropbox.com/scl/fo/iefhi4owk0sg8dfznhyxt/ALNddsCP0IqWxmv-gkXKCZg?rlkey=pwdm2s8i2080v9hdzvb75eg2g&e=1&st=654lw35j&dl=0
    ملخص تنفيذي لفكرة مشروع ترميم وصيانة وتنظيف المنازل*

*المقدمة:*
يهدف مشروع ترميم وصيانة وتنظيف المنازل إلى تقديم خدمات متكاملة تشمل الترميم الشامل للأضرار، الصيانة الدورية، والتنظيف الاحترافي للمنازل. يركز المشروع على تحسين جودة الحياة للسكان من خلال توفير بيئة معيشية نظيفة وآمنة ومريحة.

*الهدف:*
توفير خدمات ترميم وصيانة وتنظيف عالية الجودة للمنازل بمختلف أنواعها، مما يسهم في الحفاظ على قيمة الممتلكات وتحسين ظروف السكن.

*الخدمات المقدمة:*
1. *الترميم*:
   - إصلاح الأضرار الهيكلية (الشروخ، الرطوبة، التصدعات).
   - تجديد الدهانات والتشطيبات الداخلية والخارجية.
   - استبدال وصيانة الأرضيات والسباكة والكهرباء.

2. *الصيانة*:
   - فحص دوري للأجهزة الكهربائية وأنظمة التدفئة والتبريد.
   - صيانة الأبواب والنوافذ والمفصلات.
   - تنظيف وصيانة الأسطح والمناطق الخارجية (الحدائق والأسطح).

3. *التنظيف*:
   - تنظيف عميق للمنزل (الأرضيات، الجدران، السجاد، الأثاث).
   - تنظيف الزجاج والنوافذ.
   - خدمات مكافحة الحشرات والتعقيم.

*السوق المستهدف:*
- الأفراد والأسر في المناطق الحضرية.
- أصحاب العقارات والشركات العقارية.
- المستأجرين والملاك الراغبين في تجديد منازلهم قبل البيع أو التأجير.

*الفوائد الرئيسية:*
- تحسين مظهر ووظيفة المنازل مما يزيد من رضا العملاء.
- الحفاظ على قيمة الممتلكات العقارية.
- توفير الوقت والجهد للسكان من خلال تقديم خدمات متكاملة في مكان واحد.
- تقديم حلول سريعة وفعالة لمشاكل الصيانة والتنظيف اليومية.

*التسويق والمبيعات:*
- استخدام وسائل التواصل الاجتماعي والإعلانات الرقمية للوصول إلى العملاء المحتملين.
- التعاون مع الشركات العقارية والمقاولين.
- تقديم خصومات وعروض خاصة لجذب العملاء الجدد وتحفيز العملاء الحاليين على الاستفادة من الخدمات بشكل دوري.

*التكاليف والعائدات:*
- الاستثمار في المعدات والمواد اللازمة لعمليات الترميم والتنظيف.
- تكاليف العمالة والتدريب.
- تحقيق عائدات من خلال رسوم الخدمات الشهرية أو العقود السنوية للصيانة والتنظيف.

*الخاتمة:*
يعد مشروع ترميم وصيانة وتنظيف المنازل فرصة واعدة لتلبية احتياجات السوق المتزايدة لخدمات الصيانة والتنظيف المتكاملة، مما يسهم في تحسين جودة الحياة وتعزيز القيمة العقارية للمنازل.

----------------------------------------
بلوك حجر 
متر حجارة 
بيطلع ١٢ حجر ونص 
١٠٠ ب ٥٠$ ١٢ حجر ب ٦$ 
العامل ٢$ 
ترابة و رمل ١$ 
هدم و نقل ردم ١$

-----------------------------
*المواد المطلوبة:*
1. دهان أساس ٢٠$ (Primer).
2. دهان اللون المطلوب.١٥$
3. فرش دهان وأسطوانات (Rollers).١$
4. شريط لاصق وغطاء للأرضية.٠.٥$
5. يد عاملة ٢٠$ يومية 
6. ملاحظه 
7. المسافة التي يغطيها السطل: سطل دهان الأساس بسعة 3.78 لتر يمكن أن يغطي حوالي 30 إلى 40 مترًا مربعًا، بناءً على نوع السطح ومدى امتصاصه للدهان.
----------------------------------------------
بلاط السيراميك متر ب ١٠$ و هنالك انواع عديده 
بحاجة إلى 
مواد (بودرة و ردم ) حسب الحاجة تحدد السعر 
متر لليد العاملة ٢.٥$
---------------------------------
تنظيف حيطان و ارض و ترتيب 
بحاجة إلى يد عاملة ع الساعه ٢.٥$


     
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'admin' => \App\Http\Middleware\Admin::class,
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \App\Http\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];
}
