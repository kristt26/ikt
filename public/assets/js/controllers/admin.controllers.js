angular.module('adminctrl', [])
    // Admin
    .controller('dashboardController', dashboardController)
    .controller('wijkController', wijkController)
    .controller('kspController', kspController)
    .controller('detailKeluargaController', detailKeluargaController)
    .controller('anggotaController', anggotaController)
    .controller('anggotaUltahController', anggotaUltahController)
    .controller('addAnggotaController', addAnggotaController)
    .controller('editAnggotaController', editAnggotaController)
    .controller('golonganDarahController', golonganDarahController)
    .controller('gerejaController', gerejaController)
    .controller('manajemenUsersController', manajemenUsersController)
    .controller('persyaratanController', persyaratanController)
    .controller('baptisController', baptisController)
    .controller('manajemenBaptisController', manajemenBaptisController)
    .controller('manajemenSidiController', manajemenSidiController)
    .controller('manajemenNikahController', manajemenNikahController)
    .controller('laporanAnggotaJemaatController', laporanAnggotaJemaatController)
    .controller('laporanKepalaKeluargaController', laporanKepalaKeluargaController)
    .controller('laporanController', laporanController)
    .controller('pindahJemaatController', pindahJemaatController)
    // Anggota Jemaat
    .controller('layananBaptisController', layananBaptisController)
    .controller('layananSidiController', layananSidiController)
    .controller('layananNikahController', layananNikahController)

    ;

function dashboardController($scope, dashboardServices) {
    $scope.$emit("SendUp", "Dashboard");
    $scope.datas = {};
    $scope.title = "Dashboard";
    // dashboardServices.get().then(res=>{
    //     $scope.datas = res;
    // })
}

function wijkController($scope, wijkServices, pesan) {
    $scope.$emit("SendUp", "Pembobotan Faktor");
    $scope.datas = {};
    $scope.model = {};
    wijkServices.get().then((res) => {
        $scope.datas = res;
    })

    $scope.setInisial = (item) => {
        $scope.model.inisial = item.substring(0, 3).toUpperCase();
    }

    $scope.save = () => {
        pesan.dialog('Yakin ingin?', 'Yes', 'Tidak').then(res => {
            if ($scope.model.id) {
                wijkServices.put($scope.model).then(res => {
                    $scope.model = {};
                    pesan.Success("Berhasil mengubah data");
                })
            } else {
                wijkServices.post($scope.model).then(res => {
                    $scope.model = {};
                    pesan.Success("Berhasil menambah data");
                })
            }
        })
    }

    $scope.edit = (item) => {
        $scope.model = angular.copy(item);
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin?', 'Ya', 'Tidak').then(res => {
            wijkServices.deleted(param).then(res => {
                pesan.Success("Berhasil menghapus data");
            })
        });
    }
}

function kspController($scope, kspServices, pesan) {
    $scope.$emit("SendUp", "Pembobotan Faktor");
    $scope.datas = {};
    $scope.model = {};
    $scope.wijk;
    kspServices.get().then((res) => {
        $scope.datas = res;
    })

    $scope.save = (wijk_id) => {
        pesan.dialog('Yakin ingin?', 'Yes', 'Tidak').then(res => {
            if ($scope.model.id) {
                kspServices.put($scope.model).then(res => {
                    var item = $scope.wijk.ksp.find(x => x.id == res.id);
                    if (item) {
                        item.ksp = res.ksp;
                    }
                    $scope.model = {};
                    pesan.Success("Berhasil mengubah data");
                })
            } else {
                $scope.model.wijk_id = wijk_id;
                kspServices.post($scope.model).then(res => {
                    $scope.wijk.ksp.push(res);
                    $scope.model = {};
                    pesan.Success("Berhasil menambah data");
                })
            }
        })
    }

    $scope.edit = (item) => {
        $scope.model = angular.copy(item);
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin?', 'Ya', 'Tidak').then(res => {
            kspServices.deleted(param).then(res => {
                var index = $scope.wijk.ksp.indexOf(res);
                $scope.wijk.ksp.splice(index, 1);
                pesan.Success("Berhasil menghapus data");
            })
        });
    }

    $scope.show = (item) => {
        console.log(item);
    }
}

function detailKeluargaController($scope, keluargaServices, pesan, helperServices) {
    $scope.$emit("SendUp", "Pembobotan Faktor");
    $scope.datas = {};
    $scope.model = {};
    $scope.wijk;
    keluargaServices.getId(helperServices.lastPath).then((res) => {
        $scope.model = res;
    });
    $scope.pecah = (param) => {
        param.hubungan_keluarga = "KEPALA KELUARGA";
        var model = {};
        model.setPage = "pecah";
        model.anggota = [];
        model.anggota.push(param);
        window.localStorage.setItem('biodata', JSON.stringify(model));
        window.location.href = helperServices.url + "keluarga#!/add/keluarga";
    }
}

function anggotaController($scope, $compile, anggotaServices, keluargaServices, pesan, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder, helperServices) {
    $scope.$emit("SendUp", "Data Anggota");
    $scope.datas = {};
    var lastKK = "";
    var no = 1;
    // $.LoadingOverlay("show");
    // $(document).ready(function() {
    //     $('#table').DataTable({
    //         processing: true,
    //         serverSide: true,
    //         // data: $scope.datas,
    //         ajax: helperServices.url + 'keluarga/read',
    //         order: [],
    //         columns: [
    //             {data: 'no', orderable: false},
    //             // {data: 'aksi'},
    //             {data: 'wijk'},
    //             {data: 'ksp'},
    //             {data: 'kode_kk'},
    //             {data: 'kode_anggota'},
    //             {data: 'nama'},
    //             {data: 'tempat_lahir'},
    //             {data: 'sex'},
    //             {data: 'golongan_darah'},
    //             {data: 'status_kawin'},
    //             {data: 'hubungan_keluarga'},
    //             {data: 'pendidikan_terakhir'},
    //             {data: 'pekerjaan'},
    //             {data: 'nama_ayah'},
    //             {data: 'nama_ibu'},
    //             {data: 'suku'},
    //             {data: 'unsur'},
    //             {data: 'status_domisili'},
    //         ]
    //     });

    // });
    anggotaServices.get().then((res) => {
        $scope.datas = res;
        console.log(res);
        $scope.datas.forEach(element => {
            if (element.kode_kk == lastKK) {
                lastKK = element.kode_kk;
                var set = lastKK + ("0" + (no++)).slice(-2);
                element.kode_anggota = set;
            } else {
                no = 1;
                lastKK = element.kode_kk;
                var set = lastKK + ("0" + (no++)).slice(-2);
                element.kode_anggota = set;
            }

            // $.LoadingOverlay("hide");
        });

    });


    $scope.getData = (param) => {
        console.log(param);
    }
}

function anggotaUltahController($scope, anggotaServices, wijkServices, helperServices, pesan, DTOptionsBuilder) {
    $scope.$emit("SendUp", "Data Anggota");
    $scope.datas = {};
    var lastKK = "";
    var no = 1;
    $scope.tanggal = moment().add(1, 'weeks').startOf('isoWeek').add(-1, "days").format("YYYY/MM/DD") + " - " + moment().add(1, 'weeks').endOf('isoWeek').add(-1, 'days').format("YYYY/MM/DD");
    $scope.dtOptions = DTOptionsBuilder.newOptions().withOption('scrollX', '100%');
    $.LoadingOverlay("show");
    $scope.init = () => {
        // $scope.setDate();
        wijkServices.get().then(res => {
            $scope.wijks = res;
            $.LoadingOverlay("hide");
        })
        // setTimeout(() => {
        //     $scope.setDate();        
        // }, 500);
    }
    $scope.setDate = (tanggal, jenis, wijk_id) => {
        if (tanggal && jenis && wijk_id) {
            $.LoadingOverlay("show");
            var arr = tanggal.split(' - ');
            arr[0] = arr[0].split("/").join("-");
            arr[1] = arr[1].split("/").join("-");
            let item = { date: arr, jenis: jenis, wijk_id: wijk_id };
            anggotaServices.getUltah(item).then(res => {
                if (jenis == '1') {
                    $scope.datas = res;
                } else {
                    $scope.datas = res.filter((x) => x.hubungan_keluarga == 'KEPALA KELUARGA' || x.hubungan_keluarga == 'SUAMI');
                }
                $.LoadingOverlay("hide");
            })
        }
    }

    $scope.cetak = (tanggal, jenis, wijk_id) => {
        if (tanggal, jenis, wijk_id) {
            var arr = tanggal.split(' - ');
            arr[0] = arr[0].split("/").join("-");
            arr[1] = arr[1].split("/").join("-");
            var item = helperServices.url + 'laporan/excel?item=' + helperServices.enkrip("ulangTahun") + "&start=" + arr[0] + "&end=" + arr[1] + "&jenis=" + jenis + "&wijk_id=" + wijk_id;
            window.open(helperServices.url + 'laporan/excel?item=' + helperServices.enkrip("ulangTahun") + "&start=" + arr[0] + "&end=" + arr[1] + "&jenis=" + jenis + "&wijk_id=" + wijk_id, "_blank");
        } else {
            pesan.error("Tidak ada data");
        }
    }
}


