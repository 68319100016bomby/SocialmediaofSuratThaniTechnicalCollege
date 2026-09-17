import './bootstrap';
const toast=document.querySelector('#toast');const note=t=>{if(!toast)return;toast.textContent=t;toast.classList.add('show');setTimeout(()=>toast.classList.remove('show'),1900)};
document.querySelectorAll('.open-composer').forEach(b=>b.addEventListener('click',()=>document.querySelector('#composer')?.showModal()));
document.querySelectorAll('[data-open]').forEach(b=>b.addEventListener('click',()=>document.querySelector('#'+b.dataset.open)?.showModal()));
document.querySelectorAll('[data-report]').forEach(b=>b.addEventListener('click',()=>document.querySelector('#'+b.dataset.report)?.showModal()));
document.querySelectorAll('[data-close]').forEach(b=>b.addEventListener('click',()=>b.closest('dialog')?.close()));
document.querySelectorAll('.comment-toggle').forEach(b=>b.addEventListener('click',()=>{const area=b.closest('.post')?.querySelector('.comments');area?.classList.toggle('hidden');area?.querySelector('input')?.focus()}));
document.querySelectorAll('[data-share]').forEach(b=>b.addEventListener('click',async()=>{try{await navigator.clipboard.writeText(b.dataset.share);note('คัดลอกลิงก์โพสต์แล้ว')}catch{note('พร้อมแชร์โพสต์')}}));
document.addEventListener('keydown',e=>{if((e.ctrlKey||e.metaKey)&&e.key.toLowerCase()==='k'){e.preventDefault();document.querySelector('.search input')?.focus()}if(e.key==='Escape')document.querySelectorAll('dialog[open]').forEach(d=>d.close())});
document.querySelectorAll('input[type=file]').forEach(i=>i.addEventListener('change',()=>{if(i.files[0])note('เลือกรูป '+i.files[0].name+' แล้ว')}));
const stream=document.querySelector('[data-chat]');if(stream){stream.scrollTop=stream.scrollHeight;setInterval(()=>{if(!document.querySelector('.message-form input:focus'))location.reload()},15000)}
