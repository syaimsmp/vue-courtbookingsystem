@extends('layouts.app')

@section('content')
<div  id="app" class="container">
    <main class="py-4">
        @yield('content')
            <main-template></main-template>
            {{-- <meta name="user_id" content="{{ Auth::user()->id }}" />
            <meta name="user_name" content="{{ Auth::user()->name }}" /> --}}
    </main>
</div>
@endsection
