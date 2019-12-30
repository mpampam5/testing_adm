<link rel="stylesheet" href="<?=base_url()?>_template/backend/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
<script src="<?=base_url()?>_template/backend/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="<?=base_url()?>_template/backend/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>


<div class="row">
  <div class="col-md-7 mx-auto">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-black">
        <li class="breadcrumb-item" aria-current="page">Setting</li>
        <li class="breadcrumb-item active" aria-current="page"><?=ucfirst($title)?></li>
      </ol>
    </nav>
  </div>

  <div class="col-md-7 mx-auto grid-margin">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">INVESMENT</h5>
          <form action="<?=site_url("backend/setting_financial/action_invesment")?>" id="form_invesment" autocomplete="off">
            <table class="table table-bordered">
              <tr>
                <td>Biaya Admin (Rp)</td>
                <td>
                  <div class="form-group mt-2">
                    <span style="font-size:10px;" class="pb-1 text-primary">* isikan 0 jika tidak di kenakan biaya admin</span>
                  <input type="text" class="form-control form-control-sm rupiah" name="biaya_admin" id="biaya_admin" placeholder="" value="<?=format_rupiah(setting_financial("biaya_admin"))?>">
                </div>
              </td>
              </tr>

              <tr>
                <td>Min-invesment (Rp)</td>
                <td>
                  <div class="form-group mt-2">
                    <span style="font-size:10px;" class="pb-1 text-primary">* isikan 0 jika tak ada batasan</span>
                  <input type="text" class="form-control form-control-sm rupiah" name="invesment_min" id="invesment_min" placeholder="" value="<?=format_rupiah(setting_financial("invesment_min"))?>">
                </div>
              </td>
              </tr>

              <tr>
                <td>Max-invesment (Rp)</td>
                <td>
                  <div class="form-group mt-2">
                    <span style="font-size:10px;" class="pb-1 text-primary">* isikan 0 jika tak ada batasan</span>
                    <input type="text" class="form-control form-control-sm rupiah" name="invesment_max" id="invesment_max" placeholder="" value="<?=format_rupiah(setting_financial("invesment_max"))?>">
                  </div>
                </td>
              </tr>

              <tr>
                <td>Royalti (%)</td>
                <td>
                  <div class="form-group mt-2">
                  <input type="text" class="form-control form-control-sm" name="invesment_royalti" id="invesment_royalti" placeholder="" value="<?=setting_financial("invesment_royalti")?>">
                </div>
              </td>
              </tr>

              <tr>
                <td>Masa Pembagian Profit (Bulan)</td>
                <td>
                  <div class="form-group mt-2">
                    <input type="text" class="form-control form-control-sm" name="invesment_profit" id="invesment_profit" placeholder="" value="<?=setting_financial("invesment_profit")?>">
                  </div>
                </td>
              </tr>

              <tr>
                <td>Masa Kontrak (Bulan)</td>
                <td>
                  <div class="form-group mt-2">
                    <input type="text" class="form-control form-control-sm" name="invesment_kontrak" id="invesment_kontrak" placeholder="" value="<?=setting_financial("invesment_kontrak")?>">
                  </div>
                </td>
              </tr>

              <tr>
                <td>Status invesment</td>
                <td>
                  <div class="form-group mt-3">
                    <select class="form-control form-control-sm" name="invesment_status" id="invesment_status">
                      <option <?=setting_financial("invesment_status")=="on"?"selected":""?> value="on">on</option>
                      <option <?=setting_financial("invesment_status")=="off"?"selected":""?> value="off">off</option>
                    </select>
                  </div>
                </td>
              </tr>

              <tr>
                <td colspan="2">
                  <button type="submit" class="btn btn-sm btn-warning text-white pull-right" id="submit_invesment" name="submit_invesment">Update</button>
                </td>
              </tr>
            </table>
          </form>
      </div>
    </div>
  </div>

  <script type="text/javascript">
  $("#form_invesment").submit(function(e){
  e.preventDefault();
  var me = $(this);
  $("#submit_invesment").prop('disabled',true).html('<div class="spinner-border spinner-border-sm text-white"></div> Loading...');
  $.ajax({
        url             : me.attr('action'),
        type            : 'post',
        data            :  new FormData(this),
        contentType     : false,
        cache           : false,
        dataType        : 'JSON',
        processData     :false,
        success:function(json){
          if (json.success==true) {
            $('.form-group').find('.text-danger').remove();
              $.toast({
                text: json.alert,
                showHideTransition: 'slide',
                icon: 'success',
                loaderBg: '#f96868',
                position: 'bottom-right'
              });
              $("#submit_invesment").prop('disabled',false)
                                    .html('Update');
          }else {
            $("#submit_invesment").prop('disabled',false)
                                .html('Update');
            $.each(json.alert, function(key, value) {
              var element = $('#' + key);
              $(element)
              .closest('.form-group')
              .find('.text-danger').remove();
              $(element).after(value);
            });
          }
        }
  });
  });
  </script>

  <div class="col-md-7 mx-auto grid-margin">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">COMISISSION</h5>
          <form action="<?=site_url("backend/setting_financial/action_comission")?>" id="form_comission" autocomplete="off">
            <table class="table table-bordered">
              <tr>
                <td>Founder (%)</td>
                <td>
                  <div class="form-group mt-2">
                  <input type="text" class="form-control form-control-sm" name="founder" id="founder" placeholder="" value="<?=level_person(1,"comission")?>">
                </div>
              </td>
              </tr>

              <tr>
                <td>CO Founder (%)</td>
                <td>
                  <div class="form-group mt-2">
                    <input type="text" class="form-control form-control-sm" name="cofounder" id="cofounder" placeholder="" value="<?=level_person(2,"comission")?>">
                  </div>
                </td>
              </tr>

              <tr>
                <td>Agency (%)</td>
                <td>
                  <div class="form-group mt-2">
                    <div class="input-group">
                      <input type="text" class="form-control" readonly value="Rp.1.000.000 s/d Rp.499.000.000">
                      <div class="input-group-append">
                        <button class="btn btn-sm btn-primary" type="button">2%</button>
                      </div>
                    </div>
                  </div>

                  <div class="form-group mt-2">
                    <div class="input-group">
                      <input type="text" class="form-control" readonly value="Rp.500.000.000 s/d Rp.1.999.000.000">
                      <div class="input-group-append">
                        <button class="btn btn-sm btn-primary" type="button">3%</button>
                      </div>
                    </div>
                  </div>

                  <div class="form-group mt-2">
                    <div class="input-group">
                      <input type="text" class="form-control" readonly value=">= Rp.2.000.000.000">
                      <div class="input-group-append">
                        <button class="btn btn-sm btn-primary" type="button">4%</button>
                      </div>
                    </div>
                  </div>

              </td>
              </tr>


              <tr>
                <td colspan="2">
                  <button type="submit" class="btn btn-sm btn-warning text-white pull-right" id="submit_comission" name="submit_invesment">Update</button>
                </td>
              </tr>
            </table>
          </form>
      </div>
    </div>
  </div>

  <script type="text/javascript">
  $("#form_comission").submit(function(e){
  e.preventDefault();
  var me = $(this);
  $("#submit_comission").prop('disabled',true).html('<div class="spinner-border spinner-border-sm text-white"></div> Loading...');
  $.ajax({
        url             : me.attr('action'),
        type            : 'post',
        data            :  new FormData(this),
        contentType     : false,
        cache           : false,
        dataType        : 'JSON',
        processData     :false,
        success:function(json){
          if (json.success==true) {
            $('.form-group').find('.text-danger').remove();
              $.toast({
                text: json.alert,
                showHideTransition: 'slide',
                icon: 'success',
                loaderBg: '#f96868',
                position: 'bottom-right'
              });
              $("#submit_comission").prop('disabled',false)
                                    .html('Update');
          }else {
            $("#submit_comission").prop('disabled',false)
                                .html('Update');
            $.each(json.alert, function(key, value) {
              var element = $('#' + key);
              $(element)
              .closest('.form-group')
              .find('.text-danger').remove();
              $(element).after(value);
            });
          }
        }
  });
  });
  </script>


  <div class="col-md-7 mx-auto grid-margin">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">DEPOSIT</h5>
          <form action="<?=site_url("backend/setting_financial/action_deposit")?>" id="form_deposit" autocomplete="off">
            <table class="table table-bordered">
              <tr>
                <td>Min-deposit (Rp)</td>
                <td>
                  <div class="form-group mt-2">
                    <span style="font-size:10px;" class="pb-1 text-primary">* isikan 0 jika tak ada batasan</span>
                  <input type="text" class="form-control form-control-sm rupiah" name="deposit_min" id="deposit_min" placeholder="" value="<?=format_rupiah(setting_financial("deposit_min"))?>">
                </div>
              </td>
              </tr>

              <tr>
                <td>Max-deposit (Rp)</td>
                <td>
                  <div class="form-group mt-2">
                    <span style="font-size:10px;" class="pb-1 text-primary">* isikan 0 jika tak ada batasan</span>
                    <input type="text" class="form-control form-control-sm rupiah" name="deposit_max" id="deposit_max" placeholder="" value="<?=format_rupiah(setting_financial("deposit_max"))?>">
                  </div>
                </td>
              </tr>

              <tr>
                <td>Status deposit</td>
                <td>
                  <div class="form-group mt-3">
                    <select class="form-control form-control-sm" name="deposit_status" id="deposit_status">
                      <option <?=setting_financial("deposit_status")=="on"?"selected":""?> value="on">on</option>
                      <option <?=setting_financial("deposit_status")=="off"?"selected":""?> value="off">off</option>
                    </select>
                  </div>
                </td>
              </tr>

              <tr>
                <td colspan="2">
                  <button type="submit" class="btn btn-sm btn-warning text-white pull-right" id="submit_deposit" name="submit_deposit">Update</button>
                </td>
              </tr>
            </table>
          </form>
      </div>
    </div>
  </div>


  <script type="text/javascript">
  $("#form_deposit").submit(function(e){
  e.preventDefault();
  var me = $(this);
  $("#submit_deposit").prop('disabled',true).html('<div class="spinner-border spinner-border-sm text-white"></div> Loading...');
  $.ajax({
        url             : me.attr('action'),
        type            : 'post',
        data            :  new FormData(this),
        contentType     : false,
        cache           : false,
        dataType        : 'JSON',
        processData     :false,
        success:function(json){
          $('.form-group').find('.text-danger').remove();
          if (json.success==true) {
              $.toast({
                text: json.alert,
                showHideTransition: 'slide',
                icon: 'success',
                loaderBg: '#f96868',
                position: 'bottom-right'
              });
              $("#submit_deposit").prop('disabled',false)
                                  .html('Update');
          }else {
            $("#submit_deposit").prop('disabled',false)
                                .html('Update');
            $.each(json.alert, function(key, value) {
              var element = $('#' + key);
              $(element)
              .closest('.form-group')
              .find('.text-danger').remove();
              $(element).after(value);
            });
          }
        }
  });
  });
  </script>



  <!-- <div class="col-md-6 grid-margin">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">WITHDRAW</h5>
          <form action="<?=site_url("backend/setting_financial/action_withdraw")?>" id="form_withdraw" autocomplete="off">
            <table class="table table-bordered">
              <tr>
                <td>Min-withdraw (Rp)</td>
                <td>
                  <div class="form-group mt-2">
                    <span style="font-size:10px;" class="pb-1 text-primary">* isikan 0 jika tak ada batasan</span>
                  <input type="text" class="form-control form-control-sm rupiah" name="withdraw_min" id="withdraw_min" placeholder="" value="<?=format_rupiah(setting_financial("withdraw_min"))?>">
                </div>
              </td>
              </tr>

              <tr>
                <td>Max-withdraw (Rp)</td>
                <td>
                  <div class="form-group mt-2">
                    <span style="font-size:10px;" class="pb-1 text-primary">* isikan 0 jika tak ada batasan</span>
                    <input type="text" class="form-control form-control-sm rupiah" name="withdraw_max" id="withdraw_max" placeholder="" value="<?=format_rupiah(setting_financial("withdraw_max"))?>">
                  </div>
                </td>
              </tr>

              <tr>
                <td>Status withdraw</td>
                <td>
                  <div class="form-group mt-3">
                    <select class="form-control form-control-sm" name="withdraw_status" id="withdraw_status">
                      <option <?=setting_financial("withdraw_status")=="on"?"selected":""?> value="on">on</option>
                      <option <?=setting_financial("withdraw_status")=="off"?"selected":""?> value="off">off</option>
                    </select>
                  </div>
                </td>
              </tr>

              <tr>
                <td colspan="2">
                  <button type="submit" class="btn btn-sm btn-warning text-white pull-right" id="submit_withdraw" name="submit_withdraw">Update</button>
                </td>
              </tr>
            </table>
          </form>
      </div>
    </div>
  </div>


  <script type="text/javascript">
  $("#form_withdraw").submit(function(e){
  e.preventDefault();
  var me = $(this);
  $("#submit_withdraw").prop('disabled',true).html('<div class="spinner-border spinner-border-sm text-white"></div> Loading...');
  $.ajax({
        url             : me.attr('action'),
        type            : 'post',
        data            :  new FormData(this),
        contentType     : false,
        cache           : false,
        dataType        : 'JSON',
        processData     :false,
        success:function(json){
          if (json.success==true) {
            $('.form-group').find('.text-danger').remove();
              $.toast({
                text: json.alert,
                showHideTransition: 'slide',
                icon: 'success',
                loaderBg: '#f96868',
                position: 'bottom-right'
              });
              $("#submit_withdraw").prop('disabled',false)
                                  .html('Update');
          }else {
            $("#submit_withdraw").prop('disabled',false)
                                .html('Update');
            $.each(json.alert, function(key, value) {
              var element = $('#' + key);
              $(element)
              .closest('.form-group')
              .find('.text-danger').remove();
              $(element).after(value);
            });
          }
        }
  });
  });
  </script> -->










  <!-- <div class="col-md-7 mx-auto grid-margin">
    <form autocomplete="off" action="<?=site_url("backend/setting_financial/testing_comission")?>" id="form_test">
      <div class="form-group">
        <label for="">Date (05 & 15)</label>
        <input type="text" class="form-control tanggal" name="tanggal" id="tanggal" placeholder="Tanggal">
      </div>
      <button type="submit" id="test_profit" name="button" class="btn btn-sm btn-primary"> Test</button>
    </form>


    <?php
      // // print_r(is_parent(31));
      //
      //
      // $parent = is_parent(19);

      // $parent = array();
      // // foreach ($cek_parent as $id_person) {
      // //   // $parent['id_parent'][] = $id_person;
      // //   // $parent['level'][] = profile_person($id_person,"id_level");
      // //   $parent[] = array('id_level' => profile_person($id_person,"id_level"),
      // //                   'id_person' => $id_person
      // //                 );
      // // }

      // echo count($parent)."<br>";
      //
      // $omset = 2000000000;
      // $agency = $parent[0];
      // $agency_level = profile_person($agency,"id_level");
      // $agency_comission = level_person($agency_level,"comission");
      // // $omset = omset($this->btree->get_all_id_children($agency));
      // if ($omset>=1000000 AND $omset<=499000000) {
      //   $omset_agency = 2;
      // }elseif ($omset>=500000000 AND $omset<=1999000000) {
      //   $omset_agency = 3;
      // }elseif ($omset>=2000000000) {
      //   $omset_agency = 4;
      // }
      //
      // $cofounder = $parent[1];
      // $cofounder_level = profile_person($cofounder,"id_level");
      // $cofounder_comission = level_person($cofounder_level,"comission");
      //
      // $founder = $parent[2];
      // $founder_level = profile_person($founder,"id_level");
      // $founder_comission = level_person($founder_level,"comission");
      //
      // echo "agency: ".$agency."<br>";
      // echo "agency_level: ".$agency_level."<br>";
      // echo "agency_comission: ".$agency_comission."<br>";
      // echo "Rp".format_rupiah($omset)."<br>";
      // echo "Hasil ".$omset_agency."<br><br>";
      //
      //
      // echo "<br><br>";
      //
      // echo "cofounder: ".$cofounder."<br>";
      // echo "cofounder_level: ".$cofounder_level."<br>";
      // echo "cofounder_comission: ".$cofounder_comission."<br>";
      // echo "Hasil ". abs($cofounder_comission-$omset_agency)."<br><br>";
      //
      //
      // echo "founder: ".$founder."<br>";
      // echo "founder_level: ".$founder_level."<br>";
      // echo "founder_comission: ".$founder_comission."<br>";
      // echo "Hasil ". abs($founder_comission-$cofounder_comission-$omset_agency)."<br><br>";
      //

     ?>
  </div> -->

