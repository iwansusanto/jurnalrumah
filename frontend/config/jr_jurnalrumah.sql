-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 05 Des 2015 pada 09.02
-- Versi Server: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jr_jurnalrumah`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `jr_artikel`
--

CREATE TABLE IF NOT EXISTS `jr_artikel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(75) NOT NULL,
  `summary` varchar(250) NOT NULL,
  `deskripsi` text NOT NULL,
  `author` int(11) NOT NULL,
  `author_name` varchar(30) NOT NULL,
  `categori_id` int(11) NOT NULL,
  `categori_name` varchar(30) NOT NULL,
  `sumber` varchar(255) NOT NULL,
  `schedule_date` datetime NOT NULL,
  `status` tinyint(4) NOT NULL,
  `viewed` int(11) NOT NULL,
  `image1` text NOT NULL,
  `image2` text NOT NULL,
  `image3` text NOT NULL,
  `image4` text NOT NULL,
  `image5` text NOT NULL,
  `image6` text NOT NULL,
  `image7` text NOT NULL,
  `image8` text NOT NULL,
  `image9` text NOT NULL,
  `video` text NOT NULL,
  `tag` text NOT NULL,
  `user_create` int(11) NOT NULL,
  `user_update` int(11) NOT NULL,
  `date_create` datetime NOT NULL,
  `date_update` datetime NOT NULL,
  `user_by` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author` (`author`,`categori_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data untuk tabel `jr_artikel`
--

