

        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="w-100 clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © <?=date("Y")?> <a href="<?=site_url()?>" target="_blank"><?=strtoupper(setting_system("title"))?></a>. All rights reserved.</span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->

  <!-- endinject -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
  <script src="<?=base_url()?>_template/backend/vendors/inputmask/dist/jquery.mask.min.js"></script>
  <script src="<?=base_url()?>_template/backend/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <script src="<?=base_url()?>_template/backend/js/off-canvas.js"></script>
  <script src="<?=base_url()?>_template/backend/js/hoverable-collapse.js"></script>
  <script src="<?=base_url()?>_template/backend/js/template.js"></script>
  <script src="<?=base_url()?>_template/backend/js/settings.js"></script>
  <script src="<?=base_url()?>_template/backend/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="<?=base_url()?>_template/backend/js/dashboard.js"></script>
  <script src="<?=base_url()?>_template/backend/js/todolist.js"></script>
  <!-- End custom js for this page-->

  <div class="modal fade" id="modalGue" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalTitle"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            </div>
            <div class="modal-body" id="modalContent" style="max-height: 687px; overflow-y: auto;"></div>
          </div>
        </div>
    </div>


  <script type="text/javascript">
  $('#modalGue').on('hide.bs.modal', function () {
			setTimeout(function(){
					$('#modalTitle, #modalContent , #modalFooter').html('');
				}, 500);
	   });

  $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();
    });

  $('.table').on('draw.dt', function () {
      $('[data-toggle="tooltip"]').tooltip();
  });
  </script>
</body>

</html>
