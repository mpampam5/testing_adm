<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Investment extends MY_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model("Investment_model","model");
  }

  function index()
  {
    $this->template->set_title("Investment");
    $this->template->view("content/investment/index");
  }

  function detail($id="")
  {
    if ($row =  $this->model->get_detail_invest($id)) {
      $this->template->set_title("Investment");
      $data['row'] = $row;
      $this->template->view("content/investment/detail",$data);
    }
  }


  function json()
  {
    if ($this->input->is_ajax_request()) {
      $list = $this->model->get_datatables();
      $data = array();
      foreach ($list as $rows) {

        $parent = is_parent($rows->id_person);
          if (profile_person($rows->id_person,"id_level")=="4") {
            $is_prt =  '<label style="font-size:14px;"><span class="text-primary">'.profile_person($parent[2],"level").'</span> : '.profile_person($parent[2],"nama").'</label></br>
                        <label style="font-size:14px;"><span class="text-primary">'.profile_person($parent[1],"level").'</span> : '.profile_person($parent[1],"nama").'</label></br>
                        <label style="font-size:14px;"><span class="text-primary">'.profile_person($parent[0],"level").'</span> : '.profile_person($parent[0],"nama").'</label>
                        ';
          }elseif (profile_person($rows->id_person,"id_level")=="3") {
            $is_prt =  '  <label style="font-size:14px;"><span class="text-primary">'.profile_person($parent[1],"level").'</span> : '.profile_person($parent[1],"nama").'</label></br>
                          <label style="font-size:14px;"><span class="text-primary">'.profile_person($parent[0],"level").'</span> : '.profile_person($parent[0],"nama").'</label>';
          }elseif (profile_person($rows->id_person,"id_level")=="2") {
            $is_prt =  '<label style="font-size:14px;"><span class="text-primary">'.profile_person($parent[0],"level").'</span> : '.profile_person($parent[0],"nama").'</label>';
          }else {
            $is_prt = "-";
          }

          $row = array();
          $row[] = '<span class="text-primary">'.$rows->kode_invest.'</span>';
          $row[] = date("d-m-Y",strtotime($rows->created));
          $row[] = '<label style="font-size:14px;"><span class="text-warning">'.$rows->kode_person.'</span> </label><br>
                    <label style="font-size:14px;"><span>'.$rows->nama.'</span></label>';
          $row[] = 'Rp.'.format_rupiah($rows->amount);
          $row[] = $is_prt;
          $row[] = $rows->status=="ongoing" ? '<span class="badge badge-success badge-pill">Ongoing</span>':'<span class="badge badge-danger badge-pill">Done</span>';

          $row[] = '<a href="'.site_url("backend/investment/detail/".enc_uri($rows->id_invest)).'" class="badge badge-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="DETAIL"><i class="ti-zoom-in"></i></a>';

          $data[] = $row;
      }

      $output = array(
                      "draw" => $_POST['draw'],
                      "recordsTotal" => $this->model->count_all(),
                      "recordsFiltered" => $this->model->count_filtered(),
                      "data" => $data,
              );
      //output to json format
      echo json_encode($output);
    }
  }

  function profit()
  {
    $this->template->set_title("Investment");
    $this->template->view("content/investment/index_profit");
  }

function json_profit()
{
  $this->load->library('Datatables');
    header('Content-Type: application/json');
    echo $this->model->json_profit();
}


function dividen()
{
  $this->template->set_title("Investment");
  $this->template->view("content/investment/index_dividen");
}

function json_dividen()
{
$this->load->library('Datatables');
  header('Content-Type: application/json');
  echo $this->model->json_dividen();
}




  function get_spk($id="")
    {
      if ($id!="") {
        if ($row = $this->model->get_detail_invest($id)) {
          $this->load->library('Pdfgenerator');
          $data["row"] = $row;
          $html = $this->load->view('content/investment/spk',$data,true);
          $filename = 'report_'.time();
          $this->pdfgenerator->generate($html, $filename, true, 'A4', 'portrait');
        }
      }
    }