INSERT INTO `jr_artikel` (`id`, `judul`, `summary`, `deskripsi`, `author`, `author_name`, `categori_id`, `categori_name`, `sumber`, `schedule_date`, `status`, `viewed`, `image1`, `image2`, `image3`, `image4`, `image5`, `image6`, `image7`, `image8`, `image9`, `video`, `tag`, `user_create`, `user_update`, `date_create`, `date_update`, `user_by`) VALUES
(5, 'Lebaran, Penjualan Rumah di Jabodetabek-Banten Anjlok', 'Penjualan pasar perumahan di Jabodebek-Banten pada kuartal II-2015 anjlok sampai 21,8 persen.', 'Liputan6.com, Jakarta - Penjualan pasar perumahan di Jabodebek-Banten pada kuartal II-2015 anjlok sampai 21,8 persen. Penurunan terjadi di semua segmen rumah dengan nilai penjualan ditaksir sebesar Rp 2,15 triliun. Penyebabnya karena dampak musiman yang terjadi hampir setiap tahun, khususnya menjelang Idul Fitri. \r\n\r\nDari analisis Direktur Eksekutif Indonesia Property Watch, Ali Tranghanda menunjukkan, pertumbuhan positif yang terjadi di kuartal I-2015 ternyata tidak berlanjut tiga bulan berikutnya. \r\n\r\nDi kuartal II tahun ini, selain hajatan Idul Fitri juga bertepatan dengan musim liburan anak sekolah dan persiapan kenaikan kelas yang sangat berpengaruh pada penjualan pasar perumahan di segmen bawah. \r\n\r\nHasil riset menjelaskan, merosotnya penjualan rumah di segmen bawah merupakan penurunan terbesar diantara segmen lainnya yaitu sebesar 26,9 persen. Sedangkan segmen besar turun 24,7 persen dan segmen menengah hanya menurun 16,8 persen.\r\n\r\n"Kontraksi penjualan perumahan ini masih dalam batas wajar karena diperkirakan pasar perumahan akan segera memasuki fase baru di akhir 2015 atau di awal 2016," kata Ali dikutip Selasa (21/7/2015).\r\n\r\nSiklus perlambatan yang ada saat ini merupakan siklus alamiah yang harus dicermati oleh para pengembang untuk melakukan konsolidasi internal terkait pasar sasaran yang ada. Karena selama tiga tahun terakhir, pengembang melupakan pasar yang gemuk itu di segmen menengah bawah dan terlalu asik bermain di segmen menengah atas.\r\n\r\nMeskipun terjadi penurunan penjualan, diterangkan Ali, komposisi unit yang terjual di segmen menengah sampai bawah masing-masing 25,8 persen dan 68,5 persen. Sedangkan prosentase unit rumah yang terjual untuk segmen besar hanya 5,7 persen saat ini.\r\n\r\nAli mengatakan, dengan adanya pelonggaran Loan To Value (LTV) di Juli 2015 ini akan berdampak pada penjualan rumah di segmen menengah. Walaupun kebijakan tersebut akan memengaruhi pasar investor di menengah atas, namun dengan kondisi harga pasar yang sudah terlalu tinggi di segmen ini, maka dampaknya tidak terlalu berasa. \r\n\r\n"Pasar menengah akan kembali menjadi primadona dan para pengembang diharapkan dapat melakukan strategi ‘membumi’ dan tidak selalu membuat strategi ‘langit’ dengan membuat produk sesuai pasar yang ada," tandas dia. (Fik/Ndw)', 3, 'Admin', 9, 'Berita perumahan', 'http://bisnis.liputan6.com/read/2276499/lebaran-penjualan-rumah-di-jabodetabek-banten-anjlok', '2015-08-29 22:09:00', 0, 0, '2015/08/29/Nae1GRJ4_YZtw5-DQA_h349NdEbJsO-F.jpg', '', '', '', '', '', '', '', '', '', '', 1, 1, '2015-08-29 22:09:22', '2015-08-29 22:09:22', 'Super'),
(6, 'Perumahan Menengah Atas di Depok Mengarah ke Selatan', 'Depok merupakan salah satu daerah peyangga yang menjadi pemasok rumah tapak terbesar di sekitar Jakarta.', 'Liputan6.com, Jakarta - Depok merupakan salah satu daerah peyangga yang menjadi pemasok [rumah tapak](2270782 (landed house) terbesar di sekitar Jakarta. Namun seiring melonjaknya harga tanah di daerah tersebut, pasokan rumah kelas menengah dan menengah atas terus bergeser keluar pusat kota yakni ke arah selatan yang berbatasan dengan wilayah Bogor.\r\n\r\nGeneral Manager Marketing SMR Group, Tony Hartono mengatakan semakin terbatasnya lahan pengembangan di pusat Kota Depok seperti Lenteng Agung dan Margonda memang memaksa developer hunian tapak di segmen menengah dan menengah atas untuk memilih lokasi pengembangan ke arah selatan yang memiliki akses ke daerah Bogor seperti Sawangan dan Citayam. Sedangkan di kawasan pusat kota kini semakin marak dibangun hunian vertikal atau apartemen.\r\n\r\n"Mayoritas proyek perumahan tapak di Depok bermain di segmen menengah atau menengah bawah. Sementara porsi segmen perumahan menengah atas hanya sekitar 30 persen, karena pasokan dan pemainnya juga tidak banyak," ungkap Tony yang dihubungi Liputan6.com, Minggu (12/7/2015).\r\n\r\nSelain tidak banyak pengembang yang bermain di segmen perumahan menengah atas, rata-rata proyek di segmen tersebut juga memiliki luas lahan yang terbatas. Menurut Tony, proyek skala kota mandiri (township) di wilayah selatan Depok hanya Grand Depok City (GDC) yang dikembangkan SMR Group.\r\n\r\nDia menyebutkan, total luas lahan GDC mencapai 350 hektare, dan 40 persen diantaranya belum dikembangkan. Lokasi proyek tersebut berada di jalur perlintasan menuju Cibinong, Bogor. Perusahaan, kata Tony, juga memiliki rencana untuk menambah cadangan lahan pengembangan di proyek perumahan yang kini sudah dihuni 7.000 kepala keluarga tersebut.\r\n\r\nDiakui penjualan rumah menengah atas di semester pertama 2015 cenderung menurun karena investor menahan diri sembari melihat situasi pasar membaik. Namun, Tony optimistis di semester kedua ini penjualan akan lebih baik seiring pelonggaran aturan loan to value (LTV), suku bunga KPR yang sekarang rata-rata sekitar 10 persen, selain masih tingginya kebutuhan hunian masyarakat terutama bagi keluarga baru.\r\n\r\n"Perlambatan memang terjadi, namun sifatnya hanya sementara. Di semester II tentu diharapkan lebih baik. Apalagi tahun ini kami menargetkan penjualan bisa naik hingga 20 persen dibandingkan 2014," rinci dia.\r\n\r\nSeiring optimisme tersebut, SMR Group berencana meluncurkan satu produk residensial baru yang diberinama Puri Insani Boulevard, dengan total areal 2.000 meter persegi. Sedangkan unit terbatas hanya 17 rumah.\r\n\r\n"Investasinya sekitar Rp 15 miliar, dengan target penjualan pemasaran sekitar Rp 24 miliar," ungkap Tony.\r\n\r\nProduk ini berlokasi di Jalan Boulevard Utama Grand Depok City. Ditawarkan rumah dua lantai dengan gaya arsitektur classic mediteranian, serta luas lahan rata-rata di atas 120 meter persegi.\r\n\r\nSelain di Depok, SMR Group saat ini juga sedang mengembangkan proyek perumahan Balikpapan Regency di Kalimantan, pembangunan hotel di Metro Indah Mall Bandung, serta proyek Marina Anyer. \r\n\r\nReporter: Muhammad Rinaldi\r\n\r\n(Rinaldi/Ndw)', 3, 'Admin', 9, 'Berita perumahan', 'http://bisnis.liputan6.com/read/2270937/perumahan-menengah-atas-di-depok-mengarah-ke-selatan', '2015-08-29 22:11:00', 0, 0, '2015/08/29/RFwBItrrVmDLxRWFgBw8m06TSdAy1zZR.jpg', '', '', '', '', '', '', '', '', '', '', 1, 1, '2015-08-29 22:11:25', '2015-08-29 22:11:25', 'Super'),
(7, 'Pengembangan permukiman lebih banyak bertumpu di kawasan Banten utara seper', 'Pengembangan permukiman lebih banyak bertumpu di kawasan Banten utara seperti Tangerang, Tangerang Selatan.', 'Liputan6.com, Jakarta - Pemerintah Provinsi Banten akan mendorong pembangunan infrastruktur ke wilayah selatan yakni Lebak dan Pandeglang guna menarik minat swasta untuk ikut melakukan pengembangan kawasan permukiman terutama menengah bawah. Salah satu proyek infrastruktur tol Serang-Penimbang yang tahap pembebasan lahannya akan segera dilakukan pada 2016.\r\n\r\nPelaksana Tugas Gubernur Banten, Rano Karno mengungkapkan di provinsi tersebut ada empat kota dan empat kabupaten, namun pengembangan permukiman lebih banyak bertumpu di kawasan Banten utara seperti  Tangerang, Tangerang Selatan, Serang dan Kabupaten Tangerang.\r\n\r\n"Untuk pembangunan perumahan memang belum ada pemerataan, seperti di Lebak dan Pandeglang karena infrastrukturnya memang tertinggal. Oleh karena itu kita akan buka infrastrukturnya untuk menarik swasta agar mau masuk dan berinvestasi di sana termasuk di sektor properti," ungkap Rano Karno dalam perbincangan dengan Liputan6.com yang ditulis, Senin (29/06/2015).\r\n\r\nPembangunan jalan tol Serang-Penimbang ditujukan untuk membuka akses menuju Banten wilayah selatan terutama Kawasan Ekonomi Khusus (KEK) Tanjung Lesung di Pandeglang yang telah dicanangkan Presiden Jokowi. Jalan tol sepanjang 80 kilometer tersebut diperkirakan menelan dana sebesar Rp 5 triliun.\r\n\r\nSelain jalan bebas hambatan, Pemprov Banten juga akan meningkatkan kualitas jalan provinsi Serang-Penimbang, mendorong percepatan bandar udara di Banten selatan, bahkan pengembangan jaringan kereta api ke Penimbang.\r\n\r\n"Inilah sisi lain dari wilayah Banten yang harus dipercepat pembangunannya. Pembangunan tol tahun depan sudah pembebasan lahan dan penyelesaian Amdal, sehingga 2017 ditargetkan sudah konstruksi. Saya yakin Pandeglang dan Lebak akan semakin terbuka untuk investasi," papar dia.\r\n\r\nSaat ini PT Kawasan Industri Jababeka Tbk melalui anak usahanya PT Banten West Java Tourism Development Corporation telah melakukan pengembangan KEK Tanjung Lesung.\r\n\r\nTerkait rencana pembangunan rumah murah bagi masyarakat di kedua daerah itu, Rano mengaku masih sangat minim, apalagi swasta belum berkeinginan untuk masuk ke daerah tersebut. Namun Pemprov Banten memiliki program bedah rumah yang sudah berjalan, dengan bantuan Rp 15 juta per rumah.\r\n\r\nDia mengakui bantuan itu sangat kecil, namun setidaknya dapat meningkatkan kualitas hunian masyarakat kurang mampu di daerah tersebut.\r\n\r\n"Saya mengajak pengembang terutama anggota Realestat Indonesia (REI) untuk ikut membantu pembangunan rumah murah di Banten ini," imbau Rano.\r\n\r\nPemprov Banten dan REI Banten telah mencanangkan percepatan implementasi program Sejuta Rumah di provinsi tersebut guna mendukung program yang telah dicanangkan pada 29 April 2015 lalu.\r\n\r\nTahun ini akan dibangun 5.000 unit rumah murah, dan tahap pertama akan dibangun 1.000 unit.\r\n\r\n"Saya sudah minta kepada REI agar dari 1.000 rumah tahap pertama itu, sekitar 200 unit bisa dialokasikan untuk Pegawai Negeri Sipil (PNS) di daerah ini yang banyak belum memiliki rumah," tegas Rano.\r\n\r\nDia berjanji akan mengundang Presiden Jokowi untuk menyaksikan langsung groundbreaking pembangunan 1.000 unit rumah subsidi di Banten dalam waktu dekat. \r\n\r\nReporter: Muhammad Rinaldi\r\n\r\n(Rinaldi/Ndw)', 3, 'Admin', 9, 'Berita perumahan', 'http://bisnis.liputan6.com/read/2261491/rano-karno-ajak-pengembang-bangun-permukiman-di-banten-selatan', '2015-08-29 22:12:00', 0, 0, '2015/08/29/VaUDBVvAKOw68x0jZAzu5DmzfFyhv-KT.jpg', '', '', '', '', '', '', '', '', '', '', 1, 1, '2015-08-29 22:12:44', '2015-08-29 22:12:44', 'Super'),
(8, 'Siapa Minat, Rumah Subsidi Rp 120 Juta Dibangun di Bandung', 'Secara umum, tidak banyak kendala dalam pengembangan rumah murah di Bandung dan sekitarnya.', 'Liputan6.com, Jakarta - Pencanangan program Sejuta Rumah disambut antusias pengembang di daerah. Perusahaan properti PT Tujuh Pilar Sarana berencana memasarkan rumah bersubsidi dengan harga Rp 120 juta di Soreang, Bandung Selatan, Jawa Barat.\r\n\r\nFerry Sandiyana, Direktur PT Tujuh Pilar Sarana mengatakan pengembangan rumah murah itu akan dilakukan di atas lahan seluas 4 hektare lebih, dan nantinya akan dibangun total 300 unit rumah.\r\n\r\n"Sebagian besar akan kami kembangkan sebagai rumah menengah bawah termasuk rumah bersubsidi," kata Ferry kepada Liputan6.com, Sabtu (20/06/2015).\r\n\r\nSaat ini di lapangan sedang dilakukan penuntasan pembebasan lahan, sekaligus sedang disiapkan proses perizinannya. Jika perizinan tuntas akan dilanjutkan dengan proses konstruksi pada tahun ini juga.\r\n\r\nMenurut Ferry yang kini menjabat Ketua Umum DPP Asosiasi Pengembang Perumahan Rakyat Seluruh Indonesia (AP2ERSI), untuk rumah subsidi dengan tipe 30/60 akan dijual dengan harga Rp 120 juta sesuai ketentuan pemerintah agar dapat memperoleh Fasilitas Likuiditas Pembiayaan Perumahan (FLPP). Program ini menawarkan uang muka 1 persen, serta suku bunga KPR 5 persen dengan tenor hingga 20 tahun.\r\n\r\nSecara umum, dia mengungkapkan tidak banyak kendala dalam pengembangan rumah murah di Bandung dan sekitarnya. Namun diakui harga lahan untuk rumah murah semakin langka, karena lonjakan harga tanah tidak mampu dikontrol pemerintah. Selain itu, di Jawa Barat banyak bermunculan pengembang "dadakan" yang tidak bertanggungjawab dan merugikan konsumen.\r\n\r\nAktivitas pengembang dadakan yang mayoritas tidak berbadan hukum dan bermodal minim itu sebenarnya tidak hanya marak di Jawa Barat, namun juga di daerah lain.\r\n\r\n"Kami mendesak pemerintah daerah berani mengeluarkan peraturan daerah (perda) yang mewajibkan pengembang properti bergabung pada asosiasi sehingga lebih mudah dipantau sehingga tidak sampai merugikan masyarakat," tegas Ferry.\r\n\r\nDia menyebutkan kalau pengembang sudah bergabung dalam satu asosiasi, dan dikemudian hari ada persoalan, maka  konsumen dapat meminta pertanggungjawaban kepada asosiasi. "Asosiasi bisa menjadi mediator, atau bahkan menindak pengembang nakal tersebut," ujar Ferry.(Rinaldi/Nrm)', 3, 'Admin', 9, 'Berita perumahan', 'http://bisnis.liputan6.com/read/2255883/siapa-minat-rumah-subsidi-rp-120-juta-dibangun-di-bandung', '2015-08-29 22:14:00', 0, 0, '2015/08/29/rkO1Vyx914f9qjstaWZF3KreSHkaTPji.jpg', '', '', '', '', '', '', '', '', '', '', 1, 1, '2015-08-29 22:14:05', '2015-08-29 22:14:05', 'Super'),
(9, 'Paramount Land Bidik Properti Menengah Atas di Semarang', 'Perusahaan properti, Paramount Land menanamkan investasi sekitar Rp 350 miliar di Semarang, Jawa Tengah', 'Liputan6.com, Jakarta - Perusahaan properti, Paramount Land menanamkan investasi sekitar Rp 350 miliar di Semarang, Jawa Tengah, untuk pengembangan proyek residensial dan komersial kelas menengah atas di Simongan, Semarang Barat. Ekspansi ini merupakan bagian dari rencana perusahaan tersebut untuk memperkuat basis bisnis di luar Gading Serpong, Tangerang.\r\n\r\nPresiden Direktur Paramount Land, Ervan Adi Nugroho mengatakan proyek di Semarang menjadi pengembangan pertama yang dilakukan perusahaan di luar Gading Serpong. Paramount Land menguasai lahan seluas 1.200 hektare di daerah tersebut.\r\n\r\n"Kami menargetkan ke depan sekitar 40 persen penjualan berasal dari proyek-proyek di luar Gading Serpong. Saat ini hampir 99% penjualan masih berasal dari kawasan tersebut," kata Ervan yang dihubungi Liputan6.com, Rabu (10\\6\\2015).\r\n\r\nSelain di Semarang, pengembang ini berencana merambah pasar properti di Pekanbaru dan Bali. Menurut Ervan, Paramount Land akan mengembangkan proyek perumahan berikut kawasan komersial di Semarang seluas 9 hektare.\r\n\r\nDari proyek itu diharapkan diperoleh penjualan pemasaran (marketing sales) sekitar Rp 500 miliar, atau 15 persen dari target penjualan perusahaan  tahun ini yang dipatok Rp 3 triliun.\r\n\r\nPengerjaan konstruksi akan dilakukan pada Agustus 2015, dan ditargetkan selesai seluruhnya dua tahun setelah konstruksi.\r\n\r\nParamount Land juga berencana mengembangkan jaringan hotel di beberapa daerah antara lain di Surabaya, Bali, Semarang, Bogor, Bandung, dan Balikpapan. Perusahaan kini mengelola enam hotel di Gading Serpong, Malang, dan Magelang. \r\n\r\nReporter: Muhammad Rinaldi\r\n\r\n(Rinaldi/Ndw)', 3, 'Admin', 9, 'Berita perumahan', 'http://bisnis.liputan6.com/read/2248648/paramount-land-bidik-properti-menengah-atas-di-semarang', '2015-08-29 22:15:00', 0, 0, '2015/08/29/60d4um4_YfrxePHPIlfQdagMu5ZluJDD.jpg', '', '', '', '', '', '', '', '', '', '', 1, 1, '2015-08-29 22:15:21', '2015-08-29 22:15:21', 'Super'),
(10, 'BTN Luncurkan Tabungan Perumahan dengan Setoran Rp 100 Ribu', 'Maryono memasang target pembukaan rekening baru tabungan perumahan BTN lebih dari 100 ribu.', 'Liputan6.com, Jakarta - Kekurangan (backlog) rumah yang mencapai lebih dari 15 juta unit membuat PT Bank Tabungan Negara Tbk (BTN) mencari solusi mengatasi masalah perumahan di Indonesia. Bank pelat merah ini pun membuat program tabungan perumahan dengan setoran rendah bagi masyarakat berpenghasilan rendah (MBR).\r\n\r\nDirektur Utama BTN, Maryono mengungkapkan, produk tabungan ini didesain untuk membantu masyarakat yang ingin membeli rumah. Tabungan perumahan BTN membidik nasabah baru menikah, kalangan muda seiring kebutuhan kepemilikan rumah.\r\n\r\n"Nabungnya mau Rp 100 ribu, Rp 200 ribu atau Rp 500 ribu per bulan boleh. Sasarannya untuk semua masyarakat supaya tidak membebani tapi justru mempermudah dan melindungi konsumen," kata dia di acara Rakernas REI, Jakarta, Rabu (19/11/2014).\r\n\r\nLebih lanjut Maryono menuturkan, tabungan perumahan BTN dapat memberikan manfaat lebih bagi masyarakat. Dengan menyimpan uang di tabungan perumahan, nasabah akan mendapat benefit bunga per bulan.\r\n\r\n"Daripada taruh uang di developer-nya, tidak dapat bunga. Lebih baik di tabungan, dapat bunga KPR rata-rata 9 persen sampai 11 persen," terangnya.\r\n\r\nMeski tidak wajib seperti tabungan perumahan rakyat (Tapera), Maryono memasang target pembukaan rekening baru tabungan perumahan BTN lebih dari 100 ribu. "Volume penabungan sampai dengan 2015 ditargetkan sekira Rp 2 triliun," ucap dia.\r\n\r\nTabungan ini adalah tabungan berjangka yang di bundling dengan asuransi. Sehingga nasabah secara rutin melakukan setoran wajib per bulan dalam rangka menyiapkan rencana memiliki rumah impian atau mendapat uang muka.\r\n\r\nSyaratnya, Maryono menyebut, nasabah dapat mengajukan KPR ke Kantor Cabang yang tersebar di seluruh Indonesia dengan terlebih dahulu melengkapi dokumen persyaratan KPR. \r\n\r\n"Jadi selain untuk kepemilikan rumah pertama, tabungan ini bisa untuk pengajuan rumah kedua dan seterusnya," ujarnya.\r\n\r\nCaranya, cukup mengunjungi kantor cabang bank BTN dan melakukan pembukaan rekening dengan setoran awal Rp 2 juta. Lalu nasabah dapat memulai perencanaan keuangan kemepmilikan rumah bank BTNdengan setoran lanjutan relatif ringan Rp 100 ribu.\r\n\r\nSekadar informasi, Emiten berkode BBTN ini fokus pada bisnis pembiayaan perumahan mencapai 85 persen. Sementara bank umum lain mengalokasikan dana untuk portofolio pembiayaan perumahan maksimal hanya 20 persen.\r\n\r\nBTN menguasai pangsa pasar KPR sebesar 24 persen. Pada segmen KPR subsidi, perseroan menguasai pangsa pasar lebih dari 95 persen dari total penyaluran FLPP 2011, 2012 dan 2013. Secara kumulatif, BTN sudah menyalurkan KPR kepada lebih dari 3,5 juta orang di seluruh Indonesia. (Fik/Gdn)', 3, 'Admin', 9, 'Berita perumahan', 'http://bisnis.liputan6.com/read/2136315/btn-luncurkan-tabungan-perumahan-dengan-setoran-rp-100-ribu', '2015-08-29 22:16:00', 0, 0, '2015/08/29/ZKX-F-HI12k0IHhfQK7wTD791-ftJiHA.jpg', '', '', '', '', '', '', '', '', '', '', 1, 1, '2015-08-29 22:16:38', '2015-08-29 22:16:38', 'Super'),
(11, 'Harga Properti Melambung Jadi Kesalahan Pemerintah', 'Harga properti Indonesia mengalami ketidakjelasan dan berlawanan dengan hukum ekonomi.', 'Liputan6.com, Jakarta - Lembaga Penyelidik Ekonomi dan Masyarakat (LPEM) Fakultas Ekonomi Universitas Indonesia menilai melambungnya harga properti di Indonesia karena lemahnya pengawasan Pemerintah.\r\n\r\nKetua Peniliti LPEM Nuzul Achjar mengungkapkan, harga properti Indonesia mengalami ketidakjelasan dan berlawanan dengan hukum ekonomi yaitu ketersediaan banyak tetapi harga semakin melonjak.\r\n\r\n"Mengenai properti Indonesia anomalinya banyak, suplai banyak harga lemah, ini nggak," kata Nuzul di Pusdik LPEM UI, Jakarta, Kamis (25/9/2014).\r\n\r\nNuzul mengungkapkan, saat ini harga properti di Indonesia sudah tidak masuk akal. Pasalnya negara dengan pendapatan per kapita  US$ 3.600 lebih, harga tanahnya melebihi pendapatan masyarakat.\r\n\r\nPemerintah pun harus turun tangan mengontrol hal tersebut, sehingga para pengembang tidak bisa seenaknya melakukan spekulasi harga.\r\n\r\n"Negara mengkontrol seberapa jauh pemerintah mengontrol. Pemerintah aktif sehingga pengembang tidak bisa seenaknya banyak spekulasi," ungkap dia.\r\n\r\nPemerintah juga harus tegas kepada pengembang yang sudah mendapat lahan untuk segera membangun. Pasalnya, jika dibiarkan harga akan meningkat dengan menyesuaikan kenaikan harga tanah.\r\n\r\n"Jangan dibiarkan, langsung bangun kalau tidak saya cabut, supaya tidak spekulasi," pungkasnya. (Pew/Nrm)', 3, 'Admin', 9, 'Berita perumahan', 'http://bisnis.liputan6.com/read/2110369/harga-properti-melambung-jadi-kesalahan-pemerintah', '2015-08-29 22:18:00', 0, 0, '2015/08/29/UT3PGlncN-Fjt-7jwpLwew3A8lJ9SC2d.jpg', '', '', '', '', '', '', '', '', '', '', 1, 1, '2015-08-29 22:18:26', '2015-08-29 22:18:26', 'Super'),
(12, 'BTN Komitmen Bantu Masyarakat Punya Rumah', 'Direktur Utama BTN Maryono menegaskan, BTN tetap berkomitmen dan konsisten mengembangkan bisnis perbankan ', 'Liputan6.com, Jakarta - Kebutuhan masyarakat akan properti hunian terus meningkat dari tahun ke tahun. Menghadapi kondisi tersebut, Direktur Utama PT Bank Tabungan Negara (Persero) Tbk, Maryono menegaskan, BTN tetap berkomitmen dan konsisten mengembangkan bisnis perbankan pembiayaan perumahan.\r\n\r\n“Dari portofolio pembiayaan di mana aset BTN bernilai sebesar Rp 135 triliun, naik dari total Rp 111 triliun, 85 persennya ada di bidang perumahan,” jelasnya saat memberikan sambutan dalam acara peresmian BTN Property Expo 2014 di Jakarta, Sabtu (16/8/2014).\r\n\r\nDia menjelaskan, selama bertahun-tahun BTN telah mengantongi kepercayaan dari pemerintah untuk menyalurkan kredit Fasilitas Likuiditas Pembiayaan Perumahan (FLPP) atau biasa dikenal dengan sebutan kredit subsidi. Rata-rata BTN berhasil merealisasikan kredit FLPP sekitar 95-96 persen dari target pemerintah.\r\n\r\n“Itu merupakan satu bukti bahwa BTN berupaya memudahkan penjualan rumah pada rakyat. Di samping itu, BTN juga tidak melupakan pembiayaan perumahan di segmen non subsidi,” ujarnya.\r\n\r\nMaryono menerangkan, terdapat beberapa jurus yang telah dilakukan BTN guna membantu pembiayaan perumahan bagi masyarakat luas. Selama ini, BTN telah memberikan produk kredit perumahan rakyat (KPR) yang bervariasi agar masyarakat dari segala kalangan dapat membeli rumah sesuai dengan kemampuannya.\r\n\r\n“Kami juga memberikan dorongan bantuan pembiayaan pada developer. Selain itu, kami juga telah empat tahun menggelar acara pameran properti (BTN Property Expo) agar mempermudah masyarakat memiliki rumah,” terangnya.\r\n\r\nSekadar informasi, BTN Property Expo kembali digelar untuk keempat kalinya tahun ini dan digelar selama sembilan hari di Gedung Jakarta Convention Center. Pameran properti bertajuk Pesta KPR BTN ini menampilkan sekitar 410 projek properti di berbagai wilayah di Indonesia dan diikuti 178 pengembang. (Sis/Nrm)', 3, 'Admin', 9, 'Berita perumahan', 'http://bisnis.liputan6.com/read/2091921/btn-komitmen-bantu-masyarakat-punya-rumah', '2015-08-29 22:19:00', 0, 0, '2015/08/29/GCNe9uEefc2IoxVbguEGuU4f48K7asHC.jpg', '', '', '', '', '', '', '', '', '', '', 1, 1, '2015-08-29 22:19:48', '2015-08-29 22:19:48', 'Super'),
(13, 'Hunian di Serpong Masih Menjadi Incaran', 'Para pengembang menjadikan Serpong dan sekitarnya ini jadi kawasan emas untuk properti.', 'Liputan6.com, Jakarta - Kepadatan Jakarta ternyata berdampak positif kepada perkembangan properti di sekitarnya. Saat ini, banyak sekali properti bertumbuhan di daerah-daerah penunjang seperti di wilayah Serpong dan kawasan Tangerang.\r\n\r\nKetua Asosiasi Real Estate Broker Indonesia (Arebi) Banten, Nurul Yaqien mengatakan, kawasan Serpong menjadi kawasan menjanjikan untuk bisnis properti. \r\n\r\n"Mayoritas untuk hunian. Karena letaknya yang berdekatan dengan ibu kota,  para pengembang menjadikan Serpong dan sekitarnya ini jadi kawasan emas untuk properti," ungkapnya.\r\n\r\nMaka tak heran, bila harga hunian di kawasan ini harganya melejit dibanding daerah lain. "Maka saya sarankan, kalau punya Rp 350 juta ditangan, lebih baik beli apartemen. Karena harga perumahan sudah semakin melangit," paparnya.\r\n\r\nMelejitnya permintaan akan hunian di Serpong, juga diungkapkan Deputy KSO Merdeka Ronov Indonesia, sebuah perusahaan pengembang, Kiki Iswara. Menurutnya, proyek dari Merdeka Ronov yang mengeluarkan dana investasi sebesar Rp 750 miliar telah terjual 85 persen.\r\n\r\n"Untuk apartemen sendiri sudah terjual 85 persen, kemudian di kawasan ini juga hadir perkantoran yang sudah terjual 40 persen. Ini sangat signifikan penjualannya," ujar Kiki.\r\n\r\nMenurutnya, selain berada dekat dengan ibu kota, penjualan yang melejit ini dipengaruhi juga akses jalan yang mudah. Sehingga, menjadikan nilai jual hunian dan properti tersebut diburu peminatnya. (Naomi Trisna/Gdn)', 3, 'Admin', 9, 'Berita perumahan', 'http://bisnis.liputan6.com/read/2082594/hunian-di-serpong-masih-menjadi-incaran', '2015-08-29 22:21:00', 0, 0, '2015/08/29/YRqYUWqXdHI5x5gYczIF3PryZACpXLQa.jpg', '', '', '', '', '', '', '', '', '', '', 1, 1, '2015-08-29 22:21:54', '2015-08-29 22:21:54', 'Super'),
(14, 'Bekasi dan Depok Akan Jadi Incaran Para Pemburu Properti', 'Jones Lang Lasalle memperkirakan Bekasi dan Depok akan menjadi wilayah yang seksi untuk pilihan investasi di sektor ', 'Konsultan properti, Jones Lang Lasalle memperkirakan Bekasi dan Depok, dua daerah yang berada di pinggiran Kota Jakarta, akan menjadi wilayah yang seksi untuk pilihan investasi di sektor residensial (perumahan dan kondominium) dalam beberapa tahun mendatang.\r\n\r\nPasalnya, harga tanah di Bekasi dan Depok masih cukup terjangkau, bahkan berpotensi merangkak naik seiring perkembangan infrastruktur di kawasan tersebut.\r\n\r\nNational Director Head of Strategic Jones Lang Lasalle, Vivin Harsanto mengungkapkan, kondominium mulai menyesaki daerah Bekasi, sementara Depok sudah ramai dengan proyek-proyek pembangunan perumahan.\r\n\r\n"Kalau harga tanah di daerah Serpong, Cilandak, Cipete, Puri Indah, Pluit, Kelapa Gading dan lainnya sudah cukup tinggi, sehingga pengembang melirik Bekasi dan Depok," kata dia di kantornya, Jakarta, Kamis (23/1/2014).\r\n\r\nMenurut Vivin, kemolekan dua daerah ini sebagai wilayah yang cocok untuk berinvestasi sektor properti kian terangkat seiring dengan kemajuan perkembangan infrastruktur seperti jalan, perguruan tinggi, mal dan sebagainya.\r\n\r\nKondisi ini, tambah dia, mendorong harga tanah di Bekasi dan Depok merangkak naik. Peningkatan harga tanah itu, dimulai dari pengembangan yang dilakukan oleh pengembang besar Sumarecon di wilayah Bekasi. Sementara Depok, aktivitas pengembangan infrastruktur terjadi di daerah Margonda.\r\n\r\n"Harga tanah di Bekasi dan Depok berpotensi naik sekitar 20%-30% tergantung bentuk pengembangannya. Karena harga tanah di Bekasi saat ini untuk pembangunan rumah sekitar Rp 5 juta per meter persegi, sedangkan Depok sekitar Rp 3 juta-Rp 5 juta per meter persegi," terang Vivin.\r\n\r\nJika melongok harga tanah di daerah seksi di Jakarta Selatan, seperti Cilandak dan Cipete, harga tanah sudah menembus Rp 10 juta-Rp 15 juta per meter persegi atau mengalami pertumbuhan harga 50%-60% dalam kurun waktu dua tahun. (Fik/Nrm)', 3, 'Admin', 9, 'Berita perumahan', 'http://bisnis.liputan6.com/read/807829/bekasi-dan-depok-akan-jadi-incaran-para-pemburu-properti', '2015-08-29 22:23:00', 0, 0, '2015/08/29/9mXDc4w8QIrLF6gT6VAdNk4QPLMlD4J4.jpg', '', '', '', '', '', '', '', '', '', '', 1, 1, '2015-08-29 22:23:28', '2015-08-29 22:23:28', 'Super'),
(15, 'Rumah Tipe Apa yang Paling Laku Saat Bunga Kredit Naik?', 'Pengusaha pengembang properti mangatakan masyarakat kian pilih-pilih membeli rumah dengan melihat kondisi saat ini.', 'Masyarakat kian pilih-pilih membeli rumah dengan melihat kondisi bunga kredit saat ini. Itu karena mereka memikirkan cicilan yang harus dibayar tiap bulan bisa terus berubah akibat dampak dari kenaikan suku bunga kredit di bank.\r\n\r\nKetua Umum Asosiasi Pengembang Perumahan dan Pemukiman Seluruh Indonesia (Apersi), Edi Ganefo mengungkapkan ada beberapa tipe yang paling banyak diincar masyarakat dengan menyesuaikan kantong mereka. \r\n\r\n"Untuk perumahan komersil tipe paling laku 45 sampai 70, sementara pada rumah subsidi tipe 22 di Pulau Jawa dan 36 di luar Pulau Jawa," ujar Edi, Jumat (15/11/2013) ketika dihubungi liputan6.com.\r\n\r\nEdi menyebutkan, pembeli rumah komersil dengan tipe 45 sampai 70 biasanya merupakan golongan menengah atas. Harga rumah tipe ini berkisar Rp 200 juta sampai Rp 500 juta per unit. \r\n\r\nSedangkan untuk rumah subsidi diperuntukkan bagi masyarakat kelas menengah bawah. Harga rumah tipe 22 dan 36 yang paling diincar berkisar Rp 88 juta sampai Rp 95 juta.\r\n\r\nEdi menuturkan, kenaikan BI rate membuat masyarakat benar-benar memikirkan tipe rumah yang akan mereka beli. Sebab mereka tak mau terbelenggu cicilan yang besar karena melihat suku bunga kredit rumah terus naik seiring kebijakan Bank Indonesia yang terus meningkatkan bunga acuannya (BI rate).\r\n\r\nSeperti diketahui, BI rate kembali naik untuk kelima kalinya menjadi 7,5%. Dampak dari ini, perbankan dipastikan akan mengikuti dengan menyesuaikan kembali suku bunga kredit mereka.\r\n\r\nMenurut Edi, sebenarnya saat ini industri properti nasional sedang berjalan cukup baik. Meski, sepanjang tahun ini industri properti tersandung beberapa hal, seperti kenaikan bahan bakar minyak (BBM), tarif listrik dan BI rate.\r\n\r\nMeski kondisinya masih baik, dia mengaku, BI sebaiknya tak lagi mengambil kebijakan menaikkan BI rate yang akan menekan sektor usaha perumahaan di Indonesia.\r\n\r\nSelain menetapkan kenaikan suku bunga acuan sebesar 25 basis poin menjadi 7,5%, BI juga menaikkan landing facility dari 7,25% menjadi 7,5%. Sementara itu, fasilitas simpanan BI/Fasbi naik dari 5,5% menjadi 5,75%. (Nur/Igw)', 3, 'Admin', 9, 'Berita perumahan', 'http://bisnis.liputan6.com/read/747080/rumah-tipe-apa-yang-paling-laku-saat-bunga-kredit-naik', '2015-08-29 22:24:00', 0, 0, '2015/08/29/BF_hAiCQ2pem_jzSEYM24lyFg6bC5t8Z.jpg', '', '', '', '', '', '', '', '', '', '', 1, 1, '2015-08-29 22:24:37', '2015-08-29 22:24:37', 'Super'),
(16, 'Diduga Akibat Korsleting, Belasan Rumah Terbakar', 'Banyaknya bahan mudah terbakar di sekitar titik kebakaran membuat api cepat membesar dan sulit dipadamkan.', 'Banyaknya bahan mudah terbakar di sekitar titik kebakaran membuat api cepat membesar dan sulit dipadamkan.', 3, 'Admin', 9, 'Berita perumahan', 'http://video.liputan6.com/news/diduga-akibat-korsleting-belasan-rumah-terbakar-1537879', '2015-08-29 22:29:00', 0, 0, '2015/08/29/wI9VQXc52F2YCLcR3xEuvJF9hPkPlr2K.jpg', '', '', '', '', '', '', '', '', '', '', 1, 1, '2015-08-29 22:29:46', '2015-08-29 22:29:46', 'Super');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jr_auth_assignment`
--

CREATE TABLE IF NOT EXISTS `jr_auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jr_auth_assignment`
--

INSERT INTO `jr_auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '3', 1440857872),
('moderator', '2', 1440857853),
('Superadmin', '1', 1440857814);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jr_auth_item`
--

CREATE TABLE IF NOT EXISTS `jr_auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jr_auth_item`
--

INSERT INTO `jr_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('/*', 2, NULL, NULL, NULL, 1440857264, 1440857264),
('/admin/*', 2, NULL, NULL, NULL, 1440857263, 1440857263),
('/admin/assignment/*', 2, NULL, NULL, NULL, 1440857261, 1440857261),
('/admin/assignment/assign', 2, NULL, NULL, NULL, 1440857261, 1440857261),
('/admin/assignment/index', 2, NULL, NULL, NULL, 1440857261, 1440857261),
('/admin/assignment/search', 2, NULL, NULL, NULL, 1440857261, 1440857261),
('/admin/assignment/view', 2, NULL, NULL, NULL, 1440857261, 1440857261),
('/admin/default/*', 2, NULL, NULL, NULL, 1440857261, 1440857261),
('/admin/default/index', 2, NULL, NULL, NULL, 1440857261, 1440857261),
('/admin/menu/*', 2, NULL, NULL, NULL, 1440857262, 1440857262),
('/admin/menu/create', 2, NULL, NULL, NULL, 1440857262, 1440857262),
('/admin/menu/delete', 2, NULL, NULL, NULL, 1440857262, 1440857262),
('/admin/menu/index', 2, NULL, NULL, NULL, 1440857261, 1440857261),
('/admin/menu/update', 2, NULL, NULL, NULL, 1440857262, 1440857262),
('/admin/menu/view', 2, NULL, NULL, NULL, 1440857262, 1440857262),
('/admin/permission/*', 2, NULL, NULL, NULL, 1440857262, 1440857262),
('/admin/permission/assign', 2, NULL, NULL, NULL, 1440857262, 1440857262),
('/admin/permission/create', 2, NULL, NULL, NULL, 1440857262, 1440857262),
('/admin/permission/delete', 2, NULL, NULL, NULL, 1440857262, 1440857262),
('/admin/permission/index', 2, NULL, NULL, NULL, 1440857262, 1440857262),
('/admin/permission/search', 2, NULL, NULL, NULL, 1440857262, 1440857262),
('/admin/permission/update', 2, NULL, NULL, NULL, 1440857262, 1440857262),
('/admin/permission/view', 2, NULL, NULL, NULL, 1440857262, 1440857262),
('/admin/role/*', 2, NULL, NULL, NULL, 1440857262, 1440857262),
('/admin/role/assign', 2, NULL, NULL, NULL, 1440857262, 1440857262),
('/admin/role/create', 2, NULL, NULL, NULL, 1440857262, 1440857262),
('/admin/role/delete', 2, NULL, NULL, NULL, 1440857262, 1440857262),
('/admin/role/index', 2, NULL, NULL, NULL, 1440857262, 1440857262),
('/admin/role/search', 2, NULL, NULL, NULL, 1440857262, 1440857262),
('/admin/role/update', 2, NULL, NULL, NULL, 1440857262, 1440857262),
('/admin/role/view', 2, NULL, NULL, NULL, 1440857262, 1440857262),
('/admin/route/*', 2, NULL, NULL, NULL, 1440857262, 1440857262),
('/admin/route/assign', 2, NULL, NULL, NULL, 1440857262, 1440857262),
('/admin/route/create', 2, NULL, NULL, NULL, 1440857262, 1440857262),
('/admin/route/index', 2, NULL, NULL, NULL, 1440857262, 1440857262),
('/admin/route/search', 2, NULL, NULL, NULL, 1440857262, 1440857262),
('/admin/rule/*', 2, NULL, NULL, NULL, 1440857263, 1440857263),
('/admin/rule/create', 2, NULL, NULL, NULL, 1440857262, 1440857262),
('/admin/rule/delete', 2, NULL, NULL, NULL, 1440857263, 1440857263),
('/admin/rule/index', 2, NULL, NULL, NULL, 1440857262, 1440857262),
('/admin/rule/update', 2, NULL, NULL, NULL, 1440857263, 1440857263),
('/admin/rule/view', 2, NULL, NULL, NULL, 1440857262, 1440857262),
('/artikel/*', 2, NULL, NULL, NULL, 1440857263, 1440857263),
('/artikel/create', 2, NULL, NULL, NULL, 1440857263, 1440857263),
('/artikel/delete', 2, NULL, NULL, NULL, 1440857263, 1440857263),
('/artikel/index', 2, NULL, NULL, NULL, 1440857263, 1440857263),
('/artikel/update', 2, NULL, NULL, NULL, 1440857263, 1440857263),
('/artikel/view', 2, NULL, NULL, NULL, 1440857263, 1440857263),
('/category/*', 2, NULL, NULL, NULL, 1440857263, 1440857263),
('/category/ajaxlihatsubcat', 2, NULL, NULL, NULL, 1440857263, 1440857263),
('/category/create', 2, NULL, NULL, NULL, 1440857263, 1440857263),
('/category/delete', 2, NULL, NULL, NULL, 1440857263, 1440857263),
('/category/index', 2, NULL, NULL, NULL, 1440857263, 1440857263),
('/category/update', 2, NULL, NULL, NULL, 1440857263, 1440857263),
('/category/view', 2, NULL, NULL, NULL, 1440857263, 1440857263),
('/gii/*', 2, NULL, NULL, NULL, 1440857263, 1440857263),
('/gii/default/*', 2, NULL, NULL, NULL, 1440857263, 1440857263),
('/gii/default/action', 2, NULL, NULL, NULL, 1440857263, 1440857263),
('/gii/default/diff', 2, NULL, NULL, NULL, 1440857263, 1440857263),
('/gii/default/index', 2, NULL, NULL, NULL, 1440857263, 1440857263),
('/gii/default/preview', 2, NULL, NULL, NULL, 1440857263, 1440857263),
('/gii/default/view', 2, NULL, NULL, NULL, 1440857263, 1440857263),
('/site/*', 2, NULL, NULL, NULL, 1440857264, 1440857264),
('/site/error', 2, NULL, NULL, NULL, 1440857263, 1440857263),
('/site/index', 2, NULL, NULL, NULL, 1440857263, 1440857263),
('/site/login', 2, NULL, NULL, NULL, 1440857263, 1440857263),
('/site/logout', 2, NULL, NULL, NULL, 1440857263, 1440857263),
('/user/*', 2, NULL, NULL, NULL, 1440857264, 1440857264),
('/user/create', 2, NULL, NULL, NULL, 1440857264, 1440857264),
('/user/delete', 2, NULL, NULL, NULL, 1440857264, 1440857264),
('/user/index', 2, NULL, NULL, NULL, 1440857264, 1440857264),
('/user/update', 2, NULL, NULL, NULL, 1440857264, 1440857264),
('/user/view', 2, NULL, NULL, NULL, 1440857264, 1440857264),
('admin', 1, 'admin jurnalrumah : artikel, user, kategori', NULL, NULL, 1440857718, 1440857718),
('Admin akses', 2, 'akses untuk level admin', NULL, NULL, 1440857468, 1440857468),
('moderator', 1, 'moderator jurnalrumah : artikel', NULL, NULL, 1440857770, 1440857770),
('Moderator Akses', 2, 'Akses untuk role moderator', NULL, NULL, 1440857414, 1440857414),
('Superadmin', 1, 'superadmin jurnalrumah : semua akses', NULL, NULL, 1440857648, 1440857648),
('Superadmin akses', 2, 'akses untuk level superadmin', NULL, NULL, 1440857347, 1440857347);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jr_auth_item_child`
--

CREATE TABLE IF NOT EXISTS `jr_auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jr_auth_item_child`
--

INSERT INTO `jr_auth_item_child` (`parent`, `child`) VALUES
('Superadmin akses', '/*'),
('Admin akses', '/artikel/*'),
('Moderator Akses', '/artikel/*'),
('Admin akses', '/category/*'),
('Admin akses', '/user/*'),
('admin', 'Admin akses'),
('moderator', 'Moderator Akses'),
('Superadmin', 'Superadmin akses');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jr_auth_rule`
--

CREATE TABLE IF NOT EXISTS `jr_auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jr_category`
--

CREATE TABLE IF NOT EXISTS `jr_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(30) NOT NULL,
  `deskripsi` text NOT NULL,
  `parent_category` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `date_create` datetime NOT NULL,
  `date_update` datetime NOT NULL,
  `user_create` int(11) NOT NULL,
  `user_update` int(11) NOT NULL,
  `user_by` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_category` (`parent_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data untuk tabel `jr_category`
--

INSERT INTO `jr_category` (`id`, `nama`, `deskripsi`, `parent_category`, `status`, `date_create`, `date_update`, `user_create`, `user_update`, `user_by`) VALUES
(7, 'Artikel', 'Kategori Khusus Artikel', 0, 0, '2015-08-29 21:48:07', '2015-08-29 21:48:07', 1, 1, 'Super'),
(8, 'Tips', 'Kategori artikel tips', 7, 0, '2015-08-29 21:49:18', '2015-08-29 21:49:18', 1, 1, 'Super'),
(9, 'Berita perumahan', 'Kategori berita perumahan', 7, 0, '2015-08-29 22:05:59', '2015-08-29 22:05:59', 1, 1, 'Super');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jr_tag`
--

CREATE TABLE IF NOT EXISTS `jr_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `frequency` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jr_user`
--

CREATE TABLE IF NOT EXISTS `jr_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_depan` varchar(30) NOT NULL,
  `nama_belakang` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `telp` varchar(15) NOT NULL,
  `jenis_kelamin` tinyint(4) NOT NULL,
  `pict` text NOT NULL,
  `password` text NOT NULL,
  `deskripsi` text NOT NULL,
  `type_user` int(11) NOT NULL,
  `newsletter` int(11) NOT NULL,
  `activation_code` varchar(15) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `last_login` datetime NOT NULL,
  `salt` text NOT NULL,
  `role` text NOT NULL,
  `date_create` datetime NOT NULL,
  `date_update` datetime NOT NULL,
  `user_create` int(11) NOT NULL,
  `user_update` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data untuk tabel `jr_user`
--

INSERT INTO `jr_user` (`id`, `nama_depan`, `nama_belakang`, `email`, `username`, `alamat`, `telp`, `jenis_kelamin`, `pict`, `password`, `deskripsi`, `type_user`, `newsletter`, `activation_code`, `status`, `last_login`, `salt`, `role`, `date_create`, `date_update`, `user_create`, `user_update`) VALUES
(1, 'Super', 'Admin', 'iwansusanto87@gmail.com', 'iwansusanto87@gmail.com', 'Indonesia', '87', 1, '2015/07/15/VOdFf0EM1nb7BMNk4yWkJZpY0WoRm1KU.jpeg', '8f2673ace45290817d9f3bf0a69038f9ae578369', '', 3, 0, '', 0, '2015-12-05 14:50:10', '9f0e59d54a681bf2afbbb8ff65732a95e1b5f018', 'Superadmin', '2015-08-09 00:00:00', '2015-08-02 00:00:00', 0, 1),
(2, 'Moderator', 'Gerai', 'cs.jurnalrumah@gmail.com', 'cs.jurnalrumah@gmail.com', 'Depok', '087888111778', 1, '2015/08/17/gBApmWw5dMe80n9F58DZ9Zkk2dIw40sw.jpg', 'd99d89105be4f267922dd156af39417ed9bc4f9a', 'Moderator', 2, 1, 'e7fcd871c3ff1a6', 0, '2015-08-29 21:30:19', '37203871433dd71ffe34b52f2418fad2180c00a4', 'moderator', '2015-08-17 09:16:02', '2015-08-17 09:16:02', 1, 1),
(3, 'Admin', 'Gerai', 'admin.jurnalrumah@gmail.com', 'admin.jurnalrumah@gmail.com', 'Depok', '087888111778', 1, '2015/08/17/E9_ahrmksewmS0Nx5yOFa47sljCrLqmh.jpg', 'a8ff65217b719786c483f3188f95411b8332a572', 'Admingerai', 2, 1, 'ea7b723cd196db4', 0, '2015-08-17 10:19:50', '74c48a8514c2a661f5a02272f4bd13c3d6a65651', 'admin', '2015-08-17 09:38:02', '2015-08-17 09:38:02', 1, 1),
(4, 'Moderator', 'Jurnal Rumah', 'moderator@jurnalrumah.com', 'moderator@jurnalrumah.com', 'Depok', '087888111778', 1, '2015/12/05/SLAzk4_M-B1AZH7BNqg1Y7DrJ7rDGgDB.jpg', '06cf378530deee1f4dec3bd655019eccc80abf7e', 'Akun moderator', 2, 1, 'b8617d0cb842638', 0, '0000-00-00 00:00:00', '413c1316c78589cfc5c8a3df68ce32a4de3b9724', 'moderator', '2015-12-05 14:58:00', '2015-12-05 14:58:00', 1, 1);

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `jr_auth_assignment`
--
ALTER TABLE `jr_auth_assignment`
  ADD CONSTRAINT `jr_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `jr_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jr_auth_item`
--
ALTER TABLE `jr_auth_item`
  ADD CONSTRAINT `jr_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `jr_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jr_auth_item_child`
--
ALTER TABLE `jr_auth_item_child`
  ADD CONSTRAINT `jr_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `jr_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jr_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `jr_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
