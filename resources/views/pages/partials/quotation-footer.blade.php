{{-- Contact strip shown at the bottom of the cover and notices sheets. --}}
<div class="qt-foot">
    <div class="qt-foot-col">
        <div class="qt-foot-eyebrow">PHONE</div>
        <div class="qt-foot-val">{{ $company['phone'] }}</div>
        <div class="qt-foot-sub">رقم الهاتف</div>
    </div>
    <div class="qt-foot-col">
        <div class="qt-foot-eyebrow">EMAIL</div>
        <div class="qt-foot-val">{{ $company['email'] }}</div>
        <div class="qt-foot-sub">البريد الإلكتروني</div>
    </div>
    <div class="qt-foot-col">
        <div class="qt-foot-eyebrow">C.R</div>
        <div class="qt-foot-val">{{ $company['cr'] }}</div>
        <div class="qt-foot-sub">السجل التجاري</div>
    </div>
    <div class="qt-foot-col">
        <div class="qt-foot-eyebrow">ADDRESS</div>
        <div class="qt-foot-val ar">{{ $company['country'] }}<br>{{ $company['address'] }}</div>
    </div>
</div>
<div class="qt-ribbon" aria-hidden="true"><span class="r1"></span><span class="r2"></span><span class="r3"></span></div>