function xxx()
{
  include APPPATH.'third_party/PHPExcel/PHPExcel.php';




  $excel = new PHPExcel();
 // Settingan awal fil excel
 $excel->getProperties()->setCreator('My Notes Code')
              ->setLastModifiedBy('My Notes Code')
              ->setTitle("Data Investment")
              ->setSubject("Investment")
              ->setDescription("Laporan Profit Invesment")
              ->setKeywords("Laporan Invesment");
 // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
 $style_col = array(
   'font' => array('bold' => true), // Set font nya jadi bold
   'alignment' => array(
     'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
     'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
   ),
   'borders' => array(
     'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
     'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
     'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
     'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
   )
 );
 // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
 $style_row = array(
   'alignment' => array(
     'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
   ),
   'borders' => array(
     'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
     'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
     'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
     'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
   )
 );
 $excel->setActiveSheetIndex(0)->setCellValue('A1', "LAPORAN INVESTASI CLIENT"); // Set kolom A1 dengan tulisan "DATA SISWA"
 $excel->getActiveSheet()->mergeCells('A1:G1'); // Set Merge Cell pada kolom A1 sampai E1
 $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
 $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
 $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
$excel->setActiveSheetIndex(0)->setCellValue('A2', "Tanggal Export ".date('d-m-Y H:i'));


 // Buat header tabel nya pada baris ke 3
 $excel->setActiveSheetIndex(0)->setCellValue('A4', "NO");
 $excel->setActiveSheetIndex(0)->setCellValue('B4', "KODE-INVEST");
 $excel->setActiveSheetIndex(0)->setCellValue('C4', "DATA MEMBER");
 $excel->setActiveSheetIndex(0)->setCellValue('D4', "DATA REKENING");
 $excel->setActiveSheetIndex(0)->setCellValue('E4', "WAKTU INVESTASI");
 $excel->setActiveSheetIndex(0)->setCellValue('F4', "MASA KONTRAK");
 $excel->setActiveSheetIndex(0)->setCellValue('G4', "TOTAL INVESTASI");
 $excel->setActiveSheetIndex(0)->setCellValue('H4', "PROFIT 1");
 $excel->setActiveSheetIndex(0)->setCellValue('I4', "PROFIT 2");
 $excel->setActiveSheetIndex(0)->setCellValue('J4', "PROFIT 3");
 $excel->setActiveSheetIndex(0)->setCellValue('K4', "PROFIT 4");
 $excel->setActiveSheetIndex(0)->setCellValue('L4', "PROFIT 5");
 $excel->setActiveSheetIndex(0)->setCellValue('M4', "PROFIT 6");
 // Apply style header yang telah kita buat tadi ke masing-masing kolom header
 $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
 $excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
 $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
 $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
 $excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
 $excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
 $excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
 $excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);
 $excel->getActiveSheet()->getStyle('I4')->applyFromArray($style_col);
 $excel->getActiveSheet()->getStyle('J4')->applyFromArray($style_col);
 $excel->getActiveSheet()->getStyle('K4')->applyFromArray($style_col);
 $excel->getActiveSheet()->getStyle('L4')->applyFromArray($style_col);
 $excel->getActiveSheet()->getStyle('M4')->applyFromArray($style_col);

 $qry = $this->model->export_excel();
 $no = 1; // Untuk penomoran tabel, di awal set dengan 1
     $numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
     foreach($qry->result() as $data){ // Lakukan looping pada variabel siswa
       $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
       $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->kode_invest);
       $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->kode_person." | ".$data->nik." | ".$data->nama);
       $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->nama_rekening." | ".$data->no_rekening." | ".strtoupper($data->bank));
       $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, mediumdate_indo($data->created));
       $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, mediumdate_indo($data->kontrak_start)." s/d ".mediumdate_indo($data->kontrak_end));
       $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data->amount);
       $profit = $this->db->get_where("investment_profit",["id_invest"=>$data->id_invest]);
        $nos = $numrow;
       foreach ($profit->result() as $rows) {
         $excel->setActiveSheetIndex(0)->setCellValue('H'.$nos, $rows->amount_profit);
         $excel->setActiveSheetIndex(0)->setCellValue('I'.$nos, $rows->amount_profit);
         $excel->setActiveSheetIndex(0)->setCellValue('J'.$nos, $rows->amount_profit);
         $excel->setActiveSheetIndex(0)->setCellValue('K'.$nos, $rows->amount_profit);
         $excel->setActiveSheetIndex(0)->setCellValue('L'.$nos, $rows->amount_profit);
         $excel->setActiveSheetIndex(0)->setCellValue('M'.$nos, $rows->amount_profit);
       }

       $no++; // Tambah 1 setiap kali looping
       $numrow++; // Tambah 1 setiap kali looping
     }








 // Set width kolom
 $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
 $excel->getActiveSheet()->getColumnDimension('B')->setWidth(20); // Set width kolom B
 $excel->getActiveSheet()->getColumnDimension('C')->setWidth(60); // Set width kolom C
 $excel->getActiveSheet()->getColumnDimension('D')->setWidth(45); // Set width kolom D
 $excel->getActiveSheet()->getColumnDimension('E')->setWidth(16); // Set width kolom E
 $excel->getActiveSheet()->getColumnDimension('F')->setWidth(30); // Set width kolom D
 $excel->getActiveSheet()->getColumnDimension('G')->setWidth(20); // Set width kolom D
 $excel->getActiveSheet()->getColumnDimension('H')->setWidth(20); // Set width kolom D
 $excel->getActiveSheet()->getColumnDimension('I')->setWidth(20); // Set width kolom D
 $excel->getActiveSheet()->getColumnDimension('J')->setWidth(20); // Set width kolom D
 $excel->getActiveSheet()->getColumnDimension('K')->setWidth(20); // Set width kolom D
 $excel->getActiveSheet()->getColumnDimension('L')->setWidth(20); // Set width kolom D
 $excel->getActiveSheet()->getColumnDimension('M')->setWidth(20); // Set width kolom D



 // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
 $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
 // Set orientasi kertas jadi LANDSCAPE
 $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
 // Set judul file excel nya
 $filename = 'Data investment-'.date("d-m-Y H:i:s");
 $excel->getActiveSheet(0)->setTitle("Laporan Investment");
 $excel->setActiveSheetIndex(0);
 // Proses file excel\
 header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"'); // Set nama file excel nya
 header('Cache-Control: max-age=0');
 $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
 $write->save('php://output');

}


function export_excel($group="")
{
  // $this->template->set_title("Investment");
  $data['group'] = $group;
  $this->load->view("content/investment/export",$data);
}


function export_excel_dividen($group="")
{
  // $this->template->set_title("Investment");
  $data['group'] = $group;
  $this->load->view("content/investment/export_dividen",$data);
}


}
