@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between mt-1 align-items-center">
        <h3 class="m-3">HISTORY</h3>
        <div class="d-flex align-items-center m-3">
            <img src="{{ asset('/storage/profile/' . (Auth::user()->pp ?? 'default.jpg')) }}" alt="Foto Profil"
                class="rounded-circle" width="40" height="40"
                style="object-fit: cover; aspect-ratio: 1/1; margin-right: 5px">
            <span class="me-2">{{ auth()->user()->name }}</span>
        </div>
    </div>

    <div class="container bg-history">
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <tbody>
                        @foreach ($logs as $log)
                            <tr>
                                <td style="font-size: 16px; display: flex; align-items: center; gap: 10px;">
                                    <span>{{ \Carbon\Carbon::parse($log->created_at)->format('d-m-Y H:i') }}</span>

                                    @if ($log->action == 'delete')
                                        <img src="{{ asset('aset/delettt.png') }}" alt="Delete" width="30">
                                    @elseif ($log->action == 'upload')
                                        <img src="{{ asset('aset/downloadd.png') }}" alt="Upload" width="30">
                                    @elseif ($log->action == 'edit')
                                        <img src="{{ asset('aset/sharee.png') }}" alt="Edit" width="30">
                                    @endif

                                    <span>
                                        <span style="color: black;">{{ ucfirst($log->action) }} file </span>
                                        <strong>"{{ str_replace('files/', '', $log->dokumen->file) }}"</strong>
                                        by <a href="#"
                                            style="color: blue; text-decoration: none;">{{ $log->user->name }}</a>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-between align-items-center">
                    <p>
                        Showing {{ $logs->firstItem() }} to {{ $logs->lastItem() }} of
                        {{ $logs->total() }} entries
                    </p>
                    {{ $logs->links() }}
                </div>

            </div>
        </div>
    </div>

    <footer class="footer">
        <p class="p-3">Copyright 2024 - Qif Media</p>
    </footer>
@endsection
