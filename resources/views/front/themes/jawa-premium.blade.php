<?php
/* ============================================================
   TEMA PREMIUM: JAWA KLASIK
   Dipilih via settings: theme = jawa-premium
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
<title>{{ $brideNick }} &amp; {{ $groomNick }} — Undangan Jawa Klasik</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Pinyon+Script&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
<style>
:root{--soga:#241009;--soga2:#3a1c0e;--prada:#d4af37;--prada-lt:#f2d67c;--gading:#f5ead6;--gading-dim:rgba(245,234,214,.7)}
*{margin:0;padding:0;box-sizing:border-box;-webkit-tap-highlight-color:transparent}
html{scroll-behavior:smooth}
body{font-family:'Jost',sans-serif;background:var(--soga);color:var(--gading);overflow-x:hidden;font-weight:300}
/* pola kawung */
body::before{content:'';position:fixed;inset:0;z-index:0;pointer-events:none;opacity:.5;
  background-image:radial-gradient(circle at 50% 50%,transparent 34px,rgba(212,175,55,.10) 35px,rgba(212,175,55,.10) 37px,transparent 38px);
  background-size:96px 96px}
#petal{position:fixed;inset:0;z-index:1;pointer-events:none}
.wrap{position:relative;z-index:2;max-width:520px;margin:0 auto}
.serif{font-family:'Cormorant Garamond',serif}.aksara{font-family:'Pinyon Script',cursive}
#cover{position:fixed;inset:0;z-index:100;background:radial-gradient(ellipse at 50% 25%,#4a2410 0%,#241009 70%);display:flex;align-items:center;justify-content:center;transition:opacity .9s,visibility .9s}
#cover.open{opacity:0;visibility:hidden}
.cover-card{text-align:center;padding:40px 30px;margin:24px;max-width:420px;border:2px solid var(--prada);position:relative;background:rgba(36,16,9,.6)}
.cover-card::before{content:'';position:absolute;inset:8px;border:1px solid rgba(212,175,55,.45);pointer-events:none}
.gunungan{width:120px;margin:0 auto 10px;display:block;filter:drop-shadow(0 0 12px rgba(212,175,55,.5))}
.kicker{font-size:11px;letter-spacing:.4em;text-transform:uppercase;color:var(--prada)}
.cover-names{font-family:'Pinyon Script',cursive;font-size:54px;color:var(--gading);margin:12px 0;line-height:1.15}
.btn{display:inline-block;margin-top:22px;padding:14px 40px;background:linear-gradient(135deg,var(--prada-lt),var(--prada));color:#2a1408;font-size:12px;letter-spacing:.3em;text-transform:uppercase;cursor:pointer;border:none;transition:.35s;font-family:'Jost';font-weight:500}
.btn:hover{box-shadow:0 0 28px rgba(212,175,55,.6);transform:translateY(-2px)}
.btn-line{display:inline-block;padding:12px 32px;border:1px solid var(--prada);color:var(--prada-lt);font-size:12px;letter-spacing:.26em;text-transform:uppercase;cursor:pointer;background:transparent;transition:.3s;text-decoration:none;font-family:'Jost'}
.btn-line:hover{background:rgba(212,175,55,.14)}
.guest{margin-top:18px;font-size:13px;color:var(--gading-dim)}
.guest b{display:block;font-family:'Cormorant Garamond',serif;font-size:23px;color:var(--gading);margin-top:6px}
section{padding:70px 26px;text-align:center;position:relative}
.sec-kicker{font-size:11px;letter-spacing:.4em;text-transform:uppercase;color:var(--prada);margin-bottom:10px}
.sec-title{font-family:'Cormorant Garamond',serif;font-size:38px;font-weight:600}
.ukel{display:flex;align-items:center;justify-content:center;gap:10px;margin:16px auto;max-width:300px;color:var(--prada)}
.ukel::before,.ukel::after{content:'';height:1px;flex:1;background:linear-gradient(90deg,transparent,var(--prada))}
.ukel::after{background:linear-gradient(90deg,var(--prada),transparent)}
#hero{min-height:94vh;display:flex;flex-direction:column;justify-content:center;background:radial-gradient(ellipse at 50% 0%,#4a2410 0%,transparent 62%)}
.hero-script{font-family:'Pinyon Script',cursive;font-size:32px;color:var(--prada-lt)}
.hero-names{font-family:'Cormorant Garamond',serif;font-size:54px;line-height:1.08;margin:14px 0;font-weight:700}
.hero-names em{font-family:'Pinyon Script',cursive;font-weight:400;color:var(--prada-lt);font-size:42px}
.hero-date{letter-spacing:.32em;font-size:13px;color:var(--gading-dim);text-transform:uppercase}
.cd-grid{display:flex;justify-content:center;gap:10px;margin-top:26px}
.cd{width:72px;padding:16px 0;background:rgba(212,175,55,.07);border:1px solid rgba(212,175,55,.45)}
.cd b{display:block;font-family:'Cormorant Garamond',serif;font-size:34px;color:var(--prada-lt)}
.cd span{font-size:10px;letter-spacing:.28em;text-transform:uppercase;color:var(--gading-dim)}
.couple-card{border:1px solid rgba(212,175,55,.4);background:linear-gradient(180deg,rgba(212,175,55,.08),transparent);padding:34px 22px;margin:0 auto 20px;max-width:380px}
.photo{width:148px;height:148px;border-radius:50%;object-fit:cover;margin:0 auto 16px;border:2px solid var(--prada);padding:5px;display:block}
.photo-fallback{width:148px;height:148px;border-radius:50%;margin:0 auto 16px;border:2px solid var(--prada);display:flex;align-items:center;justify-content:center;font-family:'Cormorant Garamond',serif;font-size:62px;color:var(--prada-lt);background:radial-gradient(circle,#3a1c0e,#241009)}
.couple-card h3{font-family:'Pinyon Script',cursive;font-size:40px;color:var(--prada-lt);font-weight:400}
.couple-card .full{font-family:'Cormorant Garamond',serif;font-size:19px;margin:6px 0}
.couple-card p{font-size:14px;color:var(--gading-dim);line-height:1.7}
.amp{font-family:'Pinyon Script',cursive;font-size:52px;color:var(--prada);margin:4px 0}
.event{border:1px solid rgba(212,175,55,.4);padding:36px 24px;margin:0 auto 20px;max-width:400px;background:rgba(36,16,9,.55);position:relative}
.event::before{content:'';position:absolute;inset:8px;border:1px solid rgba(212,175,55,.22);pointer-events:none}
.event h3{font-family:'Cormorant Garamond',serif;font-size:28px;letter-spacing:.14em;text-transform:uppercase;color:var(--prada-lt)}
.event .date{font-family:'Cormorant Garamond',serif;font-size:20px;margin:12px 0 4px}
.event .time{letter-spacing:.24em;font-size:13px;color:var(--prada)}
.event .loc{font-size:14px;color:var(--gading-dim);margin:12px 0 18px;line-height:1.7}
.g-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:24px}
.g-grid img{width:100%;height:190px;object-fit:cover;border:1px solid rgba(212,175,55,.4);transition:.4s}
.g-grid img:hover{transform:scale(1.03)}
.tl{max-width:400px;margin:26px auto 0;text-align:left;padding-left:26px;position:relative}
.tl::before{content:'';position:absolute;left:8px;top:6px;bottom:6px;width:1px;background:linear-gradient(var(--prada),transparent)}
.tl-item{position:relative;padding:0 0 28px 18px}
.tl-item::before{content:'❋';position:absolute;left:-26px;top:-2px;color:var(--prada)}
.tl-item h4{font-family:'Cormorant Garamond',serif;font-size:22px;color:var(--prada-lt)}
.tl-item p{font-size:14px;color:var(--gading-dim);line-height:1.7;margin-top:6px}
.field{margin:0 auto 14px;max-width:380px;text-align:left}
.field label{display:block;font-size:10px;letter-spacing:.32em;text-transform:uppercase;color:var(--prada);margin-bottom:8px}
.field input,.field select,.field textarea{width:100%;background:rgba(245,234,214,.05);border:1px solid rgba(212,175,55,.45);color:var(--gading);padding:13px 14px;font-family:'Jost';font-size:15px;outline:none}
.field input:focus,.field select:focus,.field textarea:focus{border-color:var(--prada)}
.field select option{color:#222}
.wish{border-left:2px solid var(--prada);background:rgba(212,175,55,.06);padding:14px 16px;margin:0 auto 12px;max-width:400px;text-align:left}
.wish b{font-family:'Cormorant Garamond',serif;color:var(--prada-lt);font-size:17px}
.wish .st{font-size:10px;letter-spacing:.2em;color:var(--prada);text-transform:uppercase;margin-left:8px}
.wish p{font-size:14px;color:var(--gading-dim);margin-top:6px;line-height:1.6}
.bank{border:1px solid rgba(212,175,55,.45);padding:22px;margin:0 auto 14px;max-width:380px;background:rgba(212,175,55,.05)}
.bank .bk{font-size:11px;letter-spacing:.34em;color:var(--prada);text-transform:uppercase}
.bank .no{font-family:'Cormorant Garamond',serif;font-size:30px;letter-spacing:.06em;margin:10px 0 4px}
.bank .an{font-size:14px;color:var(--gading-dim)}
.copy{margin-top:12px}
footer{padding:60px 26px 90px;text-align:center}
footer .aksara{font-size:42px;color:var(--prada-lt)}
#musBtn{position:fixed;bottom:22px;right:22px;z-index:90;width:52px;height:52px;border-radius:50%;border:1px solid var(--prada);background:rgba(36,16,9,.9);color:var(--prada-lt);font-size:20px;cursor:pointer;display:flex;align-items:center;justify-content:center}
.rv{opacity:0;transform:translateY(36px);transition:opacity .9s,transform .9s}
.rv.on{opacity:1;transform:none}
@media(min-width:640px){.hero-names{font-size:66px}}
</style>
</head>
<body>
<canvas id="petal"></canvas>
<div class="wrap">

<div id="cover">
  <div class="cover-card">
    <svg class="gunungan" viewBox="0 0 100 130"><path d="M50 4 C78 30 92 62 92 96 L92 126 L8 126 L8 96 C8 62 22 30 50 4 Z" fill="none" stroke="#d4af37" stroke-width="2.5"/><path d="M50 22 C68 42 78 64 78 92 L78 118 L22 118 L22 92 C22 64 32 42 50 22 Z" fill="none" stroke="#d4af37" stroke-width="1.2" opacity=".7"/><circle cx="50" cy="70" r="7" fill="none" stroke="#d4af37" stroke-width="1.5"/><path d="M50 40 L50 100 M32 60 L68 60 M28 82 L72 82" stroke="#d4af37" stroke-width="1" opacity=".6"/></svg>
    <div class="kicker">Sugeng Rawuh</div>
    <div class="cover-names">{{ $brideNick }} &amp; {{ $groomNick }}</div>
    <div class="guest">Dhumateng Panjenengan<br>Bapak/Ibu/Sedherek<b>{{ $guestName }}</b></div>
    <button class="btn" onclick="openInv()">Buka Undangan</button>
  </div>
</div>

<section id="hero">
  <div class="rv"><div class="hero-script">Pawiwahan</div></div>
  <div class="rv"><h1 class="hero-names">{{ $brideNick }} <em>&amp;</em> {{ $groomNick }}</h1></div>
  <div class="rv"><div class="ukel">❋</div></div>
  <div class="rv"><div class="hero-date">{{ mcDate($wDate) }}</div></div>
</section>

<section>
  <div class="rv"><div class="sec-kicker">Dinten Bahagia</div><div class="sec-title serif">Hitung Mundur</div><div class="ukel">❋</div></div>
  <div class="cd-grid rv">
    <div class="cd"><b id="cdD">0</b><span>Dinten</span></div>
    <div class="cd"><b id="cdH">0</b><span>Jam</span></div>
    <div class="cd"><b id="cdM">0</b><span>Menit</span></div>
    <div class="cd"><b id="cdS">0</b><span>Detik</span></div>
  </div>
</section>

<section>
  <div class="rv"><div class="sec-kicker">Sugeng Rawuh</div><div class="sec-title serif">Mempelai</div><div class="ukel">❋</div></div>
  <div class="couple-card rv">
    @if($bridePhoto)<img class="photo" src="{{ $bridePhoto }}" alt="{{ $brideFull }}">@else<div class="photo-fallback">{{ $brideInitial }}</div>@endif
    <h3>{{ $brideNick }}</h3><div class="full">{{ $brideFull }}</div>
    <p>Putri saking<br>{{ mcGet('bride_parents', mcGet('bride_child_of', '')) }}</p>
  </div>
  <div class="amp rv">&amp;</div>
  <div class="couple-card rv">
    @if($groomPhoto)<img class="photo" src="{{ $groomPhoto }}" alt="{{ $groomFull }}">@else<div class="photo-fallback">{{ $groomInitial }}</div>@endif
    <h3>{{ $groomNick }}</h3><div class="full">{{ $groomFull }}</div>
    <p>Putra saking<br>{{ mcGet('groom_parents', mcGet('groom_child_of', '')) }}</p>
  </div>
</section>

<section>
  <div class="rv"><div class="sec-kicker">Wanci &amp; Papan</div><div class="sec-title serif">Acara</div><div class="ukel">❋</div></div>
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
  <div class="rv"><div class="sec-kicker">Momen</div><div class="sec-title serif">Galeri</div><div class="ukel">❋</div></div>
  <div class="g-grid rv">
    @foreach(array_slice($gallery, 0, 8) as $img)<img src="{{ $img }}" alt="Galeri" loading="lazy">@endforeach
  </div>
</section>
@endif

@if(!empty($stories) && count($stories))
<section>
  <div class="rv"><div class="sec-kicker">Lampah Katresnan</div><div class="sec-title serif">Kisah Kami</div><div class="ukel">❋</div></div>
  <div class="tl">
    @foreach($stories as $st)
    <div class="tl-item rv"><h4>{{ $st->title ?? 'Cerita' }}</h4><p>{{ $st->description ?? $st->content ?? '' }}</p></div>
    @endforeach
  </div>
</section>
@endif

<section>
  <div class="rv"><div class="sec-kicker">Konfirmasi</div><div class="sec-title serif">RSVP</div><div class="ukel">❋</div></div>
  <form id="rsvpForm" class="rv" onsubmit="return sendRSVP(event)">
    <div class="field"><label>Nama Lengkap</label><input required name="name" placeholder="Nama Anda"></div>
    <div class="field"><label>Kehadiran</label><select name="status"><option value="Hadir">Hadir</option><option value="Tidak Hadir">Berhalangan</option></select></div>
    <div class="field"><label>Jumlah Tamu</label><input type="number" name="guest_count" min="1" value="1"></div>
    <button class="btn" type="submit">Kirim Konfirmasi</button>
  </form>
</section>

<section>
  <div class="rv"><div class="sec-kicker">Donga Pangestu</div><div class="sec-title serif">Ucapan</div><div class="ukel">❋</div></div>
  <div id="wishList" class="rv"></div>
  <form id="wishForm" class="rv" onsubmit="return sendWish(event)" style="margin-top:22px">
    <div class="field"><label>Nama</label><input required name="name" placeholder="Nama Anda"></div>
    <div class="field"><label>Ucapan</label><textarea required name="message" rows="3" placeholder="Tulis doa terbaik..."></textarea></div>
    <button class="btn-line" type="submit">Kirim Ucapan</button>
  </form>
</section>

@if(!empty($accounts) || mcGet('gift_address'))
<section>
  <div class="rv"><div class="sec-kicker">Tanda Asih</div><div class="sec-title serif">Hadiah</div><div class="ukel">❋</div></div>
  @foreach($accounts as $a)
  <div class="bank rv"><div class="bk">{{ $a['bank'] }}</div><div class="no">{{ $a['no'] }}</div><div class="an">a.n. {{ $a['an'] }}</div>
  <button class="btn-line copy" onclick="copyNo('{{ $a['no'] }}')">Salin Nomor</button></div>
  @endforeach
  @if(mcGet('gift_address'))<div class="bank rv"><div class="bk">Hadiah Fisik</div><p style="font-size:14px;color:var(--gading-dim);margin-top:10px;line-height:1.7">{{ mcGet('gift_address') }}</p></div>@endif
</section>
@endif

<footer>
  <div class="rv"><div class="aksara">Matur Nuwun</div>
  <p style="color:var(--gading-dim);font-size:14px;line-height:1.8;max-width:380px;margin:14px auto">Matur nuwun sanget awit rawuh saha donga pangestu panjenengan. Mugi dados berkah tumrap kita sedaya.</p>
  <div class="ukel">❋</div>
  <div class="serif" style="font-size:22px;color:var(--prada-lt)">{{ $brideNick }} &amp; {{ $groomNick }}</div></div>
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
// kelopak melati
const cv=document.getElementById('petal'),cx=cv.getContext('2d');let P=[];
function rs(){cv.width=innerWidth;cv.height=innerHeight}rs();addEventListener('resize',rs);
for(let i=0;i<36;i++)P.push({x:Math.random()*innerWidth,y:Math.random()*-innerHeight,r:Math.random()*4+2,s:Math.random()*.8+.3,ph:Math.random()*6.28,sw:Math.random()*1.4+.4});
(function loop(t){cx.clearRect(0,0,cv.width,cv.height);P.forEach(p=>{p.y+=p.s;p.x+=Math.sin(t/1400+p.ph)*p.sw*.4;
  if(p.y>cv.height+8){p.y=-8;p.x=Math.random()*cv.width}
  cx.save();cx.translate(p.x,p.y);cx.rotate(Math.sin(t/900+p.ph)*.6);cx.globalAlpha=.5;cx.fillStyle='#f5ead6';
  cx.beginPath();cx.ellipse(0,0,p.r,p.r*.55,0,0,6.29);cx.fill();cx.restore()});requestAnimationFrame(loop)})(0);
async function sendRSVP(e){e.preventDefault();const f=e.target;
  const r=await fetch('/api/rsvp.php?inv_id='+INV_ID,{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({name:f.name.value,status:f.status.value,guest_count:f.guest_count.value})});
  alert(r.ok?'Matur nuwun konfirmasinipun!':'Gagal, coba lagi.');f.reset();return false;}
async function loadWishes(){try{const r=await fetch('/api/ucapan.php?inv_id='+INV_ID);const d=await r.json();
  wishList.innerHTML=(d.data||d||[]).map(w=>`<div class="wish"><b>${esc(w.name)}</b><span class="st">${esc(w.status||'')}</span><p>${esc(w.message||w.ucapan||'')}</p></div>`).join('')||'<p style="color:var(--gading-dim)">Dereng wonten ucapan.</p>';}catch(e){}}
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
