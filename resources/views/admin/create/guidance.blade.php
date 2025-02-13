@extends('admin.layouts.app')

@section('title', 'Create Guidance Account')
@section('content')
<div class="text-slate-100 p-2 bg-blue-400">Create Guidance Account</div>
<div class="min-w-full flex items-center justify-center p-6" style="min-height: 560px">
    <form enctype="multipart/form-data" action="{{ route('admin.handleCreate.guidance') }}" method="post" class="w-full max-w-3xl bg-white rounded-lg p-8 shadow">
        @csrf

        <div class="w-full">
            <label for="id_number" class="block text-gray-700 text-sm mb-1">ID number</label>
            <input type="number" id="id_number" name="id_number" class="form-input w-full rounded border-gray-300 @error('id_number') border-red-500 @enderror" value="{{ old('id_number') ?? $id_number }}">
            @error('id_number')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="block md:flex align-center justify-between my-2 gap-5">
            <div class="md:w-1/2 w-full">
                <label for="name" class="block text-gray-700 text-sm mb-1">Name</label>
                <input type="text" id="name" name="name" class="form-input w-full rounded border-gray-300 @error('name') border-red-500 @enderror" value="{{ old('name') }}">
                @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="md:w-1/2 w-full">
                <label for="extension_name" class="block text-gray-700 text-sm mb-1">Extension Name (optional)</label>
                <input type="text" id="extension_name" name="extension_name" class="form-input w-full rounded border-gray-300 @error('extension_name') border-red-500 @enderror" value="{{ old('extension_name') }}">
                @error('extension_name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="w-full">
            <label for="gender" class="block text-gray-700 text-sm mb-1">Gender</label>
            <select name="gender" id="gender" class="form-select w-full rounded border-gray-300 @error('gender') border-red-500 @enderror">
                <option value="" disabled class="hidden" selected>-- Select one --</option>
                <option value="Male" {{ old('gender') == "Male" ? "selected" : ""  }}>Male</option>
                <option value="Female" {{ old('gender') == "Female" ? "selected" : ""  }}>Female</option>
            </select>
            @error('gender')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="block md:flex align-center justify-between my-2 gap-5">
            <div class="md:w-1/2 w-full">
                <label for="email" class="block text-gray-700 text-sm mb-1">Email</label>
                <input type="email" id="email" name="email" class="form-input w-full rounded border-gray-300 @error('email') border-red-500 @enderror" value="{{ old('email') }}">
                @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="md:w-1/2 w-full">
                <label for="phone_number" class="block text-gray-700 text-sm mb-1">Phone number</label>
                <input type="phone" id="phone_number" name="phone_number" oninput="if(this.value.length > 11) this.value = this.value.slice(0, 11);"  class="form-input w-full rounded border-gray-300 @error('phone_number') border-red-500 @enderror" value="{{ old('phone_number') }}">
                @error('phone_number')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="py-6">
            <hr>
        </div>
        <div class="flex items-center justify-start gap-3">
            <h1>User Account</h1>
            <button type="button" id="generate-btn" class="bg-slate-100 border px-2 rounded-lg hover:bg-slate-800 hover:text-slate-50 shadow text-sm py-1">Generate</button>
            <script>
                $('#generate-btn').on('click', function() {
                    const nameInput = $('#name').val().trim();
                    const usernameInput = $('#username');
                    const passwordInput = $('#password');

                    const generateRandomString = (length) => {
                        const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                        let result = '';
                        for (let i = 0; i < length; i++) {
                            result += chars.charAt(Math.floor(Math.random() * chars.length));
                        }
                        return result;
                    };

                    const generateUsername = (name) => {
                        if (name) {
                            return name.split(' ')[0].toLowerCase() + generateRandomString(Math.floor(Math.random() * 7) + 2);
                        }
                        return generateRandomString(8);
                    };

                    const generatePassword = () => {
                        return generateRandomString(12);
                    };

                    usernameInput.val(generateUsername(nameInput));
                    passwordInput.val(generatePassword());
                });
            </script>
        </div>
        <div class="block md:flex align-center justify-between my-2 gap-5">
            <div class="md:w-1/2 w-full">
                <label for="username" class="block text-gray-700 text-sm mb-1">Username</label>
                <input type="text" id="username" name="username" class="form-input w-full rounded border-gray-300 @error('username') border-red-500 @enderror" value="{{ old('username') }}">
                @error('username')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="md:w-1/2 w-full">
                <label for="password" class="block text-gray-700 text-sm mb-1">Password</label>
                <div class="relative w-full">
                    <input type="password" id="password" name="password" class="form-input w-full rounded border-gray-300 @error('password') border-red-500 @enderror" value="{{ old('password') }}">
                    <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password absolute top-1/2 right-2 transform-translate-y-1/2 cursor-pointer text-gray-600 text-sm mr-2" style="transform: translateY(-47%);"></span>
                </div>
                @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <label for="file-upload" class="block text-gray-700 text-sm mb-1">Upload profile</label>
        <div class="w-full relative border-2 border-gray-300 border-dashed rounded-lg p-6 cursor-pointer @error('profile') border-red-500 @enderror" id="dropzone">
            <input id="file-upload" name="profile" type="file" class="absolute inset-0 w-full h-full opacity-0 z-50" accept="image/*" />
            <div class="text-center">
                <img class="mx-auto h-12 w-12" src="https://www.svgrepo.com/show/357902/image-upload.svg" alt="">
                <h3 class="mt-2 text-sm font-medium text-gray-900">
                    <label for="file-upload" class="relative cursor-pointer">
                        <span>Drag and drop</span>
                        <span class="text-indigo-600"> or browse</span>
                        <span>to upload</span>
                    </label>
                </h3>
                <p class="mt-1 text-xs text-gray-500">
                    PNG, JPG, GIF up to 10MB
                </p>
            </div>
            <img src="" class="mt-4 mx-auto max-h-40 hidden" id="preview">
        </div>
        @error('profile')
        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
        @enderror

        <div class="mt-6">
            <button type="submit" class="w-full md:w-40 bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Add account</button>
        </div>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Profile image preview
        const profileDropzone = document.getElementById('dropzone');
        const profileFileInput = document.getElementById('file-upload');
        const profilePreview = document.getElementById('preview');

        const displayProfilePreview = (file) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => {
                profilePreview.src = reader.result;
                profilePreview.classList.remove('hidden');
            };
        };

        profileDropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            profileDropzone.classList.add('border-indigo-600');
        });

        profileDropzone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            profileDropzone.classList.remove('border-indigo-600');
        });

        profileDropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            profileDropzone.classList.remove('border-indigo-600');
            const file = e.dataTransfer.files[0];
            if (file) {
                displayProfilePreview(file);
                profileFileInput.files = e.dataTransfer.files;
            }
        });

        profileFileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                displayProfilePreview(file);
            }
        });
    });
</script>
@endsection