function addAnggotaController($scope, anggotaServices, helperServices, keluargaServices, pesan) {
    $scope.$emit("SendUp", "Data Anggota");
    $scope.model = {};
    $scope.datas = {};
    $scope.baptis = {};
    $scope.golonganDarah = helperServices.golonganDarah;
    $scope.agama = helperServices.agama;
    $scope.hubungan = helperServices.hubungan;
    $scope.pendidikan = helperServices.pendidikan;
    $scope.pekerjaan = helperServices.pekerjaan;
    keluargaServices.getId(helperServices.lastPath).then((res) => {
        $scope.datas = res;
        $scope.kepalaKeluarga = res.anggota.find(x => x.hubungan_keluarga == 'KEPALA KELUARGA');
        $scope.model.kk_id = res.id;
    });

    $scope.save = () => {
        $scope.model.baptis = $scope.baptis;
        $scope.model.sidi = $scope.sidi;
        $scope.model.nikah = $scope.nikah;
        pesan.dialog("Yakin ingin melanjutkan?", "Ya", "Tidak").then(x => {
            if ($scope.model.id) {
                anggotaServices.put($scope.model).then(res => {
                    pesan.Success("Berhasil mengubah data");
                    document.location.href = helperServices.url + "keluarga";
                });
            } else {
                anggotaServices.post($scope.model).then(res => {
                    pesan.Success("Berhasil menambah data");
                    document.location.href = helperServices.url + "keluarga";
                });
            }
        })
    }
}

function editAnggotaController($scope, anggotaServices, helperServices, pesan) {
    $scope.$emit("SendUp", "Data Anggota");
    $scope.model = {};
    $scope.datas = {};
    $scope.baptis = {};
    $scope.golonganDarah = helperServices.golonganDarah;
    $scope.agama = helperServices.agama;
    $scope.hubungan = helperServices.hubungan;
    $scope.pendidikan = helperServices.pendidikan;
    $scope.pekerjaan = helperServices.pekerjaan;
    anggotaServices.getById(helperServices.lastPath).then((res) => {
        $scope.datas = res.kk;
        $scope.kepalaKeluarga = res.kk.anggota;
        $scope.model = res.anggota;
        $scope.model.tanggal_lahir = new Date($scope.model.tanggal_lahir);
        $scope.baptis = angular.copy(res.baptis);
        $scope.baptis.tanggal_baptis = new Date($scope.baptis.tanggal_baptis);
        $scope.sidi = angular.copy(res.sidi);
        $scope.sidi.tanggal_sidi = new Date($scope.sidi.tanggal_sidi);
        $scope.nikah = angular.copy(res.nikah);
        $scope.nikah.tanggal_nikah = new Date($scope.nikah.tanggal_nikah);
    });

    $scope.save = () => {
        $scope.model.baptis = angular.copy($scope.baptis);
        $scope.model.sidi = angular.copy($scope.sidi);
        $scope.model.nikah = angular.copy($scope.nikah);
        $scope.model.baptis.tanggal_baptis = helperServices.dateToString($scope.baptis.tanggal_baptis);
        $scope.model.sidi.tanggal_sidi = new Date($scope.sidi.tanggal_sidi);
        $scope.model.nikah.tanggal_nikah = new Date($scope.nikah.tanggal_nikah);
        pesan.dialog("Yakin ingin melanjutkan?", "Ya", "Tidak").then(x => {
            anggotaServices.put($scope.model).then(res => {
                pesan.Success("Berhasil mengubah data");
                setInterval(() => {
                    document.location.href = helperServices.url + "anggota";
                }, 1000);
            });
        })
    }
}

function golonganDarahController($scope, anggotaServices, helperServices, pesan, DTOptionsBuilder) {
    $scope.$emit("SendUp", "Data Anggota");
    $scope.datas = {};
    $scope.golonganDarah = helperServices.golonganDarah;
    $scope.dtOptions = DTOptionsBuilder.newOptions().withOption('scrollX', '100%');
    $scope.setDate = (param) => {
        $.LoadingOverlay("show");
        anggotaServices.getGolonganDarah(helperServices.enkrip(param)).then(res => {
            $scope.datas = res;
            $.LoadingOverlay("hide");
        })
    }

    $scope.cetak = (param) => {
        if (param) {
            window.open(helperServices.url + 'laporan/golongan_darah_excel?darah=' + helperServices.enkrip(param), "_blank");
        } else {
            pesan.error("Tidak ada data");
        }
    }
}

function gerejaController($scope, gerejaServices, helperServices, pesan) {
    $scope.$emit("SendUp", "Data Anggota");
    $scope.model = {};
    $scope.datas = {};
    $scope.baptis = {};
    gerejaServices.get(helperServices.lastPath).then((res) => {
        $scope.datas = res;
    });

    $scope.save = () => {
        pesan.dialog("Yakin ingin melanjutkan?", "Ya", "Tidak").then(x => {
            $.LoadingOverlay("show");
            if ($scope.model.id) {
                gerejaServices.put($scope.model).then(res => {
                    $.LoadingOverlay("hide");
                    pesan.Success("Berhasil mengubah data");
                    $scope.model = {};
                });
            } else {
                gerejaServices.post($scope.model).then(res => {
                    $.LoadingOverlay("hide");
                    pesan.Success("Berhasil menambah data");
                    $scope.model = {};
                });
            }
        })
    }
}

function manajemenUsersController($scope, manajemenUsersServices, pesan, helperServices, DTOptionsBuilder) {
    $scope.$emit("SendUp", "Manajemen User");
    $scope.datas = {};
    $scope.model = {};
    $scope.dtOptions = DTOptionsBuilder.newOptions().withOption('scrollX', '100%');
    manajemenUsersServices.get().then((res) => {
        $scope.datas = res;
    })

    $scope.setPin = (item) => {
        $scope.model.anggota_jemaat_id = item.anggota_jemaat_id;
        $scope.model.username = item.kode_kk;
        $scope.model.nama = item.nama;
        $scope.model.wijk = item.wijk;
        $scope.model.ksp = item.ksp;
        $scope.model.pin = helperServices.randNumber(6);
        console.log($scope.model);
    }

    $scope.tambah = () => {
        $("#addUser").modal("show");
    }

    $scope.save = () => {
        pesan.dialog('Yakin ingin?', 'Yes', 'Tidak').then(res => {
            $.LoadingOverlay("show");
            if ($scope.model.id) {
                manajemenUsersServices.put($scope.model).then(res => {
                    $scope.model = {};
                    pesan.Success("Berhasil mengubah data");
                })
            } else {
                manajemenUsersServices.post($scope.model).then(res => {
                    $scope.model = {};
                    $scope.jemaat = undefined;
                    $.LoadingOverlay("hide");
                    pesan.Success("Berhasil menambah data");
                })
            }
        })
    }

    $scope.edit = (param) => {
        $scope.model = angular.copy(param);
        $scope.jemaat = $scope.datas.anggota.find(x => x.anggota_jemaat_id == param.anggota_jemaat_id);
        console.log($scope.jemaat);
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin?', 'Ya', 'Tidak').then(res => {
            manajemenUsersServices.deleted(param).then(res => {
                pesan.Success("Berhasil menghapus data");
            })
        });
    }
}

function persyaratanController($scope, persyaratanServices, pesan, helperServices) {
    $scope.$emit("SendUp", "Persyaratan");
    $scope.datas = {};
    $scope.model = {};
    $scope.persyaratan;
    persyaratanServices.get().then(res => {
        $scope.datas = res;
        console.log(res);
    });
    $scope.save = () => {
        pesan.dialog("Yakin ingin melanjutkan?", "Ya", "Tidak").then(x => {
            if ($scope.model.id) {
                persyaratanServices.put($scope.model).then(res => {
                    pesan.Success("Berhasil mengubah data");
                    $scope.model = {};
                });
            } else {
                $scope.model.layanan_id = $scope.persyaratan.id;
                persyaratanServices.post($scope.model).then(res => {
                    pesan.Success("Berhasil menambah data");
                    $scope.persyaratan.persyaratan.push(res);
                    $scope.model = {};
                });
            }
        })
    }
}

function baptisController($scope, baptisServices, pesan, helperServices, DTOptionsBuilder) {
    $scope.$emit("SendUp", "Manajemen User");
    $scope.datas = {};
    $scope.model = {};
    $scope.dtOptions = DTOptionsBuilder.newOptions().withOption('scrollX', '100%');
    if (helperServices.dekrip(helperServices.urlParams('item')) == 'pengajuan') {
        baptisServices.getPengajuan().then(res => {
            $scope.datas = res;
        })
    } else if (helperServices.dekrip(helperServices.urlParams('item')) == 'proses') {
        baptisServices.getProses().then(res => {
            $scope.datas = res;
        })
    } else {
        baptisServices.getSelesai().then(res => {
            $scope.datas = res;
        })
    }
}

