<?php
/* ============================================================
   TEMA PREMIUM: ISLAMIC ELEGANCE
   Dipilih via settings: theme = islamic-elegance
   ============================================================ */
$GLOBALS['mc_settings'] = $settings ?? [];
if (!function_exists('mcGet')) {
  function mcGet($key, $default = '') {
    $s = $GLOBALS['mc_settings'];
    if (!isset($s[$key]) || trim((string)$s[$key]) === '') return $default;
    return $s[$key];
  }
}
if (!function_exists('mcDate')) {
  function mcDate($dateStr) {
    if (!$dateStr) return '';
    $days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    $months = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $ts = strtotime($dateStr);
    if (!$ts) return $dateStr;
    return $days[date('w',$ts)].', '.date('j',$ts).' '.$months[date('n',$ts)].' '.date('Y',$ts);
  }
}
if (!function_exists('mcTime')) {
  function mcTime($t) {
    $t = trim((string)$t); if ($t === '') return '08:00';
    $t = str_replace('.', ':', $t);
    return preg_match('/^\d{1,2}(:\d{2})?$/', $t) ? (strpos($t, ':') === false ? $t.':00' : $t) : '08:00';
  }
}
$groomNick = mcGet('groom_nickname') ?: mcGet('groom_name', 'Mempelai Pria');
$brideNick = mcGet('bride_nickname') ?: mcGet('bride_name', 'Mempelai Wanita');
$groomFull = mcGet('groom_name', 'Mempelai Pria');
$brideFull = mcGet('bride_name', 'Mempelai Wanita');
$wDate  = mcGet('wedding_date', date('Y-m-d'));
$wTime  = mcTime(mcGet('wedding_time_start', '08:00'));
$wTimeE = mcTime(mcGet('wedding_time_end', '10:00'));
$rDate  = mcGet('reception_date', $wDate);
$rTimeS = mcTime(mcGet('reception_time_start', '11:00'));
$rTimeE = mcTime(mcGet('reception_time_end', '13:00'));
$countdownISO = $wDate.'T'.$wTime.':00+07:00';
$accounts = [];
if (mcGet('gift_account')) $accounts[] = ['bank'=>mcGet('gift_bank','Bank'),'no'=>mcGet('gift_account'),'an'=>mcGet('gift_owner','')];
if (mcGet('gift_account2')) $accounts[] = ['bank'=>mcGet('gift_bank2','Bank'),'no'=>mcGet('gift_account2'),'an'=>mcGet('gift_owner2','')];
$musicUrl = null;
if (!empty($musicRecord) && !empty($musicRecord->file_path)) {
  $mp = $musicRecord->file_path;
  $musicUrl = (str_starts_with($mp,'http') || str_starts_with($mp,'/')) ? $mp : asset('storage/'.ltrim($mp,'/'));
}
$invId = $inv_id ?? 0;
$groomPhoto = mcGet('groom_photo'); $bridePhoto = mcGet('bride_photo');
$groomInitial = mb_substr($groomNick, 0, 1); $brideInitial = mb_substr($brideNick, 0, 1);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $brideNick }} &amp; {{ $groomNick }} — Islamic Elegance</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Cormorant+Garamond:wght@400;500;600&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
<style>
:root{--teal:#06231f;--teal2:#0a3a32;--gold:#c9a24b;--gold-lt:#f0d98c;--ivory:#f8f4e9;--dim:rgba(248,244,233,.7)}
*{margin:0;padding:0;box-sizing:border-box;-webkit-tap-highlight-color:transparent}
html{scroll-behavior:smooth}
body{font-family:'Jost',sans-serif;background:var(--teal);color:var(--ivory);overflow-x:hidden;font-weight:300}
body::before{content:'';position:fixed;inset:0;z-index:0;opacity:.55;pointer-events:none;
  background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120' viewBox='0 0 120 120'%3E%3Cg fill='none' stroke='%23c9a24b' stroke-opacity='.12'%3E%3Cpath d='M60 10 L70 50 L110 60 L70 70 L60 110 L50 70 L10 60 L50 50 Z'/%3E%3Ccircle cx='60' cy='60' r='8'/%3E%3C/g%3E%3C/svg%3E");
  background-size:120px 120px}
#glow{position:fixed;inset:0;z-index:1;pointer-events:none;background:radial-gradient(ellipse at 50% -5%,rgba(201,162,75,.14),transparent 55%)}
.wrap{position:relative;z-index:2;max-width:520px;margin:0 auto}
.serif{font-family:'Cormorant Garamond',serif}.amiri{font-family:'Amiri',serif}
#cover{position:fixed;inset:0;z-index:100;background:radial-gradient(ellipse at 50% 25%,#0d4a3e 0%,#06231f 70%);display:flex;align-items:center;justify-content:center;transition:opacity .9s,visibility .9s}
#cover.open{opacity:0;visibility:hidden}
.cover-card{text-align:center;padding:42px 30px;margin:24px;max-width:420px;border:1px solid rgba(201,162,75,.55);outline:1px solid rgba(201,162,75,.2);outline-offset:9px;background:rgba(6,35,31,.6)}
.mosque{width:150px;margin:0 auto 8px;display:block;opacity:.95}
.kicker{font-size:11px;letter-spacing:.4em;text-transform:uppercase;color:var(--gold)}
.bismillah{font-family:'Amiri',serif;font-size:26px;color:var(--gold-lt);margin-bottom:10px}
.cover-names{font-family:'Cormorant Garamond',serif;font-size:44px;margin:12px 0;font-weight:600;line-height:1.15}
.btn{display:inline-block;margin-top:22px;padding:14px 40px;background:linear-gradient(135deg,var(--gold-lt),var(--gold));color:#0a2a23;font-size:12px;letter-spacing:.3em;text-transform:uppercase;cursor:pointer;border:none;font-family:'Jost';font-weight:500;transition:.35s}
.btn:hover{box-shadow:0 0 28px rgba(201,162,75,.6);transform:translateY(-2px)}
.btn-line{display:inline-block;padding:12px 32px;border:1px solid var(--gold);color:var(--gold-lt);font-size:12px;letter-spacing:.26em;text-transform:uppercase;cursor:pointer;background:transparent;transition:.3s;text-decoration:none;font-family:'Jost'}
.btn-line:hover{background:rgba(201,162,75,.14)}
.guest{margin-top:18px;font-size:13px;color:var(--dim)}
.guest b{display:block;font-family:'Cormorant Garamond',serif;font-size:23px;color:var(--ivory);margin-top:6px}
section{padding:70px 26px;text-align:center}
.sec-kicker{font-size:11px;letter-spacing:.4em;text-transform:uppercase;color:var(--gold);margin-bottom:10px}
.sec-title{font-family:'Cormorant Garamond',serif;font-size:38px;font-weight:600}
.orn{display:flex;align-items:center;justify-content:center;gap:10px;margin:16px auto;max-width:300px;color:var(--gold)}
.orn::before,.orn::after{content:'';height:1px;flex:1;background:linear-gradient(90deg,transparent,var(--gold))}
.orn::after{background:linear-gradient(90deg,var(--gold),transparent)}
#hero{min-height:94vh;display:flex;flex-direction:column;justify-content:center}
.hero-names{font-family:'Cormorant Garamond',serif;font-size:52px;line-height:1.1;margin:14px 0;font-weight:600}
.hero-names em{font-family:'Amiri',serif;color:var(--gold-lt);font-size:40px}
.hero-date{letter-spacing:.32em;font-size:13px;color:var(--dim);text-transform:uppercase}
.verse{font-family:'Amiri',serif;font-size:19px;line-height:2;color:var(--gold-lt);max-width:400px;margin:0 auto}
.verse-src{font-size:12px;color:var(--dim);letter-spacing:.2em;margin-top:8px}
.cd-grid{display:flex;justify-content:center;gap:10px;margin-top:26px}
.cd{width:72px;padding:16px 0;border:1px solid rgba(201,162,75,.45);background:rgba(201,162,75,.06)}
.cd b{display:block;font-family:'Cormorant Garamond',serif;font-size:34px;color:var(--gold-lt)}
.cd span{font-size:10px;letter-spacing:.28em;text-transform:uppercase;color:var(--dim)}
.arch{width:168px;height:208px;margin:0 auto 18px;clip-path:path('M84 0 C130 40 150 80 150 120 L150 208 L18 208 L18 120 C18 80 38 40 84 0 Z');background:linear-gradient(160deg,#0d4a3e,#06231f);border:2px solid var(--gold);display:flex;align-items:center;justify-content:center;overflow:hidden;position:relative}
.arch img{width:100%;height:100%;object-fit:cover}
.arch .init{font-family:'Cormorant Garamond',serif;font-size:72px;color:var(--gold-lt)}
.couple-card{margin:0 auto 20px;max-width:380px;padding:30px 22px;border:1px solid rgba(201,162,75,.35);background:rgba(201,162,75,.05)}
.couple-card h3{font-family:'Cormorant Garamond',serif;font-size:32px;color:var(--gold-lt)}
.couple-card .full{font-size:16px;margin:6px 0;color:var(--ivory)}
.couple-card p{font-size:14px;color:var(--dim);line-height:1.7}
.amp{font-family:'Amiri',serif;font-size:44px;color:var(--gold);margin:2px 0}
.event{border:1px solid rgba(201,162,75,.4);padding:36px 24px;margin:0 auto 20px;max-width:400px;background:rgba(6,35,31,.6)}
.event h3{font-family:'Cormorant Garamond',serif;font-size:28px;letter-spacing:.14em;text-transform:uppercase;color:var(--gold-lt)}
.event .date{font-family:'Cormorant Garamond',serif;font-size:20px;margin:12px 0 4px}
.event .time{letter-spacing:.24em;font-size:13px;color:var(--gold)}
.event .loc{font-size:14px;color:var(--dim);margin:12px 0 18px;line-height:1.7}
.g-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:24px}
.g-grid img{width:100%;height:190px;object-fit:cover;border:1px solid rgba(201,162,75,.4);transition:.4s}
.g-grid img:hover{transform:scale(1.03)}
.tl{max-width:400px;margin:26px auto 0;text-align:left;padding-left:26px;position:relative}
.tl::before{content:'';position:absolute;left:8px;top:6px;bottom:6px;width:1px;background:linear-gradient(var(--gold),transparent)}
.tl-item{position:relative;padding:0 0 28px 18px}
.tl-item::before{content:'✦';position:absolute;left:-25px;top:-2px;color:var(--gold)}
.tl-item h4{font-family:'Cormorant Garamond',serif;font-size:22px;color:var(--gold-lt)}
.tl-item p{font-size:14px;color:var(--dim);line-height:1.7;margin-top:6px}
.field{margin:0 auto 14px;max-width:380px;text-align:left}
.field label{display:block;font-size:10px;letter-spacing:.32em;text-transform:uppercase;color:var(--gold);margin-bottom:8px}
.field input,.field select,.field textarea{width:100%;background:rgba(248,244,233,.05);border:1px solid rgba(201,162,75,.45);color:var(--ivory);padding:13px 14px;font-family:'Jost';font-size:15px;outline:none}
.field input:focus,.field select:focus,.field textarea:focus{border-color:var(--gold)}
.field select option{color:#222}
.wish{border:1px solid rgba(201,162,75,.3);background:rgba(201,162,75,.06);padding:14px 16px;margin:0 auto 12px;max-width:400px;text-align:left}
.wish b{font-family:'Cormorant Garamond',serif;color:var(--gold-lt);font-size:17px}
.wish .st{font-size:10px;letter-spacing:.2em;color:var(--gold);text-transform:uppercase;margin-left:8px}
.wish p{font-size:14px;color:var(--dim);margin-top:6px;line-height:1.6}
.bank{border:1px solid rgba(201,162,75,.45);padding:22px;margin:0 auto 14px;max-width:380px;background:rgba(201,162,75,.05)}
.bank .bk{font-size:11px;letter-spacing:.34em;color:var(--gold);text-transform:uppercase}
.bank .no{font-family:'Cormorant Garamond',serif;font-size:30px;margin:10px 0 4px;letter-spacing:.06em}
.bank .an{font-size:14px;color:var(--dim)}
.copy{margin-top:12px}
footer{padding:60px 26px 90px;text-align:center}
#musBtn{position:fixed;bottom:22px;right:22px;z-index:90;width:52px;height:52px;border-radius:50%;border:1px solid var(--gold);background:rgba(6,35,31,.9);color:var(--gold-lt);font-size:20px;cursor:pointer;display:flex;align-items:center;justify-content:center}
.rv{opacity:0;transform:translateY(36px);transition:opacity .9s,transform .9s}
.rv.on{opacity:1;transform:none}
@media(min-width:640px){.hero-names{font-size:64px}}
</style>
</head>
<body>
<div id="glow"></div>
<div class="wrap">

<div id="cover">
  <div class="cover-card">
    <svg class="mosque" viewBox="0 0 150 90"><path d="M75 6 C90 26 98 38 98 52 L98 78 L52 78 L52 52 C52 38 60 26 75 6 Z" fill="none" stroke="#c9a24b" stroke-width="2"/><rect x="70" y="22" width="10" height="22" fill="none" stroke="#c9a24b" stroke-width="1.5"/><path d="M20 78 L20 58 C30 58 34 64 34 70 M130 78 L130 58 C120 58 116 64 116 70" fill="none" stroke="#c9a24b" stroke-width="1.8"/><rect x="14" y="50" width="4" height="28" fill="#c9a24b" opacity=".8"/><rect x="132" y="50" width="4" height="28" fill="#c9a24b" opacity=".8"/><circle cx="16" cy="46" r="4" fill="none" stroke="#c9a24b" stroke-width="1.5"/><circle cx="134" cy="46" r="4" fill="none" stroke="#c9a24b" stroke-width="1.5"/><line x1="10" y1="80" x2="140" y2="80" stroke="#c9a24b" stroke-width="2"/></svg>
    <div class="bismillah">بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ</div>
    <div class="kicker">Undangan Pernikahan</div>
    <div class="cover-names">{{ $brideNick }} &amp; {{ $groomNick }}</div>
    <div class="guest">Kepada Yth.<br>Bapak/Ibu/Saudara/i<b>{{ $guestName }}</b></div>
    <button class="btn" onclick="openInv()">Buka Undangan</button>
  </div>
</div>

<section id="hero">
  <div class="rv"><div class="bismillah">بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ</div></div>
  <div class="rv"><div class="kicker">The Wedding Of</div></div>
  <div class="rv"><h1 class="hero-names">{{ $brideNick }} <em>&amp;</em> {{ $groomNick }}</h1></div>
  <div class="rv"><div class="orn">✦</div></div>
  <div class="rv"><div class="hero-date">{{ mcDate($wDate) }}</div></div>
</section>

<section>
  <div class="rv"><div class="verse">"Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu agar kamu merasa tenteram, dan Dia menjadikan di antaramu rasa kasih dan sayang."</div><div class="verse-src">QS. AR-RŪM : 21</div></div>
</section>

<section>
  <div class="rv"><div class="sec-kicker">Menuju Hari Bahagia</div><div class="sec-title serif">Hitung Mundur</div><div class="orn">✦</div></div>
  <div class="cd-grid rv">
    <div class="cd"><b id="cdD">0</b><span>Hari</span></div>
    <div class="cd"><b id="cdH">0</b><span>Jam</span></div>
    <div class="cd"><b id="cdM">0</b><span>Menit</span></div>
    <div class="cd"><b id="cdS">0</b><span>Detik</span></div>
  </div>
</section>

<section>
  <div class="rv"><div class="sec-kicker">Assalamu'alaikum Wr. Wb.</div><div class="sec-title serif">Mempelai</div><div class="orn">✦</div></div>
  <div class="couple-card rv">
    <div class="arch">@if($bridePhoto)<img src="{{ $bridePhoto }}" alt="{{ $brideFull }}">@else<span class="init">{{ $brideInitial }}</span>@endif</div>
    <h3>{{ $brideNick }}</h3><div class="full">{{ $brideFull }}</div>
    <p>Putri dari<br>{{ mcGet('bride_parents', mcGet('bride_child_of', '')) }}</p>
  </div>
  <div class="amp rv">&amp;</div>
  <div class="couple-card rv">
    <div class="arch">@if($groomPhoto)<img src="{{ $groomPhoto }}" alt="{{ $groomFull }}">@else<span class="init">{{ $groomInitial }}</span>@endif</div>
    <h3>{{ $groomNick }}</h3><div class="full">{{ $groomFull }}</div>
    <p>Putra dari<br>{{ mcGet('groom_parents', mcGet('groom_child_of', '')) }}</p>
  </div>
</section>

<section>
  <div class="rv"><div class="sec-kicker">Waktu &amp; Tempat</div><div class="sec-title serif">Rangkaian Acara</div><div class="orn">✦</div></div>
  <div class="event rv">
    <h3>Akad Nikah</h3>
    <div class="date">{{ mcDate($wDate) }}</div><div class="time">{{ $wTime }} — {{ $wTimeE }} WIB</div>
    <div class="loc">{{ mcGet('wedding_location', 'Kediaman Mempelai') }}</div>
    @if(mcGet('wedding_map_link'))<a class="btn-line" target="_blank" href="{{ mcGet('wedding_map_link') }}">Lihat Peta</a>@endif
  </div>
  <div class="event rv">
    <h3>Resepsi</h3>
    <div class="date">{{ mcDate($rDate) }}</div><div class="time">{{ $rTimeS }} — {{ $rTimeE }} WIB</div>
    <div class="loc">{{ mcGet('reception_location', mcGet('wedding_location', 'Kediaman Mempelai')) }}</div>
    @if(mcGet('reception_map_link'))<a class="btn-line" target="_blank" href="{{ mcGet('reception_map_link') }}">Lihat Peta</a>@endif
  </div>
</section>

@if(!empty($gallery))
<section>
  <div class="rv"><div class="sec-kicker">Momen Indah</div><div class="sec-title serif">Galeri</div><div class="orn">✦</div></div>
  <div class="g-grid rv">
    @foreach(array_slice($gallery, 0, 8) as $img)<img src="{{ $img }}" alt="Galeri" loading="lazy">@endforeach
  </div>
</section>
@endif

@if(!empty($stories) && count($stories))
<section>
  <div class="rv"><div class="sec-kicker">Perjalanan Kami</div><div class="sec-title serif">Kisah Cinta</div><div class="orn">✦</div></div>
  <div class="tl">
    @foreach($stories as $st)
    <div class="tl-item rv"><h4>{{ $st->title ?? 'Cerita' }}</h4><p>{{ $st->description ?? $st->content ?? '' }}</p></div>
    @endforeach
  </div>
</section>
@endif

<section>
  <div class="rv"><div class="sec-kicker">Konfirmasi</div><div class="sec-title serif">RSVP</div><div class="orn">✦</div></div>
  <form id="rsvpForm" class="rv" onsubmit="return sendRSVP(event)">
    <div class="field"><label>Nama Lengkap</label><input required name="name" placeholder="Nama Anda"></div>
    <div class="field"><label>Kehadiran</label><select name="status"><option value="Hadir">Hadir, Insya Allah</option><option value="Tidak Hadir">Berhalangan</option></select></div>
    <div class="field"><label>Jumlah Tamu</label><input type="number" name="guest_count" min="1" value="1"></div>
    <button class="btn" type="submit">Kirim Konfirmasi</button>
  </form>
</section>

<section>
  <div class="rv"><div class="sec-kicker">Doa &amp; Harapan</div><div class="sec-title serif">Ucapan</div><div class="orn">✦</div></div>
  <div id="wishList" class="rv"></div>
  <form id="wishForm" class="rv" onsubmit="return sendWish(event)" style="margin-top:22px">
    <div class="field"><label>Nama</label><input required name="name" placeholder="Nama Anda"></div>
    <div class="field"><label>Ucapan</label><textarea required name="message" rows="3" placeholder="Tulis doa terbaik..."></textarea></div>
    <button class="btn-line" type="submit">Kirim Ucapan</button>
  </form>
</section>

@if(!empty($accounts) || mcGet('gift_address'))
<section>
  <div class="rv"><div class="sec-kicker">Tanda Kasih</div><div class="sec-title serif">Hadiah</div><div class="orn">✦</div></div>
  @foreach($accounts as $a)
  <div class="bank rv"><div class="bk">{{ $a['bank'] }}</div><div class="no">{{ $a['no'] }}</div><div class="an">a.n. {{ $a['an'] }}</div>
  <button class="btn-line copy" onclick="copyNo('{{ $a['no'] }}')">Salin Nomor</button></div>
  @endforeach
  @if(mcGet('gift_address'))<div class="bank rv"><div class="bk">Hadiah Fisik</div><p style="font-size:14px;color:var(--dim);margin-top:10px;line-height:1.7">{{ mcGet('gift_address') }}</p></div>@endif
</section>
@endif

<footer>
  <div class="rv"><div class="amiri" style="font-size:30px;color:var(--gold-lt)">جَزَاكُمُ اللّٰهُ خَيْرًا</div>
  <p style="color:var(--dim);font-size:14px;line-height:1.8;max-width:380px;margin:14px auto">Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu kepada kedua mempelai.</p>
  <div class="orn">✦</div>
  <div class="serif" style="font-size:22px;color:var(--gold-lt)">{{ $brideNick }} &amp; {{ $groomNick }}</div></div>
</footer>
</div>

@if($musicUrl)
<audio id="mus" loop src="{{ $musicUrl }}"></audio>
<button id="musBtn" onclick="toggleMus()">♪</button>
@endif

<script>
const INV_ID = {{ (int)$invId }};
function openInv(){document.getElementById('cover').classList.add('open');document.body.style.overflow='';const m=document.getElementById('mus');if(m)m.play().catch(()=>{});}
document.body.style.overflow='hidden';
const target = new Date("{{ $countdownISO }}").getTime();
setInterval(()=>{const d=target-Date.now();if(d<0)return;
  cdD.textContent=Math.floor(d/864e5);cdH.textContent=Math.floor(d/36e5)%24;cdM.textContent=Math.floor(d/6e4)%60;cdS.textContent=Math.floor(d/1e3)%60;},1000);
const io=new IntersectionObserver(es=>es.forEach(e=>{if(e.isIntersecting){e.target.classList.add('on');io.unobserve(e.target)}}),{threshold:.12});
document.querySelectorAll('.rv').forEach(el=>io.observe(el));
async function sendRSVP(e){e.preventDefault();const f=e.target;
  const r=await fetch('/api/rsvp.php?inv_id='+INV_ID,{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({name:f.name.value,status:f.status.value,guest_count:f.guest_count.value})});
  alert(r.ok?'Jazakumullah atas konfirmasinya!':'Gagal, coba lagi.');f.reset();return false;}
async function loadWishes(){try{const r=await fetch('/api/ucapan.php?inv_id='+INV_ID);const d=await r.json();
  wishList.innerHTML=(d.data||d||[]).map(w=>`<div class="wish"><b>${esc(w.name)}</b><span class="st">${esc(w.status||'')}</span><p>${esc(w.message||w.ucapan||'')}</p></div>`).join('')||'<p style="color:var(--dim)">Belum ada ucapan.</p>';}catch(e){}}
function esc(s){return String(s??'').replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]))}
async function sendWish(e){e.preventDefault();const f=e.target;
  const r=await fetch('/api/ucapan.php?inv_id='+INV_ID,{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({name:f.name.value,message:f.message.value})});
  if(r.ok){f.reset();loadWishes();}else alert('Gagal mengirim.');return false;}
loadWishes();
function copyNo(t){navigator.clipboard.writeText(t).then(()=>alert('Nomor tersalin!'));}
function toggleMus(){const m=document.getElementById('mus');if(m.paused){m.play();musBtn.style.opacity=1}else{m.pause();musBtn.style.opacity=.5}}
</script>
</body>
</html>
