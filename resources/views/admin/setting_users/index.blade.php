@extends('layouts_stisla.main')

@section('content')
<div class="section-header">
  <h1>Setting Users</h1>
</div>
<div class="row">
  <div class="col-lg-12 col-md-12 col-12 col-sm-12">
    <div class="card">
      <div class="card-header">
        <h4>Data Users</h4>
        <div class="card-header-action">
          <a class="btn btn-primary" href="#"><i class="fa fa-plus"></i> Add Users</a>
        </div>
      </div>
      <div class="card-body">
        <table class="table" id="users-table">
          <thead>
            <tr>
              <th width="10">No</th>
              <th>Name</th>
              <th>Email</th>
              <th>Roles</th>
              <th width="200">Action</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection