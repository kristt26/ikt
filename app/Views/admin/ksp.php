<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>
<div class="page-header">
    <h3 class="page-title"> KSP </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">KSP</li>
        </ol>
    </nav>
</div>
<div class="row" ng-controller="kspController">
    <div class="col-md-12  mb-3">
        <div class="card">
            <div class="card-body" style="padding-top: 2rem; padding-bottom: 0.5rem;">
                <div class="form-group row">
                    <div class="col-sm-3">
                        <select ui-select2="{ allowClear: true}" class="form-control select2"
                            data-placeholder="--Pilih WIJK--"
                            ng-options="item as item.wijk for item in datas track by item.id" ng-model="wijk"
                            ng-change="show(wijk)">
                            <option value=""></option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 grid-margin" ng-if="wijk && wijk != undefined">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tambah KSP pada {{wijk.wijk}}</h4>
            </div>
            <div class="card-body">
                <form class="forms-sample" ng-submit="save(wijk.id)">
                    <div class="form-group">
                        <label for="exampleInputUsername1">KSP</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" ng-model="model.ksp"
                            placeholder="Nama KSP" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit"
                            class="btn btn-gradient-primary me-2 btn-sm">{{model.id ? 'Edit' :'Save'}}</button>
                        <button type="reset" class="btn btn-dark  btn-sm">Clear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8 grid-margin stretch-card" ng-if="wijk && wijk != undefined">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Daftar KSP pada {{wijk.wijk}}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama KSP</th>
                                <th style="width:13%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="item in wijk.ksp">
                                <td>{{$index+1}}</td>
                                <td>{{item.ksp}}</td>
                                <td class="d-flex justify-content-between">
                                    <button class="btn btn-warning btn-sm btn-rounded btn-icon" ng-click="edit(item)"><i
                                            class="mdi mdi-grease-pencil"></i></button>
                                    <button class="btn btn-danger btn-sm btn-rounded btn-icon"
                                        ng-click="delete(item)"><i class="mdi mdi-delete"></i></button>
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