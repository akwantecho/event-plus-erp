/* ============================================================================
   هذي عُمان — ملف بيانات الحلقات والمواسم
   THIS IS OMAN — Episodes & Seasons data file
   ----------------------------------------------------------------------------

   ▸ هذا هو الملف الوحيد الذي تعدّله لإضافة حلقة جديدة أو موسم جديد.
     لا حاجة لمعرفة البرمجة — فقط الصق رابط يوتيوب واكتب العنوان.

   ▸ This is the ONLY file you edit to add a new episode or a new season.
     No coding needed — just paste a YouTube link and write the title.

   ----------------------------------------------------------------------------
   ① لإضافة حلقة جديدة كل أسبوع  /  To add a weekly episode:
      انسخ كتلة حلقة كاملة (من { إلى } مع الفاصلة) والصقها في أعلى قائمة
      "episodes" للموسم المطلوب، ثم عدّل القيم. المصغّر (الصورة) يُجلب
      تلقائيًا من يوتيوب — لا داعي لرفع صورة.
      Copy one episode block ({ … },) and paste it at the TOP of that
      season's "episodes" list, then edit the values. The thumbnail is
      pulled automatically from YouTube — no image upload needed.

   ② لإضافة موسم كامل  /  To add a whole season:
      انسخ كتلة موسم كاملة والصقها في أعلى قائمة "seasons".
      Copy one season block and paste it at the top of "seasons".

   ----------------------------------------------------------------------------
   حقول الحلقة  /  Episode fields:
      yt       : رابط يوتيوب (أي صيغة) — هذا كل المطلوب لظهور الحلقة وتشغيلها.
                 YouTube link (any format). This alone makes the episode play.
                 مثال / e.g.  "https://youtu.be/dQw4w9WgXcQ"
      titleAr  : عنوان الحلقة بالعربية      titleEn : English title
      descAr   : وصف قصير بالعربية          descEn  : short English description
      locAr    : المكان بالعربية            locEn   : place in English
      dateAr   : التاريخ بالعربية           dateEn  : date in English
      thumb    : (اختياري) مسار صورة مخصّصة بدل مصغّر يوتيوب.
                 (optional) custom thumbnail path instead of the YouTube one.

   * أي حقل تتركه فارغًا "" لا يظهر. الحقل الوحيد المهم هو yt.
   * Any field left "" is hidden. The only field that matters is yt.
   ============================================================================ */

