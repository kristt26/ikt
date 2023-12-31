angular.module('admin.service', [])
    // admin
    .factory('dashboardServices', dashboardServices)
    .factory('wilayahServices', wilayahServices)
    .factory('kerukunanServices', kerukunanServices)
    .factory('keluargaServices', keluargaServices)
    .factory('anggotaServices', anggotaServices)
    .factory('manajemenUsersServices', manajemenUsersServices)
    .factory('laporanAnggotaServices', laporanAnggotaServices)
    .factory('laporanServices', laporanServices)
    .factory('pindahJemaatServices', pindahJemaatServices)

    // Anggota
   
    // All
    ;

function dashboardServices($http, $q, helperServices, AuthService) {
    var controller = helperServices.url + 'home/';
    var service = {};
    service.data = [];
    service.instance = false;
    return {
        get: get,
        getLayanan: getLayanan
    };

    function get() {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'read',
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
            }
        );
        return def.promise;
    }

    function getLayanan() {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'get_layanan',
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
            }
        );
        return def.promise;
    }
}


function wilayahServices($http, $q, helperServices, AuthService, pesan) {
    var controller = helperServices.url + 'wilayah/';
    var service = {};
    service.data = [];
    return {
        get: get,
        post: post,
        put: put,
        deleted: deleted
    };

    function get() {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'read',
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                service.data = res.data;
                def.resolve(res.data);
            },
            (err) => {
                message.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function post(param) {
        var def = $q.defer();
        $http({
            method: 'post',
            url: controller + 'post',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                service.data.push(res.data);
                def.resolve(res.data);
            },
            (err) => {
                message.error(err.data.messages.error);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function put(param) {
        var def = $q.defer();
        $http({
            method: 'put',
            url: controller + 'put',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                var data = service.data.find(x => x.id == param.id);
                if (data) {
                    data.kerukunan = param.kerukunan;
                }
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
            }
        );
        return def.promise;
    }

    function deleted(param) {
        var def = $q.defer();
        $http({
            method: 'delete',
            url: controller + "/delete/" + param.id,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                var index = service.data.indexOf(param);
                service.data.splice(index, 1);
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
                message.error(err.data.message)
            }
        );
        return def.promise;
    }

}

function kerukunanServices($http, $q, helperServices, AuthService, pesan) {
    var controller = helperServices.url + 'kerukunan/';
    var service = {};
    service.data = [];
    return {
        get: get,
        post: post,
        put: put,
        deleted: deleted
    };

    function get() {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'read',
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                service.data = res.data;
                def.resolve(res.data);
            },
            (err) => {
                message.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function post(param) {
        var def = $q.defer();
        $http({
            method: 'post',
            url: controller + 'post',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                service.data.push(res.data);
                def.resolve(res.data);
            },
            (err) => {
                message.error(err.data.messages.error);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function put(param) {
        var def = $q.defer();
        $http({
            method: 'put',
            url: controller + 'put',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                var data = service.data.find(x => x.id == param.id);
                if (data) {
                    data.kerukunan = param.kerukunan;
                }
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
            }
        );
        return def.promise;
    }

    function deleted(param) {
        var def = $q.defer();
        $http({
            method: 'delete',
            url: controller + "/delete/" + param.id,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                var index = service.data.indexOf(param);
                service.data.splice(index, 1);
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
                message.error(err.data.message)
            }
        );
        return def.promise;
    }

}


function keluargaServices($http, $q, helperServices, AuthService, pesan) {
    var controller = helperServices.url + 'keluarga/';
    var service = {};
    service.data = [];
    service.status = false;
    return {
        get: get,
        getId: getId,
        post: post,
        addKerukunan: addKerukunan,
        put: put,
        deleted: deleted,
        pecah: pecah
    };

    function get() {
        var def = $q.defer();
        if (service.status) {
            def.resolve(service.data);
        } else {
            $http({
                method: 'get',
                url: controller + 'read',
                headers: AuthService.getHeader()
            }).then(
                (res) => {
                    service.data = res.data;
                    service.status = true;
                    def.resolve(res.data);
                },
                (err) => {
                    pesan.error(err.data.message);
                    def.reject(err);
                }
            );
        }
        return def.promise;
    }

    function getId(id) {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'getdetail/' + id,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function post(param) {
        var def = $q.defer();
        $http({
            method: 'post',
            url: controller + 'post',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                service.data.keluarga.push(res.data)
                def.resolve(res.data);
            },
            (err) => {
                pesan.Error(err.data.messages.error);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function addKerukunan(param) {
        var def = $q.defer();
        $http({
            method: 'post',
            url: helperServices.url + 'kerukunan/' + 'post',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                def.resolve(res.data);
            },
            (err) => {
                message.error(err.data.messages.error);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function put(param) {
        var def = $q.defer();
        $http({
            method: 'put',
            url: controller + 'put',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                var data = service.data.keluarga.find(x => x.id == param.id);
                if (data) {
                    data.ksp = param.ksp;
                    data.wijk = param.wijk;
                    data.kode_kk = param.kode_kk;
                    data.telepon = param.telepon;
                    data.hp = param.hp;
                    data.alamat = param.alamat;
                    data.provinsi = param.provinsi;
                    data.kabupaten = param.kabupaten;
                    data.kecamatan = param.kecamatan;
                    data.kelurahan = param.kelurahan;
                    data.kode_pos = param.kode_pos;
                    data.lingkungan = param.lingkungan;
                }
                def.resolve(res.data);
            },
            (err) => {
                $.LoadingOverlay("hide");
                def.reject(err);
                pesan.Error(err.data.messages.error);
            }
        );
        return def.promise;
    }

    function deleted(param) {
        var def = $q.defer();
        $http({
            method: 'delete',
            url: controller + "/delete/" + param.id,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                var index = service.data.keluarga.indexOf(param);
                service.data.keluarga.splice(index, 1);
                def.resolve(param);
            },
            (err) => {
                def.reject(err);
                pesan.Error(err.data.messages.error);
            }
        );
        return def.promise;
    }

    function pecah(param) {
        var def = $q.defer();
        $http({
            method: 'post',
            url: controller + 'pecah',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                service.data.keluarga.push(res.data)
                def.resolve(res.data);
            },
            (err) => {
                $.LoadingOverlay("hide");
                pesan.Error(err.data.messages.error);
                def.reject(err);
            }
        );
        return def.promise;
    }

}

function anggotaServices($http, $q, helperServices, AuthService, pesan) {
    var controller = helperServices.url + 'anggota/';
    var service = {};
    service.data = [];
    return {
        get: get,
        getById: getById,
        getId: getId,
        getUltah: getUltah,
        getGolonganDarah: getGolonganDarah,
        post: post,
        put: put,
        deleted: deleted
    };

    function get() {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'read',
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                service.data = res.data;
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function getById(id) {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'getid/' + id,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function getId(id) {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'get_by_id/' + id,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function getUltah(param) {
        var def = $q.defer();
        var url = controller + 'readultah?start=' + param.date[0] + '&end=' + param.date[1] + '&jenis=' + param.jenis + '&wijk_id=' + param.wijk_id;
        $http({
            method: 'get',
            url: controller + 'readultah?start=' + param.date[0] + '&end=' + param.date[1] + '&jenis=' + param.jenis + '&wijk_id=' + param.wijk_id,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                service.data = res.data;
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function getGolonganDarah(param) {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'golongan_darah?darah=' + param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                service.data = res.data;
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
                $.LoadingOverlay("hide");
            }
        );
        return def.promise;
    }

    function post(param) {
        var def = $q.defer();
        $http({
            method: 'post',
            url: controller + 'post',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                var data = service.data.find(x => x.id == param.wijk_id);
                if (data) {
                    data.ksp.push(res.data);
                }
                def.resolve(res.data);
            },
            (err) => {
                pesan.Error(err.data.messages.error);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function put(param) {
        var def = $q.defer();
        $http({
            method: 'put',
            url: controller + 'put',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
                pesan.Error(err.data.messages.error);
            }
        );
        return def.promise;
    }

    function deleted(param) {
        var def = $q.defer();
        $http({
            method: 'delete',
            url: controller + "/delete/" + param.id,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                var data = service.data.find(x => x.id == param.wijk_id);
                if (data) {
                    var index = data.ksp.indexOf(param);
                    data.ksp.splice(index, 1);
                }
                def.resolve(param);
            },
            (err) => {
                def.reject(err);
                pesan.Error(err.data.messages.error);
            }
        );
        return def.promise;
    }

}

function manajemenUsersServices($http, $q, helperServices, AuthService, pesan) {
    var controller = helperServices.url + 'manajemen_user/';
    var service = {};
    service.data = [];
    return {
        get: get,
        post: post,
        put: put,
        deleted: deleted
    };

    function get() {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'read',
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                service.data = res.data;
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function post(param) {
        var def = $q.defer();
        $http({
            method: 'post',
            url: controller + 'post',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                service.data.data.push(res.data);
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.messages.error);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function put(param) {
        var def = $q.defer();
        $http({
            method: 'put',
            url: controller + 'put',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                var data = service.data.find(x => x.id == param.id);
                if (data) {
                    data.wijk = param.wijk;
                    data.inisial = param.inisial;
                }
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
            }
        );
        return def.promise;
    }

    function deleted(param) {
        var def = $q.defer();
        $http({
            method: 'delete',
            url: controller + "/delete/" + param.id,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                var index = service.data.indexOf(param);
                service.data.splice(index, 1);
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
                message.error(err.data.message)
            }
        );
        return def.promise;
    }

}

function laporanAnggotaServices($http, $q, helperServices, AuthService, pesan) {
    var controller = helperServices.url + 'laporan/';
    var service = {};
    service.data = [];
    return {
        index: index,
        getByWijk: getByWijk,
        getByKsp: getByKsp,
        getByUnsur: getByUnsur,
        getByAll: getByAll,
    };

    function index() {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'anggota_jemaat',
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                service.data = res.data;
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                $.LoadingOverlay("hide");
                def.reject(err);
            }
        );
        return def.promise;
    }

    function getByWijk(wijk) {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'get_anggota?wijk=' + wijk,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                service.data = res.data;
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function getByKsp(ksp_id) {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'get_anggota?ksp_id=' + ksp_id,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                service.data = res.data;
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function getByUnsur(unsur) {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'get_anggota?unsur=' + unsur,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                service.data = res.data;
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function getByAll(param) {
        var def = $q.defer();
        $http({
            method: 'post',
            url: controller + 'get_anggota',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                service.data = res.data;
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                $.LoadingOverlay("hide");
                def.reject(err);
            }
        );
        return def.promise;
    }
}

function laporanServices($http, $q, helperServices, AuthService, pesan) {
    var controller = helperServices.url + 'laporan/';
    var service = {};
    service.data = [];
    return {
        getKepalaKeluarga: getKepalaKeluarga,
        cetakKepalaKeluarga: cetakKepalaKeluarga
    };

    function getKepalaKeluarga(param) {
        var def = $q.defer();
        $http({
            method: 'post',
            url: controller + 'get_kepala_keluarga',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function cetakKepalaKeluarga(param) {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'anggota_jemaat',
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                service.data = res.data;
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }
}


function pindahJemaatServices($http, $q, helperServices, AuthService, pesan) {
    var controller = helperServices.url + 'mutasi/';
    var service = {};
    service.data = [];
    return {
        getKepalaKeluarga: getKepalaKeluarga,
        cetakKepalaKeluarga: cetakKepalaKeluarga,
        post: post,
        pindah: pindah
    };

    function post(param) {
        var def = $q.defer();
        $http({
            method: 'post',
            url: controller + 'post',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function pindah(param) {
        var def = $q.defer();
        $http({
            method: 'post',
            url: controller + 'pindah',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function getKepalaKeluarga(param) {
        var def = $q.defer();
        $http({
            method: 'post',
            url: controller + 'get_kepala_keluarga',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function cetakKepalaKeluarga(param) {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'anggota_jemaat',
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                service.data = res.data;
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }
}

// Anggota Jemaat
