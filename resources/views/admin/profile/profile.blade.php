@extends('admin.layouts.app')

@section('title', 'User Profile')
@section('content')
<div class="min-w-full bg-white border-t border-l" style="min-height: 560px">
    <h1 class="text-blue-700 font-semibold p-3 bg-slate-100 border-b">User Profile</h1>
    <div class="md:px-20 px-10">
        <div class="block md:flex items-center justify-between">
            <div class="flex my-2 items-center justify-start gap-3">
                <form action="{{ route('admin.updateProfilePhoto') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                    @csrf
                    <input type="file" name="profile_photo" id="profile_photo" class="hidden" accept="image/*">
                    <label for="profile_photo" class="cursor-pointer">
                    <img src="{{ isset($user->profile) ? asset('storage/' . $user->profile) : 'https://static.vecteezy.com/system/resources/previews/019/896/008/original/male-user-avatar-icon-in-flat-design-style-person-signs-illustration-png.png' }}" alt="Profile Image" class="mt-2 border bg-white shadow rounded-full object-cover" style="width: 100px; height: 100px;">

                    </label>
                </form>
                <div>
                    <h1 class="font-semibold text-sm md:text-lg text-blue-900">{{ $user->name }}</h1>
                    <p class="text-gray-600 text-sm">
                        <span class="font-semibold">
                            {{ $user->role }}
                        </span><br>
                        ID NO. {{ $user->id_number }}
                    </p>
                </div>
            </div>
            <div class="flex my-2 items-center justify-start gap-3">
                <button type="button" id="uploadButton" class="px-2 bg-blue-900 text-white py-1 rounded hover:bg-blue-600 text-sm">Upload New Photo</button>
                <form action="{{ route('admin.deleteProfilePhoto') }}" method="POST" id="deleteForm" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="button" id="deleteButton" class="bg-slate-50 text-slate-800 border py-1 rounded hover:bg-blue-600 text-sm px-2 shadow">Delete</button>
                </form>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#uploadButton').click(function() {
                    $('#profile_photo').click();
                });

                $('#profile_photo').change(function() {
                    $('#uploadForm').submit();
                });

                $('#deleteButton').click(function() {
                    Swal.fire({
                        title: 'Delete',
                        text: 'Are you sure to delete your profile photo?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#deleteForm').submit();
                        }
                    });
                });
            });
        </script>

        <div class="py-3">
            <hr>
        </div>
        <h1 class="font-bold text-gray-600">Personal info</h1>
        <form action="{{ route('admin.updateAccount') }}" method="post" id="personal_info">
            @csrf
            @method('PUT')
            <div class="block md:flex align-center justify-between my-2 gap-5">
                <div class="md:w-1/3 w-full">
                    <label for="name" class="block text-gray-700 text-sm mb-1 mt-2">Name</label>
                    <input readonly type="text" id="name" name="name" class="form-input w-full rounded border-gray-300 @error('name') border-red-500 @enderror" value="{{ old('name') ?? $user->name }}">
                    @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>


                <div class="md:w-1/3 w-full">
                    <label for="extension_name" class="block text-gray-700 text-sm mb-1 mt-2">Extension Name (Optional)</label>
                    <input readonly type="text" id="extension_name" name="extension_name" class="form-input w-full rounded border-gray-300 @error('extension_name') border-red-500 @enderror" value="{{ old('extension_name') ?? $user->extension_name }}">
                    @error('extension_name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>


                

                
                <div class="md:w-1/3 w-full">
                    <label for="id_number" class="block text-gray-700 text-sm mb-1 mt-2">ID No.</label>
                    <input readonly type="number" id="id_number" name="id_number" class="form-input w-full rounded border-gray-300 @error('id_number') border-red-500 @enderror" value="{{ old('id_number') ?? $user->id_number }}">
                    @error('id_number')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                
            </div>
            <div class="block md:flex align-center justify-between my-2 gap-5">
                <div class="md:w-1/3 w-full">
                    <label for="phone_number" class="block text-gray-700 text-sm mb-1 mt-2">Phone number</label>
                    <input readonly type="tel" id="phone_number" name="phone_number" oninput="if(this.value.length > 11) this.value = this.value.slice(0, 11);"  class="form-input w-full rounded border-gray-300 @error('phone_number') border-red-500 @enderror" value="{{ old('phone_number') ?? $user->phone_number }}">
                    @error('phone_number')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>


                <div class="md:w-1/3 w-full">
                    <label for="email" class="block text-gray-700 text-sm mb-1 mt-2">Email</label>
                    <input readonly type="text" id="email" name="email" class="form-input w-full rounded border-gray-300 @error('email') border-red-500 @enderror" value="{{ old('email') ?? $user->email }}">
                    @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>


                
                <div class="md:w-1/3 w-full">
                    <label for="gender" class="block text-gray-700 text-sm mb-1 mt-2">Gender</label>
                    <input readonly type="text" id="gender" name="gender" class="form-input w-full rounded border-gray-300 @error('gender') border-red-500 @enderror" value="{{ old('gender') ?? $user->gender }}">
                    @error('gender')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>


            <div class="block md:flex align-center justify-between my-2 gap-5">
            <div class="md:w-1/2 w-full">
                    <label for="username" class="block text-gray-700 text-sm mb-1 mt-2">Username</label>
                    <input readonly type="text" id="username" name="username" class="form-input w-full rounded border-gray-300 @error('username') border-red-500 @enderror" value="{{ old('username') ?? $user->username }}">
                    @error('username')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            <div class="md:w-1/2 w-full">
                    <label for="address" class="block text-gray-700 text-sm mb-1 mt-2">Address</label>
                    <input readonly type="text" id="address" name="address" class="form-input w-full rounded border-gray-300 @error('address') border-red-500 @enderror" value="{{ old('address') ?? $user->address }}">
                    @error('address')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            


            <div class="flex my-2 items-center justify-start gap-3 mt-3">
                <button type="button" id="editButton" class="px-2 bg-blue-900 text-white py-1 rounded hover:bg-blue-600 text-sm">Edit</button>
                <button type="submit" id="saveButton" class="hidden bg-slate-900 text-slate-50 border py-1 rounded hover:bg-blue-600 text-sm px-2 shadow">Save changes</button>
            </div>
        </form>
        <script>
            $(document).ready(function() {
                $('#editButton').click(function() {
                    $('#personal_info input').prop('readonly', false);
                    $('#name').focus();
                    $('#saveButton').removeClass('hidden');
                    $(this).addClass('hidden');
                });
            });
        </script>
        @if ($errors->has('name') || $errors->has('email') || $errors->has('phone_number') || $errors->has('address') || $errors->has('gender'))
        <script>
            $(() => {
                $('#editButton').click();
            })
        </script>
        @endif
        <hr class="my-6">

        <h1 class="font-bold text-gray-600">Update password</h1>
        <form action="{{ route('admin.updatePassword') }}" method="post">
            @csrf
            @method('PUT')
            <div class="block md:flex align-center justify-between my-2 gap-5">
                <div class="md:w-1/2 w-full">
                    <label for="password" class="block text-gray-700 text-sm mb-1 mt-2">Enter current password</label>
                    <input type="password" id="password" name="password" class="form-input w-full rounded border-gray-300 @error('password') border-red-500 @enderror" value="{{ old('password') }}">
                    @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="md:w-1/2 w-full">
                    <label for="new_password" class="block text-gray-700 text-sm mb-1 mt-2">Enter new password</label>
                    <input type="password" id="new_password" name="new_password" class="form-input w-full rounded border-gray-300 @error('new_password') border-red-500 @enderror" value="{{ old('new_password') }}">
                    @error('new_password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <a href="{{ route('admin.password.request') }}" class="text-sm mb-3 italic hover:underline text-slate-500 hover:text-blue-700">Forgot password?</a>
            <br>
            <button type="submit" class="mt-2 px-2 bg-blue-900 text-white py-1 rounded hover:bg-blue-600 text-sm">Update password</button>
        </form>
        <br><br><br>
    </div>





</div>
@endsection