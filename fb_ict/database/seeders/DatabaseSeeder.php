<?php
namespace Database\Seeders;
use App\Models\{Comment,Conversation,Friendship,Group,Message,Post,Reaction,Report,User};use Illuminate\Database\Seeder;use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder{public function run():void{
 $users=collect([
  ['name'=>'ผู้ดูแลระบบ STC','email'=>'admin@stc.ac.th','student_id'=>'ADMIN001','role'=>'admin','department'=>'งานศูนย์ข้อมูลสารสนเทศ'],
  ['name'=>'ธนภัทร ใจดี','email'=>'student@stc.ac.th','student_id'=>'66309010001','role'=>'student','department'=>'ปวส. 2 เทคโนโลยีสารสนเทศ'],
  ['name'=>'อาจารย์อรทัย ศรีสุข','email'=>'teacher@stc.ac.th','student_id'=>'T0008','role'=>'teacher','department'=>'แผนกวิชาเทคโนโลยีสารสนเทศ'],
  ['name'=>'พิมพ์ชนก ชูศรี','email'=>'pim@stc.ac.th','student_id'=>'66309010008','role'=>'student','department'=>'เทคโนโลยีสารสนเทศ'],
  ['name'=>'วรเมธ รักษ์ดี','email'=>'woramet@stc.ac.th','student_id'=>'66309010012','role'=>'student','department'=>'ช่างอิเล็กทรอนิกส์'],
  ['name'=>'กิตติพงษ์ บุญช่วย','email'=>'kitti@stc.ac.th','student_id'=>'65301010014','role'=>'student','department'=>'ช่างยนต์'],
  ['name'=>'นภัสสร แสงทอง','email'=>'napat@stc.ac.th','student_id'=>'66302040006','role'=>'student','department'=>'การบัญชี'],
  ['name'=>'ชยพล ศรีสุข','email'=>'chayapon@stc.ac.th','student_id'=>'65305010021','role'=>'student','department'=>'ช่างอิเล็กทรอนิกส์'],
  ['name'=>'เจ้าหน้าที่ทะเบียน','email'=>'staff@stc.ac.th','student_id'=>'S0011','role'=>'staff','department'=>'ฝ่ายทะเบียนและวัดผล'],
 ])->map(fn($d)=>User::create($d+['password'=>Hash::make('password'),'is_active'=>true]));
 [$admin,$student,$teacher,$pim,$woramet,$kitti,$napat,$chayapon,$staff]=$users;
 foreach([[$student,$pim],[$student,$woramet],[$student,$kitti],[$teacher,$student]] as [$a,$b])Friendship::create(['requester_id'=>$a->id,'addressee_id'=>$b->id,'status'=>'accepted']);
 Friendship::create(['requester_id'=>$napat->id,'addressee_id'=>$student->id,'status'=>'pending']);Friendship::create(['requester_id'=>$chayapon->id,'addressee_id'=>$student->id,'status'=>'pending']);
 $it=Group::create(['owner_id'=>$teacher->id,'name'=>'ชมรมคอมพิวเตอร์','description'=>'พื้นที่แลกเปลี่ยนความรู้ด้านไอที การเขียนโปรแกรม และโครงงานนวัตกรรม','is_private'=>false]);$auto=Group::create(['owner_id'=>$kitti->id,'name'=>'ช่างยนต์ STC','description'=>'ข่าวสาร กิจกรรม และผลงานของแผนกวิชาช่างยนต์','is_private'=>false]);$electric=Group::create(['owner_id'=>$teacher->id,'name'=>'ช่างไฟฟ้ากำลัง','description'=>'ชุมชนคนไฟฟ้า แลกเปลี่ยนความรู้และประชาสัมพันธ์กิจกรรม','is_private'=>false]);
 $it->members()->attach([$teacher->id=>['role'=>'admin'],$student->id=>['role'=>'member'],$pim->id=>['role'=>'member'],$woramet->id=>['role'=>'member']]);$auto->members()->attach([$kitti->id=>['role'=>'admin'],$student->id=>['role'=>'member']]);$electric->members()->attach([$teacher->id=>['role'=>'admin'],$student->id=>['role'=>'member']]);
 $announcement=Post::create(['user_id'=>$admin->id,'content'=>"📣 ประกาศแจ้งนักเรียน นักศึกษาทุกระดับชั้น\nขอเชิญเข้าร่วมกิจกรรม “เปิดโลกวิชาชีพ 2026” พบกับนิทรรศการผลงานนักศึกษา การแข่งขันทักษะ และแนะแนวอาชีพจากสถานประกอบการชั้นนำ\n#STCสุราษฎร์ธานี #เปิดโลกวิชาชีพ2026 #เด็กเทคนิค",'visibility'=>'college','created_at'=>now()->subMinutes(45)]);
 $iot=Post::create(['user_id'=>$woramet->id,'group_id'=>$it->id,'content'=>"แชร์บรรยากาศ Workshop IoT วันนี้ครับ 🤖 โปรเจกต์วัดอุณหภูมิผ่านมือถือสำเร็จแล้ว! ขอบคุณ @อาจารย์อรทัย และเพื่อน ๆ ทุกคน\n#IoT #ComputerClub #STCTech",'visibility'=>'group','created_at'=>now()->subHours(2)]);
 Post::create(['user_id'=>$teacher->id,'content'=>"สัปดาห์หน้าเตรียมพบกับกิจกรรมอบรม Portfolio สำหรับนักศึกษาที่กำลังสมัครงาน อย่าลืมเตรียมผลงานมาแลกเปลี่ยนกันนะคะ 📚\n#แนะแนวอาชีพ",'visibility'=>'college','created_at'=>now()->subHours(5)]);
 Comment::create(['post_id'=>$announcement->id,'user_id'=>$pim->id,'content'=>'น่าสนใจมากค่ะ ปีนี้มีการแข่งขันออกแบบเว็บไซต์ด้วยไหมคะ?']);Comment::create(['post_id'=>$announcement->id,'user_id'=>$teacher->id,'content'=>'มีค่ะ เปิดรับสมัครที่ห้องแผนกไอทีตั้งแต่วันพรุ่งนี้']);
 foreach([$student,$pim,$woramet,$teacher,$kitti] as $i=>$u)Reaction::create(['post_id'=>$announcement->id,'user_id'=>$u->id,'type'=>$i%2?'love':'like']);Reaction::create(['post_id'=>$iot->id,'user_id'=>$student->id,'type'=>'love']);
 $chat=Conversation::create(['is_group'=>false]);$chat->users()->attach([$student->id,$pim->id]);Message::create(['conversation_id'=>$chat->id,'user_id'=>$pim->id,'body'=>'พรุ่งนี้เข้า Workshop กี่โมงนะ?','created_at'=>now()->subMinutes(18)]);Message::create(['conversation_id'=>$chat->id,'user_id'=>$student->id,'body'=>'เก้าโมงเช้า เจอกันที่ห้อง Lab 3','created_at'=>now()->subMinutes(15)]);Message::create(['conversation_id'=>$chat->id,'user_id'=>$pim->id,'body'=>'โอเค ขอบคุณมาก 😊','created_at'=>now()->subMinutes(12)]);
 $reported=Post::create(['user_id'=>$chayapon->id,'content'=>'โพสต์ตัวอย่างสำหรับทดสอบระบบรายงานเนื้อหา #ทดสอบ','visibility'=>'college']);Report::create(['reporter_id'=>$pim->id,'reportable_type'=>Post::class,'reportable_id'=>$reported->id,'reason'=>'other','details'=>'รายงานตัวอย่างสำหรับทดสอบหน้า Moderation','status'=>'pending']);
}}
