<?php 
    use App\Models\Company;

    $elements = [
        // @ Teacher
        [ "prefix" => "teacher", "role" => "Profesor", "icon" => "dashboard", "route" => "dashboard" ],
        [ "prefix" => "teacher", "role" => "Profesor", "icon" => "person", "route" => "users" ],
        [ "prefix" => "teacher", "role" => "Profesor", "icon" => "link", "route" => "invites" ],
        [ "prefix" => "teacher", "role" => "Profesor", "icon" => "point_of_sale", "route" => "wholesalers" ],
        [ "prefix" => "teacher", "role" => "Profesor", "icon" => "captive_portal", "route" => "companies" ], 
        [ "prefix" => "teacher", "role" => "Profesor", "icon" => "mail", "route" => "mailing" ],

        // @ Administrator
        [ "prefix" => "admin", "role" => "Administrador", "icon" => "dashboard", "route" => "dashboard" ],
        [ "prefix" => "admin", "role" => "Administrador", "icon" => "school", "route" => "centers" ],
        [ "prefix" => "admin", "role" => "Administrador", "icon" => "person", "route" => "users" ],
        [ "prefix" => "admin", "role" => "Administrador", "icon" => "campaign", "route" => "announcements" ],
        [ "prefix" => "admin", "role" => "Administrador", "icon" => "folder", "route" => "documentation" ],

        // @ Student
        [ "prefix" => "student", "role" => "Estudiante", "icon" => "dashboard", "route" => "dashboard" ],
        [ "prefix" => "student", "role" => "Estudiante", "icon" => "public", "route" => "website" ],
        [ "prefix" => "student", "role" => "Estudiante", "icon" => "inventory", "route" => "products" ],
        [ "prefix" => "student", "role" => "Estudiante", "icon" => "attach_money", "route" => "sells" ],
        [ "prefix" => "student", "role" => "Estudiante", "icon" => "storefront", "route" => "buy" ],
        [ "prefix" => "student", "role" => "Estudiante", "icon" => "mail", "route" => "mailing" ],
    ];
?>

<nav class="flex items-center justify-end lg:hidden border-b p-4">
    <button onclick="toggle()" class="flex items-center justify-center">
        <x-icon label="menu" styles="cursor-pointer hover:text-blue-500 transition-all" />
    </button>
</nav>


<aside class="w-sm border-r hidden lg:flex flex-col transition-all bg-white">
    <div class="flex w-full items-end justify-end">
        <button onclick="toggle()" id="close" class="flex lg:hidden items-center justify-center px-3 pt-5">
            <x-icon label="close" styles="cursor-pointer hover:text-blue-500 transition-all" />
        </button>
    </div>

    @php
        $company = Company::find(Auth::user()->current_company);

        if($company) {
            $name = $company->name;
        } else $name = "Seleccionar empresa";
    @endphp

    <section class="flex-1 overflow-y-scroll my-5 flex flex-col px-3 gap-3 ">
        @if (Auth::user()->role && Auth::user()->role->name == "Estudiante" && Auth::user()->current_company)
            <div class="px-3 py-2 rounded-md flex items-center flex-row gap-3 text-sm cursor-pointer">
                <span class="material-symbols-outlined text-blue-500" onclick="window.location.href = '/student/select'">
                    apartment
                </span>
            </div>
        @endif

        @if (request()->is("*teacher*view*")) 
            <div onclick="window.location.href = '/teacher/companies/{{ str_replace(' ', '-', $name) }}/'" class="flex items-center gap-3 text-sm rounded px-3 py-2 group cursor-pointer hover:bg-blue-500 hover:text-white transition-all">
                <span class="material-symbols-outlined text-blue-500 group-hover:text-white transition-all">admin_panel_settings</span>

                Volver atrás
            </div>
            
            @foreach ($elements as $element)
                @if (Auth::user()->role && Auth::user()->role->name != "Estudiante" && "Estudiante" == $element['role'])
                    <div onclick="window.location.href = '/teacher/companies/{{ str_replace(' ', '-', $name) }}/view/{{ $element['route'] }}'" class="flex items-center gap-3 text-sm rounded px-3 py-2 group cursor-pointer hover:bg-blue-500 hover:text-white transition-all">
                        <span class="material-symbols-outlined text-blue-500 group-hover:text-white transition-all">{{ $element['icon'] }}</span>
                    </div>
                @endif
            @endforeach
        @else
            @foreach ($elements as $element)
                @if (Auth::user()->role && Auth::user()->role->name == $element['role'])
                    @php
                        if($element['route'] == 'mailing')
                        {
                            $route = '/mailing';
                        }elseif(Auth::user()->role->name == "Estudiante") { 
                            if(isset(Auth::user()->current_company)) {
                                $user_company = Company::find(Auth::user()->current_company);

                                if($user_company) {
                                    $name = str_replace(' ', '-', $user_company->name);

                                    $route = "/{$element['prefix']}/$name/{$element['route']}";
                                } else $route = "/student/select";
                            } else $route = "/student/select";
                        } else {
                            $route = "/{$element['prefix']}/{$element['route']}";
                        }
                    @endphp

                    <div onclick="window.location.href = '{{ $route }}'" class="flex items-center gap-3 text-sm rounded px-3 py-2 group cursor-pointer hover:bg-blue-500 hover:text-white transition-all">
                        <span class="material-symbols-outlined text-blue-500 group-hover:text-white transition-all">{{ $element['icon'] }}</span>
                    </div>
                @endif
            @endforeach
        @endif

        <div onclick="window.location.href = '/market'" class="flex items-center gap-3 text-sm rounded px-3 py-2 group cursor-pointer hover:bg-blue-500 hover:text-white transition-all">
            <span class="material-symbols-outlined text-blue-500 group-hover:text-white transition-all">shopping_cart</span>
        </div>
    </section>

    @if (Auth::user())  
        <div class="p-5 border-t mx-3 flex justify-between items-center gap-3 cursor-pointer flex-col">
            <p onclick="window.location.href = '/profile'" class="hover:text-blue-500 transition-all material-symbols-outlined">
                person
            </p>

            <span onclick="window.location.href = '/logout'" class="material-symbols-outlined hover:text-red-500 transition-all">logout</span>
        </div> 
    @endif
</aside>

<script>
    const toggle = () => {
        let screenWidth = window.innerWidth; 
        
        if(screenWidth < 1024) {
            let sidebar = document.querySelector('aside');

            if(sidebar.classList.contains('hidden')) {
                sidebar.classList = 'border-r flex flex-col transition-all fixed bg-white h-screen w-screen z-50';
                document.getElementById('close').classList = 'flex items-center justify-center px-3 pt-5';
            } else {
                sidebar.classList = 'hidden w-[250px] border-r flex flex-col transition-all';
                document.getElementById('close').classList = 'hidden';
            }
        }
    }

    window.addEventListener('resize', () => {
        screenWidth = window.innerWidth;

        if(screenWidth >= 1024) {
            document.querySelector('aside').classList = 'w-[250px] border-r hidden lg:flex flex-col transition-all bg-white';
            document.getElementById('close').classList = 'hidden';
        }
    });
</script>