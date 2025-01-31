@extends('layouts/dashboard/main')

@section('container')
    <!-- Header -->
    <div class="flex justify-between items-center mb-4 mt-5">
      <h1 class="text-2xl font-semibold text-gray-800">Data Rooms</h1>
      <a href="{{ route('rooms.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">
        Create Data
      </a>
    </div>

    @if (session()->has('succes'))
      <div class="bg-green-300/40 rounded-md mb-3 py-2 px-3">{{session('succes')}}</div>
    @endif

    <!-- Table -->
    <div class="overflow-x-auto rounded-md">
      <table class="w-full border border-gray-300 text-left">
        <thead class="bg-gray-200">
          <tr>
            <th class="px-4 py-2 border-b border-gray-300 text-center">No</th>
            <th class="px-4 py-2 border-b border-gray-300 text-center">Thumbnail</th>
            <th class="px-4 py-2 border-b border-gray-300 text-center">Room</th>
            <th class="px-4 py-2 border-b border-gray-300 text-center">Price</th>
            <th class="px-4 py-2 border-b border-gray-300 text-center">Category</th>
            <th class="px-4 py-2 border-b border-gray-300 text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($rooms as $room)
              
          <tr class="hover:bg-gray-100">
            <td class="px-4 py-2 border-b border-gray-300 text-center">{{ $loop->iteration }}</td>
            <td class="px-4 py-2 border-b border-gray-300 text-center"><img class="w-[100px] h-[100px] rounded-md object-cover" src="{{ asset('storage/image/kamar/' . $room->image) }}" alt="{{ asset('storage/image/kamar/' . $room->image) }}"></td>
            <td class="px-4 py-2 border-b border-gray-300 text-center">{{ $room->room }}</td>
            <td class="px-4 py-2 border-b border-gray-300 text-center">Rp {{ number_format($room->price, 0, ',', '.') }}</td>
            <td class="px-4 py-2 border-b border-gray-300 text-center">{{ $room->category->name }}</td>
            <td class="px-4 py-2 border-b border-gray-300 mx-auto text-center">
              <div class="flex items-center justify-center space-x-2">
                <a href="{{ route('rooms.edit', $room->id) }}" class="text-blue-500">Edit</a>
                <form action="{{ route('rooms.destroy', $room->id) }}" class="inline" method="post">
                  @method('delete')
                  @csrf
                  <button type="submit" onclick="myconfirm(event, 'Are you sure ?')" class="text-red-500 ml-2">Delete</button>
                </form>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

@endsection