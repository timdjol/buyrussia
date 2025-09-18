<div class="sidebar">
    <div class="logo">
        <a href="{{ route('dashboard') }}"><img src="{{ route('index') }}/img/logo.svg" alt="Logo"></a>
    </div>
    <ul>
        <li @routeactive('dash*')><a href="{{ route('dashboard')}}"><i class="fa-solid fa-chart-simple"></i>
            Dashboard</a></li>
        <li @routeactive('categor*')><a href="{{ route('categories.index')}}"><i class="fa-solid fa-list"></i>
                Categories</a></li>
        <li @routeactive('post*')><a href="{{ route('posts.index')}}"><i class="fa-solid fa-signs-post"></i>
            Posts</a></li>
        <li @routeactive('organ*')><a href="{{ route('organizations.index')}}"><i class="fa-solid fa-signs-post"></i>
            Organizations</a></li>
        <li @routeactive('taglist*')><a href="{{ route('taglists.index')}}"><i class="fa-solid fa-tag"></i> Tags</a></li>
        <li @routeactive('comment*')><a href="{{ route('comments.index')}}"><i class="fa-solid fa-comment"></i>
            Comments</a></li>
        <li @routeactive('ad*')><a href="{{ route('ads.index')}}"><i class="fa-solid fa-rectangle-ad"></i>
            Ads</a></li>
{{--        <li @routeactive('page*')><a href="{{ route('pages.index')}}"><i class="fa-solid fa-file"></i> Pages</a></li>--}}
        @admin
        <li @routeactive('user*')><a href="{{ route('users.index')}}"><i class="fa-solid fa-users"></i> Users</a></li>
        <li @routeactive('permis*')><a href="{{ route('permissions.index') }}"><i class="fa-solid fa-lock"></i>
            Permissions</a></li>
        <li @routeactive('role*')><a href="{{ route('roles.index') }}"><i class="fa-solid fa-mask"></i> Roles</a></li>
        @endadmin
        <li @routeactive('contact*')><a href="{{ route('contacts.index') }}"><i class="fas fa-address-book"></i>
            Contacts</a></li>
        <li @routeactive('prof*')><a href="{{ route('profile.edit') }}"><i class="fa-solid fa-user"></i>
            Profile</a></li>
        <li style="margin-top: 30px"><a href="{{ route('index') }}" target="_blank"><i class="fa-solid fa-globe"></i>
                Visit site</a></li>
    </ul>
</div>
