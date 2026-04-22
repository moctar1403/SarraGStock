<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"> 
            <div class="p-8 text-gray-900">
                <h4>{{ __('Editer') }} User</h4>
                <form method="POST" action="{{ route('users.update',$user->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="p-5 flex flex-col">
                        <label for="name">{{ __('Nom') }}</label>
                        <input type="text" 
                               id="name"
                               class="block mt-1 rounded-md border-gray-300 w-full @error('name') border-red-500 bg-red-100 @enderror"
                               name="name"
                               value="{{old('name',$user->name)}}"
                               @if ($user->name=="super-admin") readonly @endif>
                        @error('name')
                            <div class="text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="p-5 flex flex-col">
                        <label for="email">{{ __('Email') }}</label>
                        <input type="email" 
                               id="email"
                               class="block mt-1 rounded-md border-gray-300 w-full @error('email') border-red-500 bg-red-100 @enderror"
                               name="email"
                               value="{{old('email',$user->email)}}"
                               @if ($user->name=="super-admin") readonly @endif>
                        @error('email')
                            <div class="text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="p-5 flex flex-col">
                        <label for="password">{{ __('Mot de passe') }}</label>
                        <input type="password" 
                               id="password"
                               class="block mt-1 rounded-md border-gray-300 w-full @error('password') border-red-500 bg-red-100 @enderror"
                               name="password">
                        @error('password')
                            <div class="text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="p-5 flex flex-col">
                        <x-label for="password_confirmation" value="{{ __('Confirmation mot de passe') }}" />
                        <input type="password" 
                               id="password_confirmation"
                               class="block mt-1 rounded-md border-gray-300 w-full @error('password_confirmation') border-red-500 bg-red-100 @enderror"
                               name="password_confirmation">
                        @error('password_confirmation')
                            <div class="text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    @if ($user->name != "super-admin")
                        <div class="p-5 flex flex-col">
                            <label for="roles">{{ __('Rôles') }}</label>
                            <select id="roles"
                                    class="block mt-1 rounded-md border-gray-300 @error('roles') border-red-500 bg-red-100 @enderror"
                                    name="roles[]"  
                                    multiple>
                                <option value="">{{ __('Sélectionner un rôle') }}</option>
                                @foreach ($roles as $role)
                                    <option value="{{$role}}" @if(in_array($role,$userRoles)) selected @endif>
                                        {{$role}}
                                    </option>
                                @endforeach
                            </select>
                            @error('roles')
                                <div class="text-red-500 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif
                    
                    <div class="p-5 flex justify-between items-center bg-gray-100">
                        <button class="bg-green-600 p-3 rounded-sm text-white text-sm" type="submit">{{ __('Modifier') }}</button>
                    </div>
                </form>
            </div>
            
            <div class="p-8 text-gray-900">
                <a href="{{ url('users') }}" class="bg-red-500 rounded-md p-2 text-white">
                    {{ __('Retour') }}
                </a> 
            </div>
        </div>
    </div>
</div>