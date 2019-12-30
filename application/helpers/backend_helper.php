<?php if (!defined("BASEPATH")) exit("No direct script access allowed");
if ( ! function_exists('sess'))
{
  function sess($str)
  {
     $ci=& get_instance();
    return $ci->session->userdata($str);
  }
}

if ( ! function_exists('setting_system'))
{
  function setting_system($field)
  {
     $ci=& get_instance();
     $qry = $ci->db->get_where("setting_system",["id_setting_system"=>999]);
     return $qry->row()->$field;
  }
}


if ( ! function_exists('setting_financial'))
{
  function setting_financial($field)
  {
     $ci=& get_instance();
     $qry = $ci->db->get_where("setting_financial",["id_financial"=>999]);
     return $qry->row()->$field;
  }
}


if ( ! function_exists('level_person'))
{
  function level_person($id,$field)
  {
     $ci=& get_instance();
     $qry = $ci->db->get_where("level_person",["id_level"=>$id]);
     return $qry->row()->$field;
  }
}

if ( ! function_exists('profile_admin'))
{
  function profile_admin($field)
  {
     $ci=& get_instance();
     $qry = $ci->db->get_where("tb_admin",["id_admin"=>$ci->session->userdata("id_admin")]);
     return $qry->row()->$field;
  }
}

if ( ! function_exists('format_rupiah'))
{
  function format_rupiah($int)
  {
    return number_format($int, 0, ',', '.');
  }
}

if ( ! function_exists('replace_rupiah'))
{
  function replace_rupiah($int)
  {
    return str_replace(".","","$int");
  }
}


if (! function_exists('cek_invest')) {
  function cek_invest($id_invest,$field)
  {
    $ci=& get_instance();
    $qry = $ci->db->get_where("investment",["id_invest"=>$id_invest]);
    if ($qry->num_rows()==1) {
      return $qry->row()->$field;
    }else {
      return "error";
    }
  }
}


if ( ! function_exists('profile'))
{
  function profile_person($id,$field)
  {
      $ci=& get_instance();
      $qry = $ci->db->select("tb_person.id_person,
                                tb_person.is_parent,
                                tb_person.kode_person,
                                tb_person.id_level,
                                tb_person.nik,
                                tb_person.nama,
                                tb_person.tempat_lahir,
                                tb_person.tanggal_lahir,
                                tb_person.telepon1,
                                tb_person.telepon2,
                                tb_person.email,
                                tb_person.pekerjaan,
                                tb_person.alamat,
                                tb_person.file_foto,
                                tb_person.file_ktp,
                                tb_person.waris_nama,
                                tb_person.waris_hubungan,
                                tb_person.waris_telepon,
                                tb_person.waris_alamat,
                                tb_person.is_active,
                                tb_person.is_complate,
                                tb_person.is_complate_berkas,
                                tb_person.keterangan,
                                tb_person.ukuran_baju,
                                tb_person.created,
                                tb_person.modified,
                                auth_person.username,
                                level_person.level,
                                level_person.comission,
                                rekening_person.nama_rekening,
                                rekening_person.no_rekening,
                                rekening_person.bank,
                                rekening_person.file_foto_rek")
                        ->from("tb_person")
                        ->join("auth_person","auth_person.id_person = tb_person.id_person","left")
                        ->join("level_person","level_person.id_level = tb_person.id_level","left")
                        ->join("rekening_person","rekening_person.id_person = tb_person.id_person","left")
                        ->where("tb_person.id_person",$id)
                        ->get()
                        ->row();
    return $qry->$field;
  }
}

//form edit person
function dataname($id="")
{
  if ($id=="") {
    return "";
  }elseif ($id=="0") {
    return "admin";
  }else {
    $ci=& get_instance();
    $qry = $ci->db->select("tb_person.id_person,
                            tb_person.kode_person,
                            tb_person.is_active,
                            tb_person.id_level,
                            tb_person.nama,
                            auth_person.username")
                  ->from('tb_person')
                  ->join('auth_person','auth_person.id_person = tb_person.id_person')
                  ->where("tb_person.id_person",$id)
                  ->get()
                  ->row();
    return $qry->kode_person." | ".$qry->nama." | ".$qry->username;
  }

}



// cek is parent
function is_parent($id)
{
  $id = iterator_to_array(new RecursiveIteratorIterator(new RecursiveArrayIterator(cek_is_parent($id))), 0);
  return $id;
}

function cek_is_parent($id){ //Function get id left children
  $ci=& get_instance();
  $array = $ci->db->get_where("tb_person",['id_person'=>$id])->row();
  $is_parent=[];

  if($array->is_parent!=0) {
      array_push($is_parent, $array->is_parent);
      $is_parent[]= all_parent($array->is_parent);
  }
  return $is_parent;
}


function all_parent($id) { //Function get id all children
  $ci=& get_instance();
  $array = $ci->db->get_where("tb_person",['id_person'=>$id])->row();
  $all_parent = [];
  if($array->is_parent!=0) {
      array_push($all_parent, $array->is_parent);
      $all_parent[]= all_parent($array->is_parent);
  }
  return array_values($all_parent);
}


// end_cek is parent




	function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
		}
		return $temp;
	}

	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}
		return ucwords($hasil);
	}



  function omset($id_child_array)
  {
    $ci=& get_instance();
    $id = count($id_child_array);
    if ($id!=0) {
      $qry = $ci->db->select("investment.id_invest,
                              	investment.kode_invest,
                              	investment.id_person,
                              	SUM(investment.amount) AS amount,
                              	investment.status")
                        ->from("investment")
                        ->where("status","ongoing")
                        ->where_in("id_person",$id_child_array)
                        ->get();
        return $qry->row()->amount;
    }else {
      return 0;
    }

  }