function manajemenBaptisController($scope, manajemenBaptisServices, kelengkapanServices, persyaratanServices, helperServices, pesan, DTOptionsBuilder, $sce) {
    $scope.$emit("SendUp", "Manajemen Baptis");
    $scope.datas = {};
    $scope.dtOptions = DTOptionsBuilder.newOptions().withOption('scrollX', '100%');
    const message = document.querySelector("#pesan");
    if (helperServices.dekrip(helperServices.urlParams('item')) == 'pengajuan') {
        if (message.dataset.pesan) {
            pesan.Success('Data diubah');
        }
        console.log(pesan);
        manajemenBaptisServices.getPengajuan().then(res => {
            $scope.datas = res;
        })
    } else if (helperServices.dekrip(helperServices.urlParams('item')) == 'proses') {
        if (message.dataset.pesan) {
            pesan.Success('Data disimpan');
        }
        manajemenBaptisServices.getProses().then(res => {
            $scope.datas = res;
        })
    } else if (helperServices.dekrip(helperServices.urlParams('item')) == 'selesai') {
        manajemenBaptisServices.getSelesai().then(res => {
            $scope.datas = res;
        })
    } else {
        $('.js-example-basic-single').select2({
            minimumInputLength: 3,
            templateSelection: formatSelection,
            placeholder: '--- Pilih Anggota Jemaat ---',
            language: {
                inputTooShort: function () {
                    return "Masukkan minimal 3 karakter";
                }
            },
            ajax: {
                url: helperServices.url + "manajemen_baptis/add",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
            }
        });
        function formatSelection(state) {
            if (state.id) {
                $scope.model = {};
                $scope.model.jemaat_kk_id = state.jemaat_kk_id;
                $scope.model.status = 1;
                $scope.model.anggotas = {};
                $scope.model.anggotas.tanggal_lahir = state.tanggal_lahir;
                $scope.model.anggotas.anggota_jemaat_id = state.id;
                $scope.model.anggotas.tempat_lahir = state.tempat_lahir;
                $scope.model.anggotas.sex = state.sex;
                $scope.model.anggotas.hubungan_keluarga = state.hubungan_keluarga;
                $scope.model.anggotas.alamat = state.alamat;
                $scope.model.anggotas.nama_ayah = state.nama_ayah;
                $scope.model.anggotas.nama_ibu = state.nama_ibu;
                persyaratanServices.getByLayanan("1").then(res => {
                    if (res.length > 0) {
                        res.map(x => x.set = 'baptis' + x.id);
                        $scope.model.layanan_id = res[0].layanan_id;
                        $scope.model.persyaratans = res;
                    } else {
                        pesan.dialog("Persyaratan belum ditentukan, silahkan inputkan persyaratan terlebuh dahulu", "OK", false).then(x => {
                            document.location.href = helperServices.url + "manajemen_baptis?item=" + helperServices.enkrip('proses');
                        })
                    }
                })
            }
            return state.text;
        };
    }
    $scope.getDataAnggota = (param) => {
    }

    $scope.setPdf = (param) => {
        var url = helperServices.url + 'assets/berkas/' + param;

        var pdfDoc = null,
            pageNum = 1,
            pageRendering = false,
            pageNumPending = null,
            scale = 3,
            canvas = document.getElementById('the-canvas'),
            ctx = canvas.getContext('2d');

        /**
         * Get page info from document, resize canvas accordingly, and render page.
         * @param num Page number.
         */
        function renderPage(num) {
            pageRendering = true;
            // Using promise to fetch the page
            pdfDoc.getPage(num).then(function (page) {
                var viewport = page.getViewport({ scale: scale });
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Render PDF page into canvas context
                var renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                var renderTask = page.render(renderContext);

                // Wait for rendering to finish
                renderTask.promise.then(function () {
                    pageRendering = false;
                    if (pageNumPending !== null) {
                        // New page rendering is pending
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                });
            });

            // Update page counters
            document.getElementById('page_num').textContent = num;
        }

        /**
         * If another page rendering in progress, waits until the rendering is
         * finised. Otherwise, executes rendering immediately.
         */
        function queueRenderPage(num) {
            if (pageRendering) {
                pageNumPending = num;
            } else {
                renderPage(num);
            }
        }

        /**
         * Displays previous page.
         */
        function onPrevPage() {
            if (pageNum <= 1) {
                return;
            }
            pageNum--;
            queueRenderPage(pageNum);
        }
        document.getElementById('prev').addEventListener('click', onPrevPage);

        /**
         * Displays next page.
         */
        function onNextPage() {
            if (pageNum >= pdfDoc.numPages) {
                return;
            }
            pageNum++;
            queueRenderPage(pageNum);
        }
        document.getElementById('next').addEventListener('click', onNextPage);

        /**
         * Asynchronously downloads PDF.
         */
        pdfjsLib.getDocument(url).promise.then(function (pdfDoc_) {
            pdfDoc = pdfDoc_;
            document.getElementById('page_count').textContent = pdfDoc.numPages;

            // Initial/first page rendering
            renderPage(pageNum);
            $("#modalFile").modal('show');
        });
    }

    $scope.showPersyaratan = (param) => {
        $scope.model = param;
        $scope.persyaratan = [];
        kelengkapanServices.getByPendaftaran(param.id).then(res => {
            res.forEach(element => {
                var item = element.berkas.split('.');
                element.set = item[1];
                $scope.persyaratan.push(element);
            });
            $("#modalPersyaratan").modal('show');
        })
    }

    $scope.showFile = (param) => {
        $scope.setItem = param;
        if (param.set == 'pdf') {
            setTimeout(() => {
                $scope.setPdf(param.berkas);
                $("#modalFile").modal('show');
                $("#modalPersyaratan").modal('hide');
            }, 300);
        } else {
            $scope.setItem.url = $sce.trustAsHtml(helperServices.url + 'assets/berkas/' + $scope.setItem.berkas);
            $("#modalFile").modal('show');
            $("#modalPersyaratan").modal('hide');
        }
    }

    $scope.download = () => {
        $scope.setItem
        var link = document.createElement('a');
        link.href = helperServices.url + 'assets/berkas/' + $scope.setItem.berkas;
        link.download = $scope.setItem.nama + '.' + $scope.setItem.set;
        link.dispatchEvent(new MouseEvent('click'));
    }

    $scope.hideFile = () => {
        $("#modalFile").modal('hide');
        $("#pesanTolak").modal('hide');
        $("#modalSelesai").modal('hide');
        $("#modalPersyaratan").modal('show');
    }

    $scope.show = (param) => {
        param.nama_gereja = document.getElementById("tempatBaptis").value;
        console.log(param);
    }

    $scope.save = () => {
        pesan.dialog("Yakin ingin melanjutkan?", "Ya", "Tidak").then(x => {
            if ($scope.model.id) {
                if ($scope.model.status == "2") {
                    $scope.model.nama_gereja = document.getElementById("tempatBaptis").value;
                }
                manajemenBaptisServices.put($scope.model).then(res => {
                    if (helperServices.dekrip(helperServices.urlParams('item')) == 'proses') {
                        document.location.href = helperServices.url + "manajemen_baptis?item=" + helperServices.enkrip('proses');
                    } else {
                        document.location.href = helperServices.url + "manajemen_baptis?item=" + helperServices.enkrip('pengajuan');
                    }
                })
            } else {
                manajemenBaptisServices.post($scope.model).then(res => {
                    document.location.href = helperServices.url + "manajemen_baptis?item=" + helperServices.enkrip('proses');
                })
            }
        })
    }
}

function manajemenNikahController($scope, manajemenNikahServices, kelengkapanServices, persyaratanServices, helperServices, pesan, DTOptionsBuilder, $sce) {
    $scope.$emit("SendUp", "Manajemen Baptis");
    $scope.datas = {};
    $scope.dtOptions = DTOptionsBuilder.newOptions().withOption('scrollX', '100%');
    const message = document.querySelector("#pesan");
    if (helperServices.dekrip(helperServices.urlParams('item')) == 'pengajuan') {
        if (message.dataset.pesan) {
            pesan.Success('Data diubah');
        }
        console.log(pesan);
        manajemenNikahServices.getPengajuan().then(res => {
            $scope.datas = res;
        })
    } else if (helperServices.dekrip(helperServices.urlParams('item')) == 'proses') {
        if (message.dataset.pesan) {
            pesan.Success('Data disimpan');
        }
        manajemenNikahServices.getProses().then(res => {
            $scope.datas = res;
        })
    } else if (helperServices.dekrip(helperServices.urlParams('item')) == 'selesai') {
        manajemenNikahServices.getSelesai().then(res => {
            $scope.datas = res;
        })
    } else {
        $('.js-example-basic-single').select2({
            minimumInputLength: 3,
            templateSelection: formatSelection,
            placeholder: '--- Pilih Anggota Jemaat ---',
            language: {
                inputTooShort: function () {
                    return "Masukkan minimal 3 karakter";
                }
            },
            ajax: {
                url: helperServices.url + "manajemen_nikah/add",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
            }
        });
        function formatSelection(state) {
            if (state.id) {
                $scope.model = {};
                $scope.model.jemaat_kk_id = state.jemaat_kk_id;
                $scope.model.status = 1;
                $scope.model.anggotas = {};
                $scope.model.anggotas.tanggal_lahir = state.tanggal_lahir;
                $scope.model.anggotas.anggota_jemaat_id = state.id;
                $scope.model.anggotas.tempat_lahir = state.tempat_lahir;
                $scope.model.anggotas.sex = state.sex;
                $scope.model.anggotas.hubungan_keluarga = state.hubungan_keluarga;
                $scope.model.anggotas.alamat = state.alamat;
                $scope.model.anggotas.nama_ayah = state.nama_ayah;
                $scope.model.anggotas.nama_ibu = state.nama_ibu;
                persyaratanServices.getByLayanan("3").then(res => {
                    if (res.length > 0) {
                        res.map(x => x.set = 'nikah' + x.id);
                        $scope.model.layanan_id = res[0].layanan_id;
                        $scope.model.persyaratans = res;
                        console.log($scope.model);

                    } else {
                        pesan.dialog("Persyaratan belum ditentukan, silahkan inputkan persyaratan terlebuh dahulu", "OK").then(x => {
                            document.location.href = helperServices.url + "manajemen_nikah?item=" + helperServices.enkrip('proses');
                        })
                    }
                })
            }
            return state.text;
        };
    }
    $scope.getDataAnggota = (param) => {
    }

    $scope.setPdf = (param) => {
        var url = helperServices.url + 'assets/berkas/' + param;

        var pdfDoc = null,
            pageNum = 1,
            pageRendering = false,
            pageNumPending = null,
            scale = 3,
            canvas = document.getElementById('the-canvas'),
            ctx = canvas.getContext('2d');

        /**
         * Get page info from document, resize canvas accordingly, and render page.
         * @param num Page number.
         */
        function renderPage(num) {
            pageRendering = true;
            // Using promise to fetch the page
            pdfDoc.getPage(num).then(function (page) {
                var viewport = page.getViewport({ scale: scale });
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Render PDF page into canvas context
                var renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                var renderTask = page.render(renderContext);

                // Wait for rendering to finish
                renderTask.promise.then(function () {
                    pageRendering = false;
                    if (pageNumPending !== null) {
                        // New page rendering is pending
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                });
            });

            // Update page counters
            document.getElementById('page_num').textContent = num;
        }

        /**
         * If another page rendering in progress, waits until the rendering is
         * finised. Otherwise, executes rendering immediately.
         */
        function queueRenderPage(num) {
            if (pageRendering) {
                pageNumPending = num;
            } else {
                renderPage(num);
            }
        }

        /**
         * Displays previous page.
         */
        function onPrevPage() {
            if (pageNum <= 1) {
                return;
            }
            pageNum--;
            queueRenderPage(pageNum);
        }
        document.getElementById('prev').addEventListener('click', onPrevPage);

        /**
         * Displays next page.
         */
        function onNextPage() {
            if (pageNum >= pdfDoc.numPages) {
                return;
            }
            pageNum++;
            queueRenderPage(pageNum);
        }
        document.getElementById('next').addEventListener('click', onNextPage);

        /**
         * Asynchronously downloads PDF.
         */
        pdfjsLib.getDocument(url).promise.then(function (pdfDoc_) {
            pdfDoc = pdfDoc_;
            document.getElementById('page_count').textContent = pdfDoc.numPages;

            // Initial/first page rendering
            renderPage(pageNum);
            $("#modalFile").modal('show');
        });
    }

    $scope.showPersyaratan = (param) => {
        $scope.model = param;
        $scope.persyaratan = [];
        kelengkapanServices.getByPendaftaran(param.id).then(res => {
            res.forEach(element => {
                var item = element.berkas.split('.');
                element.set = item[1];
                $scope.persyaratan.push(element);
            });
            $("#modalPersyaratan").modal('show');
        })
    }

    $scope.showFile = (param) => {
        $scope.setItem = param;
        if (param.set == 'pdf') {
            setTimeout(() => {
                $scope.setPdf(param.berkas);
                $("#modalFile").modal('show');
                $("#modalPersyaratan").modal('hide');
            }, 300);
        } else {
            $scope.setItem.url = $sce.trustAsHtml(helperServices.url + 'assets/berkas/' + $scope.setItem.berkas);
            $("#modalFile").modal('show');
            $("#modalPersyaratan").modal('hide');
        }
    }

    $scope.download = () => {
        $scope.setItem
        var link = document.createElement('a');
        link.href = helperServices.url + 'assets/berkas/' + $scope.setItem.berkas;
        link.download = $scope.setItem.nama + '.' + $scope.setItem.set;
        link.dispatchEvent(new MouseEvent('click'));
    }

    $scope.hideFile = () => {
        $("#modalFile").modal('hide');
        $("#pesanTolak").modal('hide');
        $("#modalSelesai").modal('hide');
        $("#modalPersyaratan").modal('show');
    }

    $scope.show = (param) => {
        param.nama_gereja = document.getElementById("tempatBaptis").value;
        console.log(param);
    }

    $scope.save = () => {
        pesan.dialog("Yakin ingin melanjutkan?", "Ya", "Tidak").then(x => {
            if ($scope.model.id) {
                if ($scope.model.status == "2") {
                    $scope.model.nama_gereja = document.getElementById("tempatBaptis").value;
                }
                manajemenNikahServices.put($scope.model).then(res => {
                    if (helperServices.dekrip(helperServices.urlParams('item')) == 'proses') {
                        document.location.href = helperServices.url + "manajemen_baptis?item=" + helperServices.enkrip('proses');
                    } else {
                        document.location.href = helperServices.url + "manajemen_baptis?item=" + helperServices.enkrip('pengajuan');
                    }
                })
            } else {
                manajemenNikahServices.post($scope.model).then(res => {
                    document.location.href = helperServices.url + "manajemen_baptis?item=" + helperServices.enkrip('proses');
                })
            }
        })
    }
}

function manajemenSidiController($scope, manajemenSidiServices, kelengkapanServices, persyaratanServices, helperServices, pesan, DTOptionsBuilder, $sce) {
    $scope.$emit("SendUp", "Manajemen Baptis");
    $scope.datas = {};
    $scope.dtOptions = DTOptionsBuilder.newOptions().withOption('scrollX', '100%');
    const message = document.querySelector("#pesan");
    if (helperServices.dekrip(helperServices.urlParams('item')) == 'pengajuan') {
        if (message.dataset.pesan) {
            pesan.Success('Data diubah');
        }
        console.log(pesan);
        manajemenSidiServices.getPengajuan().then(res => {
            $scope.datas = res;
        })
    } else if (helperServices.dekrip(helperServices.urlParams('item')) == 'proses') {
        if (message.dataset.pesan) {
            pesan.Success('Data disimpan');
        }
        manajemenSidiServices.getProses().then(res => {
            $scope.datas = res;
        })
    } else if (helperServices.dekrip(helperServices.urlParams('item')) == 'selesai') {
        manajemenSidiServices.getSelesai().then(res => {
            $scope.datas = res;
        })
    } else {
        $('.js-example-basic-single').select2({
            minimumInputLength: 3,
            templateSelection: formatSelection,
            placeholder: '--- Pilih Anggota Jemaat ---',
            language: {
                inputTooShort: function () {
                    return "Masukkan minimal 3 karakter";
                }
            },
            ajax: {
                url: helperServices.url + "manajemen_sidi/add",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
            }
        });
        function formatSelection(state) {
            if (state.id) {
                $scope.model = {};
                $scope.model.jemaat_kk_id = state.jemaat_kk_id;
                $scope.model.status = 1;
                $scope.model.anggotas = {};
                $scope.model.anggotas.tanggal_lahir = state.tanggal_lahir;
                $scope.model.anggotas.anggota_jemaat_id = state.id;
                $scope.model.anggotas.tempat_lahir = state.tempat_lahir;
                $scope.model.anggotas.sex = state.sex;
                $scope.model.anggotas.hubungan_keluarga = state.hubungan_keluarga;
                $scope.model.anggotas.alamat = state.alamat;
                $scope.model.anggotas.nama_ayah = state.nama_ayah;
                $scope.model.anggotas.nama_ibu = state.nama_ibu;
                persyaratanServices.getByLayanan("2").then(res => {
                    if (res.length > 0) {
                        res.map(x => x.set = 'sidi' + x.id);
                        $scope.model.layanan_id = res[0].layanan_id;
                        $scope.model.persyaratans = res;
                    } else {
                        pesan.dialog("Persyaratan belum ditentukan, silahkan inputkan persyaratan terlebuh dahulu", "OK").then(x => {
                            document.location.href = helperServices.url + "manajemen_sidi?item=" + helperServices.enkrip('proses');
                        })
                    }
                })
            }
            return state.text;
        };
    }
    $scope.getDataAnggota = (param) => {
    }

    $scope.setPdf = (param) => {
        var url = helperServices.url + 'assets/berkas/' + param;

        var pdfDoc = null,
            pageNum = 1,
            pageRendering = false,
            pageNumPending = null,
            scale = 3,
            canvas = document.getElementById('the-canvas'),
            ctx = canvas.getContext('2d');

        /**
         * Get page info from document, resize canvas accordingly, and render page.
         * @param num Page number.
         */
        function renderPage(num) {
            pageRendering = true;
            // Using promise to fetch the page
            pdfDoc.getPage(num).then(function (page) {
                var viewport = page.getViewport({ scale: scale });
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Render PDF page into canvas context
                var renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                var renderTask = page.render(renderContext);

                // Wait for rendering to finish
                renderTask.promise.then(function () {
                    pageRendering = false;
                    if (pageNumPending !== null) {
                        // New page rendering is pending
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                });
            });

            // Update page counters
            document.getElementById('page_num').textContent = num;
        }

        /**
         * If another page rendering in progress, waits until the rendering is
         * finised. Otherwise, executes rendering immediately.
         */
        function queueRenderPage(num) {
            if (pageRendering) {
                pageNumPending = num;
            } else {
                renderPage(num);
            }
        }

        /**
         * Displays previous page.
         */
        function onPrevPage() {
            if (pageNum <= 1) {
                return;
            }
            pageNum--;
            queueRenderPage(pageNum);
        }
        document.getElementById('prev').addEventListener('click', onPrevPage);

        /**
         * Displays next page.
         */
        function onNextPage() {
            if (pageNum >= pdfDoc.numPages) {
                return;
            }
            pageNum++;
            queueRenderPage(pageNum);
        }
        document.getElementById('next').addEventListener('click', onNextPage);

        /**
         * Asynchronously downloads PDF.
         */
        pdfjsLib.getDocument(url).promise.then(function (pdfDoc_) {
            pdfDoc = pdfDoc_;
            document.getElementById('page_count').textContent = pdfDoc.numPages;

            // Initial/first page rendering
            renderPage(pageNum);
            $("#modalFile").modal('show');
        });
    }

    $scope.showPersyaratan = (param) => {
        $scope.model = param;
        $scope.persyaratan = [];
        kelengkapanServices.getByPendaftaran(param.id).then(res => {
            res.forEach(element => {
                var item = element.berkas.split('.');
                element.set = item[1];
                $scope.persyaratan.push(element);
            });
            $("#modalPersyaratan").modal('show');
        })
    }

    $scope.showFile = (param) => {
        $scope.setItem = param;
        if (param.set == 'pdf') {
            setTimeout(() => {
                $scope.setPdf(param.berkas);
                $("#modalFile").modal('show');
                $("#modalPersyaratan").modal('hide');
            }, 300);
        } else {
            $scope.setItem.url = $sce.trustAsHtml(helperServices.url + 'assets/berkas/' + $scope.setItem.berkas);
            $("#modalFile").modal('show');
            $("#modalPersyaratan").modal('hide');
        }
    }

    $scope.download = () => {
        $scope.setItem
        var link = document.createElement('a');
        link.href = helperServices.url + 'assets/berkas/' + $scope.setItem.berkas;
        link.download = $scope.setItem.nama + '.' + $scope.setItem.set;
        link.dispatchEvent(new MouseEvent('click'));
    }

    $scope.hideFile = () => {
        $("#modalFile").modal('hide');
        $("#pesanTolak").modal('hide');
        $("#modalSelesai").modal('hide');
        $("#modalPersyaratan").modal('show');
    }

    $scope.show = (param) => {
        param.nama_gereja = document.getElementById("tempatBaptis").value;
        console.log(param);
    }

    $scope.save = () => {
        pesan.dialog("Yakin ingin melanjutkan?", "Ya", "Tidak").then(x => {
            if ($scope.model.id) {
                if ($scope.model.status == "2") {
                    $scope.model.nama_gereja = document.getElementById("tempatSidi").value;
                }
                manajemenSidiServices.put($scope.model).then(res => {
                    if (helperServices.dekrip(helperServices.urlParams('item')) == 'proses') {
                        document.location.href = helperServices.url + "manajemen_sidi?item=" + helperServices.enkrip('proses');
                    } else {
                        document.location.href = helperServices.url + "manajemen_sidi?item=" + helperServices.enkrip('pengajuan');
                    }
                })
            } else {
                manajemenSidiServices.post($scope.model).then(res => {
                    document.location.href = helperServices.url + "manajemen_sidi?item=" + helperServices.enkrip('proses');
                })
            }
        })
    }
}



function laporanAnggotaJemaatController($scope, laporanAnggotaServices, wijkServices, pesan, helperServices, DTOptionsBuilder) {
    $scope.$emit("SendUp", "Manajemen User");
    $scope.datas = {};
    $scope.model = {};
    $scope.wijks = [];
    $scope.dataAnggota = [];
    $scope.dtOptions = DTOptionsBuilder.newOptions().withOption('scrollX', '100%');
    $scope.unsurs = helperServices.unsur;
    $.LoadingOverlay("show");
    laporanAnggotaServices.index().then((res) => {
        $scope.wijks = res;
        $.LoadingOverlay("hide");
    })

    $scope.viewData = (wijk, ksp, unsur) => {
        $.LoadingOverlay("show");
        var item = { wijk: wijk ? wijk.id : undefined, ksp_id: ksp ? ksp.id : undefined, unsur: unsur ? unsur : undefined }
        laporanAnggotaServices.getByAll(item).then((res) => {
            $.LoadingOverlay("hide");
            $scope.datas = res
        })
        // if(wijk && !ksp && !unsur){
        //     laporanAnggotaServices.getByWijk(item).then((res) => {
        //         $scope.datas = res
        //     })
        // }else if(ksp && unsur){
        // }else if(ksp){
        //     laporanAnggotaServices.getByKsp(ksp.id).then((res) => {
        //         $scope.datas = res
        //     })
        // }else if(unsur){
        //     laporanAnggotaServices.getByUnsur(unsur).then((res) => {
        //         $scope.datas = res
        //     })
        // }
    }

    $scope.cetak = (wijk, ksp, unsur) => {

        if (wijk && !ksp && !unsur) {
            window.open(helperServices.url + 'laporan/cetak_anggota?wijk_id=' + helperServices.enkrip(wijk.id), "_blank");
        } else if (wijk && !ksp && unsur) {
            window.open(helperServices.url + 'laporan/cetak_anggota?wijk_id=' + helperServices.enkrip(wijk.id) + '&unsur=' + helperServices.enkrip(unsur), "_blank");
        } else if (ksp && unsur) {
            window.open(helperServices.url + 'laporan/cetak_anggota?ksp_id=' + helperServices.enkrip(ksp.id) + '&unsur=' + helperServices.enkrip(unsur), "_blank");
        } else if (ksp && !unsur) {
            window.open(helperServices.url + 'laporan/cetak_anggota?ksp_id=' + helperServices.enkrip(ksp.id), "_blank");
        } else if (!wijk && !ksp && unsur) {
            window.open(helperServices.url + 'laporan/cetak_anggota?unsur=' + helperServices.enkrip(unsur), "_blank");
        } else {
            pesan.error("Tidak ada data");
        }
    }


}

function laporanKepalaKeluargaController($scope, laporanServices, kspServices, pesan, helperServices, DTOptionsBuilder) {
    $scope.$emit("SendUp", "Laporan Kepala Keluarga");
    $scope.datas = {};
    $scope.model = {};
    $scope.wijks = [];
    $scope.dataAnggota = [];
    $scope.dtOptions = DTOptionsBuilder.newOptions().withOption('scrollX', '100%');
    $scope.unsurs = helperServices.unsur;
    $.LoadingOverlay("show");
    kspServices.get().then((res) => {
        $scope.wijks = res;
        $.LoadingOverlay("hide");
    })

    $scope.viewData = (wijk, ksp) => {
        $.LoadingOverlay("show");
        var item = { wijk: wijk ? wijk.id : undefined, ksp_id: ksp ? ksp.id : undefined }
        laporanServices.getKepalaKeluarga(item).then((res) => {
            $.LoadingOverlay("hide");
            $scope.datas = res
        })
    }

    $scope.cetak = (wijk, ksp, statusCetak) => {
        if (statusCetak == 'kepala') {
            if (wijk && ksp) {
                window.open(helperServices.url + "laporan/print?item=" + helperServices.encript('kepalaKeluarga') + "&ksp_id=" + helperServices.enkrip(ksp.id), "_blank");
            } else if (wijk && !ksp) {
                window.open(helperServices.url + "laporan/print?item=" + helperServices.encript('kepalaKeluarga') + "&wijk_id=" + helperServices.enkrip(wijk.id), "_blank");
            } else {
                pesan.error("WIJK belum di pilih");
            }
        } else if (statusCetak == 'anggota') {
            if (wijk && ksp) {
                window.open(helperServices.url + 'keluarga/cetakall?ksp_id=' + helperServices.enkrip(ksp.id), "_blank");
            } else if (wijk && !ksp) {
                window.open(helperServices.url + 'keluarga/cetakall?wijk_id=' + helperServices.enkrip(wijk.id), "_blank");
            } else {
                pesan.error("WIJK belum di pilih");
            }
        } else {
            pesan.error('Pilih Model Data');
        }
    }

    $scope.export = (wijk, ksp) => {
        if (wijk && ksp) {
            window.open(helperServices.url + "laporan/excel?item=" + helperServices.encript('kepalaKeluarga') + "&ksp_id=" + helperServices.enkrip(ksp.id), "_blank");
        } else if (wijk && !ksp) {
            window.open(helperServices.url + "laporan/excel?item=" + helperServices.encript('kepalaKeluarga') + "&wijk_id=" + helperServices.enkrip(wijk.id), "_blank");
        } else {
            pesan.error("WIJK belum di pilih");
        }
    }


}

function laporanController($scope, layananBaptisServices, persyaratanServices, wijkServices, helperServices, pesan, DTOptionsBuilder, $sce) {
    $scope.$emit("SendUp", "Manajemen Baptis");
    $scope.datas = {};
    $scope.anggotaJemaat = [];
    $scope.dtOptions = DTOptionsBuilder.newOptions().withOption('scrollX', '100%');
    wijkServices.get().then(res => {
        $scope.wijks = res;
    })
    if (helperServices.dekrip(helperServices.urlParams('item')) == 'layakBaptis') {
    } else if (helperServices.dekrip(helperServices.urlParams('item')) == 'layakSidi') {
    }

    $scope.setView = (param) => {
        console.log(param);
    }
}

function pindahJemaatController($scope, pindahJemaatServices, gerejaServices, anggotaServices, keluargaServices, helperServices, pesan, $sce, $compile) {
    $scope.$emit("SendUp", "Manajemen Baptis");
    $scope.datas = {};
    $scope.anggotaJemaat = [];
    $scope.jenisAnggota;
    $scope.hubungan = helperServices.hubungan;
    $scope.jemaat = {};
    $scope.jenis_mutasi;
    $scope.model = {};
    $scope.setValue = false
    // $scope.showJemaat= ()=>{
    // }
    $scope.showForm = () => {
        pesan.Success("OK");
    }
    $scope.clear = () => {
        document.querySelector("#form").classList.add('set-hide-page');
        document.querySelector("#statusMutasi").classList.add('set-hide-page');

    }
    // $scope.age = (item)=>{
    //     var tglMeninggal = new Date(item)
    // }

    $scope.hitungUmur = (item) => {
        if (!$scope.model.tanggal_meninggal) {
            var today = new Date();
            var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
            var time = today.getHours() + ":" + today.getMinutes();
            var dateTime = date + ' ' + time;
            $scope.model.tanggal_meninggal = new Date(dateTime);
        }
        var tanggal_lahir = new Date(item);
        var month_diff = $scope.model.tanggal_meninggal - tanggal_lahir;
        var age_dt = new Date(month_diff);
        var year = age_dt.getUTCFullYear();
        $scope.model.umur = Math.abs(year - 1970);
    }

    $scope.$watch('jenisAnggota', function () {
        if ($scope.jenisAnggota) {
            $scope.string = '<label>' + ($scope.jenisAnggota == '1' ? 'Anggota KK' : $scope.jenisAnggota == '2' ? 'Kepala Keluarga' : "") + '</label>' +
                '<div><select name="jemaat" id="jemaat" onchange="view()" class="form-select form-select-sm js-example-basic-jemaat" ng-model="jemaat"' +
                '<option value="">Pilih</option>' +
                '</select></div>';
            var html = $compile($scope.string)($scope);
            // console.log(html);
            document.getElementById("pilihJemaat").innerHTML = '';
            document.getElementById("pilihJemaat").innerHTML = $scope.string;

        }
        $scope.$applyAsync(() => {
            $('.js-example-basic-jemaat').select2({
                minimumInputLength: 3,
                theme: 'bootstrap-5',
                templateSelection: formatSelection,
                placeholder: $scope.jenisAnggota == '1' ? '--- Pilih Jemaat ---' : '--- Pilih Keluarga ---',
                language: {
                    inputTooShort: function () {
                        return "Masukkan minimal 4 karakter";
                    }
                },
                ajax: {
                    url: helperServices.url + "mutasi/" + ($scope.jenisAnggota == '1' ? 'get_jemaat_aktif' : 'get_kk_aktif'),
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                }
            });
            function formatSelection(state) {
                if (state.id) {
                    $scope.jemaat = {};
                    if ($scope.jenisAnggota == '1') {
                        $scope.model.anggota_kk_id = state.anggota_kk_id;
                        $scope.model.hubungan_keluarga = state.hubungan_keluarga;
                        $scope.model.kk_id = state.kk_id;
                        $scope.hitungUmur(state.tanggal_lahir);
                        $scope.jemaat.anggota_kk_id = state.id;
                        $scope.jemaat.tanggal_lahir = state.tanggal_lahir;
                        $scope.jemaat.nama = state.nama;
                        $scope.jemaat.nik = state.nik;
                        $scope.jemaat.wijk_ksp = state.wijk + "/" + state.ksp;
                        $scope.jemaat.unsur = state.unsur;
                        $scope.jemaat.hubungan_keluarga = state.hubungan_keluarga;
                        $scope.jemaat.asal_gereja = state.asal_gereja;
                    } else {
                        keluargaServices.getId(state.kk_id).then(res => {
                            $scope.keluarga = res;
                            $scope.model.jemaat_kk_id = res.jemaat_kk_id;
                            $scope.model.anggota = angular.copy($scope.keluarga.anggota);
                        })
                    }


                }
                return state.text;
            };
        })
    });

    $scope.$watch('pindah', function () {
        $scope.string = '<label>Kepala Keluarga' + '</label>' +
            '<div><select name="jemaat" id="jemaat" class="form-select form-select-sm js-example-basic-jemaat" ng-model="jemaat"' +
            '<option value="">Pilih</option>' +
            '</select></div>';
        $scope.string1 = '<label>Kepala Keluarga' + '</label>' +
            '<div><select name="jemaat" id="kkTujuan" class="form-select form-select-sm js-example-basic-tujuan" ng-model="tujuan"' +
            '<option value="">Pilih</option>' +
            '</select></div>';
        // var html = $compile($scope.string)($scope);
        // console.log(html);
        document.getElementById("pilihJemaat").innerHTML = '';
        document.getElementById("pilihJemaat").innerHTML = $scope.string;
        document.getElementById("pilihKKTujuan").innerHTML = '';
        document.getElementById("pilihKKTujuan").innerHTML = $scope.string1;
        // if ($scope.jenisAnggota) {
        // }
        $scope.$applyAsync(() => {
            $('.js-example-basic-jemaat').select2({
                minimumInputLength: 3,
                theme: 'bootstrap-5',
                templateSelection: formatSelection,
                placeholder: '--- Pilih Keluarga ---',
                language: {
                    inputTooShort: function () {
                        return "Masukkan minimal 3 karakter";
                    }
                },
                ajax: {
                    url: helperServices.url + "mutasi/get_kk_aktif",
                    dataType: 'json',
                    delay: 100,
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                }
            });
            function formatSelection(state) {
                if (state.id) {
                    $.LoadingOverlay('show');
                    keluargaServices.getId(state.kk_id).then(res => {
                        $scope.$applyAsync(() => {
                            $scope.keluarga = res;
                            $scope.keluarga.anggota.forEach(element => {
                                element.set = false;
                            });
                            $.LoadingOverlay('hide');
                            console.log($scope.keluarga);
                        })
                    })
                }
                return state.text;
            };
            $('.js-example-basic-tujuan').select2({
                minimumInputLength: 3,
                theme: 'bootstrap-5',
                templateSelection: formatSelectionn,
                placeholder: '--- Pilih Keluarga ---',
                language: {
                    inputTooShort: function () {
                        return "Masukkan minimal 3 karakter";
                    }
                },
                ajax: {
                    url: helperServices.url + "mutasi/get_kk_aktif",
                    dataType: 'json',
                    delay: 100,
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                }
            });
            function formatSelectionn(state) {
                if (state.id) {
                    $.LoadingOverlay('show');
                    keluargaServices.getId(state.kk_id).then(res => {
                        $scope.$applyAsync(() => {
                            $scope.keluargaTujuan = res;
                            $scope.keluargaTujuan.anggotaBaru = $scope.keluarga.anggota.filter(x=>x.set==true);
                            $scope.keluargaTujuan.anggotaBaru.forEach(element => {
                                element.hubungan_keluarga = "FAMILI LAIN";
                            });
                            $scope.keluargaTujuan.kkLama = $scope.keluarga.id;
                            $scope.keluargaTujuan.setStatus = $scope.keluarga.setStatus
                            $.LoadingOverlay('hide');
                            console.log($scope.keluargaTujuan);
                        })
                    })
                }
                return state.text;
            };
        })
    });

    $scope.$watch('jenis_mutasi', function () {
        $scope.$applyAsync(() => {
            $('#tujuan').select2({
                theme: 'bootstrap-5',
                minimumInputLength: 3,
                templateSelection: formatGereja,
                placeholder: '---Pilih Gereja Tujuan---',
                language: {
                    inputTooShort: function () {
                        return "Masukkan minimal 3 karakter";
                    }
                },
                ajax: {
                    url: helperServices.url + "gereja/read",
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                }
            });
            function formatGereja(state) {
                if (state.id) {
                    $scope.model.gereja_id = state.id;
                }
                return state.text;
            };
        })
    })

    $scope.saveGereja = (param) => {
        pesan.dialog("Ingin menambah data ?", "Ya", "Tidak", 'warning').then(x => {
            gerejaServices.post(param).then(res => {
                pesan.Success("Berasil menambah data");
                $("#addGereja").modal('hide');
            })
        })
    }

    $scope.save = (param) => {
        pesan.dialog("Anda yakin !", "Ya", "Tidak", 'warning').then(x => {
            var item = angular.copy(param);
            item.status_pindah && item.status_pindah == "2" ? item.tanggal_meninggal = helperServices.dateTimeToString(param.tanggal_meninggal) : item.tanggal_pindah = helperServices.dateToString(param.tanggal_pindah);
            item.status_pindah = item.jenisAnggota == '2' ? '1' : item.status_pindah;
            pindahJemaatServices.post(item).then(res => {
                pesan.Success("Berasil menambah data");
                setTimeout(() => {
                    if (item.status_pindah == "1") document.location.href = helperServices.url + "mutasi?item=" + helperServices.enkrip('pindah');
                    else document.location.href = helperServices.url + "mutasi?item=" + helperServices.enkrip('meninggal');
                }, 1000);
            })
        })
    }

    $scope.pindahKK = () => {
        pesan.dialog("Anda yakin !", "Ya", "Tidak", 'warning').then(x => {
            pindahJemaatServices.pindah($scope.keluargaTujuan).then(res => {
                pesan.Success("Berasil menambah data");
            })
        })
    }

    $scope.set = (param) => {
        $scope.keluarga.anggota.forEach(element => {
            element.set = param == true ? true : false;
        });
        $scope.keluarga.setStatus = param == true ? true : false;
    }

    $scope.checkSet = () => {
        var item = undefined;
        var item = $scope.keluarga.anggota.find(x => x.set == false);
        if (item) {
            $scope.setValue = false;
            $scope.keluarga.setStatus = false;
        } else {
            $scope.setValue = true;
            $scope.keluarga.setStatus = true;
        }
    }
}

// Anggota Jemaat

function layananBaptisController($scope, layananBaptisServices, persyaratanServices, helperServices, pesan, DTOptionsBuilder, $sce) {
    $scope.$emit("SendUp", "Manajemen Baptis");
    $scope.datas = {};
    $scope.anggotaJemaat = [];
    $scope.dtOptions = DTOptionsBuilder.newOptions().withOption('scrollX', '100%');
    if (helperServices.dekrip(helperServices.urlParams('item')) == 'pengajuan') {
        layananBaptisServices.getPengajuan().then(res => {
            $scope.datas = res;
        })
    } else if (helperServices.dekrip(helperServices.urlParams('item')) == 'proses') {
        layananBaptisServices.getProses().then(res => {
            $scope.datas = res;
        })
    } else if (helperServices.dekrip(helperServices.urlParams('item')) == 'selesai') {
        layananBaptisServices.getSelesai().then(res => {
            $scope.datas = res;
        })
    } else if (helperServices.dekrip(helperServices.urlParams('item')) == 'add') {
        layananBaptisServices.getAdd().then(res => {
            $scope.anggotaJemaat = res;
        })
    } else if (helperServices.dekrip(helperServices.urlParams('item')) == 'edit') {
        layananBaptisServices.getEdit(helperServices.dekrip(helperServices.urlParams('set'))).then(res => {
            $scope.model = res;
        })
    }
    $scope.selectedAnggota = (state) => {
        $scope.model = {};
        $scope.model.jemaat_kk_id = state.jemaat_kk_id;
        $scope.model.anggotas = {};
        $scope.model.anggotas.tanggal_lahir = state.tanggal_lahir;
        $scope.model.anggotas.anggota_jemaat_id = state.id;
        $scope.model.anggotas.tempat_lahir = state.tempat_lahir;
        $scope.model.anggotas.sex = state.sex;
        $scope.model.anggotas.hubungan_keluarga = state.hubungan_keluarga;
        $scope.model.anggotas.alamat = state.alamat;
        $scope.model.anggotas.nama_ayah = state.nama_ayah;
        $scope.model.anggotas.nama_ibu = state.nama_ibu;
        persyaratanServices.getByLayanan().then(res => {
            res.map(x => x.set = 'baptis' + x.id);
            $scope.model.layanan_id = res[0].layanan_id;
            $scope.model.persyaratans = res;
            console.log($scope.model);
        })
    }

    $scope.edit = (state) => {
        document.location.href = helperServices.url + 'layanan_baptis?item=' + helperServices.enkrip('edit') + '&set=' + helperServices.enkrip(state);
    }

    $scope.setPdf = (param) => {
        var url = helperServices.url + 'assets/berkas/' + param;

        var pdfDoc = null,
            pageNum = 1,
            pageRendering = false,
            pageNumPending = null,
            scale = 3,
            canvas = document.getElementById('the-canvas'),
            ctx = canvas.getContext('2d');

        /**
         * Get page info from document, resize canvas accordingly, and render page.
         * @param num Page number.
         */
        function renderPage(num) {
            pageRendering = true;
            // Using promise to fetch the page
            pdfDoc.getPage(num).then(function (page) {
                var viewport = page.getViewport({ scale: scale });
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Render PDF page into canvas context
                var renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                var renderTask = page.render(renderContext);

                // Wait for rendering to finish
                renderTask.promise.then(function () {
                    pageRendering = false;
                    if (pageNumPending !== null) {
                        // New page rendering is pending
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                });
            });

            // Update page counters
            document.getElementById('page_num').textContent = num;
        }

        /**
         * If another page rendering in progress, waits until the rendering is
         * finised. Otherwise, executes rendering immediately.
         */
        function queueRenderPage(num) {
            if (pageRendering) {
                pageNumPending = num;
            } else {
                renderPage(num);
            }
        }

        /**
         * Displays previous page.
         */
        function onPrevPage() {
            if (pageNum <= 1) {
                return;
            }
            pageNum--;
            queueRenderPage(pageNum);
        }
        document.getElementById('prev').addEventListener('click', onPrevPage);

        /**
         * Displays next page.
         */
        function onNextPage() {
            if (pageNum >= pdfDoc.numPages) {
                return;
            }
            pageNum++;
            queueRenderPage(pageNum);
        }
        document.getElementById('next').addEventListener('click', onNextPage);

        /**
         * Asynchronously downloads PDF.
         */
        pdfjsLib.getDocument(url).promise.then(function (pdfDoc_) {
            pdfDoc = pdfDoc_;
            document.getElementById('page_count').textContent = pdfDoc.numPages;

            // Initial/first page rendering
            renderPage(pageNum);
            $("#modalFile").modal('show');
        });
    }

    $scope.showPersyaratan = (param) => {
        $scope.persyaratan = [];
        param.persyaratans.forEach(element => {
            var item = element.berkas.split('.');
            element.set = item[1];
            $scope.persyaratan.push(element);
        });
        $("#modalPersyaratan").modal('show');
    }

    $scope.showFile = (param) => {
        $scope.setItem = param;
        if (param.set == 'pdf') {
            setTimeout(() => {
                $scope.setPdf(param.berkas);
                $("#modalFile").modal('show');
                $("#modalPersyaratan").modal('hide');
            }, 300);
        } else {
            $scope.setItem.url = $sce.trustAsHtml(helperServices.url + 'assets/berkas/' + $scope.setItem.berkas);
            $("#modalFile").modal('show');
            $("#modalPersyaratan").modal('hide');
        }
    }

    $scope.download = () => {
        $scope.setItem
        var link = document.createElement('a');
        link.href = helperServices.url + 'assets/berkas/' + $scope.setItem.berkas;
        link.download = $scope.setItem.nama + '.' + $scope.setItem.set;
        link.dispatchEvent(new MouseEvent('click'));
    }

    $scope.hideFile = () => {
        $("#modalFile").modal('hide');
        $("#modalPersyaratan").modal('show');
    }

    $scope.save = () => {
        $scope.model.status = "0";
        pesan.dialog("Yakin ingin melanjutkan?", "Ya", "Tidak").then(x => {
            if ($scope.model.id) {
                layananBaptisServices.put($scope.model).then(res => {
                    document.location.href = helperServices.url + "layanan_baptis?item=" + helperServices.enkrip('pengajuan');
                })
            } else {
                layananBaptisServices.post($scope.model).then(res => {
                    document.location.href = helperServices.url + "layanan_baptis?item=" + helperServices.enkrip('pengajuan');
                })
            }
        })
    }
}

function layananSidiController($scope, layananSidiServices, persyaratanServices, helperServices, pesan, DTOptionsBuilder, $sce) {
    $scope.$emit("SendUp", "Manajemen Baptis");
    $scope.datas = {};
    $scope.anggotaJemaat = [];
    $scope.dtOptions = DTOptionsBuilder.newOptions().withOption('scrollX', '100%');
    if (helperServices.dekrip(helperServices.urlParams('item')) == 'pengajuan') {
        layananSidiServices.getPengajuan().then(res => {
            $scope.datas = res;
        })
    } else if (helperServices.dekrip(helperServices.urlParams('item')) == 'proses') {
        layananSidiServices.getProses().then(res => {
            $scope.datas = res;
        })
    } else if (helperServices.dekrip(helperServices.urlParams('item')) == 'selesai') {
        layananSidiServices.getSelesai().then(res => {
            $scope.datas = res;
        })
    } else if (helperServices.dekrip(helperServices.urlParams('item')) == 'add') {
        layananSidiServices.getAdd().then(res => {
            $scope.anggotaJemaat = res;
        })
    } else if (helperServices.dekrip(helperServices.urlParams('item')) == 'edit') {
        layananSidiServices.getEdit(helperServices.dekrip(helperServices.urlParams('set'))).then(res => {
            $scope.model = res;
        })
    }
    $scope.selectedAnggota = (state) => {
        persyaratanServices.getByLayanan("2").then(res => {
            if (res.length == 0) {
                pesan.dialog("Persyaratan belum ada, silahkan hubungi Admini Gereja", "Ya", false, "error").then(res => {
                    window.history.back();
                });
            } else {
                res.map(x => x.set = 'sidi' + x.id);
                $scope.model = {};
                $scope.model.jemaat_kk_id = state.jemaat_kk_id;
                $scope.model.anggotas = {};
                $scope.model.anggotas.tanggal_lahir = state.tanggal_lahir;
                $scope.model.anggotas.anggota_jemaat_id = state.id;
                $scope.model.anggotas.tempat_lahir = state.tempat_lahir;
                $scope.model.anggotas.sex = state.sex;
                $scope.model.anggotas.hubungan_keluarga = state.hubungan_keluarga;
                $scope.model.anggotas.alamat = state.alamat;
                $scope.model.anggotas.nama_ayah = state.nama_ayah;
                $scope.model.anggotas.nama_ibu = state.nama_ibu;
                $scope.model.layanan_id = res[0].layanan_id;
                $scope.model.persyaratans = res;
                console.log($scope.model);
            }
        })
    }

    $scope.edit = (state) => {
        document.location.href = helperServices.url + 'layanan_sidi?item=' + helperServices.enkrip('edit') + '&set=' + helperServices.enkrip(state);
    }

    $scope.setPdf = (param) => {
        var url = helperServices.url + 'assets/berkas/' + param;

        var pdfDoc = null,
            pageNum = 1,
            pageRendering = false,
            pageNumPending = null,
            scale = 3,
            canvas = document.getElementById('the-canvas'),
            ctx = canvas.getContext('2d');

        /**
         * Get page info from document, resize canvas accordingly, and render page.
         * @param num Page number.
         */
        function renderPage(num) {
            pageRendering = true;
            // Using promise to fetch the page
            pdfDoc.getPage(num).then(function (page) {
                var viewport = page.getViewport({ scale: scale });
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Render PDF page into canvas context
                var renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                var renderTask = page.render(renderContext);

                // Wait for rendering to finish
                renderTask.promise.then(function () {
                    pageRendering = false;
                    if (pageNumPending !== null) {
                        // New page rendering is pending
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                });
            });

            // Update page counters
            document.getElementById('page_num').textContent = num;
        }

        /**
         * If another page rendering in progress, waits until the rendering is
         * finised. Otherwise, executes rendering immediately.
         */
        function queueRenderPage(num) {
            if (pageRendering) {
                pageNumPending = num;
            } else {
                renderPage(num);
            }
        }

        /**
         * Displays previous page.
         */
        function onPrevPage() {
            if (pageNum <= 1) {
                return;
            }
            pageNum--;
            queueRenderPage(pageNum);
        }
        document.getElementById('prev').addEventListener('click', onPrevPage);

        /**
         * Displays next page.
         */
        function onNextPage() {
            if (pageNum >= pdfDoc.numPages) {
                return;
            }
            pageNum++;
            queueRenderPage(pageNum);
        }
        document.getElementById('next').addEventListener('click', onNextPage);

        /**
         * Asynchronously downloads PDF.
         */
        pdfjsLib.getDocument(url).promise.then(function (pdfDoc_) {
            pdfDoc = pdfDoc_;
            document.getElementById('page_count').textContent = pdfDoc.numPages;

            // Initial/first page rendering
            renderPage(pageNum);
            $("#modalFile").modal('show');
        });
    }

    $scope.showPersyaratan = (param) => {
        $scope.persyaratan = [];
        param.persyaratans.forEach(element => {
            var item = element.berkas.split('.');
            element.set = item[1];
            $scope.persyaratan.push(element);
        });
        $("#modalPersyaratan").modal('show');
    }

    $scope.showFile = (param) => {
        $scope.setItem = param;
        if (param.set == 'pdf') {
            setTimeout(() => {
                $scope.setPdf(param.berkas);
                $("#modalFile").modal('show');
                $("#modalPersyaratan").modal('hide');
            }, 300);
        } else {
            $scope.setItem.url = $sce.trustAsHtml(helperServices.url + 'assets/berkas/' + $scope.setItem.berkas);
            $("#modalFile").modal('show');
            $("#modalPersyaratan").modal('hide');
        }
    }

    $scope.download = () => {
        $scope.setItem
        var link = document.createElement('a');
        link.href = helperServices.url + 'assets/berkas/' + $scope.setItem.berkas;
        link.download = $scope.setItem.nama + '.' + $scope.setItem.set;
        link.dispatchEvent(new MouseEvent('click'));
    }

    $scope.hideFile = () => {
        $("#modalFile").modal('hide');
        $("#modalPersyaratan").modal('show');
    }

    $scope.save = () => {
        $scope.model.status = "0";
        pesan.dialog("Yakin ingin melanjutkan?", "Ya", "Tidak").then(x => {
            if ($scope.model.id) {
                layananSidiServices.put($scope.model).then(res => {
                    document.location.href = helperServices.url + "layanan_baptis?item=" + helperServices.enkrip('pengajuan');
                })
            } else {
                layananSidiServices.post($scope.model).then(res => {
                    document.location.href = helperServices.url + "layanan_baptis?item=" + helperServices.enkrip('pengajuan');
                })
            }
        })
    }
}

function layananNikahController($scope, layananNikahServices, persyaratanServices, helperServices, pesan, DTOptionsBuilder, $sce) {
    $scope.$emit("SendUp", "Manajemen Baptis");
    $scope.datas = {};
    $scope.anggotaJemaat = [];
    $scope.dtOptions = DTOptionsBuilder.newOptions().withOption('scrollX', '100%');
    if (helperServices.dekrip(helperServices.urlParams('item')) == 'pengajuan') {
        layananNikahServices.getPengajuan().then(res => {
            $scope.datas = res;
        })
    } else if (helperServices.dekrip(helperServices.urlParams('item')) == 'proses') {
        layananNikahServices.getProses().then(res => {
            $scope.datas = res;
        })
    } else if (helperServices.dekrip(helperServices.urlParams('item')) == 'selesai') {
        layananNikahServices.getSelesai().then(res => {
            $scope.datas = res;
        })
    } else if (helperServices.dekrip(helperServices.urlParams('item')) == 'add') {
        layananNikahServices.getAdd().then(res => {
            $scope.anggotaJemaat = res;
        })
    } else if (helperServices.dekrip(helperServices.urlParams('item')) == 'edit') {
        layananNikahServices.getEdit(helperServices.dekrip(helperServices.urlParams('set'))).then(res => {
            $scope.model = res;
        })
    }
    $scope.selectedAnggota = (state) => {
        persyaratanServices.getByLayanan("3").then(res => {
            if (res.length == 0) {
                pesan.dialog("Persyaratan belum ada, silahkan hubungi Admini Gereja", "Ya", false, "error").then(res => {
                    window.history.back();
                });
            } else {
                res.map(x => x.set = 'sidi' + x.id);
                $scope.model = {};
                $scope.model.jemaat_kk_id = state.jemaat_kk_id;
                $scope.model.anggotas = {};
                $scope.model.anggotas.tanggal_lahir = state.tanggal_lahir;
                $scope.model.anggotas.anggota_jemaat_id = state.id;
                $scope.model.anggotas.tempat_lahir = state.tempat_lahir;
                $scope.model.anggotas.sex = state.sex;
                $scope.model.anggotas.hubungan_keluarga = state.hubungan_keluarga;
                $scope.model.anggotas.alamat = state.alamat;
                $scope.model.anggotas.nama_ayah = state.nama_ayah;
                $scope.model.anggotas.nama_ibu = state.nama_ibu;
                $scope.model.layanan_id = res[0].layanan_id;
                $scope.model.persyaratans = res;
                console.log($scope.model);
            }
        })
    }

    $scope.edit = (state) => {
        document.location.href = helperServices.url + 'layanan_sidi?item=' + helperServices.enkrip('edit') + '&set=' + helperServices.enkrip(state);
    }

    $scope.setPdf = (param) => {
        var url = helperServices.url + 'assets/berkas/' + param;

        var pdfDoc = null,
            pageNum = 1,
            pageRendering = false,
            pageNumPending = null,
            scale = 3,
            canvas = document.getElementById('the-canvas'),
            ctx = canvas.getContext('2d');

        /**
         * Get page info from document, resize canvas accordingly, and render page.
         * @param num Page number.
         */
        function renderPage(num) {
            pageRendering = true;
            // Using promise to fetch the page
            pdfDoc.getPage(num).then(function (page) {
                var viewport = page.getViewport({ scale: scale });
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Render PDF page into canvas context
                var renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                var renderTask = page.render(renderContext);

                // Wait for rendering to finish
                renderTask.promise.then(function () {
                    pageRendering = false;
                    if (pageNumPending !== null) {
                        // New page rendering is pending
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                });
            });

            // Update page counters
            document.getElementById('page_num').textContent = num;
        }

        /**
         * If another page rendering in progress, waits until the rendering is
         * finised. Otherwise, executes rendering immediately.
         */
        function queueRenderPage(num) {
            if (pageRendering) {
                pageNumPending = num;
            } else {
                renderPage(num);
            }
        }

        /**
         * Displays previous page.
         */
        function onPrevPage() {
            if (pageNum <= 1) {
                return;
            }
            pageNum--;
            queueRenderPage(pageNum);
        }
        document.getElementById('prev').addEventListener('click', onPrevPage);

        /**
         * Displays next page.
         */
        function onNextPage() {
            if (pageNum >= pdfDoc.numPages) {
                return;
            }
            pageNum++;
            queueRenderPage(pageNum);
        }
        document.getElementById('next').addEventListener('click', onNextPage);

        /**
         * Asynchronously downloads PDF.
         */
        pdfjsLib.getDocument(url).promise.then(function (pdfDoc_) {
            pdfDoc = pdfDoc_;
            document.getElementById('page_count').textContent = pdfDoc.numPages;

            // Initial/first page rendering
            renderPage(pageNum);
            $("#modalFile").modal('show');
        });
    }

    $scope.showPersyaratan = (param) => {
        $scope.persyaratan = [];
        param.persyaratans.forEach(element => {
            var item = element.berkas.split('.');
            element.set = item[1];
            $scope.persyaratan.push(element);
        });
        $("#modalPersyaratan").modal('show');
    }

    $scope.showFile = (param) => {
        $scope.setItem = param;
        if (param.set == 'pdf') {
            setTimeout(() => {
                $scope.setPdf(param.berkas);
                $("#modalFile").modal('show');
                $("#modalPersyaratan").modal('hide');
            }, 300);
        } else {
            $scope.setItem.url = $sce.trustAsHtml(helperServices.url + 'assets/berkas/' + $scope.setItem.berkas);
            $("#modalFile").modal('show');
            $("#modalPersyaratan").modal('hide');
        }
    }

    $scope.download = () => {
        $scope.setItem
        var link = document.createElement('a');
        link.href = helperServices.url + 'assets/berkas/' + $scope.setItem.berkas;
        link.download = $scope.setItem.nama + '.' + $scope.setItem.set;
        link.dispatchEvent(new MouseEvent('click'));
    }

    $scope.hideFile = () => {
        $("#modalFile").modal('hide');
        $("#modalPersyaratan").modal('show');
    }

    $scope.save = () => {
        $scope.model.status = "0";
        pesan.dialog("Yakin ingin melanjutkan?", "Ya", "Tidak").then(x => {
            if ($scope.model.id) {
                layananNikahServices.put($scope.model).then(res => {
                    document.location.href = helperServices.url + "layanan_baptis?item=" + helperServices.enkrip('pengajuan');
                })
            } else {
                layananNikahServices.post($scope.model).then(res => {
                    document.location.href = helperServices.url + "layanan_baptis?item=" + helperServices.enkrip('pengajuan');
                })
            }
        })
    }
}