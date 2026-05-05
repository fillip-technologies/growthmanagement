@extends('admin.include.layout')
@section('heading', 'Employees')
@section('title', 'Add Employees')

@section('content')
    <div class="max-w-5xl mx-auto mt-10">

        <div class="bg-white shadow-xl rounded-xl p-8">

            <h2 class="text-2xl font-bold mb-6 text-gray-800">Add Employees

            </h2>

            {{-- SweetAlert --}}
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            @if ($errors->any())
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: `{!! implode('<br>', $errors->all()) !!}`
                    });
                </script>
            @endif

            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: "{{ session('success') }}",
                        timer: 2500,
                        showConfirmButton: false
                    });
                </script>
            @endif

            {{-- Form --}}
            <form action="{{ route('add.employees') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-6">
                    <label class="block font-medium text-gray-700 mb-2">Name</label>

                    <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded-lg p-2">
                    @error('name')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block font-medium text-gray-700 mb-2">Email</label>

                    <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded-lg p-2">
                    @error('email')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block font-medium text-gray-700 mb-2">Phone</label>

                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border rounded-lg p-2"
                        maxlength="12" placeholder="Enter phone number"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,12)">

                    @error('phone')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>



                <div class="mb-6">
                    <label class="block font-medium text-gray-700 mb-2">Password</label>

                    <input type="password" name="password" value="{{ old('password') }}"
                        class="w-full border rounded-lg p-2">
                    @error('password')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block font-medium text-gray-700 mb-2">Role</label>

                    <select name="role" class="w-full border rounded-lg p-2">
                        <option value="">Select Role</option>
                        <option value="employees" {{ old('role') == 'employees' ? 'selected' : '' }}>Employee</option>
                        <option value="developer" {{ old('role') == 'developer' ? 'selected' : '' }}>Developer</option>
                        <option value="designer" {{ old('role') == 'designer' ? 'selected' : '' }}>Designer</option>
                        <option value="tester" {{ old('role') == 'tester' ? 'selected' : '' }}>Tester</option>
                        <option value="intern" {{ old('role') == 'intern' ? 'selected' : '' }}>Intern</option>
                    </select>
                    @error('role')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="text-right">
                    <button type="submit"
                        class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-3 rounded-lg font-semibold">
                        Save Users
                    </button>
                </div>

            </form>
        </div>
    </div>

@endsection
