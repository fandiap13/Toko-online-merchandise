<div class="modal fade" id="modalreview" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Review Produk</h5>
      </div>
      <div class="modal-body">
        <div id="pesan"></div>
        <?= form_open_multipart($formaction, ['class' => 'formsimpan']); ?>
        <input type="hidden" name="reviewid" value="<?= $reviewid; ?>">
        <input type="hidden" value="<?= $detailtransid; ?>" name="detailtransid">

        <div class="form-group">
          <label for="">Nama Produk</label>
          <input type="text" name="namaproduk" class="form-control" value="<?= $namaproduk; ?>" readonly>
        </div>

        <div class="form-group">
          <label for="">Ranting</label>
          <br>
          <i class="fa fa-2x fa-star <?= $ranting >= 1 ? 'text-warning' : ''; ?>" onclick="ranting('1')"></i>
          <i class="fa fa-2x fa-star <?= $ranting >= 2 ? 'text-warning' : ''; ?>" onclick="ranting('2')"></i>
          <i class="fa fa-2x fa-star <?= $ranting >= 3 ? 'text-warning' : ''; ?>" onclick="ranting('3')"></i>
          <i class="fa fa-2x fa-star <?= $ranting >= 4 ? 'text-warning' : ''; ?>" onclick="ranting('4')"></i>
          <i class="fa fa-2x fa-star <?= $ranting == 5 ? 'text-warning' : ''; ?>" onclick="ranting('5')"></i>
          <input type="hidden" name="ranting" value="<?= $ranting; ?>">
        </div>

        <div class="form-group">
          <label for="">Gambar</label>

          <div class="row mb-3 dataGambar">

          </div>

          <?php if ($formtype == 'simpan') { ?>
            <input type="file" name="gambar[]" multiple='multiple' class="form-control">
          <?php } else { ?>
            <div class="row">
              <div class="col-7">
                <input type="file" id="tambahGambar" name="gambar[]" multiple='multiple' class="form-control">
                <div class="invalid-feedback errorGambar">

                </div>
              </div>
              <div class="col-5">
                <button type="submit" class="btn btn-primary btnTambahGambar"><i class="fa fa-plus"></i> Tambah gambar</button>
              </div>
            </div>
          <?php } ?>
        </div>

        <div class="form-group">
          <label for="">Review</label>
          <textarea name="review" id="review" class="form-control" rows="5"><?= $review; ?></textarea>
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary btnSimpan">Kirim Review</button>
        </div>
        <?= form_close(); ?>

        <!-- <div class="1">
          <div class="2">
            <label for="" class="hai">Hai</label>
            <label for="">Hai</label>
          </div>
        </div> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  function ranting(jml) {
    let jmlRanting = parseInt(jml);
    // let className = document.querySelector('.fa-star');
    let className = document.getElementsByClassName('fa-star');
    switch (jmlRanting) {
      case 1:
        className[0].classList.add('text-warning');
        className[1].classList.remove('text-warning');
        className[2].classList.remove('text-warning');
        className[3].classList.remove('text-warning');
        className[4].classList.remove('text-warning');
        break;
      case 2:
        className[0].classList.add('text-warning');
        className[1].classList.add('text-warning');
        className[2].classList.remove('text-warning');
        className[3].classList.remove('text-warning');
        className[4].classList.remove('text-warning');
        break;
      case 3:
        className[0].classList.add('text-warning');
        className[1].classList.add('text-warning');
        className[2].classList.add('text-warning');
        className[3].classList.remove('text-warning');
        className[4].classList.remove('text-warning');
        break;
      case 4:
        className[0].classList.add('text-warning');
        className[1].classList.add('text-warning');
        className[2].classList.add('text-warning');
        className[3].classList.add('text-warning');
        className[4].classList.remove('text-warning');
        break;
      default:
        className[0].classList.add('text-warning');
        className[1].classList.add('text-warning');
        className[2].classList.add('text-warning');
        className[3].classList.add('text-warning');
        className[4].classList.add('text-warning');
        break;
    }

    document.getElementsByName('ranting')[0].value = jmlRanting;
  }

  $('.tambahGambar').click(function(e) {
    e.preventDefault();
    $('.gambarReview').append(`
      <div class="row mt-2 gambarTambahan">
      <div class="col-md-9">
                <input type="file" name="gambar[]" id="gambar" class="form-control">
              </div>
              <div class="col-md-3">
              <button type="button" class="btn btn-danger hapusGambar"><i class="fa fa-trash-alt"></i> Hapus</button>
              </div>
      </div>
      `);
  });

  // $(document).on('click', '.hapusGambar', function(e) {
  //   e.preventDefault();
  //   // $('.1, .2').remove();
  //   $(this).parents('.gambarTambahan').remove();
  // });
  function dataGambar() {
    $.ajax({
      type: "post",
      url: '<?= site_url('/review/dataGambar'); ?>',
      data: {
        reviewid: $('input[name=reviewid]').val()
      },
      dataType: "json",
      success: function(response) {
        if (response.data) {
          $('.dataGambar').html(response.data);
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  }

  $(document).ready(function() {
    dataGambar();

    window.setTimeout(function() {
      $('.alert').fadeTo(500.0).slideUp(500,
        function() {
          $(this).remove();
        })
    }, 5000);

    $('.hapusGambar').on('click', function(e) {
      e.preventDefault();
      $(this).parents('.gambarTambahan').remove();
    });

    $('.formsimpan').submit(function(e) {
      e.preventDefault();
      let form = $('.formsimpan')[0];
      let data = new FormData(form);

      $.ajax({
        type: "post",
        url: $(this).attr('action'),
        data: data,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        dataType: "json",
        beforeSend: function() {
          $('.btnSimpan').attr('disabled', true);
          $('.btnSimpan').html('<i class="fa fa-spin fa-spinner"></i>');
        },
        complete: function() {
          $('.btnSimpan').removeAttr('disabled');
          $('.btnSimpan').html('Kirim Review');
        },
        success: function(response) {
          // console.log(response);
          if (response.sukses) {
            // Swal.fire('Sukses', response.sukses, 'success')
            Swal.fire('Sukses', response.sukses, 'success');
            $('#modalreview').modal('hide');
          }

          if (response.errors) {
            $('#pesan').html(response.errors);
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
    });

    $('.btnTambahGambar').click(function(e) {
      e.preventDefault();

      var form_data = new FormData(); // Creating object of FormData class

      var file_data = document.getElementById('tambahGambar'); // Getting the properties of file from file field
      for (let i = 0; i < file_data.files.length; i++) {
        form_data.append("gambar[]", file_data.files[i]) // Appending parameter named file with properties of file_field to form_data
      }

      form_data.append("reviewid", $('input[name=reviewid]').val()) // Adding extra parameters to form_data

      // console.log(file_data.files[0]);
      $.ajax({
        type: "post",
        url: "<?= site_url('/review/tambahGambar'); ?>",
        data: form_data,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        dataType: "json",
        beforeSend: function() {
          $('.btnTambahGambar').attr('disabled', true);
          $('.btnTambahGambar').html('<i class="fa fa-spin fa-spinner"></i>');
        },
        complete: function() {
          $('.btnTambahGambar').removeAttr('disabled');
          $('.btnTambahGambar').html('<i class="fa fa-plus"></i> Tambah gambar');
        },
        success: function(response) {
          // console.log(response);
          if (response.sukses) {
            Swal.fire('Berhasil', response.sukses, 'success');
            $('#tambahGambar').removeClass('is-invalid');
            $('.errorGambar').html("");
            $('#tambahGambar').val(null);
            dataGambar();
          }
          if (response.errorJml) {
            $('#pesan').html(response.errorJml);
            $('#tambahGambar').removeClass('is-invalid');
            $('.errorGambar').html("");
            $('#tambahGambar').val(null);
            dataGambar();
          }

          if (response.errors) {
            if (response.errors.gambar) {
              $('#tambahGambar').addClass('is-invalid');
              $('.errorGambar').html(response.errors.gambar);
            }
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
    });
  });
</script>