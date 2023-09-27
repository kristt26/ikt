<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>
<div class="page-header">
    <h3 class="page-title"> Persyaratan </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Persyaratan</li>
        </ol>
    </nav>
</div>
<div class="row" ng-controller="persyaratanController">
    <div class="col-md-12  mb-3">
        <div class="card">
            <div class="card-body" style="padding-top: 2rem; padding-bottom: 0.5rem;">
                <div class="form-group row">
                    <div class="col-sm-3">
                        <select ui-select2="{ allowClear: true}" class="form-control select2" data-placeholder="--Pilih Layanan--" ng-options="item as item.nama for item in datas track by item.id" ng-model="persyaratan">
                            <option value=""></option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 grid-margin" ng-if="persyaratan">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tambah Persyaratan {{persyaratan.nama}}</h4>
            </div>
            <div class="card-body">
                <form class="forms-sample" ng-submit="save(model)">
                    <div class="form-group">
                        <label for="persyaratan">Persyaratan</label>
                        <input type="text" class="form-control" id="persyaratan" ng-model="model.nama" placeholder="Persyaratan" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-gradient-primary me-2 btn-sm">{{model.id ? 'Edit' :'Save'}}</button>
                        <button type="reset" class="btn btn-dark  btn-sm">Clear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8 grid-margin stretch-card" ng-if="persyaratan">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Daftar Persyaratan {{persyaratan.nama}}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Persyaratan</th>
                                <th style="width:13%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="item in persyaratan.persyaratan">
                                <td>{{$index+1}}</td>
                                <td>{{item.nama}}</td>
                                <td class="d-flex justify-content-between">
                                    <button class="btn btn-warning btn-sm btn-rounded btn-icon" ng-click="edit(item)"><i class="mdi mdi-grease-pencil"></i></button>
                                    <button class="btn btn-danger btn-sm btn-rounded btn-icon" ng-click="delete(item)"><i class="mdi mdi-delete"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>