</div>




<script type="text/javascript">
// $(document).ready(function(){
// $('.tanggal').datepicker({
//   format: 'yyyy-mm-dd',
//   autoclose: true
// });
// });


$("#form_test").submit(function(e){
e.preventDefault();
var me = $(this);
$("#test_profit").prop('disabled',true).html('<div class="spinner-border spinner-border-sm text-white"></div> Loading...');
$.ajax({
      url             : me.attr('action'),
      type            : 'post',
      data            :  new FormData(this),
      contentType     : false,
      cache           : false,
      dataType        : 'JSON',
      processData     :false,
      success:function(json){
        if (json.success==true) {
          $('.form-group').find('.text-danger').remove();
            $.toast({
              text: json.alert,
              showHideTransition: 'slide',
              icon: json.alert_header,
              loaderBg: '#f96868',
              position: 'bottom-right'
            });
            $('.tanggal').val("");
            $("#test_profit").prop('disabled',false)
                                  .html('Test');
        }else {
          $("#test_profit").prop('disabled',false)
                              .html('Test');
          $.each(json.alert, function(key, value) {
            var element = $('#' + key);
            $(element)
            .closest('.form-group')
            .find('.text-danger').remove();
            $(element).after(value);
          });
        }
      }
});
});
</script>





















<script type="text/javascript">
$(document).ready(function(){
  $('.rupiah').mask('00.000.000.000', {reverse: true});
});
</script>
