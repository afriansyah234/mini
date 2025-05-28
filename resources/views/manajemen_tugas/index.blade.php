@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Manajemen Tugas</h1>
            <a href=""><i class="fas fa-plus me-2"></i></a>
        </div>
        <div class="kanban-column">
    <h2>To Do</h2>
    <div class="kanban-card">Buat wireframe</div>
    <div class="kanban-card">Riset market</div>
    <div class="kanban-card">Draft artikel</div>
  </div>
    </div>
</div>
@endsection