<?php

/*
Pesan: baca dengan teliti, penjelasan ada di baris komentar yang disisipkan.
Bot tidak akan berjalan, jika tidak diamati coding ini sampai akhir.
*/
/*
//isikan token dan nama botmu yang di dapat dari bapak bot :
$TOKEN = "842590160:AAExqP6zh1v-EaMDWWoM_ZuBiGwuF66Ricc";
$usernamebot= "@kangaroospringbed_bot"; // sesuaikan besar kecilnya, bermanfaat nanti jika bot dimasukkan grup.
*/
//isikan token dan nama botmu yang di dapat dari bapak bot :
$TOKEN = "1243315513:AAEakZlDO6T1HxW-XTHbpmun06XxwhvPHlw";
$usernamebot= "@kabayan_bot"; // sesuaikan besar kecilnya, bermanfaat nanti jika bot dimasukkan grup.

// aktifkan ini jika perlu debugging
$debug = false;

// fungsi untuk mengirim/meminta/memerintahkan sesuatu ke bot
function request_url($method)
{
global $TOKEN;
return "https://api.telegram.org/bot" . $TOKEN . "/". $method;
}

// fungsi untuk meminta pesan
// bagian ebook di sesi Meminta Pesan, polling: getUpdates
function get_updates($offset)
{
$url = request_url("getUpdates")."?offset=".$offset;
$resp = file_get_contents($url);
$result = json_decode($resp, true);
if ($result["ok"]==1)
return $result["result"];
return array();
}

// fungsi untuk mebalas pesan,
// bagian ebook Mengirim Pesan menggunakan Metode sendMessage
function send_reply($chatid, $msgid, $text)
{
global $debug;
$data = array(
'chat_id' => $chatid,
'text' => $text,
'reply_to_message_id' => $msgid // <---- biar ada reply nya balasannya, opsional, bisa dihapus baris ini
);
// use key 'http' even if you send the request to https://...
$options = array(
'http' => array(
'header' => "Content-type: application/x-www-form-urlencodedrn",
'method' => 'POST',
'content' => http_build_query($data),
),
);
$context = stream_context_create($options);
$result = file_get_contents(request_url('sendMessage'), false, $context);

if ($debug)
print_r($result);
}

// fungsi mengolahan pesan, menyiapkan pesan untuk dikirimkan

