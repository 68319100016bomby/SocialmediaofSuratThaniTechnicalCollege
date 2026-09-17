# STC Connect — College Social Network System

ระบบสังคมออนไลน์ภายในวิทยาลัยเทคนิคสุราษฎร์ธานี พัฒนาด้วย Laravel 12 และรองรับ MySQL

## ความสามารถ

- สมัครสมาชิก เข้าสู่ระบบ ออกจากระบบ และแบ่งสิทธิ์ Student/Teacher/Staff/Admin
- Feed และระดับการมองเห็นโพสต์ พร้อมอัปโหลดรูปภาพ
- Reaction, Comment, Hashtag และ Mention
- คำขอเป็นเพื่อน รายชื่อเพื่อน และเริ่มบทสนทนา
- Community/Group แบบสาธารณะและส่วนตัว
- Messenger พร้อมรีเฟรชข้อความอัตโนมัติ
- ค้นหาสมาชิก โพสต์ กลุ่ม และแฮชแท็ก
- Report, Moderation, ระงับสมาชิก และ Dashboard ผู้ดูแล
- Responsive UI สำหรับคอมพิวเตอร์ แท็บเล็ต และโทรศัพท์

## ติดตั้งด้วย MySQL

1. สร้างฐานข้อมูลชื่อ `stc_social`
2. คัดลอก `.env.example` เป็น `.env` และแก้ `DB_USERNAME` / `DB_PASSWORD`
3. รัน `composer install`
4. รัน `php artisan key:generate`
5. รัน `php artisan migrate --seed`
6. รัน `php artisan storage:link`
7. รัน `npm install` และ `npm run build`
8. รัน `php artisan serve`

## บัญชีทดลอง

- นักศึกษา: `student@stc.ac.th`
- ครู: `teacher@stc.ac.th`
- ผู้ดูแล: `admin@stc.ac.th`
- รหัสผ่านทุกบัญชี: `password`

โหมดพัฒนาใน workspace ใช้ SQLite เพื่อเปิดทดสอบได้ทันที ส่วน `.env.example` กำหนดค่า MySQL สำหรับการนำไปติดตั้งใช้งานจริง
