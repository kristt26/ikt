angular.module('adminctrl', [])
    // Admin
    .controller('dashboardController', dashboardController)
    .controller('kerukunanController', kerukunanController)
    .controller('detailKeluargaController', detailKeluargaController)
    .controller('anggotaController', anggotaController)
    .controller('anggotaUltahController', anggotaUltahController)
    .controller('addAnggotaController', addAnggotaController)
    .controller('editAnggotaController', editAnggotaController)
    .controller('golonganDarahController', golonganDarahController)
    .controller('laporanAnggotaJemaatController', laporanAnggotaJemaatController)
    .controller('laporanKepalaKeluargaController', laporanKepalaKeluargaController)
    .controller('laporanController', laporanController)
    .controller('pindahJemaatController', pindahJemaatController)

    ;

function dashboardController($scope, dashboardServices) {
    $scope.$emit("SendUp", "Dashboard");
    $scope.datas = {};
    $scope.title = "Dashboard";
    // dashboardServices.get().then(res=>{
    //     $scope.datas = res;
    // })
}

function kerukunanController($scope, kerukunanServices, pesan) {
    $scope.$emit("SendUp", "Pembobotan Faktor");
    $scope.datas = {};
    $scope.model = {};
    $.LoadingOverlay("show");
    kerukunanServices.get().then((res) => {
        $scope.datas = res;
        $.LoadingOverlay("hide");
    })

    $scope.setInisial = (item) => {
        $scope.model.inisial = item.substring(0, 3).toUpperCase();
    }

    $scope.save = () => {
        pesan.dialog('Yakin ingin?', 'Yes', 'Tidak').then(res => {
            $.LoadingOverlay("show");
            if ($scope.model.id) {
                kerukunanServices.put($scope.model).then(res => {
                    $scope.model = {};
                    $.LoadingOverlay("hide");
                    pesan.Success("Berhasil mengubah data");
                })
            } else {
                kerukunanServices.post($scope.model).then(res => {
                    $scope.model = {};
                    $.LoadingOverlay("hide");
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
            $.LoadingOverlay("show");
            kerukunanServices.deleted(param).then(res => {
                $.LoadingOverlay("hide");
                pesan.Success("Berhasil menghapus data");
            })
        });
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
        $scope.model.keluarga_id = res.id;
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
    setTimeout(() => {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    }, 300);
    anggotaServices.getById(helperServices.lastPath).then((res) => {
        $scope.datas = res.kk;
        $scope.kepalaKeluarga = res.kk.anggota;
        $scope.model = res.anggota;
        $scope.model.tanggal_lahir = new Date($scope.model.tanggal_lahir);
    });

    $scope.save = () => {
        pesan.dialog("Yakin ingin melanjutkan?", "Ya", "Tidak").then(x => {
            $.LoadingOverlay('show');
            anggotaServices.put($scope.model).then(res => {
                $.LoadingOverlay('hide');
                pesan.Success("Berhasil mengubah data");
                setInterval(() => {
                    document.location.href = helperServices.url + "anggota";
                }, 1000);
            });
        })
    }
}

function golonganDarahController($scope, anggotaServices, helperServices, pesan, DTOptionsBuilder) {
    $scope.$emit("SendUp", "Golongan Darah");
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
    laporanServices.getKepalaKeluarga().then((res) => {
        $.LoadingOverlay("hide");
        $scope.datas = res
    })

    // $scope.viewData = () => {
    // }

    $scope.cetak = (wijk, ksp, statusCetak) => {
        if (statusCetak == 'kepala') {
            window.open(helperServices.url + "laporan/print?item=" + helperServices.encript('kepalaKeluarga'));
        } else if (statusCetak == 'anggota') {
            window.open(helperServices.url + 'keluarga/cetakall');
        } else {
            pesan.error('Pilih Model Data');
        }
    }

    $scope.export = (wijk, ksp) => {
        window.open(helperServices.url + "laporan/excel?item=" + helperServices.encript('kepalaKeluarga'), "_blank");
    }


}

function laporanController($scope, layananBaptisServices, persyaratanServices, wijkServices, helperServices, pesan, DTOptionsBuilder, $sce) {
    $scope.$emit("SendUp", "Laporan Anggota");
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