function create_response($text, $message)
{
	global $usernamebot;
	// inisiasi variable hasil yang mana merupakan hasil olahan pesan
	$hasil = '';

	$fromid = $message["from"]["id"]; // variable penampung id user
	$chatid = $message["chat"]["id"]; // variable penampung id chat
	$pesanid= $message['message_id']; // variable penampung id message

	// variable penampung username nya user
	isset($message["from"]["username"])
	? $chatuser = $message["from"]["username"]
	: $chatuser = '';

	// variable penampung nama user

	isset($message["from"]["last_name"])
	? $namakedua = $message["from"]["last_name"]
	: $namakedua = '';
	$namauser = $message["from"]["first_name"]. ' ' .$namakedua;

	// ini saya pergunakan untuk menghapus kelebihan pesan spasi yang dikirim ke bot.
	$textur = preg_replace('/ss+/', ' ', $text);

	// memecah pesan dalam 2 blok array, kita ambil yang array pertama saja
	$command = explode(' ',$textur,2); //

	// identifikasi perintah (yakni kata pertama, atau array pertamanya)
	switch ($command[0])
	{
		// jika ada pesan /id, bot akan membalas dengan menyebutkan idnya user
		case '/id':
		case '/id'.$usernamebot : //dipakai jika di grup yang haru ditambahkan @usernamebot
		$hasil = "$namauser, ID kamu adalah $fromid";
		break;

		// jika ada permintaan waktu
		date_default_timezone_set('Asia/Jakarta');
		case '/time':
		case '/time'.$usernamebot :
		$hasil = "$namauser, waktu lokal bot sekarang adalah : ";
		$hasil .= date("d M Y")." Pukul ".date("H:i:s");
		break;

		// jika ada permintaan detail PT. AKA
		case '/ptaka':
		case '/ptaka'.$usernamebot :
		$hasil = "PT. ANUGRAH KARYA ASLINDO
Jl. Raya Pangkalan Baru KM. 8 Simpang Pulai,
Kel. Desa Baru, Kec. Siakhulu, Kab. Kampar
28452 - RIAU
pt.aka@kangaroospringbed.com";
		break;

		// jika ada permintaan detail PT. AMJ
		case '/ptamj':
		case '/ptamj'.$usernamebot :
		$hasil = "PT. ANUGERAH MAJU JAYA
Jl. Raya Pangkalan Baru KM. 9 Simpang Pulai,
Kel. Desa Baru, Kec. Siakhulu, Kab. Kampar
28452 - RIAU
pt.amj@kangaroospringbed.com";
		break;

		// jika ada permintaan detail PT. AKS
		case '/ptaks':
		case '/ptaks'.$usernamebot :
		$hasil = "PT. ANUGERAH KARYA SENTOSA
Komplek Citra Buana Centre Park Blok BB no 1-4,
Kel. Pelita, Kec. Lubuk Baja
29444 - KEPULAUAN RIAU
pt.aks@kangaroospringbed.com";
		break;

		// jika ada permintaan detail PT. AMIN
		case '/ptamin':
		case '/ptamin'.$usernamebot :
		$hasil = "PT. ANUGERAH MUSI INDAH NUSANTARA
Jl. Camat 1 RT. 52 / RW. 08 KM. 16,
Kel. Sukamoro, Kec.Talang Kelapa Kab. Banyuasin
30961 - SUMATERA SELATAN
pt.amin@kangaroospringbed.com";
		break;

		// jika ada permintaan detail PT. AKM
		case '/ptakm':
		case '/ptakm'.$usernamebot :
		$hasil = "PT. ANUGERAH KARYA MEBELINDO
Jl. Lintas Sumatera KM. 30 No. 77 B,
Kel. Banjar Negeri, Kec. Natar, Kab. Lampung Selatan,
35362 - LAMPUNG
pt.akm@kangaroospringbed.com";
		break;

		// jika ada permintaan detail PT. AJM
		case '/ptajm':
		case '/ptajm'.$usernamebot :
		$hasil = "PT. ANUGERAH JAYA MULTIPLIKASI
Jl. Raya By Pass Kawasan Industri PIP Bintungan Kanagarian Kasang,
Kel. Kasang, Kec. Batang Anai, Kab. Padang Priaman
25586 - SUMATERA BARAT
pt.ajm@kangaroospringbed.com";
		break;

		// jika ada permintaan detail PT. AMI
		case '/ptami':
		case '/ptami'.$usernamebot :
		$hasil = "PT. ANUGERAH MULTIPLIKASI INDONESIA
Jln. Jambi - Suak Kandis, No.6 RT.6,
Kel. Pudak, Kec. Kumpeh Ulu, Kab. Muaro Jambi
36373 - JAMBI
pt.ami@kangaroospringbed.com";
		break;

		// jika ada permintaan detail PT. AGEM
		case '/ptagem':
		case '/ptagem'.$usernamebot :
		$hasil = "PT. ANUGERAH GERBANG EMAS
Jl. Suryadinata (CV Anggun Rotan),
Kel. Marikangen, Kec. Plumbon, Kab Cirebon 
45155 - JAWA BARAT
pt.agem@kangaroospringbed.com";
		break;

		// jika ada permintaan detail PT. AKP
		case '/ptakp':
		case '/ptakp'.$usernamebot :
		$hasil = "PT. ANUGERAH KREASI PLASINDO
Jl. Raya Pangkalan Baru KM. 10 Simpang Pulai,
Kel. Desa Baru, Kec. Siakhulu, Kab. Kampar
28452 - RIAU
pt.akp@kangaroospringbed.com";
		break;

		// jika ada permintaan waktu
		case '/laporanpenjualan':
		case '/time'.$usernamebot :
		$hasil = "$namauser, Laporan Penjualan untuk Tanggal : ";
		$hasil .= date("d M Y")." Pukul ".date("H:i:s");
		break;

		// jika ada permintaan waktu
		case '/laporanproduksi':
		case '/laporanproduksi'.$usernamebot :
		$hasil = "$namauser, Laporan Produksi untuk Tanggal : ";
		$hasil .= date("d M Y")." Pukul ".date("H:i:s");
		break;

		// jika ada permintaan waktu
		case '/siapasri':
		case '/siapasri'.$usernamebot :
		$hasil = "Sriwanti Jelek banget";
		break;

		// balasan default jika pesan tidak di definisikan
		default:
		$hasil = 'Terima Kasih';
		break;
	}

	return $hasil;
}

// jebakan token, klo ga diisi akan mati
// boleh dihapus jika sudah mengerti
if (strlen($TOKEN)<20)
die("Token mohon diisi dengan benar!n");

// fungsi pesan yang sekaligus mengupdate offset
// biar tidak berulang-ulang pesan yang di dapat
function process_message($message)
{
	$updateid = $message["update_id"];
	$message_data = $message["message"];
	if (isset($message_data["text"]))
	{
		$chatid = $message_data["chat"]["id"];
		$message_id = $message_data["message_id"];
		$text = $message_data["text"];
		$response = create_response($text, $message_data);
		if (!empty($response))
		send_reply($chatid, $message_id, $response);
	}
	return $updateid;
}

// hapus baris dibawah ini, jika tidak dihapus berarti kamu kurang teliti!

// hanya untuk metode poll
// fungsi untuk meminta pesan
// baca di ebooknya, yakni ada pada proses 1
function process_one()
{
global $debug;
$update_id = 0;
echo "-";

if (file_exists("last_update_id"))
$update_id = (int)file_get_contents("last_update_id");

$updates = get_updates($update_id);

// jika debug=0 atau debug=false, pesan ini tidak akan dimunculkan
if ((!empty($updates)) and ($debug) ) {
echo "rn===== isi diterima rn";
print_r($updates);
}

foreach ($updates as $message)
{
echo '+';
$update_id = process_message($message);
}

// update file id, biar pesan yang diterima tidak berulang
file_put_contents("last_update_id", $update_id + 1);
}

// metode poll
// proses berulang-ulang
// sampai di break secara paksa
// tekan CTRL+C jika ingin berhenti
/*while (true) {
process_one();
sleep(1);
}*/

// metode webhook
// secara normal, hanya bisa digunakan secara bergantian dengan polling
// aktifkan ini jika menggunakan metode webhook

$entityBody = file_get_contents('php://input');
$pesanditerima = json_decode($entityBody, true);
process_message($pesanditerima);


/*
* -----------------------
* Grup @botphp
* Jika ada pertanyaan jangan via PM
* langsung ke grup saja.
* ----------------------

* Just ask, not asks for ask..

Sekian.

*/

?>
