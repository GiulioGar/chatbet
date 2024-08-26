 @extends('layouts.app')

 @section('title', 'Dashboard Amministrativa')

 @section('content')
 <div class="container">
     <h1>Dashboard Amministrativa</h1>
     <div class="row">
         <div class="col-md-6">
             <h3>Utenti Registrati</h3>
             <ul>
                 @foreach($users as $user)
                     <li>{{ $user->name }} ({{ $user->email }})</li>
                 @endforeach
             </ul>
         </div>
         <div class="col-md-6">
             <h3>Ruoli Disponibili</h3>
             <ul>
                 @foreach($roles as $role)
                     <li>{{ $role->name }}</li>
                 @endforeach
             </ul>
         </div>
     </div>
 </div>
 @endsection
