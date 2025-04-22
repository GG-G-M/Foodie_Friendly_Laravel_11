@extends('layouts.welcome_admin')

@section('title', 'Rider Users')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6 text-brown-700">Rider Users</h1>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 bg-brown-200 text-left text-sm font-semibold text-brown-800 uppercase tracking-wider">
                        Name
                    </th>
                    <th class="px-5 py-3 border-b-2 bg-brown-200 text-left text-sm font-semibold text-brown-800 uppercase tracking-wider">
                        Email
                    </th>
                    <th class="px-5 py-3 border-b-2 bg-brown-200 text-left text-sm font-semibold text-brown-800 uppercase tracking-wider">
                        Phone
                    </th>
                    <th class="px-5 py-3 border-b-2 bg-brown-200 text-left text-sm font-semibold text-brown-800 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-5 py-3 border-b-2 bg-brown-200 text-left text-sm font-semibold text-brown-800 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($riders as $rider)
                <tr class="hover:bg-brown-50">
                    <td class="px-5 py-5 border-b text-sm">{{ $rider->name }}</td>
                    <td class="px-5 py-5 border-b text-sm">{{ $rider->email }}</td>
                    <td class="px-5 py-5 border-b text-sm">{{ $rider->phone }}</td>
                    <td class="px-5 py-5 border-b text-sm">
                        <span class="inline-block px-3 py-1 text-sm rounded-full {{ $rider->status == 'active' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                            {{ ucfirst($rider->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-5 border-b text-sm">
                        <a href="{{ route('riders.edit', $rider->id) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                        |
                        <form action="{{ route('riders.destroy', $rider->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this rider?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
