<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Personal_model extends MY_Model{

    function get_where_person($id="")
    {
      $qry = $this->db->select("tb_person.id_person,
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
                                tb_person.ukuran_baju,
                                tb_person.is_active,
                                tb_person.is_complate,
                                tb_person.keterangan,
                                tb_person.created,
                                level_person.level,
                                rekening_person.id_rekening_person,
                                rekening_person.nama_rekening,
                                rekening_person.no_rekening,
                                rekening_person.bank,
                                rekening_person.file_foto_rek,
                                auth_person.id_auth,
                                auth_person.username")
                ->from("tb_person")
                ->join("level_person","level_person.id_level = tb_person.id_level","left")
                ->join("rekening_person","rekening_person.id_person = tb_person.id_person","left")
                ->join("auth_person","auth_person.id_person = tb_person.id_person","left")
                ->where("tb_person.id_person",$id)
                ->get()
                ->row();
      return $qry;
    }



function json_personal($id)
{
  $this->datatables->select("tb_person.id_person,
                              tb_person.kode_person,
                              tb_person.is_active,
                              tb_person.id_level,
                              tb_person.nama,
                              auth_person.username");
    $this->datatables->from('tb_person');
    $this->datatables->join('auth_person','auth_person.id_person = tb_person.id_person');
    $this->datatables->where("id_level",$id);
    $this->datatables->add_column('action','<a href="#" class="badge badge-primary text-white" data-id="$1" data-nama="$2&nbsp;|&nbsp;$3&nbsp;|&nbsp;$4" id="pilih-person"><i class="ti-check-box"></i> Pilih</a>','id_person,kode_person,nama,username');
    return $this->datatables->generate();
}


function export($id_level="")
{
  $qry = $this->db->select("tb_person.id_person,
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
                            tb_person.ukuran_baju,
                            tb_person.waris_alamat,
                            tb_person.is_active,
                            tb_person.is_complate,
                            tb_person.keterangan,
                            tb_person.created,
                            level_person.level,
                            rekening_person.id_rekening_person,
                            rekening_person.nama_rekening,
                            rekening_person.no_rekening,
                            rekening_person.bank,
                            rekening_person.file_foto_rek,
                            auth_person.id_auth,
                            auth_person.username")
            ->from("tb_person")
            ->join("level_person","level_person.id_level = tb_person.id_level","left")
            ->join("rekening_person","rekening_person.id_person = tb_person.id_person","left")
            ->join("auth_person","auth_person.id_person = tb_person.id_person","left")
            ->where("tb_person.id_level",$id_level)
            ->get();
  return $qry;
}

}
