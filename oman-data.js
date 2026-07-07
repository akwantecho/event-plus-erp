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

    /* ===== الموسم الأول / SEASON ONE ===== */
    {
      id: "s1",
      titleAr: "الموسم الأول",
      titleEn: "Season One",
      yearAr: "٢٠٢٥",
      yearEn: "2025",
      sponsorAr: "",
      sponsorEn: "",
      episodes: [
        {
          yt: "https://youtu.be/iXpEzfgArA0",
          thumb: "",
          titleAr: "الحلقة الأولى",
          titleEn: "Episode One",
          descAr: "",
          descEn: "",
          locAr: "عُمان", locEn: "Oman",
          dateAr: "الحلقة الأولى", dateEn: "Episode 01"
        },
        {
          yt: "https://youtu.be/9sUeOq6r98c",
          thumb: "",
          titleAr: "الحلقة الثانية",
          titleEn: "Episode Two",
          descAr: "",
          descEn: "",
          locAr: "عُمان", locEn: "Oman",
          dateAr: "الحلقة الثانية", dateEn: "Episode 02"
        },
        {
          yt: "https://youtu.be/tkR0lBbXwfg",
          thumb: "",
          titleAr: "الحلقة الثالثة",
          titleEn: "Episode Three",
          descAr: "",
          descEn: "",
          locAr: "عُمان", locEn: "Oman",
          dateAr: "الحلقة الثالثة", dateEn: "Episode 03"
        },
        {
          yt: "https://youtu.be/nyH0PnTJtnM",
          thumb: "",
          titleAr: "الحلقة الرابعة",
          titleEn: "Episode Four",
          descAr: "",
          descEn: "",
          locAr: "عُمان", locEn: "Oman",
          dateAr: "الحلقة الرابعة", dateEn: "Episode 04"
        },
        {
          yt: "https://youtu.be/_Cug7e4LSHA",
          thumb: "",
          titleAr: "الحلقة الخامسة",
          titleEn: "Episode Five",
          descAr: "",
          descEn: "",
          locAr: "عُمان", locEn: "Oman",
          dateAr: "الحلقة الخامسة", dateEn: "Episode 05"
        },
        {
          yt: "https://youtu.be/vQlNtGMgC-U",
          thumb: "",
          titleAr: "الحلقة السادسة",
          titleEn: "Episode Six",
          descAr: "",
          descEn: "",
          locAr: "عُمان", locEn: "Oman",
          dateAr: "الحلقة السادسة", dateEn: "Episode 06"
        }
      ]
    },

    /* ===== الموسم الثاني — برعاية عُمانتل / SEASON TWO — sponsored by Omantel ===== */
    {
      id: "s2",
      titleAr: "الموسم الثاني",
      titleEn: "Season Two",
      yearAr: "٢٠٢٦",
      yearEn: "2026",
      sponsorAr: "برعاية عُمانتل",
      sponsorEn: "Sponsored by Omantel",
      episodes: [
        {
          yt: "https://youtu.be/gmzcT_z48Xs",
          thumb: "",
          titleAr: "الحلقة الأولى",
          titleEn: "Episode One",
          descAr: "",
          descEn: "",
          locAr: "عُمان", locEn: "Oman",
          dateAr: "الحلقة الأولى", dateEn: "Episode 01"
        }
      ]
    },

  ]
};
