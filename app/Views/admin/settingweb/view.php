<?= $this->extend('main/main'); ?>

<?= $this->section('isi'); ?>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<input type="hidden" value="<?= $setting['id']; ?>" id="idsetting">

<div class="card card-outline card-primary">
  <div class="card-header">
    <ul class="nav nav-pills nav-justified">
      <li class="nav-item">
        <a class="nav-link active" href="#setting" data-toggle="tab">Setting Web</a fa-minus>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#deskripsi" data-toggle="tab">Tentang Kami</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#kontak" data-toggle="tab">Kontak</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#support" data-toggle="tab">Support</a>
      </li>
    </ul>
  </div>
  <div class="card-body">
    <div class="tab-content">
      <div class="tab-pane active" id="setting">
        <div class="card card-primary collapsed-card">
          <div class="card-header">
            <h3 class="card-title">Setting Carousel</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="<?= site_url('/admin/setting/index'); ?>" data-source-selector="#settingCarousel" data-load-on-init="false">
                <i class="fas fa-sync-alt"></i>
              </button>

              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa fa-plus"></i>
              </button>
            </div>
          </div>
          <div class="card-body" id="settingCarousel">
            <?= form_open_multipart(site_url('/admin/setting/updateCarousel/' . $setting['id']), ['class' => 'formCarousel']); ?>
            <div class=" form-group">
              <label for="">Judul carousel</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-book-reader"></i></span>
                </div>
                <input type="text" name="judulcarousel" class=" form-control" value="<?= $setting['judulcarousel']; ?>">
                <div class="invalid-feedback errorJudulcarousel">

                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="">Gambar carousel</label>
              <div class="row">
                <div class="col-md-3">
                  <img src="<?= base_url('gambar/setting/' . $setting['gambarcarousel']); ?>" class="img-thumbnail" style="width: 100%; height: 100%;">
                </div>
                <div class="col-md-9">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-image"></i></span>
                    </div>
                    <input type="file" name="gambarcarousel" class="form-control">
                    <div class="invalid-feedback errorGambarcarousel">

                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="">Deskripsi carousel</label>
              <textarea name="deskripsicarousel" class="form-control" rows="5"><?= $setting['deskripsicarousel'];  ?></textarea>
              <div class="invalid-feedback errorDeskripsicarousel">

              </div>
            </div>
            <div class="form-group">
              <button type="submit" name="submit" class="btn btn-primary btnCarousel">Simpan perubahan</button>
            </div>
            <?= form_close(); ?>

            <script>
              $('.formCarousel').on('submit', function(e) {
                e.preventDefault();

                let form = $('.formCarousel')[0];
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
                  beforeSend: function(e) {
                    $('.btnCarousel').prop('disabled', 'disabled');
                    $('.btnCarousel').html('<i class="fa fa-spin fa-spinner"></i>');
                  },
                  complete: function(e) {
                    $('.btnCarousel').removeAttr('disabled');
                    $('.btnCarousel').html('Simpan perubahan');
                  },
                  success: function(response) {
                    if (response.sukses) {
                      Swal.fire('Berhasil', response.sukses, 'success').then(function() {
                        window.location.reload();
                      });
                    }

                    if (response.errors) {
                      if (response.errors.judulcarousel) {
                        $('.errorJudulcarousel').html(response.errors.judulcarousel);
                        $('input[name=judulcarousel]').addClass('is-invalid');
                      }
                      if (response.errors.gambarcarousel) {
                        $('.errorGambarcarousel').html(response.errors.gambarcarousel);
                        $('input[name=gambarcarousel]').addClass('is-invalid');
                      }
                      if (response.errors.deskripsicarousel) {
                        $('.errorDeskripsicarousel').html(response.errors.deskripsicarousel);
                        $('textarea[name=deskripsicarousel]').addClass('is-invalid');
                      }
                    }
                  },
                  error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                  }
                });
                return false;
              });
            </script>
          </div>
        </div>

        <div class="card card-primary collapsed-card">
          <div class="card-header">
            <h3 class="card-title">Setting Web</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="<?= site_url('/admin/setting/index'); ?>" data-source-selector="#settingWeb" data-load-on-init="false">
                <i class="fas fa-sync-alt"></i>
              </button>

              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa fa-plus"></i>
              </button>
            </div>
          </div>
          <div class="card-body" id="settingWeb">
            <?= form_open_multipart(site_url('/admin/setting/updateSettingWeb/' . $setting['id']), ['class' => 'formSettingWeb']); ?>
            <div class=" form-group">
              <label for="">Nama Website</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-globe"></i></span>
                </div>
                <input type="text" name="namawebsite" class=" form-control" value="<?= $setting['namawebsite']; ?>">
                <div class="invalid-feedback errornamawebsite"></div>
              </div>
            </div>
            <div class="form-group">
              <label for="">Logo Website</label>
              <div class="row">
                <div class="col-md-3">
                  <img src="<?= base_url('gambar/setting/' . $setting['logowebsite']); ?>" class="img-thumbnail" style="width: 100%; height: 100%;">
                </div>
                <div class="col-md-9">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-image"></i></span>
                    </div>
                    <input type="file" name="logowebsite" class="form-control">
                    <div class="invalid-feedback errorlogowebsite"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="">Favicon Website</label>
              <div class="row">
                <div class="col-md-3">
                  <img src="<?= base_url('gambar/setting/' . $setting['favicon']); ?>" class="img-thumbnail" style="width: 100%; height: 100%;">
                </div>
                <div class="col-md-9">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-image"></i></span>
                    </div>
                    <input type="file" name="favicon" class="form-control">
                    <div class="invalid-feedback errorfavicon"></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-primary btnSettingWeb">Simpan perubahan</button>
            </div>

            <?= form_close(); ?>

            <script>
              $('.formSettingWeb').on('submit', function(e) {
                e.preventDefault();

                let form = $('.formSettingWeb')[0];
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
                  beforeSend: function(e) {
                    $('.btnSettingWeb').prop('disabled', 'disabled');
                    $('.btnSettingWeb').html('<i class="fa fa-spin fa-spinner"></i>');
                  },
                  complete: function(e) {
                    $('.btnSettingWeb').removeAttr('disabled');
                    $('.btnSettingWeb').html('Simpan perubahan');
                  },
                  success: function(response) {
                    if (response.sukses) {
                      Swal.fire('Berhasil', response.sukses, 'success').then(function() {
                        window.location.reload();
                      });
                    }

                    if (response.errors) {
                      if (response.errors.namawebsite) {
                        $('.errornamawebsite').html(response.errors.namawebsite);
                        $('input[name=namawebsite]').addClass('is-invalid');
                      }
                      if (response.errors.favicon) {
                        $('.errorfavicon').html(response.errors.favicon);
                        $('input[name=favicon]').addClass('is-invalid');
                      }
                      if (response.errors.logowebsite) {
                        $('.errorlogowebsite').html(response.errors.logowebsite);
                        $('input[name=logowebsite]').addClass('is-invalid');
                      }
                    }
                  },
                  error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                  }
                });
                return false;
              });
            </script>
          </div>
        </div>

        <div class="card card-primary collapsed-card">
          <div class="card-header">
            <h3 class="card-title">Setting Lokasi</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="<?= site_url('/admin/setting/index'); ?>" data-source-selector="#settingLokasi" data-load-on-init="false">
                <i class="fas fa-sync-alt"></i>
              </button>

              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa fa-plus"></i>
              </button>
            </div>
          </div>
          <div class="card-body" id="settingLokasi">
            <?= form_open(site_url('/admin/setting/ubahSettingLokasi/' . $setting['id']), ['class' => 'formSettingLokasi']); ?>
            <div class="form-group">
              <label for="">Lokasi Gmap</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                </div>
                <input type="text" class="form-control" name="lokasigmap" value="<?= $setting['lokasigmap']; ?>">
                <div class="invalid-feedback errorlokasigmap"></div>
              </div>
            </div>
            <div class="form-group">
              <label for="">Alamat Toko</label>
              <textarea name="alamattoko" id="alamattoko" class="form-control"><?= $setting['alamattoko']; ?></textarea>
              <div class="invalid-feedback erroralamattoko"></div>
            </div>
            <div class="form-group">
              <label for="">Provinsi</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-map"></i></span>
                </div>
                <select name="provinsi" id="provinsi" class="form-control"></select>
                <div class="invalid-feedback errorprovinsi"></div>
              </div>
            </div>
            <div class="form-group">
              <label for="">Distrik</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-location-arrow"></i></span>
                </div>
                <select name="distrik" id="distrik" class="form-control"></select>
                <div class="invalid-feedback errordistrik"></div>
              </div>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-primary btnSettingLokasi" disabled=true>Simpan perubahan</button>
            </div>
            <?= form_close(); ?>

            <script>
              function dataProvinsi() {
                $.ajax({
                  type: 'post',
                  url: "<?= site_url('/admin/rajaongkiradmin/dataprovinsi'); ?>",
                  data: {
                    id: $('#idsetting').val()
                  },
                  dataType: "json",
                  success: function(response) {
                    if (response.data) {
                      $('#provinsi').html(response.data);
                    }
                  },
                  error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                  }
                });
              }

              function datadistrik() {
                $.ajax({
                  type: "post",
                  url: "<?= site_url('/admin/rajaongkiradmin/datadistrik'); ?>",
                  data: {
                    id: $("#idsetting").val(),
                  },
                  dataType: "json",
                  success: function(response) {
                    if (response.data) {
                      $('#distrik').html(response.data);
                      $('.btnSettingLokasi').removeAttr('disabled');
                    }
                  },
                  error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                  }
                });
              }

              $(document).ready(function() {
                dataProvinsi();
                datadistrik();

                $('#provinsi').change(function(e) {
                  e.preventDefault();
                  let id_provinsi = $(this).find(':selected').attr('id_provinsi');

                  $.ajax({
                    type: "post",
                    url: "<?= site_url('/admin/rajaongkiradmin/datadistrik'); ?>",
                    data: {
                      id: $('#idsetting').val(),
                      id_provinsi: id_provinsi
                    },
                    dataType: "json",
                    success: function(response) {
                      if (response.data) {
                        $('#distrik').html(response.data);
                      }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                      alert(xhr.status + '\n' + thrownError);
                    }
                  });
                });

                $('.formSettingLokasi').submit(function(e) {
                  e.preventDefault();
                  $.ajax({
                    type: "post",
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: "json",
                    beforeSend: function(e) {
                      $('.btnSettingLokasi').prop('disabled', 'disabled');
                      $('.btnSettingLokasi').html('<i class="fa fa-spin fa-spinner"></i>');
                    },
                    complete: function(e) {
                      $('.btnSettingLokasi').removeAttr('disabled');
                      $('.btnSettingLokasi').html('Simpan perubahan');
                    },
                    success: function(response) {
                      if (response.sukses) {
                        Swal.fire('Berhasil', response.sukses, 'success').then(function() {
                          window.location.reload();
                        });
                      }

                      if (response.errors) {
                        if (response.errors.lokasigmap) {
                          $('.errorlokasigmap').html(response.errors.lokasigmap);
                          $('input[name=lokasigmap]').addClass('is-invalid');
                        }
                        if (response.errors.alamattoko) {
                          $('.erroralamattoko').html(response.errors.alamattoko);
                          $('textarea[name=alamattoko]').addClass('is-invalid');
                        }
                        if (response.errors.provinsi) {
                          $('.errorprovinsi').html(response.errors.provinsi);
                          $('input[name=provinsi]').addClass('is-invalid');
                        }
                        if (response.errors.distrik) {
                          $('.errordistrik').html(response.errors.distrik);
                          $('input[name=distrik]').addClass('is-invalid');
                        }
                      }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                      alert(xhr.status + '\n' + thrownError);
                    }
                  });
                  return false;
                });
              });
            </script>
          </div>
        </div>
      </div>

      <div class="tab-pane" id="deskripsi">
        <div class="card">
          <div class="card-header">
            <div class="card-tools"> <button type="button" class="btn btn-warning" data-card-widget="card-refresh" data-source="<?= site_url('/admin/setting/index'); ?>" data-source-selector=".refreshDeskripsi" data-load-on-init="false">
                <i class="fas fa-sync-alt"></i> Refresh
              </button></div>
          </div>
          <div class="card-body refreshDeskripsi">
            <?= form_open(site_url('/admin/setting/ubahTentangKami/' . $setting['id']), ['class' => 'formTentangKami']); ?>
            <div class="form-group">
              <div class="col-4"><label for="">Tentang kami</label></div>
              <textarea name="tentangkami" id="tentangkami" class="summernote form-control"><?= $setting['tentangkami']; ?></textarea>
              <div class="invalid-feedback errortentangkami"></div>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-primary btnTentangKami">Simpan perubahan</button>
            </div>
            <?= form_close(); ?>

            <script>
              $('.formTentangKami').submit(function(e) {
                e.preventDefault();
                $.ajax({
                  type: "post",
                  url: $(this).attr('action'),
                  data: $(this).serialize(),
                  dataType: "json",
                  beforeSend: function(e) {
                    $('.btnTentangKami').prop('disabled', 'disabled');
                    $('.btnTentangKami').html('<i class="fa fa-spin fa-spinner"></i>');
                  },
                  complete: function(e) {
                    $('.btnTentangKami').removeAttr('disabled');
                    $('.btnTentangKami').html('Simpan perubahan');
                  },
                  success: function(response) {
                    // console.log(response);
                    if (response.sukses) {
                      Swal.fire('Berhasil', response.sukses, 'success').then(function() {
                        window.location.reload();
                      });
                    }

                    if (response.errors) {
                      if (response.errors.tentangkami) {
                        $('.errortentangkami').html(response.errors.tentangkami);
                        $('textarea[name=tentangkami]').addClass('is-invalid');
                      }
                    }
                  },
                  error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                  }
                });
                return false;
              });

              $(function() {
                $('.summernote').summernote({
                  height: '200px',
                })

                // CodeMirror
                CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
                  mode: "htmlmixed",
                  theme: "monokai"
                });
              });
            </script>
          </div>
        </div>
      </div>

      <div class="tab-pane" id="kontak">
        <div class="card">
          <div class="card-header">
            <div class="card-tools">
              <button type="button" class="btn btn-warning" data-card-widget="card-refresh" data-source="<?= site_url('/admin/setting/index'); ?>" data-source-selector=".refreshKontak" data-load-on-init="false">
                <i class="fas fa-sync-alt"></i> Refresh
              </button>
            </div>
          </div>
          <div class="card-body refreshKontak">
            <?php
            $kontak = explode("#", $setting['kontak']);
            ?>
            <?= form_open(site_url('/admin/setting/ubahKontak/' . $setting['id']), ['class' => 'formKontak']); ?>
            <div class="form-group">
              <label for="">E-mail</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-at"></i></span>
                </div>
                <input type="email" name="email" class="form-control" value="<?= $kontak[0]; ?>">
                <div class="invalid-feedback erroremail"></div>
              </div>
            </div>
            <div class="form-group">
              <label for="">No. Whatsapp <small class="text-danger">(08XXXXXXXXXX)</small></label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <ion-icon name="logo-whatsapp"></ion-icon>
                  </span>
                </div>
                <input type="text" name="wa" class="form-control" value="<?= $kontak[1]; ?>">
                <div class="invalid-feedback errorwa"></div>
              </div>
            </div>
            <div class="form-group">
              <label for="">Instagram</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <ion-icon name="logo-instagram"></ion-icon>
                  </span>
                </div>
                <input type="text" name="instagram" class="form-control" value="<?= $kontak[2]; ?>">
                <div class="invalid-feedback errorinstagram"></div>
              </div>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary btnKontak">Simpan perubahan</button>
            </div>
            <?= form_close(); ?>

            <script>
              $('.formKontak').on('submit', function(e) {
                e.preventDefault();
                let notelp = $('input[name=wa]').val();
                if (notelp.startsWith('08') && notelp.trim().length <= 13) {
                  $.ajax({
                    type: "post",
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: 'json',
                    beforeSend: function(e) {
                      $('.btnKontak').prop('disabled', 'disabled');
                      $('.btnKontak').html('<i class="fa fa-spin fa-spinner"></i>');
                    },
                    complete: function(e) {
                      $('.btnKontak').removeAttr('disabled');
                      $('.btnKontak').html('Simpan perubahan');
                    },
                    success: function(response) {
                      // console.log(response);
                      if (response.sukses) {
                        Swal.fire('Berhasil', response.sukses, 'success').then(function() {
                          window.location.reload();
                        });
                      }

                      if (response.errors) {
                        if (response.errors.wa) {
                          $('.errorwa').html(response.errors.wa);
                          $('input[name=wa]').addClass('is-invalid');
                        }
                        if (response.errors.instagram) {
                          $('.errorinstagram').html(response.errors.instagram);
                          $('input[name=instagram]').addClass('is-invalid');
                        }
                        if (response.errors.email) {
                          $('.erroremail').html(response.errors.email);
                          $('input[name=email]').addClass('is-invalid');
                        }
                      }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                      alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                  });
                } else {
                  $('input[name=wa]').addClass('is-invalid');
                  $('.errorwa').html("No telp tidak valid");
                }
              });
            </script>
          </div>
        </div>
      </div>

      <div class="tab-pane" id="support">
        <div class="card">
          <div class="card-header">
            <div class="card-tools">
              <button type="button" class="btn btn-warning" data-card-widget="card-refresh" data-source="<?= site_url('/admin/setting/index'); ?>" data-source-selector=".refreshSupport" data-load-on-init="false">
                <i class="fas fa-sync-alt"></i> Refresh
              </button>
            </div>
          </div>
          <div class="card-body refreshSupport">
            <?= form_open_multipart(site_url('/admin/setting/supported/' . $setting['id']), ['class' => 'formSupport']); ?>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Supported</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fas fa-copyright"></i>
                      </span>
                    </div>
                    <input class="form-control" type="text" name="supported">
                    <div class="invalid-feedback errorsupported"></div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Link website</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fas fa-globe"></i>
                      </span>
                    </div>
                    <input class="form-control" type="text" name="linkwebsite">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="">Logo</label>
              <div class="row">
                <div class="col-md-3">
                  <img src="<?= base_url(); ?>/gambar/produk/default.png" class="img-thumbnail img-preview" id="gambarSupported">
                </div>
                <div class="col-md-9">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fas fa-image"></i>
                      </span>
                    </div>
                    <input class="form-control previewImg gambar" type="file" name="gambar">
                    <div class="invalid-feedback errorgambar"></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group">
              <button class="btn btn-primary btnSupported">Tambah data</button>
            </div>
            <?= form_close(); ?>

            <div class="dataSupport"></div>
            <div class="viewmodal" style="display: none;"></div>

            <script>
              function clearForm() {
                $('input[name=supported]').val("");
                $('input[name=gambar]').val("");
                $('input[name=linkwebsite]').val("");
                $('#gambarSupported').attr('src', '<?= base_url(); ?>/gambar/produk/default.png');
              }

              function clearInvalidFeedback() {
                $('input[name=supported]').removeClass('is-invalid');
                $('input[name=gambar]').removeClass('is-invalid');
              }

              function dataSupport() {
                $.ajax({
                  type: "post",
                  url: "<?= site_url('admin/setting/dataSupport'); ?>",
                  data: {
                    id: <?= $setting['id']; ?>
                  },
                  beforeSend: function() {
                    $('.dataSupport').html('<i class="fa fa-spin fa-spinner"></i>');
                  },
                  dataType: "json",
                  success: function(response) {
                    if (response.data) {
                      // console.log(response);
                      $('.dataSupport').html(response.data);
                    }
                  },
                  error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                  }
                });
              }

              $('.formSupport').submit(function(e) {
                e.preventDefault();

                clearInvalidFeedback();

                let form = $('.formSupport')[0];
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
                  beforeSend: function(e) {
                    $('.btnSupported').prop('disabled', 'disabled');
                    $('.btnSupported').html('<i class="fa fa-spin fa-spinner"></i>');
                  },
                  complete: function(e) {
                    $('.btnSupported').removeAttr('disabled');
                    $('.btnSupported').html('Tambah data');
                  },
                  success: function(response) {
                    // console.log(response);
                    if (response.sukses) {
                      Swal.fire('Berhasil', response.sukses, 'success');
                      dataSupport();
                      clearForm();
                    }

                    if (response.errors) {
                      if (response.errors.supported) {
                        $('.errorsupported').html(response.errors.supported);
                        $('input[name=supported]').addClass('is-invalid');
                      }
                      if (response.errors.gambar) {
                        $('.errorgambar').html(response.errors.gambar);
                        $('input[name=gambar]').addClass('is-invalid');
                      }
                    }
                  },
                  error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                  }
                });
              });

              $(document).ready(function() {
                dataSupport();

                $('.previewImg').change(function(e) {
                  e.preventDefault();
                  const foto = this;
                  // $(".trigger").bind("click", function(event) {
                  //   var el = $(event.currentTarget);
                  //   var parent = el.parents().eq(3);
                  //   parent.toggleClass("active", true);
                  // });
                  // const imgPreview = $(event.currentTarget).parents().eq(1);
                  // const foto = document.querySelector('.gambar');
                  // const imgPreview = document.querySelector('.img-preview');
                  const imgPreview = this.parentElement.parentElement.parentElement.querySelector('.col-md-3 .img-preview');

                  // console.log("foto", foto);
                  // console.log("gambar", imgPreview);
                  const fileFoto = new FileReader();
                  fileFoto.readAsDataURL(foto.files[0]);
                  fileFoto.onload = function(e) {
                    imgPreview.src = e.target.result;
                  }
                });
              });
            </script>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection('isi'); ?>