window.OMAN_DATA = {

  /* الأرقام الظاهرة في شريط الأثر — عدّلها بحرية / Impact-bar numbers — edit freely */
  impact: [
    { value: "+1.5M", labelAr: "مشاهدة",      labelEn: "Views" },
    { value: "+30",   labelAr: "منشور",       labelEn: "Posts" },
    { value: "2",     labelAr: "موسم",        labelEn: "Seasons" },
    { value: "11",    labelAr: "محافظة",      labelEn: "Governorates" }
  ],

  seasons: [

    /* ===== الموسم الثاني — برعاية عُمانتل / SEASON TWO — sponsored by Omantel ===== */
    {
      id: "s2",
      titleAr: "الموسم الثاني",
      titleEn: "Season Two",
      yearAr: "٢٠٢٥",
      yearEn: "2025",
      sponsorAr: "برعاية عُمانتل",
      sponsorEn: "Sponsored by Omantel",
      episodes: [

        /* ↓↓↓ لإضافة حلقة جديدة: انسخ هذه الكتلة والصقها هنا في الأعلى ↓↓↓ */
        {
          yt: "",
          thumb: "assets/oman/ep-dhofari.jpg",
          titleAr: "الإنسان الظفاري والأرض",
          titleEn: "The Dhofari & the Land",
          descAr: "علاقة أهل ظفار بأرضهم — من رعي الإبل إلى موسم اللبان، حكاية انتماءٍ يتوارثه الجيل بعد الجيل.",
          descEn: "Dhofar's bond with its land — from herding to the frankincense season, a story of belonging passed down generations.",
          locAr: "ظفار", locEn: "Dhofar",
          dateAr: "الحلقة السادسة", dateEn: "Episode 06"
        },
        {
          yt: "",
          thumb: "assets/oman/tent-elder.jpg",
          titleAr: "العرس الظفاري",
          titleEn: "The Dhofari Wedding",
          descAr: "ليالي العرس في ظفار: الزينة، والمجالس، والأهازيج التي ترافق العريس حتى مطلع الفجر.",
          descEn: "Wedding nights in Dhofar — the adornment, the gatherings, and the chants that carry the groom till dawn.",
          locAr: "ظفار", locEn: "Dhofar",
          dateAr: "الحلقة الثانية", dateEn: "Episode 02"
        },
        {
          yt: "",
          thumb: "assets/oman/frankincense.jpg",
          titleAr: "الخريف والصرب",
          titleEn: "Khareef & the Highlands",
          descAr: "حين يكسو الضباب جبال ظفار في الخريف، تتحوّل السهول إلى مراعٍ خضراء تنبض بالحياة.",
          descEn: "When the monsoon mist wraps Dhofar's mountains, the plains turn into living green pastures.",
          locAr: "صلالة", locEn: "Salalah",
          dateAr: "الحلقة الرابعة", dateEn: "Episode 04"
        },
        {
          yt: "",
          thumb: "assets/oman/house-interior.jpg",
          titleAr: "بيوت الطين والذاكرة",
          titleEn: "Houses of Mud & Memory",
          descAr: "داخل البيوت العُمانية القديمة، حيث تروي الجدران والسقوف حكايات من سكنوها.",
          descEn: "Inside the old Omani houses, where walls and ceilings still tell the stories of those who lived there.",
          locAr: "الداخلية", locEn: "Ad Dakhiliyah",
          dateAr: "الحلقة الخامسة", dateEn: "Episode 05"
        },
        {
          yt: "",
          thumb: "assets/oman/men-khanjar.jpg",
          titleAr: "مجالس العيد",
          titleEn: "The Eid Majlis",
          descAr: "العيد كما تعيشه العائلة العُمانية: الخنجر، والقهوة، والمجلس الذي يجمع الأجيال.",
          descEn: "Eid as the Omani family lives it — the khanjar, the coffee, and the majlis that gathers generations.",
          locAr: "مسقط", locEn: "Muscat",
          dateAr: "الحلقة الثالثة", dateEn: "Episode 03"
        },
        {
          yt: "",
          thumb: "assets/oman/fog-interview.jpg",
          titleAr: "مسقط .. البداية",
          titleEn: "Muscat — the Beginning",
          descAr: "من العاصمة تبدأ الرحلة: بين البحر والجبل، تتلاقى عُمان القديمة والحديثة.",
          descEn: "The journey begins in the capital — between sea and mountain, old and new Oman meet.",
          locAr: "مسقط", locEn: "Muscat",
          dateAr: "الحلقة الأولى", dateEn: "Episode 01"
        }

      ]
    },

    /* ===== الموسم الأول / SEASON ONE ===== */
    {
      id: "s1",
      titleAr: "الموسم الأول",
      titleEn: "Season One",
      yearAr: "٢٠٢٤",
      yearEn: "2024",
      sponsorAr: "",
      sponsorEn: "",
      episodes: [
        /* أضِف حلقات الموسم الأول هنا بنفس الطريقة.
           Add Season One episodes here the same way. */
        {
          yt: "",
          thumb: "",
          titleAr: "الحلقة الأولى",
          titleEn: "Episode One",
          descAr: "الصق رابط يوتيوب واكتب العنوان لتظهر الحلقة.",
          descEn: "Paste a YouTube link and a title to publish this episode.",
          locAr: "عُمان", locEn: "Oman",
          dateAr: "الموسم الأول", dateEn: "Season One"
        },
        {
          yt: "",
          thumb: "",
          titleAr: "الحلقة الثانية",
          titleEn: "Episode Two",
          descAr: "الصق رابط يوتيوب واكتب العنوان لتظهر الحلقة.",
          descEn: "Paste a YouTube link and a title to publish this episode.",
          locAr: "عُمان", locEn: "Oman",
          dateAr: "الموسم الأول", dateEn: "Season One"
        },
        {
          yt: "",
          thumb: "",
          titleAr: "الحلقة الثالثة",
          titleEn: "Episode Three",
          descAr: "الصق رابط يوتيوب واكتب العنوان لتظهر الحلقة.",
          descEn: "Paste a YouTube link and a title to publish this episode.",
          locAr: "عُمان", locEn: "Oman",
          dateAr: "الموسم الأول", dateEn: "Season One"
        }
      ]
    }

  ]
};
