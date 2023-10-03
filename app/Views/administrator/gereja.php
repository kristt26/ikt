<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>
<div class="page-header">
    <h3 class="page-title"> Data Gereja </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Gereja</li>
        </ol>
    </nav>
</div>
<div class="row" ng-controller="gerejaController">
    <div class="col-md-4 grid-margin ">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tambah Gereja</h4>
            </div>
            <div class="card-body">
                <form class="forms-sample" name="inputform" ng-submit="save()" novalidate>
                    <div class="form-group">
                        <label for="jemaat">Nama Jemaat</label>
                        <input type="text" class="form-control form-control-sm" name="jemaat" id="jemaat"
                            ng-model="model.jemaat" placeholder="Nama Jemaat" required>
                        <span style="color: red;" ng-show="inputform.jemaat.$dirty && inputform.jemaat.$invalid">
                            <small class="" ng-show="inputform.jemaat.$error.required">
                                Wajib*
                            </small>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="nama">Pengguna</label>
                        <input type="text" class="form-control form-control-sm" name="nama" id="nama"
                            ng-model="model.nama" placeholder="Nama Pengguna" required>
                        <span style="color: red;" ng-show="inputform.nama.$dirty && inputform.nama.$invalid">
                            <small class="" ng-show="inputform.nama.$error.required">
                                Wajib*
                            </small>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control form-control-sm" name="username" id="username"
                            ng-model="model.username" placeholder="Username" required>
                        <span style="color: red;" ng-show="inputform.username.$dirty && inputform.username.$invalid">
                            <small class="" ng-show="inputform.username.$error.required">
                                Wajib*
                            </small>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control form-control-sm" name="email" id="email"
                            ng-model="model.email" placeholder="Email" required>
                        <span style="color: red;" ng-show="inputform.email.$dirty && inputform.email.$invalid">
                            <small class="" ng-show="inputform.email.$error.required">
                                Wajib*
                            </small>
                            <small class="" ng-show="inputform.email.$error.email">
                                format salah*
                            </small>
                        </span>
                    </div>
                    <button type="submit" class="btn btn-gradient-primary me-2 btn-sm"
                        ng-disabled="inputform.$invalid">{{model.id ? 'Edit' :'Save'}}</button>
                    <button type="reset" class="btn btn-dark btn-sm">Clear</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8 grid-margin">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Daftar Gereja</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama jemaat</th>
                                <th>Penanggung Jawab</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th style="width:13%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="item in datas">
                                <td>{{$index+1}}</td>
                                <td>{{item.jemaat}}</td>
                                <td>{{item.nama}}</td>
                                <td>{{item.username}}</td>
                                <td>{{item.email}}</td>
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