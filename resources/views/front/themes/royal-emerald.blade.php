<?php
/* ============================================================
   TEMA PREMIUM: ROYAL EMERALD & GOLD
   Dipilih via settings: theme = royal-emerald
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
<title>{{ $brideNick }} &amp; {{ $groomNick }} — Royal Wedding Invitation</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Great+Vibes&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
<style>
:root{--emerald:#07271e;--emerald2:#0b3a2c;--gold:#c9a24b;--gold-lt:#f0d98c;--cream:#f7f2e7;--cream-dim:rgba(247,242,231,.72)}
*{margin:0;padding:0;box-sizing:border-box;-webkit-tap-highlight-color:transparent}
html{scroll-behavior:smooth}
body{font-family:'Jost',sans-serif;background:var(--emerald);color:var(--cream);overflow-x:hidden;font-weight:300;letter-spacing:.02em}
.serif{font-family:'Cormorant Garamond',serif}.script{font-family:'Great Vibes',cursive}
#dust{position:fixed;inset:0;z-index:1;pointer-events:none}
.wrap{position:relative;z-index:2;max-width:520px;margin:0 auto}
/* ---------- cover ---------- */
#cover{position:fixed;inset:0;z-index:100;background:radial-gradient(ellipse at 50% 30%,#0e4a37 0%,#07271e 65%);display:flex;align-items:center;justify-content:center;transition:opacity .9s,visibility .9s}
#cover.open{opacity:0;visibility:hidden}
.cover-card{text-align:center;padding:36px 28px;border:1px solid rgba(201,162,75,.45);outline:1px solid rgba(201,162,75,.18);outline-offset:8px;margin:24px;max-width:420px;background:rgba(7,39,30,.55);backdrop-filter:blur(2px)}
.mono{width:96px;height:96px;margin:0 auto 18px;border:1px solid var(--gold);border-radius:50%;display:flex;align-items:center;justify-content:center;position:relative}
.mono::before{content:'';position:absolute;inset:6px;border:1px solid rgba(201,162,75,.4);border-radius:50%}
.mono span{font-family:'Cormorant Garamond',serif;font-size:34px;color:var(--gold-lt);letter-spacing:2px}
.kicker{font-size:11px;letter-spacing:.42em;text-transform:uppercase;color:var(--gold)}
.cover-names{font-family:'Great Vibes',cursive;font-size:52px;color:var(--cream);margin:14px 0 6px;line-height:1.1}
.btn-gold{display:inline-block;margin-top:22px;padding:14px 38px;border:1px solid var(--gold);color:var(--emerald);background:linear-gradient(135deg,var(--gold-lt),var(--gold));font-family:'Jost';font-size:12px;letter-spacing:.28em;text-transform:uppercase;cursor:pointer;transition:.35s;text-decoration:none}
.btn-gold:hover{box-shadow:0 0 26px rgba(201,162,75,.55);transform:translateY(-2px)}
.btn-ghost{display:inline-block;padding:12px 30px;border:1px solid rgba(201,162,75,.6);color:var(--gold-lt);font-size:12px;letter-spacing:.24em;text-transform:uppercase;cursor:pointer;background:transparent;transition:.3s;text-decoration:none}
.btn-ghost:hover{background:rgba(201,162,75,.12)}
.guest{margin-top:18px;font-size:13px;color:var(--cream-dim)}
.guest b{display:block;font-family:'Cormorant Garamond',serif;font-size:22px;color:var(--cream);font-weight:600;margin-top:6px;letter-spacing:.04em}
/* ---------- section ---------- */
section{padding:72px 26px;text-align:center;position:relative}
.sec-kicker{font-size:11px;letter-spacing:.42em;text-transform:uppercase;color:var(--gold);margin-bottom:12px}
.sec-title{font-family:'Cormorant Garamond',serif;font-size:38px;font-weight:500;color:var(--cream)}
.divider{display:flex;align-items:center;justify-content:center;gap:12px;margin:18px auto;max-width:280px}
.divider::before,.divider::after{content:'';height:1px;flex:1;background:linear-gradient(90deg,transparent,var(--gold))}
.divider::after{background:linear-gradient(90deg,var(--gold),transparent)}
.divider i{color:var(--gold);font-style:normal;font-size:14px}
/* hero */
#hero{min-height:92vh;display:flex;flex-direction:column;justify-content:center;background:radial-gradient(ellipse at 50% 0%,#0e4a37 0%,transparent 60%)}
.hero-script{font-family:'Great Vibes',cursive;font-size:30px;color:var(--gold-lt)}
.hero-names{font-family:'Cormorant Garamond',serif;font-size:56px;line-height:1.05;margin:16px 0;font-weight:600}
.hero-names em{font-family:'Great Vibes',cursive;font-weight:400;color:var(--gold-lt);font-size:44px}
.hero-date{letter-spacing:.3em;font-size:13px;color:var(--cream-dim);text-transform:uppercase}
.scroll-hint{margin-top:44px;font-size:10px;letter-spacing:.4em;color:var(--gold);text-transform:uppercase;animation:bob 2.4s ease-in-out infinite}
@keyframes bob{0%,100%{transform:translateY(0);opacity:.7}50%{transform:translateY(10px);opacity:1}}
/* countdown */
.cd-grid{display:flex;justify-content:center;gap:12px;margin-top:26px}
.cd{width:74px;padding:16px 0;border:1px solid rgba(201,162,75,.4);background:rgba(201,162,75,.06)}
.cd b{display:block;font-family:'Cormorant Garamond',serif;font-size:34px;color:var(--gold-lt);font-weight:600}
.cd span{font-size:10px;letter-spacing:.3em;text-transform:uppercase;color:var(--cream-dim)}
/* couple */
.couple-card{border:1px solid rgba(201,162,75,.35);padding:34px 22px;margin:0 auto 22px;max-width:380px;background:linear-gradient(180deg,rgba(201,162,75,.07),transparent)}
.photo{width:150px;height:150px;border-radius:50%;margin:0 auto 18px;object-fit:cover;border:2px solid var(--gold);padding:5px;background:var(--emerald)}
.photo-fallback{width:150px;height:150px;border-radius:50%;margin:0 auto 18px;border:2px solid var(--gold);display:flex;align-items:center;justify-content:center;font-family:'Cormorant Garamond',serif;font-size:64px;color:var(--gold-lt);background:radial-gradient(circle,#0e4a37,#07271e)}
.couple-card h3{font-family:'Great Vibes',cursive;font-size:38px;color:var(--gold-lt);font-weight:400}
.couple-card .full{font-family:'Cormorant Garamond',serif;font-size:19px;margin:6px 0}
.couple-card p{font-size:14px;color:var(--cream-dim);line-height:1.7}
.amp{font-family:'Great Vibes',cursive;font-size:54px;color:var(--gold);margin:6px 0}
/* event */
.event{border:1px solid rgba(201,162,75,.35);padding:36px 24px;margin:0 auto 22px;max-width:400px;background:rgba(7,39,30,.5);position:relative}
.event::before{content:'';position:absolute;inset:8px;border:1px solid rgba(201,162,75,.2);pointer-events:none}
.event h3{font-family:'Cormorant Garamond',serif;font-size:30px;color:var(--gold-lt);letter-spacing:.12em;text-transform:uppercase;font-weight:600}
.event .date{font-family:'Cormorant Garamond',serif;font-size:20px;margin:14px 0 4px}
.event .time{letter-spacing:.24em;font-size:13px;color:var(--gold)}
.event .loc{font-size:14px;color:var(--cream-dim);margin:12px 0 18px;line-height:1.7}
/* gallery */
.g-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:24px}
.g-grid img{width:100%;height:190px;object-fit:cover;border:1px solid rgba(201,162,75,.35);transition:.4s;cursor:pointer}
.g-grid img:hover{transform:scale(1.03);border-color:var(--gold)}
/* story */
.tl{position:relative;margin-top:26px;padding-left:26px;text-align:left;max-width:400px;margin-left:auto;margin-right:auto}
.tl::before{content:'';position:absolute;left:8px;top:6px;bottom:6px;width:1px;background:linear-gradient(var(--gold),transparent)}
.tl-item{position:relative;padding:0 0 28px 18px}
.tl-item::before{content:'◆';position:absolute;left:-24px;top:0;color:var(--gold);font-size:12px}
.tl-item h4{font-family:'Cormorant Garamond',serif;font-size:22px;color:var(--gold-lt)}
.tl-item p{font-size:14px;color:var(--cream-dim);line-height:1.7;margin-top:6px}
/* forms */
.field{margin:0 auto 14px;max-width:380px;text-align:left}
.field label{display:block;font-size:10px;letter-spacing:.32em;text-transform:uppercase;color:var(--gold);margin-bottom:8px}
.field input,.field select,.field textarea{width:100%;background:rgba(247,242,231,.05);border:1px solid rgba(201,162,75,.4);color:var(--cream);padding:13px 14px;font-family:'Jost';font-size:15px;outline:none;transition:.3s}
.field input:focus,.field select:focus,.field textarea:focus{border-color:var(--gold);background:rgba(201,162,75,.08)}
.field select option{color:#222}
/* wishes */
.wish{border-left:2px solid var(--gold);background:rgba(201,162,75,.06);padding:14px 16px;margin:0 auto 12px;max-width:400px;text-align:left}
.wish b{font-family:'Cormorant Garamond',serif;color:var(--gold-lt);font-size:17px}
.wish .st{font-size:10px;letter-spacing:.2em;color:var(--gold);text-transform:uppercase;margin-left:8px}
.wish p{font-size:14px;color:var(--cream-dim);margin-top:6px;line-height:1.6}
/* gift */
.bank{border:1px solid rgba(201,162,75,.4);padding:22px;margin:0 auto 14px;max-width:380px;background:rgba(201,162,75,.05)}
.bank .bk{font-size:11px;letter-spacing:.34em;color:var(--gold);text-transform:uppercase}
.bank .no{font-family:'Cormorant Garamond',serif;font-size:30px;letter-spacing:.08em;margin:10px 0 4px}
.bank .an{font-size:14px;color:var(--cream-dim)}
.copy{margin-top:12px}
/* footer */
footer{padding:60px 26px 90px;text-align:center}
footer .script{font-size:40px;color:var(--gold-lt)}
/* music */
#musBtn{position:fixed;bottom:22px;right:22px;z-index:90;width:52px;height:52px;border-radius:50%;border:1px solid var(--gold);background:rgba(7,39,30,.85);color:var(--gold-lt);font-size:20px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:.3s}
#musBtn:hover{box-shadow:0 0 18px rgba(201,162,75,.5)}
/* reveal */
.rv{opacity:0;transform:translateY(36px);transition:opacity .9s ease,transform .9s ease}
.rv.on{opacity:1;transform:none}
@media(min-width:640px){.hero-names{font-size:68px}}
</style>
</head>
<body>
<canvas id="dust"></canvas>
<div class="wrap">

<!-- COVER -->
<div id="cover">
  <div class="cover-card rv on">
    <div class="kicker">Undangan Pernikahan</div>
    <div class="cover-names">{{ $brideNick }} &amp; {{ $groomNick }}</div>
    <div class="mono"><span>{{ $brideInitial }}{{ $groomInitial }}</span></div>
    <div class="guest">Kepada Yth.<br>Bapak/Ibu/Saudara/i<b>{{ $guestName }}</b></div>
    <button class="btn-gold" onclick="openInv()">Buka Undangan</button>
  </div>
</div>

<!-- HERO -->
<section id="hero">
  <div class="rv"><div class="hero-script">The Royal Wedding Of</div></div>
  <div class="rv"><h1 class="hero-names">{{ $brideNick }} <em>&amp;</em> {{ $groomNick }}</h1></div>
  <div class="rv"><div class="divider"><i>❖</i></div></div>
  <div class="rv"><div class="hero-date">{{ mcDate($wDate) }}</div></div>
  <div class="scroll-hint rv">Gulir ke bawah</div>
</section>

<!-- COUNTDOWN -->
<section>
  <div class="rv"><div class="sec-kicker">Menuju Hari Bahagia</div><div class="sec-title serif">Hitung Mundur</div><div class="divider"><i>❖</i></div></div>
  <div class="cd-grid rv">
    <div class="cd"><b id="cdD">0</b><span>Hari</span></div>
    <div class="cd"><b id="cdH">0</b><span>Jam</span></div>
    <div class="cd"><b id="cdM">0</b><span>Menit</span></div>
    <div class="cd"><b id="cdS">0</b><span>Detik</span></div>
  </div>
</section>

<!-- MEMPELAI -->
<section>
  <div class="rv"><div class="sec-kicker">Assalamu'alaikum Wr. Wb.</div><div class="sec-title serif">Mempelai</div><div class="divider"><i>❖</i></div></div>
  <div class="couple-card rv">
    @if($bridePhoto)<img class="photo" src="{{ $bridePhoto }}" alt="{{ $brideFull }}">@else<div class="photo-fallback">{{ $brideInitial }}</div>@endif
    <h3>{{ $brideNick }}</h3><div class="full">{{ $brideFull }}</div>
    <p>Putri dari<br>{{ mcGet('bride_parents', mcGet('bride_child_of', '')) }}</p>
  </div>
  <div class="amp rv">&amp;</div>
  <div class="couple-card rv">
    @if($groomPhoto)<img class="photo" src="{{ $groomPhoto }}" alt="{{ $groomFull }}">@else<div class="photo-fallback">{{ $groomInitial }}</div>@endif
    <h3>{{ $groomNick }}</h3><div class="full">{{ $groomFull }}</div>
    <p>Putra dari<br>{{ mcGet('groom_parents', mcGet('groom_child_of', '')) }}</p>
  </div>
</section>

<!-- ACARA -->
<section>
  <div class="rv"><div class="sec-kicker">Waktu &amp; Tempat</div><div class="sec-title serif">Rangkaian Acara</div><div class="divider"><i>❖</i></div></div>
  <div class="event rv">
    <h3>Akad Nikah</h3>
    <div class="date">{{ mcDate($wDate) }}</div>
    <div class="time">{{ $wTime }} — {{ $wTimeE }} WIB</div>
    <div class="loc">{{ mcGet('wedding_location', 'Kediaman Mempelai') }}</div>
    @if(mcGet('wedding_map_link'))<a class="btn-ghost" target="_blank" href="{{ mcGet('wedding_map_link') }}">Lihat Peta</a>@endif
  </div>
  <div class="event rv">
    <h3>Resepsi</h3>
    <div class="date">{{ mcDate($rDate) }}</div>
    <div class="time">{{ $rTimeS }} — {{ $rTimeE }} WIB</div>
    <div class="loc">{{ mcGet('reception_location', mcGet('wedding_location', 'Kediaman Mempelai')) }}</div>
    @if(mcGet('reception_map_link'))<a class="btn-ghost" target="_blank" href="{{ mcGet('reception_map_link') }}">Lihat Peta</a>@endif
  </div>
</section>

<!-- GALERI -->
@if(!empty($gallery))
<section>
  <div class="rv"><div class="sec-kicker">Momen Indah</div><div class="sec-title serif">Galeri</div><div class="divider"><i>❖</i></div></div>
  <div class="g-grid rv">
    @foreach(array_slice($gallery, 0, 8) as $img)<img src="{{ $img }}" alt="Galeri {{ $brideNick }} & {{ $groomNick }}" loading="lazy">@endforeach
  </div>
</section>
@endif

<!-- KISAH -->
@if(!empty($stories) && count($stories))
<section>
  <div class="rv"><div class="sec-kicker">Perjalanan Kami</div><div class="sec-title serif">Kisah Cinta</div><div class="divider"><i>❖</i></div></div>
  <div class="tl">
    @foreach($stories as $st)
    <div class="tl-item rv"><h4>{{ $st->title ?? 'Cerita' }}</h4><p>{{ $st->description ?? $st->content ?? '' }}</p></div>
    @endforeach
  </div>
</section>
@endif

<!-- RSVP -->
<section>
  <div class="rv"><div class="sec-kicker">Konfirmasi</div><div class="sec-title serif">RSVP</div><div class="divider"><i>❖</i></div></div>
  <form id="rsvpForm" class="rv" onsubmit="return sendRSVP(event)">
    <div class="field"><label>Nama Lengkap</label><input required name="name" placeholder="Nama Anda"></div>
    <div class="field"><label>Konfirmasi Kehadiran</label><select name="status"><option value="Hadir">Hadir, Insya Allah</option><option value="Tidak Hadir">Berhalangan</option></select></div>
    <div class="field"><label>Jumlah Tamu</label><input type="number" name="guest_count" min="1" value="1"></div>
    <button class="btn-gold" type="submit">Kirim Konfirmasi</button>
  </form>
</section>

<!-- UCAPAN -->
<section>
  <div class="rv"><div class="sec-kicker">Doa &amp; Harapan</div><div class="sec-title serif">Ucapan</div><div class="divider"><i>❖</i></div></div>
  <div id="wishList" class="rv"></div>
  <form id="wishForm" class="rv" onsubmit="return sendWish(event)" style="margin-top:22px">
    <div class="field"><label>Nama</label><input required name="name" placeholder="Nama Anda"></div>
    <div class="field"><label>Ucapan</label><textarea required name="message" rows="3" placeholder="Tulis doa terbaik Anda..."></textarea></div>
    <button class="btn-ghost" type="submit">Kirim Ucapan</button>
  </form>
</section>

<!-- GIFT -->
@if(!empty($accounts) || mcGet('gift_address'))
<section>
  <div class="rv"><div class="sec-kicker">Tanda Kasih</div><div class="sec-title serif">Hadiah</div><div class="divider"><i>❖</i></div></div>
  @foreach($accounts as $a)
  <div class="bank rv">
    <div class="bk">{{ $a['bank'] }}</div>
    <div class="no">{{ $a['no'] }}</div>
    <div class="an">a.n. {{ $a['an'] }}</div>
    <button class="btn-ghost copy" onclick="copyNo('{{ $a['no'] }}')">Salin Nomor</button>
  </div>
  @endforeach
  @if(mcGet('gift_address'))<div class="bank rv"><div class="bk">Kirim Hadiah Fisik</div><p style="font-size:14px;color:var(--cream-dim);margin-top:10px;line-height:1.7">{{ mcGet('gift_address') }}</p></div>@endif
</section>
@endif

<footer>
  <div class="rv"><div class="script">Terima kasih</div>
  <p style="color:var(--cream-dim);font-size:14px;line-height:1.8;max-width:380px;margin:14px auto">Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.</p>
  <div class="divider"><i>❖</i></div>
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
// countdown
const target = new Date("{{ $countdownISO }}").getTime();
setInterval(()=>{const d=target-Date.now();if(d<0)return;
  cdD.textContent=Math.floor(d/864e5);cdH.textContent=Math.floor(d/36e5)%24;cdM.textContent=Math.floor(d/6e4)%60;cdS.textContent=Math.floor(d/1e3)%60;},1000);
// reveal
const io=new IntersectionObserver(es=>es.forEach(e=>{if(e.isIntersecting){e.target.classList.add('on');io.unobserve(e.target)}}),{threshold:.12});
document.querySelectorAll('.rv').forEach(el=>io.observe(el));
// gold dust
const cv=document.getElementById('dust'),cx=cv.getContext('2d');let P=[];
function rs(){cv.width=innerWidth;cv.height=innerHeight}rs();addEventListener('resize',rs);
for(let i=0;i<70;i++)P.push({x:Math.random()*innerWidth,y:Math.random()*innerHeight,r:Math.random()*2+.4,s:Math.random()*.5+.15,o:Math.random()*.7+.15,ph:Math.random()*6.28});
(function loop(t){cx.clearRect(0,0,cv.width,cv.height);P.forEach(p=>{p.y-=p.s;if(p.y<-5){p.y=cv.height+5;p.x=Math.random()*cv.width}
  cx.globalAlpha=p.o*(0.6+0.4*Math.sin(t/900+p.ph));cx.fillStyle='#e8c86a';cx.beginPath();cx.arc(p.x,p.y,p.r,0,6.29);cx.fill()});
  cx.globalAlpha=1;requestAnimationFrame(loop)})(0);
// rsvp
async function sendRSVP(e){e.preventDefault();const f=e.target;
  const r=await fetch('/api/rsvp.php?inv_id='+INV_ID,{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({name:f.name.value,status:f.status.value,guest_count:f.guest_count.value})});
  alert(r.ok?'Terima kasih atas konfirmasinya!':'Gagal mengirim, coba lagi.');f.reset();return false;}
// wishes
async function loadWishes(){try{const r=await fetch('/api/ucapan.php?inv_id='+INV_ID);const d=await r.json();
  wishList.innerHTML=(d.data||d||[]).map(w=>`<div class="wish"><b>${esc(w.name)}</b><span class="st">${esc(w.status||'')}</span><p>${esc(w.message||w.ucapan||'')}</p></div>`).join('')||'<p style="color:var(--cream-dim)">Belum ada ucapan.</p>';}catch(e){}}
function esc(s){return String(s??'').replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]))}
async function sendWish(e){e.preventDefault();const f=e.target;
  const r=await fetch('/api/ucapan.php?inv_id='+INV_ID,{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({name:f.name.value,message:f.message.value})});
  if(r.ok){f.reset();loadWishes();}else alert('Gagal mengirim ucapan.');return false;}
loadWishes();
function copyNo(t){navigator.clipboard.writeText(t).then(()=>alert('Nomor tersalin!'));}
function toggleMus(){const m=document.getElementById('mus');if(m.paused){m.play();musBtn.style.opacity=1}else{m.pause();musBtn.style.opacity=.5}}
</script>
</body>
</html>
