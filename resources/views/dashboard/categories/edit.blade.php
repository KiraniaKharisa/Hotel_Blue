@extends('layouts/dashboard/main')

@section('container')

<h1 class="text-2xl font-bold text-gray-800 mb-4">Edit Data Category Rooms</h1>
    <form action="{{ route('categories.update', $category->id) }}" method="POST" class="w-[90%]">
        @method('put')
        @csrf
      <!-- Input Nama -->
      <div class="mb-4">
        <label for="name" class="block mb-1 text-gray-700 font-medium">Name Category</label>
        <input type="text" id="name" name="name" class="w-full outline-none transition duration-300 outline-[1px] mt-2 p-2 border-gray-300 rounded-md shadow-sm focus:outline-blue-500 focus:ouline-blue-500" placeholder="Category name..." value="{{ old('name', $category->name) }}"/>
        @error('name')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>
      <div class="mb-4">
        <label for="class_category" class="block mb-1 text-gray-700 font-medium">Class Category</label>
        <input type="text" id="class_category" name="class_category" class="w-full outline-none transition duration-300 outline-[1px] mt-2 p-2 border-gray-300 rounded-md shadow-sm focus:outline-blue-500 focus:ouline-blue-500" placeholder="Category class..." value="{{ old('name', $category->class_category) }}"/>
        @error('class_category')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
          <p class="text-gray-800 text-sm mt-1">Category data will be sorted alphabetically, for example AB, then class A is part 2</p>
        </div>

      <!-- Tombol Submit -->
      <button type="submit" class="w-full bg-blue-500 text-white font-medium py-2 px-4 rounded-md hover:bg-blue-600 transition-colors">
        Edit Data
      </button>
    </form>
@endsection