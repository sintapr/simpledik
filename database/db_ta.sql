/*
SQLyog Professional v13.1.1 (64 bit)
MySQL - 10.4.32-MariaDB : Database - db_ta
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_ta` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `db_ta`;

/*Table structure for table `absensi` */

DROP TABLE IF EXISTS `absensi`;

CREATE TABLE `absensi` (
  `id_absensi` varchar(8) NOT NULL,
  `NIS` varchar(8) NOT NULL,
  `id_kelas` varchar(8) NOT NULL,
  `tanggal` date NOT NULL,
  `STATUS` enum('Hadir','Sakit','Izin','Alpa') NOT NULL,
  `id_ta` varchar(8) NOT NULL,
  PRIMARY KEY (`id_absensi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `absensi` */

insert  into `absensi`(`id_absensi`,`NIS`,`id_kelas`,`tanggal`,`STATUS`,`id_ta`) values 
('AB001','1111','K001','2025-04-14','Hadir','TA001');

/*Table structure for table `anggota_kelas` */

DROP TABLE IF EXISTS `anggota_kelas`;

CREATE TABLE `anggota_kelas` (
  `id_anggota` varchar(8) NOT NULL,
  `NIS` varchar(8) NOT NULL,
  `id_wakel` varchar(12) NOT NULL,
  PRIMARY KEY (`id_anggota`),
  KEY `NIS` (`NIS`),
  KEY `id_wakel` (`id_wakel`),
  CONSTRAINT `anggota_kelas_ibfk_1` FOREIGN KEY (`NIS`) REFERENCES `siswa` (`NIS`),
  CONSTRAINT `anggota_kelas_ibfk_2` FOREIGN KEY (`id_wakel`) REFERENCES `wali_kelas` (`id_wakel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `anggota_kelas` */

insert  into `anggota_kelas`(`id_anggota`,`NIS`,`id_wakel`) values 
('AG00003','0001','WK001'),
('AG00005','1111','WK001'),
('AG00006','0002','WK002'),
('AG00007','0003','WK002'),
('AG00008','0004','WK002'),
('AG00009','0003','WK004'),
('AG00010','0004','WK004'),
('AG00011','0001','WK002'),
('AG00012','1111','WK002'),
('AG00013','1111','WK005'),
('AG00014','9081','WK002'),
('AG00015','SW002','WK006');

/*Table structure for table `assesment` */

DROP TABLE IF EXISTS `assesment`;

CREATE TABLE `assesment` (
  `id_assesment` varchar(8) NOT NULL,
  `NIS` varchar(8) NOT NULL,
  `id_tp` varchar(8) NOT NULL,
  `sudah_muncul` tinyint(1) DEFAULT NULL,
  `konteks` text DEFAULT NULL,
  `tempat_waktu` text NOT NULL,
  `kejadian_teramati` text NOT NULL,
  `minggu` varchar(12) NOT NULL,
  `bulan` varchar(12) NOT NULL,
  `tahun` year(4) NOT NULL,
  `semester` tinyint(4) NOT NULL,
  PRIMARY KEY (`id_assesment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `assesment` */

insert  into `assesment`(`id_assesment`,`NIS`,`id_tp`,`sudah_muncul`,`konteks`,`tempat_waktu`,`kejadian_teramati`,`minggu`,`bulan`,`tahun`,`semester`) values 
('AS001','1111','TP001',1,'Membilang angka maupun benda berdasarkan berdsarkan warna / bentuk.','Dikelas saat kegiatan berlangsung','Ananda Fiona sudah bisa membilang angka atau  lebih dari sepuluh','3','1',2023,1),
('AS002','1111','TP002',1,'Anak mampu menyebutkan suku kata awal pe misal Pelangi, pedal, pesawat.','Dikelas saat kegiatan berlangsung.','Ananda dengan cepat dan mengacungkan tangan menjawabnya.','3','1',2023,1),
('AS003','1111','TP003',1,'Anak mampu menghafal Asmaul Husna.','Di depan kelas saat sholat dhuha Bersama.','Anak tertib dan semangat dalam menghafal asmaul husna.','3','1',2023,1),
('AS004','1111','TP004',1,'Anak mampu mengelola emosi diri baik saat bermain maupuan belajar.','Di depan kelas, saat bermain dengan teman temannya.','Adam saat bermain selalu menanggapi teman bestinya dengan baik.','3','1',2023,1),
('AS005','9081','TP001',1,'Membilang angka maupun benda berdasarkan berdsarkan warna / bentuk.','Di depan kelas saat sholat dhuha Bersama.','Ananda adam sudah bisa membilang angka atau  lebih dari sepuluh.','3','1',2023,1);

/*Table structure for table `detail_nilai_cp` */

DROP TABLE IF EXISTS `detail_nilai_cp`;

CREATE TABLE `detail_nilai_cp` (
  `id_detail_nilai_cp` varchar(8) NOT NULL,
  `id_rapor` varchar(8) NOT NULL,
  `id_penilaian_cp` varchar(8) NOT NULL,
  `nilai` text NOT NULL,
  `foto` varchar(255) NOT NULL,
  PRIMARY KEY (`id_detail_nilai_cp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `detail_nilai_cp` */

insert  into `detail_nilai_cp`(`id_detail_nilai_cp`,`id_rapor`,`id_penilaian_cp`,`nilai`,`foto`) values 
('DCP001','R1-003','PC001','Alhamdulilah di semester ini  akmal dapat mengenal ajaran agama islam dengan mengikuti kegiatan praktek Gerakan sholat, dari takbiratul ihram sampai salam dengan tertib serta sudah menghafal  hafal bacaan sholat seperti bacaan rukuk, sujud, I’tidal duduk diantara dua sujud.','foto_cp/BtCUUnsuBp9kBOOHfxYhUPHYxSLjZGOAM8x6ICgr.png'),
('DCP002','R1-003','PC002','Alhamdulilah akmal dapat menjaga kebersihan lingkungan, seperti membuang sampah pada tempatnya, cuci tangan sebelum makan, dan menggosok gigi dengan odol.','foto_cp/QPO0W8VutC1d0LZ44jE7uhXRIAvF61e9sxfUO3O0.png'),
('DCP003','R1-003','PC003','Alhamdulilah dalam kegiatan sehari hari Akmal dapat mengahafal surat surat pendek, doa  sehari hari, asmaul husna, dan hadist dengan lancar.','foto_cp/kmC2KXK1VZVbeFi6CFDJVgQoZ5RAWiMRka8d1WCm.png'),
('DCP004','R1-003','PC004','Akmal juga menunjukkan adab yang baik yaitu dengan menggunakan tangan kanan saat makan snack dan duduk manis di karpet maupun di kursi. Akmal sudah terbiasa mengucapkan permisi tolong, serta mau minta maaf. insyaaAllah Guru akan membimbing  akmal untuk selalu bersyukur, menambah hafalan surat pendek dan mempraktekan doa sehari hari. Misal doa masuk masjid masuk dengan kaki kanan dan lain lain. Ayah bunda dirumah juga dapat membantu Akmal untuk melanjutkan dan mempraktekkan prilaku baik yang telah dilaksanakan disekolah.','foto_cp/dZdrXAUN0Twq49jOJcISrgE1zCZBuRZ6Lm7C2v0a.png'),
('DCP005','R1-003','PC005','Alhamdulilah disemseter 1 ini Akmal menunjukkan sikap positif dan berpartisipasi aktif dalam kegiatan fisik. Akmal terlihat antusias Ketika mengikuti senam Bersama pada hari jumat, Akmal juga bisa memanjat dipapan pelangi, bergelantung di kandang majemuk, bermain dengan permainan out door seperti ayunan, perosotan, papan titian.','foto_cp/aBWuaCf59YhdcpAKLUcO0r1Mu8g3OFHkmax3X1Jh.png'),
('DCP006','R1-003','PC006','Akmal juga memiliki prilaku positif terhadap lingkungan yaitu mampu bermain dan bekerja sama membuat kendang binatang ternak, rumah dan sekolah dengan media balok. Akmal sangat senang dengan kegiatan bermain lego  ( dibentuk senapan)Bersama teman dikelas. Akmal jua mau membereskan mainan dan mengembalikan ke tempatnya.','foto_cp/mu4MDgpnQHBYjlLdVQcbz3HGDdfzHB8JJ3QLfDMs.png'),
('DCP007','R1-003','PC007','Akmal juga mau mengkonsumsi makan makanan  yang sehat, seperti buah melon,  jajan pasar, makan taman gizi dan berbagi makanan dengan temannya.','foto_cp/I8g20yqEfCxrC7aDu8ySwufJBwrjnQthqoOwExnX.png'),
('DCP008','R1-003','PC008','Akmal sudah bisa mengenali emosi diri dan orang lain dengan baik, serta mau mentaati aturan kelas.    Ayah bunda dirumah dapat terus mempertahankan pembiasaan baik yang telah di lakukan anak  di sekolah.','foto_cp/brR7M7ZJLzxXlZWP6OeGxnO4ADR5jLALxI6mPdOe.png'),
('DCP009','R1-003','PC009','Alhamdulilah di semester 1 ini,  akmal sudah bisa memahami berbagai informasi seperti, menyimak guru membaca buku cerita, menceritakan Kembali isi buku tersebut . Akmal juga aktif dikelas, dan mau meniru serta menjawab  dengan Bahasa jawa, misal mas Akmal sakniki hari nopo? Ananda “menjawab :  “ jumat bu Guru”.   Akmal sudah hafal dengan huruf dan angka, baik vocal atau konsonan maka Akmal dengan mudah  menyelesaikan kegiatan pembelajaran   seperti menulis kata dan angka, meniru beberapa kata  dengan media manik manik. Misalnya kata air dan api ( seperti yang terlihat di foto).','foto_cp/iOKW6TLmVOnptJIWwNnRV7aYTf1meB7whUxbsYXQ.png'),
('DCP010','R1-003','PC010','Akmal juga dengan cepat menghitung angka dari satu sampai sepuluh menggunakan jari  atau benda, mengenal ukuran, mengelompokkan benda berdasarkan warna serta mengenal penjumlahan dan pengurangan.','foto_cp/srgpEhjcUcIJFwpKj2GPERlYRfDwe78K9x4QZt7x.png'),
('DCP011','R1-003','PC011','Akmal bisa berkreasi dengan berbagai media atau bahan alam. Ketika bermain akmal mampu mengekspresikan imajinasinya menjadi karya menggunakan material yang ada di sekitarnya. Hal ini terlihat Ketika membuat kreasi dari bahan alam seperti, daun Nangka, batang daun ketela, biji bijian, stik eskrim, dan batang korek api.','foto_cp/Lu8NruJG83Zzp4avFMFMh85DZGq2dgwlYHSZl0lH.png'),
('DCP012','R1-003','PC012','Akmal juga menunjukkan rasa ingin tahu melalui ekplorasi, dan eksperimen menggunakan bahan disekitarnya, ananda melakukan percobaan sederhana membuat makanan dari ubi jalar menjadi bola bola ubi dengan rasa coklat, mau mencicipinya. Akmal juga bisa menyebutkan rasa bola bola ubi yang di makannya.','foto_cp/5NYK96ubIdepUB5cfQ3CqhS4nXcnk2i7JDGWolVn.png'),
('DCP013','R1-003','PC013','Akmal  bisa  meronce manik manik menjadi kalung, membuat topeng harimau, meniru menulis beberapa kata dan replika binatang jerapah ( seperti yang terlihat di foto).','foto_cp/UGnplaEo55H7XkhS1R0sCLa215tI8Qv0bSthDlT8.png'),
('DCP014','R1-003','PC014','Di semester II insyaAllah Guru akan membantu akmal untuk bereksplorasi dengan berbagai benda lose part dan bahan lain yang dapat di temukan dengan mudah untuk dapat menghasilkan karya sesuai dengan minatnya.   Ayah bunda dapat membantu akmal untuk menunjukkan minat, kegemaran dan partisipasi dalam kegiatan membacakan buku dirumah.','foto_cp/2Ttqii3jZGhzQSH5RTaZ2z8nwJZAV7OwMGEa266G.png'),
('DCP015','R1-004','PC001','Alhamdulilah di semester ini  akmal dapat mengenal ajaran agama islam dengan mengikuti kegiatan praktek Gerakan sholat, dari takbiratul ihram sampai salam dengan tertib serta sudah menghafal  hafal bacaan sholat seperti bacaan rukuk, sujud, I’tidal duduk diantara dua sujud.','foto_cp/eJAdCC7DU5Jy8sjwm5phoIGElX8n5dyKJHTEFgcP.png'),
('DCP016','R1-004','PC006','Akmal juga memiliki prilaku positif terhadap lingkungan yaitu mampu bermain dan bekerja sama membuat kendang binatang ternak, rumah dan sekolah dengan media balok. Akmal sangat senang dengan kegiatan bermain lego  ( dibentuk senapan)Bersama teman dikelas. Akmal jua mau membereskan mainan dan mengembalikan ke tempatnya.','foto_cp/A3rvfzlCcqLOdxd5L2uABsEFMxp2vhOGxWXgf8OY.png'),
('DCP017','R1-004','PC011','Alhamdulilah dalam kegiatan sehari hari Akmal dapat mengahafal surat surat pendek, doa  sehari hari, asmaul husna, dan hadist dengan lancar.','foto_cp/PYK6gMcQANaTyexz7FnAGZzhhX3VgUmtoZ0dq5H7.png');

/*Table structure for table `detail_nilai_hafalan` */

DROP TABLE IF EXISTS `detail_nilai_hafalan`;

CREATE TABLE `detail_nilai_hafalan` (
  `id_detail_nilai_hafalan` varchar(8) NOT NULL,
  `id_rapor` varchar(8) NOT NULL,
  `id_surat` varchar(8) NOT NULL,
  `nilai` enum('Mumtaz','Jayyid Jiddan','Jayyid','Maqbul') NOT NULL,
  PRIMARY KEY (`id_detail_nilai_hafalan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `detail_nilai_hafalan` */

insert  into `detail_nilai_hafalan`(`id_detail_nilai_hafalan`,`id_rapor`,`id_surat`,`nilai`) values 
('DHT001','R1-003','H001','Mumtaz'),
('DHT002','R1-004','H001','Mumtaz');

/*Table structure for table `detail_nilai_p5` */

DROP TABLE IF EXISTS `detail_nilai_p5`;

CREATE TABLE `detail_nilai_p5` (
  `id_detail_nilai_p5` varchar(8) NOT NULL,
  `id_rapor` varchar(8) NOT NULL,
  `id_perkembangan` varchar(8) NOT NULL,
  `nilai` text NOT NULL,
  `foto` varchar(255) NOT NULL,
  PRIMARY KEY (`id_detail_nilai_p5`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `detail_nilai_p5` */

insert  into `detail_nilai_p5`(`id_detail_nilai_p5`,`id_rapor`,`id_perkembangan`,`nilai`,`foto`) values 
('DNP001','R1-003','P006','Mengenal hak dan tanggung jawabnya dirumah dan di sekolah, serta kaitannya dengan keimanan kepada Tuhan YME ( Dimensi beriman bertaqwa kepada Tuhan YME dan berakhlak mulia, elemen : akhlak bernegara)','1748250037.png'),
('DNP002','R1-003','P006','Menunjukkan kesadaran untuk menerima teman yang berbeda latar belakang dalam beberapa situasi ( Dinensi Berkebinekaan Global, elemen : refleksi dan tanggung jawab terhadap pengalaman kebinekaan)','1748250055.png'),
('DNP003','R1-003','P006','Terbiasa bekerja bersama dalam melakukan kegiatan kelompok (melibatkan dua orang atau lebih) (dimensi : gotong-royong, elemen : kolaborasi)','1748250072.png'),
('DNP004','R1-003','P006','Mengenali kemampuan dan minat/kesukaan diri serta menerima keberadaan dan keunikan sendiri ( Dimensi : Mandiri, elemen : pemahaman diri dan situasi yang dihadapi)','1748250104.png'),
('DNP005','R1-003','P006','Menyampaikan apa yang dipikirkan dengan singkat (Dimensi : bernalar kritis, Elemen : Refleksi pemikiran dan proses berfikir).','1748250139.png'),
('DNP006','R1-004','P006','Alhamdulilah di semester ini  akmal dapat mengenal ajaran agama islam dengan mengikuti kegiatan praktek Gerakan sholat, dari takbiratul ihram sampai salam dengan tertib serta sudah menghafal  hafal bacaan sholat seperti bacaan rukuk, sujud, I’tidal duduk diantara dua sujud.','1749469293.png');

/*Table structure for table `detail_nilai_tarbiyah` */

DROP TABLE IF EXISTS `detail_nilai_tarbiyah`;

CREATE TABLE `detail_nilai_tarbiyah` (
  `id_detail_nilai_tarbiyah` varchar(8) NOT NULL,
  `id_rapor` varchar(8) NOT NULL,
  `id_materi` varchar(8) NOT NULL,
  `nilai` enum('Mumtaz','Jayyid Jiddan','Jayyid','Maqbul') NOT NULL,
  PRIMARY KEY (`id_detail_nilai_tarbiyah`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `detail_nilai_tarbiyah` */

insert  into `detail_nilai_tarbiyah`(`id_detail_nilai_tarbiyah`,`id_rapor`,`id_materi`,`nilai`) values 
('DPT001','R1-003','MT001','Mumtaz'),
('DPT002','R1-003','MT002','Mumtaz'),
('DPT003','R1-004','MT001','Mumtaz');

/*Table structure for table `detail_rapor` */

DROP TABLE IF EXISTS `detail_rapor`;

CREATE TABLE `detail_rapor` (
  `no_detail_rapor` varchar(8) NOT NULL,
  `id_rapor` varchar(8) NOT NULL,
  `id_perkembangan` varchar(8) NOT NULL,
  PRIMARY KEY (`no_detail_rapor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `detail_rapor` */

insert  into `detail_rapor`(`no_detail_rapor`,`id_rapor`,`id_perkembangan`) values 
('DR001','R1-003','P001'),
('DR002','R1-003','P002'),
('DR003','R1-003','P003'),
('DR004','R1-003','P004'),
('DR005','R1-003','P005'),
('DR006','R1-003','P006'),
('DR007','R1-004','P001'),
('DR008','R1-004','P002'),
('DR009','R1-004','P003'),
('DR010','R1-004','P004'),
('DR011','R1-004','P005'),
('DR012','R1-004','P006');

/*Table structure for table `fase` */

DROP TABLE IF EXISTS `fase`;

CREATE TABLE `fase` (
  `id_fase` varchar(8) NOT NULL,
  `nama_fase` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `fase` */

insert  into `fase`(`id_fase`,`nama_fase`) values 
('F001','Fondasi');

/*Table structure for table `guru` */

DROP TABLE IF EXISTS `guru`;

CREATE TABLE `guru` (
  `NIP` varchar(12) NOT NULL,
  `nama_guru` varchar(155) NOT NULL,
  `jabatan` enum('admin','wali_kelas','kepala_sekolah') NOT NULL,
  `tgl_lahir` date NOT NULL,
  `foto` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`NIP`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `guru` */

insert  into `guru`(`NIP`,`nama_guru`,`jabatan`,`tgl_lahir`,`foto`,`password`,`status`) values 
('0986','Natasya Aulia S.Pd','admin','2025-05-23','foto_guru/fYey0LSswU2BiLMyUEIUhM0a4yObFrx3jDiWXwVh.png','$2y$12$YRD5XY3Cac9wWnFplRWMbObiI3rERq9rAOeSxGqIXd01NcKFGddAy',1),
('0987','IBU','admin','2025-05-02','foto_guru/V9yIuKYnkjQjnFyGKfiqtImDz9LH5uJZ96dS4gj1.jpg','$2y$12$LecHC.xo7aAFiWe2ttacxORHfgf4mK0Wi3QlN8SLHGDERBum1LDda',1),
('111','putra','kepala_sekolah','2001-12-31','foto_guru/a8Qd4DlKIzsumXMKMT7lY68M2YPMWsP6J8CG9h4v.png','$2y$12$M5A0JPPceRpcWh5pIx4wruuaWW0uTKY5BUmrz6dTYZjk1cLmtY5ja',1),
('123454','Sinta','wali_kelas','2025-04-19','','$2y$12$l9c8ojNvgCnM/Vq57l5Nr./.r1dhwi9bX5detZpdps2.rcMVkqXBS',0),
('19121172','Dian, S.Pd','admin','1995-02-26','','$2y$12$l9c8ojNvgCnM/Vq57l5Nr./.r1dhwi9bX5detZpdps2.rcMVkqXBS',0),
('19850101001','Pak Andii','wali_kelas','1985-01-01','','12345678hmm',0),
('19870102002','Bu Sari','wali_kelas','1987-02-02','','$2y$12$HJ4CGOp5uH3plI6l2zAlA.ZLTvGY7sZ.2zwxPGuHdvYqVa/hhx.Pm',0),
('19890203003','Admin Aplikasi','admin','1989-03-03','foto_guru/Prgpo2XbsSit72fLc0mEZ9kpDwGAxp73x5BvTUiA.png','$2y$12$l9c8ojNvgCnM/Vq57l5Nr./.r1dhwi9bX5detZpdps2.rcMVkqXBS',0),
('5678','Setya Wati S.Kom','admin','2025-05-20','foto/nUeVhKgaR5Quu2iyQIps5WO4jRtyVZiprTmJaAG2.png','$2y$12$7DC66iLnOjqWFdngU9qxh.q3ujg7gYW7irF1WsELxZ8xYcQ6hUia.',0),
('9807','Dila Arfiana S.Pd','wali_kelas','2025-05-23','foto_guru/YPvagu0r7XhqtYq8eV3eUIHhhB2Kxa6imitEwfjh.jpg','$2y$12$spSztdcCFuz1dgSZsi/89.bh/TlckvmMxs3vE7LIKd/AAEF06BHwu',0),
('G001','Suparyati,S.Pd,AUD','kepala_sekolah','1987-06-03','foto_guru/n8H7sj4LidtZ3U3UrLzXNMe6lEewR1pL51iZ0luc.jpg','$2y$12$8RuUDfqRTytstxoojkaDE.x/7ORbPE7Na2ApXJLNG1UlBhs3UPeS.',1),
('G002','Siti Setyawati, S.Pd','wali_kelas','1990-06-01','foto_guru/nIOATkEhVShYgSEZhmw6czmMLKs9fvbcPCvkyFJO.jpg','$2y$12$ZdioHxplgnXvxPFVKtynse.EV/4kSndluUCVQ/8BWhcgxV71pClky',1),
('G003','Dian Puspita Indriastuti Susilo S.Pd','wali_kelas','1996-01-10','foto_guru/UYxPYzFRUlJgyLgwAVFVFoy9x7vVpDe1wlWSZ9oE.jpg','$2y$12$/sGOYvVhkdHeQagBDkhl3e3isDNQuCr4Oxd9xpkmXIOv46Ono3wuK',1),
('G004','Mega Nisaa`Sholichah','wali_kelas','1999-04-25','foto_guru/B5yAihw9pnIoxlvWB2lxNO3tTXef3cwQwZ4upMv2.jpg','$2y$12$vp2T/u3drzZk4fPs32guo..tnB65z7vRgkW7933iK6m/0CwCEWLOu',1),
('G005','Nina Ariyani, S.Pd.','wali_kelas','1993-06-03','foto_guru/Eb4y0TfuYin2qZDQfzsqIWzXhbsdd9ZDbzYjMjtQ.jpg','$2y$12$8X3r3SjpqCKsXUoRrvj48esBUMnsvvLgJMD9u5NVQDwXr.y6nF6MS',1),
('G006','Karni, S.Pd','wali_kelas','1998-11-12','foto_guru/YhURdTluv6OfnFT8DFSZe1HqwoKY4rj0lecZ6t5q.jpg','$2y$12$q4q1Dk2vAdyRfoKqht6KweUzmKYDAk03Xl/daig6wthCEDpNG8tsu',1),
('G007','Suprapti, A.Md.','wali_kelas','1994-06-03','foto_guru/I8RBA2bxa4xRsCoKymtP0B7e1dNwwrf6hNw4VULb.jpg','$2y$12$2LJU.7LVS5lmMD7DtCXZie3p15VZ5tGL9kk5O38ReoJkT0s6lbdWm',1),
('G008','Dyah Emiyati, S.Pd','wali_kelas','1992-12-26','foto_guru/fzuUYU4ZWUVudzXBm0p1jQh0iq5z6B14bppHwpS3.jpg','$2y$12$uXMzVlwygmcEL3Hjw4tG6uJbLark.zCW5yvtIplbKSXU4AYRz8tQW',1);

/*Table structure for table `indikator_tarbiyah` */

DROP TABLE IF EXISTS `indikator_tarbiyah`;

CREATE TABLE `indikator_tarbiyah` (
  `id_indikator` varchar(8) NOT NULL,
  `indikator` varchar(60) NOT NULL,
  `id_perkembangan` varchar(8) NOT NULL,
  `semester` varchar(10) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id_indikator`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `indikator_tarbiyah` */

insert  into `indikator_tarbiyah`(`id_indikator`,`indikator`,`id_perkembangan`,`semester`,`status`) values 
('IT1-001','Asmaul Husna','P001','1',1),
('IT1-002','Aqidah','P002','1',1),
('IT1-003','Siroh','P002','1',1),
('IT1-004','Adab','P002','1',1),
('IT1-005','Terjemah Perkata','P002','1',1),
('IT1-006','Hadist','P002','1',1),
('IT1-007','Bahasa Arab','P002','1',1),
('IT1-008','Do’a dalam Al-Quran','P002','1',1),
('IT1-009','Nama Surat','P002','1',1),
('IT1-010','Nama Bulan Hijriyah','P002','1',1),
('IT1-011','Iqra’','P002','1',1),
('IT2-001','Asmaul Husna','P002','2',1);

/*Table structure for table `kelas` */

DROP TABLE IF EXISTS `kelas`;

CREATE TABLE `kelas` (
  `id_kelas` varchar(8) NOT NULL,
  `nama_kelas` varchar(6) NOT NULL,
  PRIMARY KEY (`id_kelas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `kelas` */

insert  into `kelas`(`id_kelas`,`nama_kelas`) values 
('K001','A1'),
('K002','A2'),
('K003','A3'),
('K004','A4'),
('K005','B1'),
('K006','B2'),
('K007','B3'),
('K008','B4');

/*Table structure for table `kondisi_siswa` */

DROP TABLE IF EXISTS `kondisi_siswa`;

CREATE TABLE `kondisi_siswa` (
  `id_kondisi` varchar(8) NOT NULL,
  `NIS` varchar(8) NOT NULL,
  `BB` int(11) DEFAULT NULL,
  `TB` int(11) DEFAULT NULL,
  `LK` int(11) DEFAULT NULL,
  `penglihatan` enum('Normal','Tidak Normal') NOT NULL,
  `pendengaran` enum('Normal','Tidak Normal') NOT NULL,
  `gigi` enum('Normal','Tidak Normal') NOT NULL,
  `id_ta` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `kondisi_siswa` */

insert  into `kondisi_siswa`(`id_kondisi`,`NIS`,`BB`,`TB`,`LK`,`penglihatan`,`pendengaran`,`gigi`,`id_ta`) values 
('KS001','1111',40,165,50,'Normal','Normal','Normal','TA001');

/*Table structure for table `materi_tarbiyah` */

DROP TABLE IF EXISTS `materi_tarbiyah`;

CREATE TABLE `materi_tarbiyah` (
  `id_materi` varchar(8) NOT NULL,
  `materi` varchar(60) NOT NULL,
  `id_indikator` varchar(8) NOT NULL,
  `semester` varchar(10) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id_materi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `materi_tarbiyah` */

insert  into `materi_tarbiyah`(`id_materi`,`materi`,`id_indikator`,`semester`,`status`) values 
('MT001','Asmaul Husna 1-40','IT1-001','1',1),
('MT002','Dimana Allah','IT1-002','1',1),
('MT003','Ibadah yang paling besar','IT1-002','1',1),
('MT004','Dosa paling besar','IT1-002','1',1),
('MT005','Nabi Nuh, AS','IT1-003','1',1),
('MT006','Nabi Ibrahim, AS','IT1-003','1',1),
('MT007','Adab Ketika ada petir','IT1-004','1',1),
('MT008','Adab Ketika ada angin kencang','IT1-004','1',1),
('MT009','Adab Ketika memakai pakaian baru','IT1-004','1',1),
('MT010','Surat Al Ikhlas','IT1-005','1',1),
('MT011','Surat Al Lahab','IT1-005','1',1);

/*Table structure for table `monitoring_semester` */

DROP TABLE IF EXISTS `monitoring_semester`;

CREATE TABLE `monitoring_semester` (
  `id_rapor` varchar(8) NOT NULL,
  `NIS` varchar(8) NOT NULL,
  `id_kelas` varchar(8) NOT NULL,
  `NIP` varchar(8) NOT NULL,
  `id_fase` varchar(8) NOT NULL,
  `id_ta` varchar(8) NOT NULL,
  PRIMARY KEY (`id_rapor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `monitoring_semester` */

insert  into `monitoring_semester`(`id_rapor`,`NIS`,`id_kelas`,`NIP`,`id_fase`,`id_ta`) values 
('R1-001','111113','K005','19121172','K001','TA001'),
('R1-002','0001','K003','19121172','F001','TA003'),
('R1-003','1111','K001','G002','F001','TA001'),
('R1-004','9081','K001','G002','F001','TA001'),
('R2-003','1111','K001','G002','F001','TA002');

/*Table structure for table `notifikasi` */

DROP TABLE IF EXISTS `notifikasi`;

CREATE TABLE `notifikasi` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `pesan` text NOT NULL,
  `untuk_role` enum('orangtua','guru','admin') NOT NULL,
  `NIS` varchar(20) DEFAULT NULL,
  `dibaca` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_notifikasi_siswa` (`NIS`),
  CONSTRAINT `fk_notifikasi_siswa` FOREIGN KEY (`NIS`) REFERENCES `siswa` (`NIS`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `notifikasi` */

insert  into `notifikasi`(`id`,`judul`,`pesan`,`untuk_role`,`NIS`,`dibaca`,`created_at`,`updated_at`) values 
(1,'Notifikasi Rapor Semester','Assalamu’alaikum, Bapak/Ibu orangtua/wali dari Andhini Amalia Puteri.\r\nRapor semester 1 Tahun Ajaran  sudah tersedia dan dapat dilihat atau diunduh melalui sistem.\r\nTerima kasih.','orangtua','1111',0,'2025-06-07 10:29:24','2025-06-07 10:29:24'),
(2,'Notifikasi Rapor Semester','Assalamu’alaikum, Bapak/Ibu orangtua/wali dari Andhini Amalia Puteri.\r\nRapor semester 1 Tahun Ajaran  sudah tersedia dan dapat dilihat atau diunduh melalui sistem.\r\nTerima kasih.','orangtua','1111',0,'2025-06-07 10:38:21','2025-06-07 10:38:21'),
(4,'Notifikasi Rapor Semester','Assalamu’alaikum, Bapak/Ibu orangtua/wali dari Andhini Amalia Puteri.\r\nRapor semester 1 Tahun Ajaran  sudah tersedia dan dapat dilihat atau diunduh melalui sistem.\r\nTerima kasih.','orangtua','1111',0,'2025-06-09 11:20:25','2025-06-09 11:20:25'),
(5,'Notifikasi Rapor Semester','Assalamu’alaikum, Bapak/Ibu orangtua/wali dari Andhini Amalia Puteri.\r\nRapor semester 1 Tahun Ajaran  sudah tersedia dan dapat dilihat atau diunduh melalui sistem.\r\nTerima kasih.','orangtua','1111',0,'2025-06-09 11:20:37','2025-06-09 11:20:37'),
(6,'Notifikasi Rapor Semester','Assalamu’alaikum, Bapak/Ibu orangtua/wali dari Ananda Dian.\r\nRapor semester 1 Tahun Ajaran  sudah tersedia dan dapat dilihat atau diunduh melalui sistem.\r\nTerima kasih.','orangtua','9081',0,'2025-06-09 11:44:40','2025-06-09 11:44:40'),
(7,'Notifikasi Laporan Mingguan','Assalamu’alaikum, Bapak/Ibu orangtua/wali dari Ananda Dian.\r\nLaporan perkembangan siswa untuk Minggu ke-3, Semester 1 Tahun Ajaran 2023/ sudah tersedia di sistem.\r\nSilakan login untuk melihat detail laporan.\r\nTerima kasih.','orangtua','9081',0,'2025-06-12 11:23:49','2025-06-12 11:23:49');

/*Table structure for table `orangtua` */

DROP TABLE IF EXISTS `orangtua`;

CREATE TABLE `orangtua` (
  `id_ortu` varchar(8) NOT NULL,
  `NIS` varchar(8) NOT NULL,
  `nama_ayah` varchar(155) NOT NULL,
  `nama_ibu` varchar(155) NOT NULL,
  `pekerjaan_ayah` varchar(50) DEFAULT NULL,
  `pekerjaan_ibu` varchar(50) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `orangtua` */

insert  into `orangtua`(`id_ortu`,`NIS`,`nama_ayah`,`nama_ibu`,`pekerjaan_ayah`,`pekerjaan_ibu`,`alamat`,`password`) values 
('OT001','0001','Arto Saputro','Setyaning','Guru','Guru','Sleman',''),
('OT002','9081','Andi','Andhini','Guru','Guru','Brebes','$2y$12$yOPC.WyC838MwsOgI0ganef699yKYfRIBaqL.oWN1mj5NuapeL3xq'),
('OT003','1111','Atmaja','Ayu','Guru','Guru','Bekasi','$2y$12$lcMvskD/f557.dyyFXKGVuKdlavsqNxd8Fg/u36be0AFXNApHT3X.'),
('OT004','8900','akfjwo','fsojw','Guru','Guru','Brebes','$2y$12$ttLzKjUoRCZmE5ftOD9EwehajirKmt/MBmNTcOQVRltYGp6MaHgy2'),
('OT0002','0002','agus','titi','Guru','Guru','Brebes','$2y$12$tzsu/fngPBgBRgoM4fJhw.XmtyStMuF2F4.XFZ4fjhFiUUfPerv7y'),
('OT0003','0003','-','-',NULL,NULL,NULL,'$2y$12$zNcWrtyjGbE2nbCr7OKytOw0ELMsWCUBSiyan1GKHjZwNViK8PHAe'),
('OT0004','0004','-','-',NULL,NULL,NULL,'$2y$12$zfSEXnlW43EqQOmu5M.09uoF9.DclTuwezhIuj5OqkHu11FxIaS9O'),
('OT005','SW001','Andri','Putri','Dokter','Dokter','Jakarta','$2y$12$gqCHZ9tQnTxHB/IICesYKuLQBiOjbnwXFHHl5jCcYFb24roFzjIq6');

/*Table structure for table `penilaian_cp` */

DROP TABLE IF EXISTS `penilaian_cp`;

CREATE TABLE `penilaian_cp` (
  `id_penilaian_cp` varchar(8) NOT NULL,
  `id_perkembangan` varchar(8) NOT NULL,
  `aspek_nilai` text NOT NULL,
  PRIMARY KEY (`id_penilaian_cp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `penilaian_cp` */

insert  into `penilaian_cp`(`id_penilaian_cp`,`id_perkembangan`,`aspek_nilai`) values 
('PC001','P003','Anak percaya kepada Tuhan Yang Maha Esa, mulai mengenal dan mempraktikkan ajaran pokok sesuai dengan agama dan kepercayaanNya.'),
('PC002','P003','Anak berpartisipasi aktif dalam menjaga kebersihan, kesehatan dan keselamatan diri sebagai bentuk rasa sayang terhadap dirinya dan rasa syukur pada Tuhan Yang Maha Esa.'),
('PC003','P003','Anak menghargai sesama manusia dengan berbagai perbedaannya dan mempraktikkan perilaku baik dan berakhlak mulia'),
('PC004','P003','Anak menghargai alam dengan cara merawatnya dan menunjukkan rasa sayang terhadap makhluk hidup yang merupakan ciptaan Tuhan Yang Maha Esa.'),
('PC005','P004','Anak mengenali, mengekspresikan, dan mengelola emosi diri serta membangun hubungan sosial secara sehat.'),
('PC006','P004','Anak mengenal dan memiliki perilaku positif terhadap diri dan lingkungan (keluarga, sekolah, masyarakat, negara, dan dunia) serta rasa bangga sebagai anak Indonesia yang berlandaskan Pancasila.'),
('PC007','P004','Anak menyesuaikan diri dengan lingkungan, aturan, dan norma yang berlaku.'),
('PC008','P004','Anak menggunakan fungsi gerak (motorik kasar, halus, dan taktil) untuk mengeksplorasi dan memanipulasi berbagai objek dan lingkungan sekitar sebagai bentuk pengembangan diri'),
('PC009','P005','Anak mengenali dan memahami berbagai informasi, mengomunikasikan perasaan dan pikiran secara lisan, tulisan, atau menggunakan berbagai media serta membangun percakapan.'),
('PC010','P005','Anak menunjukkan minat, kegemaran, dan berpartisipasi dalam kegiatan pramembaca dan pramenulis.'),
('PC011','P005','Anak mengenali dan menggunakan konsep pramatematika untuk memecahkan masalah di dalam kehidupan sehari-hari.'),
('PC012','P005','Anak menunjukkan kemampuan dasar berpikir kritis, kreatif, dan kolaboratif.'),
('PC013','P005','Anak menunjukkan rasa ingin tahu melalui observasi, eksplorasi, dan eksperimen dengan menggunakan lingkungan sekitar dan media sebagai sumber belajar, untuk mendapatkan gagasan mengenai fenomena alam dan sosial.'),
('PC014','P005','Anak menunjukkan kemampuan awal menggunakan dan merekayasa teknologi serta untuk mencari informasi, gagasan, dan keterampilan secara aman dan bertanggung jawab.'),
('PC015','P005','Anak mengeksplorasi berbagai proses seni, mengekspresikannya serta mengapresiasi karya seni.');

/*Table structure for table `perkembangan` */

DROP TABLE IF EXISTS `perkembangan`;

CREATE TABLE `perkembangan` (
  `id_perkembangan` varchar(8) NOT NULL,
  `indikator` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `perkembangan` */

insert  into `perkembangan`(`id_perkembangan`,`indikator`) values 
('P001','Hafalan Surah Pendek'),
('P002','Tarbiyah dan BTQ'),
('P003','Agama dan Budi Pekerti'),
('P004','Jatidiri'),
('P005','Dasar-dasar LIerasi, Matematika, Sains, Teknologi, Rekayasa,'),
('P006','Projek Penguatan Profil Pelajar Pancasila');

/*Table structure for table `siswa` */

DROP TABLE IF EXISTS `siswa`;

CREATE TABLE `siswa` (
  `NIS` varchar(8) NOT NULL,
  `NISN` varchar(12) DEFAULT NULL,
  `NIK` varchar(12) DEFAULT NULL,
  `nama_siswa` varchar(155) NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`NIS`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `siswa` */

insert  into `siswa`(`NIS`,`NISN`,`NIK`,`nama_siswa`,`tempat_lahir`,`tgl_lahir`,`foto`) values 
('0001','023','2425','Sinta Prameswari','Bekasi','2025-05-02','foto_siswa/bA8jlOpx7bLbIBkLUkI5Aaz2EvgnvnyilYEniyuR.jpg'),
('0002','1010','0098765','Fiska Alfianti','Bekasi','2025-06-03','foto/qLnPBHoxzg7WqI8hO21lpXyeewflkLrnocqv8uNu.jpg'),
('0003','12435','09121','Syafwan Alfarizi','Cirebon','2025-06-06','foto_siswa/gJvFZXgr03DeWgjmCAFJsSnrWCqP5lNF4ocUimww.jpg'),
('0004','a249','q5251','Natasya Eriani','Klaten','2025-12-26','foto_siswa/ELAJCXIEGt5UANWkmZgOf1sMBkcmX6sDL5zlX8Tp.jpg'),
('0987','1010','2425','Jisung Park','Brebes','2025-05-03','foto_siswa/UGioB2tnySqrHMKKUX69tL8nQz8WDuTfhVFzAHKK.jpg'),
('1111','1010','09121','Andhini Amalia Puteri','Bekasi','2025-04-14','foto_siswa/VXngiT4ALsjiLG0TP1TRS8PuZeUvccBr8ETJY0J4.jpg'),
('111113','023','0912','Rinaica Avarsha','Bekasi','2025-04-16','foto_siswa/VLQowafegPcdoa2lI670EyA5SQQUWiulMRXAO6p5.jpg'),
('2345','1010','0912','Salma Nabila','Bekasi','2025-04-23','fotosiswa/ShfXvQWXHDrrXLEiVrAXCfxDAQcy19VoeuZtUHVA.jpg'),
('3456','23456','76854','Nandika Atmaja','Brebes','2025-05-02','fotosiswa/YziK9UYI4Uoww6Eg8wk1HGHPZ1vz73KOuk9nyjvU.png'),
('52102','4567','34568','Angga Aditya','Sleman','2025-05-20','foto_siswa/nBNaDlWGYzLYyo6lck2jDJtzWRHbKIkAKXA1bUmQ.png'),
('8900','1010','0912','Fathya Cici','Bekasi','2025-04-23','fotosiswa/xc3JX4tg2gjJkXl4RURf21QCp0DQIXOL1EariLkH.jpg'),
('9081','9028502','8475','Ananda Dian','Brebes','2025-05-23','foto_siswa/1tIV7GECSbkxgbn0VgxQdD0R56VE1KtDaFFAiTjx.jpg'),
('SW001','5678',NULL,'Nalagra Dirgantara','Jakarta','2025-06-08','foto_siswa/mu8o3nKsuP2x46sFyGqsXWAaXiq7tjmG7OgMwUP6.png'),
('SW002','3245','45677','Viona Ayudya','Jakarta','2025-06-13','foto_siswa/gvQ6f9AaYn7brEFJjBFo1fVyyoX1fMKi1pz1NiRs.png');

/*Table structure for table `surat_hafalan` */

DROP TABLE IF EXISTS `surat_hafalan`;

CREATE TABLE `surat_hafalan` (
  `id_surat` varchar(8) NOT NULL,
  `nama_surat` varchar(15) NOT NULL,
  `id_perkembangan` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `surat_hafalan` */

insert  into `surat_hafalan`(`id_surat`,`nama_surat`,`id_perkembangan`) values 
('H001','Al Fatihah','P001'),
('H002','An Naas','P001'),
('H003','Al Falaq','P001'),
('H004','Al Ikhlas','P001'),
('H005','Al Lahab','P001');

/*Table structure for table `tahun_ajaran` */

DROP TABLE IF EXISTS `tahun_ajaran`;

CREATE TABLE `tahun_ajaran` (
  `id_ta` varchar(8) NOT NULL,
  `semester` tinyint(4) NOT NULL,
  `tahun_mulai` year(4) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_ta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tahun_ajaran` */

insert  into `tahun_ajaran`(`id_ta`,`semester`,`tahun_mulai`,`status`) values 
('TA001',1,2023,1),
('TA002',2,2023,1),
('TA003',1,2024,1),
('TA004',2,2024,1),
('TA005',1,2025,0);

/*Table structure for table `tujuan_pembelajaran` */

DROP TABLE IF EXISTS `tujuan_pembelajaran`;

CREATE TABLE `tujuan_pembelajaran` (
  `id_tp` varchar(8) NOT NULL,
  `tujuan_pembelajaran` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tujuan_pembelajaran` */

insert  into `tujuan_pembelajaran`(`id_tp`,`tujuan_pembelajaran`,`status`) values 
('TP001','Membilang dan menjumlahkan angka',0),
('TP002','Berfikir dan menyebutkan suku kata awal yang sama',0),
('TP003','Mampu mempraktekan ajaran pokok sesuai dengan agamanya',0),
('TP004','Mampu mengelola emosi diri',1),
('TP005','jhgjfyt',0);

/*Table structure for table `wali_kelas` */

DROP TABLE IF EXISTS `wali_kelas`;

CREATE TABLE `wali_kelas` (
  `id_wakel` varchar(12) NOT NULL,
  `NIP` varchar(12) NOT NULL,
  `id_ta` varchar(8) NOT NULL,
  `id_kelas` varchar(8) NOT NULL,
  PRIMARY KEY (`id_wakel`),
  KEY `id_ta` (`id_ta`),
  KEY `NIP` (`NIP`),
  KEY `id_kelas` (`id_kelas`),
  CONSTRAINT `wali_kelas_ibfk_1` FOREIGN KEY (`NIP`) REFERENCES `guru` (`NIP`),
  CONSTRAINT `wali_kelas_ibfk_2` FOREIGN KEY (`id_ta`) REFERENCES `tahun_ajaran` (`id_ta`),
  CONSTRAINT `wali_kelas_ibfk_3` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `wali_kelas` */

insert  into `wali_kelas`(`id_wakel`,`NIP`,`id_ta`,`id_kelas`) values 
('WK001','G002','TA004','K001'),
('WK002','G002','TA001','K001'),
('WK003','G003','TA001','K002'),
('WK004','G004','TA004','K004'),
('WK005','G002','TA002','K001'),
('WK006','G005','TA005','K007');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
