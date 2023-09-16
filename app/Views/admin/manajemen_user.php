<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>

<div class="page-header">

    <h3 class="page-title"> Manajemen User Jemaat </h3>

    <nav aria-label="breadcrumb">

        <ol class="breadcrumb">

            <li class="breadcrumb-item"><a href="#">Home</a></li>

            <li class="breadcrumb-item active" aria-current="page">Manajemen User</li>

        </ol>

    </nav>

</div>

<div class="row" ng-controller="manajemenUsersController">

    <div class="col-md-4 grid-margin ">

        <div class="card">

            <div class="card-header">

                <h4 class="card-title">Tambah User</h4>

            </div>

            <div class="card-body">

                <form class="forms-sample" ng-submit="save()">

                    <div class="form-group">

                        <label for="keluarga">Anggota Jemaat</label>

                        <select name="jemaat" id="jemaat" ui-select2 class="form-control form-control-sm select2" data-placeholder="--Pilih Keluarga--" ng-options="item as (item.kode_kk+' - '+item.nama) for item in datas.anggota" ng-model="jemaat" required ng-change="setPin(jemaat)">

                            <option value=""></option>

                        </select>

                    </div>

                    <div class="form-group">

                        <label for="email">Email</label>

                        <input type="email" class="form-control form-control-sm" id="email" ng-model="model.email" placeholder="Email" required>

                    </div>

                    <div class="form-group">

                        <label for="pin">PIN</label>

                        <input type="text" class="form-control form-control-sm" id="pin" ng-model="model.pin" placeholder="PIN" required readonly>

                    </div>

                    <button type="submit" class="btn btn-gradient-primary me-2 btn-sm">{{model.id ? 'Edit' :'Save'}}</button>

                    <button type="reset" class="btn btn-dark btn-sm">Clear</button>

                </form>

            </div>

        </div>

    </div>

    <div class="col-md-8 grid-margin stretch-card">

        <div class="card">

            <div class="card-body">

                <div class="col-md-12">

                    <div class="table-responsive">

                        <table datatable="ng" dt-options="dtOptions" class="table table-hover table-striped table-bordered" id="userJemaat" width="100%">

                            <thead>

                                <tr>

                                    <th>No</th>

                                    <th>WIJK</th>

                                    <th>KSP</th>

                                    <th>Nama</th>

                                    <th>User</th>

                                    <th>Email</th>

                                    <th style="width:13%">Action</th>

                                </tr>

                            </thead>

                            <tbody>

                                <tr ng-repeat="item in datas.data">

                                    <td>{{$index+1}}</td>

                                    <td>{{item.wijk}}</td>

                                    <td>{{item.ksp}}</td>

                                    <td>{{item.nama}}</td>

                                    <td>{{item.username}}</td>

                                    <td>{{item.email}}</td>

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

</div>

<?= $this->endSection() ?>