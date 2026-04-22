<x-ap-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"> 
                <div class="p-8 text-gray-900">
                    <h4>{{ __('Editer') }} User</h4>
                    <form method="POST" action="{{ url('users/'.$user->id) }}">
                        @csrf
                        @method('PUT')
                        @if (Session::get('error'))
                            <div class="p-5">
                                <div class="p-2 border-red-300 bg-red-400 animate-bounce text-white">{{ Session::get('error') }}</div>
                            </div>
                        @endif
                        <div class="p-5 flex flex-col">
                            <label for="" >{{ __('Nom') }}</label>
                            <input type="text" 
                                   class="block mt-1 rounded-md border-gray-300 w-full @error('name') border-red-500 bg-red-100 animate-bounce @enderror"
                                   name="name"
                                   value="{{$user->name}}"
                                >
                            @error('name')
                                <div class="text text-red-500 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-5 flex flex-col">
                            <label for="" >User Email</label>
                            <input type="email" class="block mt-1 rounded-md border-gray-300 w-full @error('email') border-red-500 bg-red-100 animate-bounce @enderror"
                                name="email"
                                value="{{$user->email}}" readonly>
                            @error('email')
                                <div class="text text-red-500 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-5 flex flex-col">
                            <label for="" >Password</label>
                            <input type="password" class="block mt-1 rounded-md border-gray-300 w-full @error('password') border-red-500 bg-red-100 animate-bounce @enderror"
                                name="password">
                            @error('password')
                                <div class="text text-red-500 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-5 flex flex-col">
                            <label for="" >Roles</label>
                            <select  class="block mt-1 rounded-md border-gray-300  @error('roles') border-red-500 bg-red-100 animate-bounce @enderror"
                                    name="roles[]" multiple>
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role )
                                        <option value="{{$role}}" {{in_array($role,$userRoles) ? 'selected':''}}>
                                            {{$role}}
                                        </option>
                                    @endforeach

                            </select>
                            @error('roles')
                                <div class="text text-red-500 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-5 flex justify-between items-center bg-gray-100">
                            <button class="bg-green-600 p-3 rounded-sm text-white text-sm" type="submit">Update</button>
                        </div>
                    </form>
                </div>
                <div class="p-8 text-gray-900">
                   <a href="{{ url('users') }}" class="bg-red-500 rounded-md p-2 text-white ">
                    {{ __('Retour') }}
                   </a> 
                </div>
            </div>
        </div>
    </div>
</x-ap-layout>
